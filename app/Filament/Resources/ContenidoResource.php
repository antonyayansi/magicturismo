<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContenidoResource\Pages;
use App\Models\Contenido;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContenidoResource extends Resource
{
    protected static ?string $model = Contenido::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Contenido CMS';

    protected static ?string $navigationLabel = 'Textos del sitio';

    protected static ?string $modelLabel = 'Texto';

    protected static ?string $pluralModelLabel = 'Textos del sitio';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('clave')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->disabled(fn (?Model $record) => $record !== null)
                ->dehydrated(),
            Forms\Components\TextInput::make('grupo')->maxLength(100),
            Forms\Components\TextInput::make('titulo')->maxLength(255),
            Forms\Components\Textarea::make('texto')->rows(6)->columnSpanFull(),
            Forms\Components\FileUpload::make('imagen')
                ->image()
                ->directory('cms/contenidos')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->maxSize(4096),
            Forms\Components\TextInput::make('orden')->numeric()->default(0),
            Forms\Components\Select::make('estado')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ])
                ->default('activo')
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('clave')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('grupo')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('titulo')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('texto')->searchable()->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('orden')->sortable(),
                Tables\Columns\TextColumn::make('estado')->badge(),
            ])
            ->defaultSort('orden')
            ->reorderable('orden')
            ->filters([
                Tables\Filters\SelectFilter::make('grupo')
                    ->options(fn () => Contenido::query()->whereNotNull('grupo')->distinct()->pluck('grupo', 'grupo')->all()),
                Tables\Filters\SelectFilter::make('estado')->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isAdmin()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContenidos::route('/'),
            'create' => Pages\CreateContenido::route('/create'),
            'edit' => Pages\EditContenido::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
