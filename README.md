## About Trov

:exlamation::exclamation: Do not install this in an existing application unless you know what you are doing.

A Laravel / Filament starter kit for CMS functionality on websites.

Please star these awesome repos and/or sponsor all of these people's hard work:

- [Filament](https://github.com/laravel-filament/filament)
- [Filament Breezy](https://github.com/jeffgreco13/filament-breezy)
- [Filament Shield](https://github.com/bezhanSalleh/filament-shield)
- [Spatie Laravel Package Tools](https://github.com/spatie/laravel-package-tools)
- [Spatie Laravel Sluggable](https://github.com/spatie/laravel-sluggable)
- [Spatie Laravel Tags](https://github.com/spatie/laravel-tags)

## Installation

Install packages via composer

```bash
composer require awcodes/trov awcodes/trov-components awcodes/filament-curator awcodes/filament-tiptap-editor
```

Install Trov Core

```bash
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

Update `App\Models\User.php` with:

```php
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

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

Update `filament-shield.php` config file where appropriate, then initialize Shield with:

```bash
php artisan shield:install
```

## License

Trov is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
