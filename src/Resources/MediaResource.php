<?php

namespace Trov\Resources;

use Trov\Models\Media;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Trov\Forms\Fields\MediaUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\IconColumn;
use Trov\Resources\MediaResource\Pages\EditMedia;
use Trov\Resources\MediaResource\Pages\ListMedia;
use Trov\Resources\MediaResource\Pages\CreateMedia;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('File')
                            ->hidden(function ($livewire) {
                                return $livewire instanceof EditMedia;
                            })
                            ->schema([
                                MediaUpload::make('filename')
                                    ->preserveFilenames(config('trov.media.preserve_file_names'))
                                    ->disableLabel()
                                    ->maxWidth(5000)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'])
                                    ->directory(config('trov.media.directory', 'images'))
                                    ->disk(config('trov.media.disk', 'public'))
                                    ->required()
                                    ->maxFiles(1)
                                    ->panelAspectRatio('24:9')
                            ]),
                        Section::make('Preview')
                            ->hidden(function ($livewire) {
                                return $livewire instanceof CreateMedia;
                            })
                            ->schema([
                                ViewField::make('preview')
                                    ->view('trov::components.media-preview')
                                    ->disableLabel()
                                    ->afterStateHydrated(function ($component, $state, $record) {
                                        $component->state($record);
                                    }),
                            ]),
                        Section::make('Details')
                            ->schema([
                                Placeholder::make('uploaded_on')
                                    ->label('Uploaded on')
                                    ->content(fn ($record): string => $record ? $record->created_at->format('F j, Y') : '-'),
                                Placeholder::make('file_type')
                                    ->label('File Type')
                                    ->content(fn ($record): string => $record ? $record->type : '-'),
                                Placeholder::make('file_size')
                                    ->label('File Size')
                                    ->content(fn ($record): string => $record ? $record->sizeForHumans() : '-'),
                                Placeholder::make('dimensions')
                                    ->label('Dimensions')
                                    ->content(fn ($record): string => $record ? $record->width . ' x ' . $record->height : '-'),
                                Placeholder::make('disk')
                                    ->label('Disk')
                                    ->content(fn ($record): string => $record ? $record->disk : '-'),
                                Placeholder::make('directory')
                                    ->label('Directory')
                                    ->content(fn ($record): string => $record ? $record->directory : '-'),
                                Placeholder::make('public_id')
                                    ->label('Public Id')
                                    ->content(fn ($record): string => $record ? $record->public_id : '-')->columnSpan(['lg' => 4]),
                                Placeholder::make('file_url')
                                    ->label('File URL')
                                    ->content(fn ($record): string => $record ? $record->url : '-')->columnSpan(['lg' => 4]),
                            ])
                            ->columns(['lg' => 4]),
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 2
                    ]),
                Group::make()
                    ->schema([
                        Section::make('Meta')
                            ->schema([
                                TextInput::make('alt')
                                    ->helperText('<a href="https://www.w3.org/WAI/tutorials/images/decision-tree" target="_blank" rel="noopener" class="underline text-primary-500 hover:text-primary-600 focus:text-primary-600">Learn how to describe the purpose of the image</a>. Leave empty if the image is purely decorative.'),
                                TextInput::make('title'),
                                Textarea::make('caption')
                                    ->rows(2),
                                Textarea::make('description')
                                    ->rows(2),
                            ])
                    ])
                    ->columnSpan([
                        'lg' => 'full',
                        'xl' => 1,
                    ]),
            ])
            ->columns([
                'lg' => 3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_url'),
                TextColumn::make('public_id')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('disk')
                    ->options([
                        'heroicon-o-server',
                        'heroicon-o-cloud' => function ($state): bool {
                            return in_array($state, ['cloudinary', 's3']);
                        },
                    ])
                    ->colors([
                        'secondary', 'success' => function ($state): bool {
                            return in_array($state, ['cloudinary', 's3']);
                        },
                    ]),
                TextColumn::make('updated_at')
                    ->label('Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
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
            'index' => ListMedia::route('/'),
            'create' => CreateMedia::route('/create'),
            'edit' => EditMedia::route('/{record}/edit'),
        ];
    }
}
