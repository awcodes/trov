<?php

namespace Trov;

use Livewire\Livewire;
use Livewire\Component;
use Trov\Livewire\Profile;
use Trov\Livewire\EditUser;
use Laravel\Fortify\Fortify;
use Trov\Livewire\UserIndex;
use Spatie\Menu\Laravel\Html;
use Trov\Livewire\CreateUser;
use Illuminate\Support\Facades\Gate;
use Spatie\Menu\Laravel\Facades\Menu;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

class TrovServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {
            return view('trov::auth.login');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('trov::auth.reset-password', ['request' => $request]);
        });

        Fortify::registerView(function () {
            return view('trov::auth.register');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('trov::auth.two-factor-challenge');
        });

        Fortify::verifyEmailView(function () {
            return view('trov::auth.verify-email');
        });

        Fortify::confirmPasswordView(function () {
            return view('trov::auth.confirm-password');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('trov::auth.forgot-password');
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/trov/css'),
                __DIR__ . '/../resources/js' => public_path('vendor/trov/js'),
                __DIR__ . '/../resources/images' => public_path('vendor/trov/images'),
            ], 'trov-assets');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/trov'),
            ], 'trov-views');

            $this->publishes([
                __DIR__ . '/../config/trov.php' => config_path('trov.php'),
            ], 'trov-config');

            $this->publishes([
                __DIR__ . '/../config/brand.php' => config_path('brand.php'),
            ], 'trov-brand-config');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/trov.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'trov');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/trov.php', 'trov');

        // $this->loadViewComponentsAs('trov', [
        //     Alert::class,
        //     Button::class,
        // ]);

        Menu::macro('main', function () {
            return Menu::new()
                ->withoutWrapperTag()
                ->url(config('trov.home'), '<i class="mr-2 fas fa-fw fa-home"></i> Dashboard')
                ->setActiveFromRequest();
        });

        Menu::macro('admin', function () {
            return Menu::new()
                ->withoutWrapperTag()
                ->add(Html::raw('<a role="button" href="javascript:void(0)" class="media-manager"><i class="mr-2 fas fa-fw fa-photo-video"></i> Media</a>'))
                ->route('trov.users.profile', '<i class="mr-2 fas fa-fw fa-user"></i> Profile', auth()->user())
                ->routeIfCan('manage users', 'trov.users.index', '<i class="mr-2 fas fa-fw fa-users"></i> Users')
                ->setActiveFromRequest();
        });

        app()->singleton('menu.primary', function () {
            return Menu::new()
                ->withoutWrapperTag()
                ->setActiveFromRequest();
        });

        app()->singleton('menu.newitems', function () {
            return Menu::new()
                ->withoutWrapperTag()
                ->routeIfCan('manage users', 'trov.users.create', 'User');
        });

        Gate::after(function ($user, $ability) {
            return in_array($user->email, config('trov.titans')) ? true : null;
        });

        Gate::define('manage-profile', function ($user, $profile) {
            return $user->id === $profile->id;
        });

        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Livewire::component('users-index', UserIndex::class);
        Livewire::component('users-edit', EditUser::class);
        Livewire::component('users-create', CreateUser::class);
        Livewire::component('profile', Profile::class);
    }

    public function register()
    {
    }
}
