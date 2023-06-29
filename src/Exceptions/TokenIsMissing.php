<?php

declare(strict_types=1);

namespace Slack\Laravel\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
final class TokenIsMissing extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     */
    public static function create(): self
    {
        return new self(
            'The Slack Token is missing. Please publish the [slack.php] configuration file and set the [token].'
        );
    }
}
