<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriaPaqResource\Pages;
use App\Filament\Resources\GaleriaPaqResource\RelationManagers;
use App\Models\GaleriaPaq;
use App\Models\Paquetes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GaleriaPaqResource extends Resource
{
    protected static ?string $model = GaleriaPaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getModelLabel(): string
    {
        return 'Galería';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Galería';
    }

    public static function getNavigationLabel(): string
    {
        return 'Galería';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paquete_id')
                    ->required()
                    ->label('Paquete')
                    ->options(Paquetes::all()->pluck('titulo', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('desc')->required(),
                Forms\Components\FileUpload::make('img')
                    ->image()
                    ->directory('paquetes/imagenes')
                    ->maxSize(8048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\ImageColumn::make('img')
                    ->circular(),
                Tables\Columns\TextColumn::make('paquete.titulo')
                    ->label('Paquete'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGaleriaPaqs::route('/'),
            'create' => Pages\CreateGaleriaPaq::route('/create'),
            'edit' => Pages\EditGaleriaPaq::route('/{record}/edit'),
        ];
    }
}
