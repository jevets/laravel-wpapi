# WpApi

Laravel package for communicating with the WordPress REST API. Uses Guzzle under the hood.

**This package is in alpha state and will change.**

Built and tested on Laravel 5.6. Older versions may work fine, but I haven't tried on anything < L5.6.

## Installation

1. Define and require the repository in your local `composer.json` file:

```json
// composer.json
"require": {
  "jevets/laravel-wpapi": "dev-master"
}
"repositories": [
  {
    "type": "git",
    "url": "https://github.com/jevets/laravel-wpapi"
  }
]
```

2. (For Laravel <= 5.4) Register the provider and alias in `config/app.php`:

```php
// config/app.php
'providers' => [
  // ...
  Jevets\WpApi\ServiceProvider::class
],

'aliases' => [
  'WpApi' => Jevets\WpApi\Facade::class,
],
```

## Usage

The Facade will be available as `WpApi`.

Examples:

```php
$posts = WpApi::posts();
$pages = WpApi::pages():
$tags = WpApi::tags();
$categories = WpApi::categories();

// Get a page by its slug
$aboutPage = WpApi::page('about');
// Or by its WP ID
$pageWithIdEqualsThree = WpApi::page(3);

// Custom taxonomy
$genre = WpApi::taxonomy('genres');
```

## Extending

The easiest (and more common) way of adding features is to set up your own API wrapper class in your application that extends the WpApi class.

Here's an example extended class that retrieves a custom post type of `book` (which has an endpoint at `/wp-json/wp/v2/books`).

```php
<?php

namespace App\MyApi;

use Jevets\WpApi\WpApi;

class MyApi extends WpApi
{
    /**
     * @param array $query
     * @return array
     */
    public function books(array $query = [])
    {
        return $this->get('books', $query);
    }
}
```

## Macroable

The WpApi class is [Macroable](https://laravel.com/api/5.6/Illuminate/Support/Traits/Macroable.html).

### Example

Say you've got a custom post type `products` and you've enabled the as a REST API resource, available at `http://your-wp.local/wp-json/wp/v2/products`:

```php
WpApi::macro('products', function () {
    return $this->get('products');
});
```

Calling:

```php
WpApi::products();
```

would return something like:

```php
[
    'data' => [
        [
            'id' => 1,
            'title' => 'My Product #1',
            'slug' => 'my-product-1',
            'content' => '<p>Lorem ipsum</p>'
        ],
        [
            'id' => 2,
            'title' => 'My Product #2',
            'slug' => 'my-product-2',
            'content' => '<p>Sin dolor</p>'
        ]
    ],
    'total' => 2,
    'pages' => 1,
]
```

## Responders for Formatting the return data

A default `Jevets\WpApi\ArrayResponder` is provided, which returns results in this format:

```php
[
  'error' => [...],
  'data' => [...],
  'total' => 2,
  'pages' => 1,
]
```

You may use any Responder you'd like, as long as it implements the `Jevets\WpApi\Responder` interface.

If extending `WpApi`, simply inject the dependency. Otherwise, feel free to publish the config file and update the `wpapi.responder` value to your own, class:

```php
// config/wpapi.php
return [
  'responder' => 'App\MyApi\MyArrayResponder',
];
```

## Roadmap

- [ ] Add optional authentication methods and headers
- [ ] Implement Responder interface and allow easy injection from config/custom class

## Alternatives

- [CyberDuck's `laravel-wp-api`](https://github.com/Cyber-Duck/laravel-wp-api)

## ChangeLog

### 2018-04-09

- Add a `setResponder(\Jevets\WpApi\Responder $responder)` method to `WpApi` to allow overriding the Responder
- Add an ArrayResponder as a default responder, and allow config to override
- Make `WpApi::get()` a public method
- Refactor `WpApi::get()`'s return value to call a responder instance

### 2018-03-30

- Initial public offering

## Contributing

Use GitHub's issue tracker on this repo. Feel free to submit pull requests!
