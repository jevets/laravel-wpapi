# WpApi

Laravel package for communicating with the WordPress REST API.

Built and tested on Laravel 5.6. Older versions may work fine, but I haven't tried on anything < L5.6.

## Installation

1. Add the repository to your local `composer.json` file:

```json
// composer.json
"repositories": [
  {
    "type": "git",
    "url": "https://github.com/jevets/laravel-wpapi"
  }
]
```

2. Require the package in your local `composer.json`:

```json
{
  "require": {
    "jevets/laravel-wpapi": "dev-master"
  }
}
```

3. (For Laravel <= 5.4) Register the provider and alias in `config/app.php`:

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

The Facade will be available as `WpApi` or `WPAPI`.

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

## Custom Formatter/Transformer

Coming soon...

## Macroable

Coming soon...

## Alternatives

- [CyberDuck's `laravel-wp-api`](https://github.com/Cyber-Duck/laravel-wp-api)

## ChangeLog

### 2018-03-30

Initial public offering

## Roadmap

## Contributing

Use GitHub's issue tracker. Feel free to submit pull requests!
