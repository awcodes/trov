<?php

namespace Trov\Resources\UserResource\Pages;

use Trov\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
