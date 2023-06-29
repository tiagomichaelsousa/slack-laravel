<?php

use Slack\Client;
use Illuminate\Config\Repository;
use Slack\Laravel\ServiceProvider;
use Slack\Contracts\ClientContract;
use Slack\Laravel\Exceptions\TokenIsMissing;

it('binds the client on the container', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'slack' => [
            'token' => 'test',
        ],
    ]));

    (new ServiceProvider($app))->register();

    expect($app->get(Client::class))->toBeInstanceOf(Client::class);
});

it('binds the client on the container as singleton', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'slack' => [
            'token' => 'test',
        ],
    ]));

    (new ServiceProvider($app))->register();

    $client = $app->get(Client::class);

    expect($app->get(Client::class))->toBe($client);
});

it('requires an token', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([]));

    (new ServiceProvider($app))->register();
})->throws(
    TokenIsMissing::class,
    'The Slack Token is missing. Please publish the [slack.php] configuration file and set the [token].',
);

it('provides', function () {
    $app = app();

    $provides = (new ServiceProvider($app))->provides();

    expect($provides)->toBe([
        Client::class,
        ClientContract::class,
        'slack',
    ]);
});
