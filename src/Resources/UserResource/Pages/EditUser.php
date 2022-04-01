<?php

namespace Trov\Resources\UserResource\Pages;

use Filament\Facades\Filament;
use Trov\Resources\UserResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getActions(): array
    {
        parent::getActions();

        return array_merge([
            ButtonAction::make('reset')->label('Reset Passwod')->color('warning')->action('sendResetLink'),
        ], parent::getActions());
    }

    public function sendResetLink(): void
    {
        $response = Password::sendResetLink(['email' => $this->record]);
        if ($response == Password::RESET_LINK_SENT) {
            Filament::notify('success', __("Password reset email has been sent to this user."));
        } else {
            Filament::notify('danger', match ($response) {
                "passwords.throttled" => __("passwords.throttled"),
                "passwords.user" => __("passwords.user")
            });
        }
    }
}
