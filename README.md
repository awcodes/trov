## About Trov

A Laravel / Filament starter kit for CMS functionality on websites.

Please star these awesome repos and/or sponsor all of these people's hard work:

- [Filament](https://github.com/laravel-filament/filament)
- [Filament Breezy](https://github.com/jeffgreco13/filament-breezy)
- [Filament Shield](https://github.com/bezhanSalleh/filament-shield)
- [Spatie Laravel Package Tools](https://github.com/spatie/laravel-package-tools)
- [Spatie Laravel Sluggable](https://github.com/spatie/laravel-sluggable)
- [Spatie Laravel Tags](https://github.com/spatie/laravel-tags)

## Installation

1. Install the package via composer

```bash
composer require awcodes/trov
```

2. Install Trov

```bash
php artisan trov:install
```

3. Update `App\Models\User.php` model with:

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

4. Update `filament-shield.php` config file where appropriate, then initialize Shield with:

```bash
php artisan shield:install
```

## License

Trov is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
