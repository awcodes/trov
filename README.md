## About Trov

:bangbang: Do not install this in an existing application unless you know what you are doing.

A Laravel / Filament starter kit for CMS functionality on websites.

## Installation

Install packages via composer

```bash
composer require awcodes/trov awcodes/filament-addons awcodes/filament-curator awcodes/filament-tiptap-editor awcodes/filament-sentry awcodes/filament-versions
```

Install optional packages

```bash
composer require awcodes/filament-quick-create awcodes/filament-sticky-header
```

## Setup Filament Breezy

Publish config file. This will publish Sentry's version of Breezy's config with stronger default password rules. You are free to modify this however you see fit.

```bash
php artisan vendor:publish --tag=filament-sentry-config
```

## Setup Filament Shield
Install Shield

```bash
php artisan vendor:publish --tag=filament-shield-migrations
php artisan vendor:publish --tag=filament-shield-seeder
```

Open the `Database\Seeders\ShieldSettingSeeder.php` file and update the $settingKeys as needed.

```bash
php artisan migrate
php artisan db:seed --class=ShieldSettingSeeder
```

Add the Spatie\Permission\Traits\HasRoles trait to your User model(s):

```php
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;

    public function canAccessFilament(): bool
    {
        // this can be anything as long as it returns true / false
        return str_ends_with($this->email, '@domain.com') && $this->getRoleNames()->isNotEmpty();
    }
}
```

## Setup Filament Curator and Trov Core

```bash
php artisan curator:install
php artisan trov:install
```

Install Modules (optional)

```bash
php artisan trov:install --module=airport
php artisan trov:install --module=discoveries
php artisan trov:install --module=faqs
php artisan trov:install --module=linkables
php artisan trov:install --module=whitepages
```

## License

Trov is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
