<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Contenido CMS';

    protected static ?string $navigationLabel = 'Menús';

    protected static ?string $modelLabel = 'Ítem de menú';

    protected static ?string $pluralModelLabel = 'Menús';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('ubicacion')
                ->options([
                    'header' => 'Header',
                    'footer' => 'Footer',
                ])
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('label')->required()->maxLength(255),
            Forms\Components\TextInput::make('url')->maxLength(255)->helperText('URL absoluta o relativa'),
            Forms\Components\TextInput::make('ruta')->maxLength(100)->helperText('Nombre de ruta Laravel (ej. tours)'),
            Forms\Components\Select::make('parent_id')
                ->label('Padre')
                ->relationship('parent', 'label')
                ->searchable()
                ->nullable(),
            Forms\Components\TextInput::make('orden')->numeric()->default(0),
            Forms\Components\Toggle::make('visible')->default(true),
            Forms\Components\Select::make('target')
                ->options([
                    '_self' => 'Misma ventana',
                    '_blank' => 'Nueva ventana',
                ])
                ->default('_self'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ubicacion')->badge()->sortable(),
                Tables\Columns\TextColumn::make('label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ruta')->toggleable(),
                Tables\Columns\TextColumn::make('url')->limit(30)->toggleable(),
                Tables\Columns\TextColumn::make('parent.label')->label('Padre'),
                Tables\Columns\TextColumn::make('orden')->sortable(),
                Tables\Columns\IconColumn::make('visible')->boolean(),
            ])
            ->defaultSort('orden')
            ->reorderable('orden')
            ->filters([
                Tables\Filters\SelectFilter::make('ubicacion')->options([
                    'header' => 'Header',
                    'footer' => 'Footer',
                ]),
                Tables\Filters\TernaryFilter::make('visible'),
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
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
