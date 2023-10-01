<?php

declare(strict_types=1);

namespace App\Livewire\Seo;

use Google\Client;
use Google\Service\SiteVerification;
use Google\Service\SiteVerification\SiteVerificationWebResourceGettokenRequest;
use Google\Service\SiteVerification\SiteVerificationWebResourceGettokenRequestSite;
use Google\Service\SiteVerification\SiteVerificationWebResourceResourceSite;
use Google_Service_Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Exception;

class VerifySite extends Component
{
    public $siteUrl = '';
    public $verificationMethod = 'META'; // Default verification method is META
    public $verificationToken = ''; // Store the verification token here
    public $verificationStatus = ''; // Flag to track if the site is verified
    public $webResources = []; // Store the list of web resources here
    public $verifySiteModal = false;
    private $siteVerificationService;

    public function mount()
    {
        $client = new Client();
        $client->setApplicationName('Laravel');
        $client->setDeveloperKey(env('GOOGLE_SERVER_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        // $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->setAccessToken(Cache::get('google_access_token'));

        $this->siteVerificationService = new SiteVerification($client);
        $this->webResources = $this->siteVerificationService->webResource->listWebResource();
    }

    public function verifySiteModal()
    {
        $this->verifySiteModal = true;
    }

    public function isVerified()
    {
        // Make a GET request to get the web resource (site) status
        $webResource = $this->siteVerificationService->webResource->get($this->siteUrl);

        // Check if the site is verified
        $isVerified = in_array($this->siteUrl, $webResource->getOwners());

        // Return true or false based on the verification status
        return $isVerified;
    }

    public function getVerificationToken()
    {
        $siteVerificationService = new SiteVerification();

        $postBody = new SiteVerificationWebResourceGettokenRequest();
        $postBody->setVerificationMethod($this->verificationMethod);

        $site = new SiteVerificationWebResourceGettokenRequestSite();
        $site->setType('SITE');
        $site->setIdentifier($this->siteUrl);
        $postBody->setSite($site);

        try {
            $tokenResponse = $siteVerificationService->webResource->getToken($postBody);
            $this->verificationToken = $tokenResponse->getToken();
        } catch (Google_Service_Exception $e) {
            $this->verificationStatus = 'Verification failed: '.$e->getMessage();
        }
    }

    public function verifySite()
    {
        try {
            $site = new SiteVerificationWebResourceResourceSite();
            $site->setType('SITE');
            $site->setIdentifier($this->siteUrl);

            $this->siteVerificationService->webResource->insert($site, $this->verificationMethod);

            $this->verificationStatus = 'Verification successful';
        } catch (Exception $e) {
            $this->verificationStatus = 'Verification failed: '.$e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.seo.verify-site');
    }
}
