<?php

test('exceptions')
    ->expect('Slack\Laravel\Exceptions')
    ->toUseNothing();

test('facades')
    ->expect('Slack\Laravel\Facades\Slack')
    ->toOnlyUse([
        'Illuminate\Support\Facades\Facade',
        'Slack\Contracts\ResponseContract',
        'Slack\Laravel\Testing\SlackFake',
        'Slack\Responses\StreamResponse',
    ]);

test('service providers')
    ->expect('Slack\Laravel\ServiceProvider')
    ->toOnlyUse([
        'GuzzleHttp\Client',
        'Illuminate\Support\ServiceProvider',
        'Slack\Laravel',
        'Slack',
        'Illuminate\Contracts\Support\DeferrableProvider',

        // helpers...
        'config',
        'config_path',
    ]);
