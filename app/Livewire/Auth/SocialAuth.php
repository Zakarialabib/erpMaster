<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Google\Client;
use Google\Service\PeopleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Enums\Status;
use Google\Service\SiteVerification;
use Illuminate\Support\Facades\Cache;

class SocialAuth extends Component
{
    public $socialUser;

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $this->socialUser = Socialite::driver('facebook')->user();

        $user = User::updateOrCreate([
            'facebook_id' => $this->socialUser->id,
        ], [
            'name'     => $this->socialUser->getName(),
            'email'    => $this->socialUser->getEmail(),
            'password' => Hash::make(Str::random(16)), // Generate a random password
            // 'phone'    => $this->phone,
            // 'city'     => $this->city,
            // 'country'  => $this->country,
            'status' => Status::INACTIVE,
        ]);

        $role = Role::where('name', 'CLIENT')->first();

        $user->assignRole($role);

        Auth::login($user, true);

        $homePage = match (true) {
            $user->hasRole('admin') => RouteServiceProvider::ADMIN_HOME,
            default                 => RouteServiceProvider::CLIENT_HOME,
        };

        return redirect()->intended($homePage);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $this->socialUser = Socialite::driver('google')->user();

        $user = User::where('email', $this->socialUser->getEmail())->first();

        if ($user) {
            // User with the same email already exists, update their information
            $user->update(['provider_id' => $this->socialUser->getId()]);
        } else {
            // User does not exist; create a new user
            $user = User::create([
                'provider_id' => $this->socialUser->getId(),
                'name' => $this->socialUser->getName(),
                'email' => $this->socialUser->getEmail(),
                'password' => Hash::make(Str::random(16)), // Generate a random password
                // Add other required fields as needed
            ]);
        }

        // Set token for the Google API PHP Client
        $google_client_token = [
            'access_token' => $this->socialUser->token,
            'refresh_token' => $this->socialUser->refreshToken,
            'expires_in' => $this->socialUser->expiresIn
        ];
        // cache google client token for later use
        Cache::put('google_client_token', $google_client_token);

        Auth::login($user, true);

        $client = new Client();
        $client->setApplicationName("Laravel");
        $client->setDeveloperKey(env('GOOGLE_SERVER_KEY'));
        $client->setAccessToken(json_encode($google_client_token));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        $client->setScopes(
            [
                \Google\Service\Oauth2::USERINFO_PROFILE,
                \Google\Service\Oauth2::USERINFO_EMAIL,
                \Google\Service\Oauth2::OPENID,
                \Google\Service\Drive::DRIVE_METADATA_READONLY,
                PeopleService::CONTACTS_READONLY,
                PeopleService::CONTACTS,
                SiteVerification::SITEVERIFICATION,
            ]
        );

        $client->setIncludeGrantedScopes(true);

        $auth_url = $client->createAuthUrl();

        return redirect()->intended($auth_url);
    }

    public function render()
    {
        return view('livewire.auth.social-auth');
    }
}
