<?php

namespace App\Filament\Resources\Trov\UserResource\Pages;

use Filament\Facades\Filament;
use App\Filament\Resources\Trov\UserResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
}
