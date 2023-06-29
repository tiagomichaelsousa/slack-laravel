<?php

declare(strict_types=1);

namespace Slack\Laravel\Facades;

use Slack\Responses\StreamResponse;
use Slack\Laravel\Testing\SlackFake;
use Slack\Contracts\ResponseContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Slack\Resources\User users()
 * @method static \Slack\Resources\Conversation conversations()
 * @method static \Slack\Resources\Reminder reminders()
 */
final class Slack extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'slack';
    }

    /**
     * @param  array<array-key, ResponseContract|StreamResponse|string>  $responses
     */
    /** @phpstan-ignore-next-line */
    public static function fake(array $responses = []): SlackFake
    {
        $fake = new SlackFake($responses);
        self::swap($fake);

        return $fake;
    }
}
