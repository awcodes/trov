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
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
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
                Section::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(User::class, 'email', fn ($record) => $record),
                        Toggle::make('reset_password')
                            ->reactive()
                            ->hidden(function ($livewire) {
                                if ($livewire instanceof CreateUser) {
                                    return true;
                                }
                            })
                            ->columnSpan('full'),
                        PasswordGenerator::make('password')
                            ->visible(function ($livewire, $get) {
                                if ($livewire instanceof CreateUser) {
                                    return true;
                                }
                                return $get('reset_password') == true;
                            })
                            ->rules(config('filament-breezy.password_rules'))
                            ->required()
                            ->dehydrateStateUsing(function ($state) {
                                return Hash::make($state);
                            }),
                        CheckboxList::make('roles')
                            ->relationship('roles', 'name', function(Builder $query) {
                                if (!auth()->user()->hasRole('super_admin')) {
                                    return $query->where('name', '<>', 'super_admin');
                                }

                                return $query;
                            })
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return Str::of($record->name)->headline();
                            })
                            ->columns(4),
                    ]),
                Section::make('Permissions')
                    ->description('Users with roles have permission to completely manage resources based on the permissions set under the Roles Menu. To limit a user\'s access to specific resources disable thier roles and assign them individual permissions below.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
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
            ])
            ->actions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([])
            ->defaultSort('name', 'asc');
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
