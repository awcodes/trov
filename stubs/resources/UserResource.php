<?php

namespace App\Filament\Resources\Trov;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\CheckboxList;
use FilamentAddons\Forms\Fields\PasswordGenerator;
use App\Filament\Resources\Trov\UserResource\Pages;
use App\Filament\Resources\Trov\UserResource\Pages\EditUser;
use App\Filament\Resources\Trov\UserResource\Pages\ListUsers;
use App\Filament\Resources\Trov\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'User';

    protected static ?string $navigationGroup = 'Filament Shield';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(User::class, 'email', fn ($record) => $record),
                        Toggle::make('reset_password')->reactive()->columnSpan('full'),
                        PasswordGenerator::make('password')
                            ->visible(function ($get) {
                                return $get('reset_password') == true;
                            })
                            ->rules(config('filament-breezy.password_rules'))
                            ->required()
                            ->dehydrateStateUsing(function ($state) {
                                return Hash::make($state);
                            }),
                        CheckboxList::make('roles')
                            ->helperText('Users with resource specific roles have permission to completely manage a resource. To limit a user\'s access to a specific resource disable that role and assign individual permissions below.')
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return Str::of($record->name)->headline();
                            })
                            ->columns(4),
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return Str::of($record->name)->headline();
                            })
                            ->columns(4)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email'),
                TextColumn::make('roles.name')
                    ->formatStateUsing(function ($state) {
                        return Str::of($state)->headline();
                    }),
            ])
            ->filters([
                SelectFilter::make('roles')->relationship('roles', 'name')
            ])->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
