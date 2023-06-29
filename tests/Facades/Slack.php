<?php

use Slack\Laravel\Facades\Slack;
use Illuminate\Config\Repository;
use Slack\Resources\Conversation;
use Slack\Laravel\ServiceProvider;
use PHPUnit\Framework\ExpectationFailedException;
use Slack\Responses\Conversation\CreateConversationResponse;

it('resolves resources', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'slack' => [
            'token' => 'test',
        ],
    ]));

    (new ServiceProvider($app))->register();

    Slack::setFacadeApplication($app);

    $conversations = Slack::conversations();

    expect($conversations)->toBeInstanceOf(Conversation::class);
});

test('fake returns the given response', function () {
    Slack::fake([
        CreateConversationResponse::fake([
            'channel' => [
                'name' => 'foo',
            ],
        ]),
    ]);

    $result = Slack::conversations()->create('foo');

    expect($result['ok'])->toBeTruthy();
    expect($result['channel']['name'])->toBe('foo');
});

test('fake throws an exception if there is no more given response', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::conversations()->create('bar');
})->expectExceptionMessage('No fake responses left');

test('append more fake responses', function () {
    Slack::fake([
        CreateConversationResponse::fake([
            'channel' => [
                'name' => 'foo',
            ],
        ]),
    ]);

    Slack::addResponses([
        CreateConversationResponse::fake([
            'channel' => [
                'name' => 'bar',
            ],
        ]),
    ]);

    $response = Slack::conversations()->create('foo');
    expect($response->channel)->name->toBe('foo');

    $response = Slack::conversations()->create('bar');
    expect($response->channel)->name->toBe('bar');
});

test('fake can assert a request was sent', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::assertSent(Conversation::class, function (string $method, array $parameters): bool {
        return $method === 'create' &&
            $parameters['name'] === 'foo';
    });
});

test('fake throws an exception if a request was not sent', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::assertSent(Conversation::class, function (string $method, array $parameters): bool {
        return $method === 'create' &&
            $parameters['name'] === 'foo';
    });
})->expectException(ExpectationFailedException::class);

test('fake can assert a request was sent on the resource', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::conversations()->assertSent(function (string $method, array $parameters): bool {
        return $method === 'create' &&
            $parameters['name'] === 'foo';
    });
});

test('fake can assert a request was sent n times', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');
    Slack::conversations()->create('bar');

    Slack::assertSent(Conversation::class, 2);
});

test('fake throws an exception if a request was not sent n times', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::assertSent(Conversation::class, 2);
})->expectException(ExpectationFailedException::class);

test('fake can assert a request was not sent', function () {
    Slack::fake();

    Slack::assertNotSent(Conversation::class);
});

test('fake throws an exception if a unexpected request was sent', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::assertNotSent(Conversation::class);
})->expectException(ExpectationFailedException::class);

test('fake can assert a request was not sent on the resource', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->assertNotSent();
});

test('fake can assert no request was sent', function () {
    Slack::fake();

    Slack::assertNothingSent();
});

test('fake throws an exception if any request was sent when non was expected', function () {
    Slack::fake([
        CreateConversationResponse::fake(),
    ]);

    Slack::conversations()->create('foo');

    Slack::assertNothingSent();
})->expectException(ExpectationFailedException::class);
