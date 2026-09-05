<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaquetesResource\Pages;
use App\Filament\Resources\PaquetesResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Paquetes;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaquetesResource extends Resource
{
    protected static ?string $model = Paquetes::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Catálogo';

    protected static ?string $navigationLabel = 'Paquetes';

    protected static ?string $modelLabel = 'Paquete';

    protected static ?string $pluralModelLabel = 'Paquetes';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información principal')->schema([
                    Forms\Components\TextInput::make('titulo')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set, ?Model $record) {
                            if (! $record) {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Editable; se genera del título al crear.'),
                    Forms\Components\TextInput::make('duracion'),
                    Forms\Components\TextInput::make('can_personas')
                        ->label('Cantidad de personas')
                        ->numeric(),
                    Forms\Components\TextInput::make('altitud'),
                    Forms\Components\Select::make('tipo')
                        ->options([
                            'tour' => 'Tour',
                            'paquete' => 'Paquete',
                            'treks' => 'Caminata/Trek',
                            'caminata' => 'Caminata (legado)',
                            'diferente' => 'Algo diferente',
                        ])
                        ->default('tour')
                        ->required(),
                    Forms\Components\TextInput::make('dificultad'),
                    Forms\Components\TextInput::make('precio')->numeric(),
                    Forms\Components\Select::make('estado')
                        ->options([
                            'pendiente' => 'Pendiente',
                            'activo' => 'Activo',
                            'inactivo' => 'Inactivo',
                        ])
                        ->default('activo')
                        ->required(),
                    Forms\Components\Select::make('categoria_id')
                        ->required()
                        ->label('Categoría')
                        ->relationship('categoria', 'nombre')
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('ubicacion'),
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Extracto')
                        ->rows(3)
                        ->columnSpanFull(),
                    RichEditor::make('descripcion')
                        ->columnSpanFull(),
                ])->columns(3),
                Forms\Components\Section::make('Medios')->schema([
                    Forms\Components\FileUpload::make('imagen')
                        ->image()
                        ->directory('paquetes/imagenes')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(5120),
                    Forms\Components\FileUpload::make('adj_pdf')
                        ->label('Archivo PDF')
                        ->directory('paquetes/pdf')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240),
                    Forms\Components\FileUpload::make('adj_video')
                        ->label('Video')
                        ->directory('paquetes/videos')
                        ->acceptedFileTypes(['video/mp4'])
                        ->maxSize(51200),
                ])->columns(3),
                Forms\Components\Section::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')->rows(3),
                    Forms\Components\TextInput::make('meta_keywords')->maxLength(255),
                    Forms\Components\TextInput::make('canonical_url')->url()->maxLength(255),
                ])->columns(2)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('categoria'))
            ->columns([
                Tables\Columns\TextColumn::make('titulo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tipo')->badge()->sortable(),
                Tables\Columns\TextColumn::make('categoria.nombre')->label('Categoría')->sortable(),
                Tables\Columns\TextColumn::make('precio')->money('USD'),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')->options([
                    'tour' => 'Tour',
                    'paquete' => 'Paquete',
                    'treks' => 'Caminata/Trek',
                    'caminata' => 'Caminata (legado)',
                    'diferente' => 'Algo diferente',
                ]),
                Tables\Filters\SelectFilter::make('estado')->options([
                    'pendiente' => 'Pendiente',
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ]),
                Tables\Filters\SelectFilter::make('categoria_id')
                    ->label('Categoría')
                    ->options(fn () => Categoria::query()->orderBy('nombre')->pluck('nombre', 'id')),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\GaleriaRelationManager::class,
            RelationManagers\ItinerariosRelationManager::class,
            RelationManagers\IncluyeRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaquetes::route('/'),
            'create' => Pages\CreatePaquetes::route('/create'),
            'edit' => Pages\EditPaquetes::route('/{record}/edit'),
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
