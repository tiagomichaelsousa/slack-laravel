<?php

declare(strict_types=1);

namespace Slack\Laravel;

use Slack;
use Slack\Client;
use Slack\Contracts\ClientContract;
use Slack\Laravel\Exceptions\TokenIsMissing;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * @internal
 */
final class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientContract::class, static function (): Client {
            $token = config('slack.token');

            if (!is_string($token)) {
                throw TokenIsMissing::create();
            }

            return Slack::factory()
                ->withToken($token)
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => config('slack.request_timeout', 30)]))
                ->make();
        });

        $this->app->alias(ClientContract::class, 'slack');
        $this->app->alias(ClientContract::class, Client::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/slack.php' => config_path('slack.php'),
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            Client::class,
            ClientContract::class,
            'slack',
        ];
    }
}
