<?php

namespace Trov\Forms\Fields;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Arrayable;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasExtraAlpineAttributes;

class PasswordGenerator extends TextInput
{
    protected string $view = 'trov::components.fields.password-generator';
}
