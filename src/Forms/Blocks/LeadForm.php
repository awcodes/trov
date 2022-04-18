<?php

namespace Trov\Forms\Blocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Builder\Block;

class LeadForm
{
    public static function make(string $field = 'lead-form'): Block
    {
        return Block::make($field)
            ->schema([
                MultiSelect::make('products')
                    ->options([
                        'car-title-loan' => 'Car Title Secured Loan',
                        'motorcycle-title-loan' => 'Motorcycle Title Secured Loan',
                        'rv-title-loan' => 'RV Title Secured Loan',
                        'personal-loan' => 'Personal Loan',
                        'online-personal-loan' => 'Online Personal Loan',
                    ])
                    ->default(['car-title-loan', 'motorcycle-title-loan', 'rv-title-loan'])
                    ->required(),
                MultiSelect::make('includes')
                    ->options([
                        'first-name' => 'First Name',
                        'last-name' => 'Last Name',
                        'invitation-code' => 'Invitation Code',
                    ])
                    ->default(['first-name', 'last-name']),
                Select::make('theme')
                    ->options([
                        'light' => 'Light',
                        'dark' => 'Dark',
                    ])
                    ->default('light')
                    ->required(),
                TextInput::make('cta')
                    ->default('Tell Me Now')
                    ->required(),
                Select::make('cta_color')
                    ->options([
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'tertiary' => 'Tertiary',
                        'accent' => 'Accent'
                    ])
                    ->default('primary')
                    ->required(),

            ]);
    }
}
