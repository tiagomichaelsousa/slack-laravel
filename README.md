<p align="center">
    <img src="https://raw.githubusercontent.com/tiagomichaelsousa/slack-laravel/main/art/client.png" width="600" alt="Slack Laravel">
    <p align="center">
        <a href="https://github.com/tiagomichaelsousa/slack-laravel/actions"><img alt="GitHub Workflow Status (main)" src="https://github.com/tiagomichaelsousa/slack-laravel/actions/workflows/tests.yml/badge.svg?branch=main"></a>
        <a href="https://packagist.org/packages/tiagomichaelsousa/slack-laravel"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/tiagomichaelsousa/slack-laravel"></a>
        <a href="https://packagist.org/packages/tiagomichaelsousa/slack-laravel"><img alt="Latest Version" src="https://img.shields.io/packagist/v/tiagomichaelsousa/slack-laravel"></a>
        <a href="https://packagist.org/packages/tiagomichaelsousa/slack-laravel"><img alt="License" src="https://img.shields.io/github/license/tiagomichaelsousa/slack-laravel"></a>
    </p>
</p>

------
**Slack Laravel** is a non-official PHP API package that allows you to interact with the [Slack API](https://api.slack.com/methods) ⚡️

> **This package is still under development.** There may have methods that are still not implemented.

---

## Get Started

The official documentation for the Slack Client will be available soon. 👀

Until there you can still explore the SDK development experience with the `users()`, `conversations()` and `reminders()` methods 🚀

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install Slack Laravel via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require tiagomichaelsousa/slack-laravel
```

Next, publish the configuration file:

```bash
php artisan vendor:publish --provider="Slack\Laravel\ServiceProvider"
```

This will create a `config/slack.php` configuration file in your project, which you can modify to your needs
using environment variables: 

```env
SLACK_TOKEN=xoxb-...
```

Finally, you may use the `Slack` facade to access the Slack API:

```php
use Slack\Laravel\Facades\Slack;

$conversations = Slack::conversations()->create('foo');

echo $conversations->channel->name;
```

## Usage

For usage examples, take a look at the [tiagomichaelsousa/slack-client](https://github.com/tiagomichaelsousa/slack-client) repository.

## Testing

The `Slack` facade provides a `fake()` method that allows you to fake the API responses.

All responses are having a `fake()` method that allows you to easily create a response object by only providing the parameters relevant for your test case.

```php
use Slack\Laravel\Facades\Slack;
use Slack\Responses\Conversation\CreateConversationResponse;

Slack::fake([
    CreateConversationResponse::fake([
        'channel' => [
            'name' => 'foo',
        ],
    ]);
]);

$conversations = Slack::conversations()->create('foo');

expect($conversations->channel)->name->toBe('foo');
```

The official documentation for the Slack Client for Laravel will be available soon. 👀

---

Slack Client for Laravel is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
