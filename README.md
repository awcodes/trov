## About Trov

TODO: write description

Please star these awesome repos and/or sponsors all of these peoples hard work:

-   [Filament](https://github.com/laravel-filament/filament)
-   [Filament Breezy](https://github.com/jeffgreco13/filament-breezy)
-   [Filament Shield](https://github.com/bezhanSalleh/filament-shield)
-   [Spatie Laravel Package Tools](https://github.com/spatie/laravel-package-tools)
-   [Spatie Laravel Sluggable](https://github.com/spatie/laravel-sluggable)
-   [Spatie Laravel Tags](https://github.com/spatie/laravel-tags)

## Installation

1. Install the package via composer

```bash
composer require awcodes/trov
```

2. Publish config files and assets

```bash
php artisan vendor:publish --tag="filament-config"
php artisan vendor:publish --tag="filament-breezy-config"
php artisan vendor:publish --tag="filament-shield-config"
php artisan vendor:publish --tag="filament-forms-tinyeditor-config"
```

3. Publish migrations

```bash
php artisan vendor:publish --tag="trov-migrations"
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"
php artisan migrate
```

4. Update `filament.php` config file with:

```php
'auth' => [
    'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
    'pages' => [
        'login' => \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login::class,
    ],
],
```

Optionally, Update `filament-breezy.php` config file with:

```php
"password_rules" => [\Illuminate\Validation\Rules\Password::min(8)->letters()->numbers()->mixedCase()],
"enable_registration" => false,
```

5. Update `App\Models\User.php` model with:

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

6. Update `filament-shield.php` config file where appropriate, then initialize Shield with:

```bash
php artisan shield:install
```

7. Publish Assets

```bash
php artisan vendor:publish --tag="trov-assets"
php artisan vendor:publish --tag="filament-forms-tinyeditor-assets"
```

## License

Trov is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
