<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservasResource\Pages;
use App\Models\ReservaEstado;
use App\Models\Reservas;
use App\Services\DashboardMetrics;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReservasResource extends Resource
{
    protected static ?string $model = Reservas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Operaciones';

    protected static ?string $navigationLabel = 'Reservas';

    protected static ?string $modelLabel = 'Reserva';

    protected static ?string $pluralModelLabel = 'Reservas';

    protected static ?string $recordTitleAttribute = 'cliente';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $pendientes = DashboardMetrics::pendientes();

        return $pendientes > 0 ? (string) $pendientes : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cliente')->schema([
                    Forms\Components\TextInput::make('cliente')
                        ->required()
                        ->label('Nombre')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cantidad_personas')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(100),
                    Forms\Components\DatePicker::make('fecha_reserva')
                        ->required()
                        ->native(false)
                        ->minDate(now()->subYear()),
                    Forms\Components\Select::make('estado')
                        ->options(fn () => ReservaEstado::opciones())
                        ->default('pendiente')
                        ->required()
                        ->searchable(),
                    Forms\Components\Select::make('paquete_id')
                        ->label('Experiencia')
                        ->relationship('paquete', 'titulo')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Textarea::make('comentario')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('paquete:id,titulo,tipo'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('paquete.titulo')
                    ->label('Experiencia')
                    ->placeholder('—')
                    ->limit(36)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cantidad_personas')
                    ->label('Pers.')
                    ->sortable()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('fecha_reserva')
                    ->label('Viaje')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => ReservaEstado::etiqueta($state))
                    ->color(fn (?string $state) => ReservaEstado::colorFilament($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibida')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options(fn () => ReservaEstado::opciones()),
                Tables\Filters\Filter::make('proximos')
                    ->label('Viajes próximos')
                    ->query(fn (Builder $query) => $query->whereDate('fecha_reserva', '>=', today())),
                Tables\Filters\Filter::make('esta_semana')
                    ->label('Recibidas esta semana')
                    ->query(fn (Builder $query) => $query->where('created_at', '>=', now()->startOfWeek())),
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
            'index' => Pages\ListReservas::route('/'),
            'create' => Pages\CreateReservas::route('/create'),
            'edit' => Pages\EditReservas::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['cliente', 'email'];
    }
}
