# Mastodon API for Laravel

[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/invokable/laravel-mastodon-api)

## Requirements
- PHP >= 8.2
- Laravel >= 11.0

## Installation

### Composer
```
composer require revolution/laravel-mastodon-api
```

[Socialite](https://github.com/invokable/socialite-mastodon) and [Notification](https://github.com/invokable/laravel-notification-mastodon) packages will also be installed.

## Usage

### Registering an application

#### By Web UI
1. Go to your Mastodon's user preferences page.
2. Go to development page.

#### By API
```php
use Revolution\Mastodon\Facades\Mastodon;

class MastodonController
{
    public function app()
    {
        $client_name = 'my-app';
        $redirect_uris = 'https://my-instance/callback';
        $scopes = 'read write follow';
        
        $app_info = Mastodon::domain('https://example.com')
                            ->createApp($client_name, $redirect_uris, $scopes);

        dd($app_info);
        //[
        //    'id' => '',
        //    'client_id' => '',
        //    'client_secret' => '',
        //]
     }
}
```

### OAuth authentication
Use https://github.com/invokable/socialite-mastodon

Save account info.(`id`, `token`, `username`, `acct`...and more.)

### Get statuses
```php
use Revolution\Mastodon\Facades\Mastodon;

$statuses = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->statuses($account_id);

dd($statuses);
```

### Get one status
```php
use Revolution\Mastodon\Facades\Mastodon;

$status = Mastodon::domain('https://example.com')
                  ->token('token')
                  ->status($status_id);

dd($status);
```

### Post status
```php
use Revolution\Mastodon\Facades\Mastodon;

Mastodon::domain('https://example.com')->token('token');
$response = Mastodon::createStatus('test1');
$response = Mastodon::createStatus('test2', ['visibility' => 'unlisted']);

dd($response);
```

### Any API by `get` or `post` method
```php
use Revolution\Mastodon\Facades\Mastodon;

$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->get('/timelines/public', ['local' => true]);
```

```php
use Revolution\Mastodon\Facades\Mastodon;

$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->post('/follows', ['uri' => '']);
```

### Any API can call by `call` method
```php
use Revolution\Mastodon\Facades\Mastodon;

$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->call('DELETE', '/statuses/1');
```

### Other methods
Check public methods in `Contracts/Factory.php`

## Streaming API
Edit `$token` and `$url` in streaming_example.php

```
php ./streaming_example.php
```

`Ctrl+C` to quit.

## LICENSE
MIT  
