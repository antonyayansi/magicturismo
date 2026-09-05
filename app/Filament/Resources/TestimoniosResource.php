<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimoniosResource\Pages;
use App\Models\Testimonios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TestimoniosResource extends Resource
{
    protected static ?string $model = Testimonios::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Contenido CMS';

    protected static ?string $navigationLabel = 'Testimonios';

    protected static ?string $modelLabel = 'Testimonio';

    protected static ?string $pluralModelLabel = 'Testimonios';

    protected static ?int $navigationSort = 5;

    protected static bool $isGloballySearchable = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombres')->required()->maxLength(255),
            Forms\Components\TextInput::make('cargo')->maxLength(255),
            Forms\Components\Textarea::make('texto')->required()->rows(5)->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('nombres')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('cargo')->searchable(),
                Tables\Columns\TextColumn::make('texto')->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('estado')->badge(),
            ])
            ->filters([
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
            'index' => Pages\ListTestimonios::route('/'),
            'create' => Pages\CreateTestimonios::route('/create'),
            'edit' => Pages\EditTestimonios::route('/{record}/edit'),
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
