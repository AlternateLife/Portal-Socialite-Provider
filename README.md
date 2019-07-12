# Alternate-Life Socialite Provider

Alternate-Life Portal OAuth2 Provider for Laravel Socialite

### Install

```shell
composer require alternatelife/portal-socialite-provider
```

### Register

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'AlternateLife\Socialite\Portal\AlternateLifeExtendSocialite@handle'
    ],
];
```

### Configure

```php
'alternatelife' => [
    'client_id'     => env('ALTERNATELIFE_KEY'),
    'client_secret' => env('ALTERNATELIFE_SECRET'),
    'redirect'      => env('ALTERNATELIFE_REDIRECT_URI'),
]
```

### Start building

```php
return Socialite::with('alternatelife')->redirect();
```
