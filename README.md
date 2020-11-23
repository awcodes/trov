# Custom Admin scaffolding for freash Laravel Apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/trov.svg?style=flat-square)](https://packagist.org/packages/awcodes/trov)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/awcodes/trov/run-tests?label=tests)](https://github.com/awcodes/trov/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/trov.svg?style=flat-square)](https://packagist.org/packages/awcodes/trov)


This is just a basic admin scaffolding for Laravel. If you want to use it great, if not, so be it.

## Installation

You can install the package via composer:

```bash
composer require awcodes/trov
```

You can publish the assets with:
```bash
php artisan vendor:publish --provider="Trov\TrovServiceProvider" --tag="trov-assets"
```

You can publish the views with:
```bash
php artisan vendor:publish --provider="Trov\TrovServiceProvider" --tag="trov-views"
```

You can publish the config with:
```bash
php artisan vendor:publish --provider="Trov\TrovServiceProvider" --tag="trov-config"
```

You can publish the brand config with:
```bash
php artisan vendor:publish --provider="Trov\TrovServiceProvider" --tag="trov-brand-config"
```

You can publish the Fortify config with:
```bash
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
```

## Credits

- [awcodes](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
