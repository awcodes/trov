<?php

namespace Trov\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Trov\Resources\UserResource\Pages;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Trov\Resources\UserResource\Pages\EditUser;
use Trov\Resources\UserResource\Pages\ListUsers;
use Trov\Resources\UserResource\Pages\CreateUser;
use TrovComponents\Forms\Fields\PasswordGenerator;
use Filament\Forms\Components\BelongsToManyCheckboxList;

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
                        PasswordGenerator::make('password')
                            ->visible(function ($livewire) {
                                return $livewire instanceof CreateUser;
                            })
                            ->rules(config('filament-breezy.password_rules'))
                            ->required()
                            ->dehydrateStateUsing(function ($state) {
                                return Hash::make($state);
                            }),
                        BelongsToManyCheckboxList::make('roles')
                            ->helperText('Users with resource specific roles have permission to completely manage a resource. To limit a user\'s access to a specific resource disable that role and assign individual permissions below.')
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return Str::of($record->name)->headline();
                            })
                            ->columns(4),
                        BelongsToManyCheckboxList::make('permissions')
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
