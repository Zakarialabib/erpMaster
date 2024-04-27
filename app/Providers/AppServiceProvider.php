<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Language;
use App\Models\Settings;
use App\Observers\SettingsObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Models\Contact;
use App\Models\Subscriber;
use App\Observers\ContactObserver;
use App\Observers\OrderFormObserver;
use App\Observers\SubscriberObserver;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void
    {
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        if (settings('multi_language')) {
            View::share('languages', $this->getLanguages());
        } else {
            // If multi_language is false, provide the default language directly
            View::share('languages', [$this->getDefaultLanguage()]);
        }

        Settings::observe(SettingsObserver::class);
        // Contact::observe(ContactObserver::class);
        // Contact::observe(OrderFormObserver::class);
        Subscriber::observe(SubscriberObserver::class);
        // Model::shouldBeStrict(! $this->app->isProduction());
    }

    private function getLanguages()
    {
        return Cache::rememberForever('languages', function () {
            return Language::pluck('name', 'code')->toArray();
        });
    }

    private function getDefaultLanguage()
    {
        return Language::where('is_default', true)->pluck('name', 'code')->toArray();
    }
}
