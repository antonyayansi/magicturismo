<?php

namespace App\Filament\Pages;

use App\Models\datos_empresa;
use App\Services\SiteSettings;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-site-settings';

    protected static ?string $navigationGroup = 'Empresa';

    protected static ?string $navigationLabel = 'Ajustes del sitio';

    protected static ?string $title = 'Ajustes del sitio';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public function mount(): void
    {
        $record = datos_empresa::query()->first() ?? new datos_empresa();
        $this->form->fill($record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Empresa')->schema([
                    Forms\Components\TextInput::make('nombre')->required()->maxLength(255),
                    Forms\Components\TextInput::make('direccion')->maxLength(255),
                    Forms\Components\TextInput::make('horario')->maxLength(255),
                    Forms\Components\TextInput::make('telefono')->maxLength(50),
                    Forms\Components\TextInput::make('telefono2')->maxLength(50),
                    Forms\Components\TextInput::make('email')->email()->maxLength(255),
                    Forms\Components\TextInput::make('email2')->email()->maxLength(255),
                    Forms\Components\Textarea::make('desc_corto')->rows(3)->columnSpanFull(),
                ])->columns(2),
                Forms\Components\Section::make('Marca')->schema([
                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->directory('empresa')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                        ->maxSize(2048),
                    Forms\Components\FileUpload::make('favicon')
                        ->image()
                        ->directory('empresa')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/x-icon', 'image/vnd.microsoft.icon'])
                        ->maxSize(1024),
                ])->columns(2),
                Forms\Components\Section::make('Redes sociales')->schema([
                    Forms\Components\TextInput::make('facebook')->url()->maxLength(255),
                    Forms\Components\TextInput::make('twitter')->url()->maxLength(255),
                    Forms\Components\TextInput::make('instagram')->url()->maxLength(255),
                    Forms\Components\TextInput::make('linkedin')->url()->maxLength(255),
                    Forms\Components\TextInput::make('whatsapp')->url()->maxLength(255),
                    Forms\Components\TextInput::make('youtube')->url()->maxLength(255),
                ])->columns(2),
                Forms\Components\Section::make('Pie y enlaces')->schema([
                    Forms\Components\Textarea::make('footer_texto')->rows(4)->columnSpanFull(),
                    Forms\Components\TextInput::make('copyright')->maxLength(255),
                    Forms\Components\TextInput::make('url_frances')->url()->maxLength(255),
                    Forms\Components\TextInput::make('faq_url')->url()->maxLength(255),
                    Forms\Components\TextInput::make('soporte_url')->url()->maxLength(255),
                ])->columns(2),
                Forms\Components\Section::make('SEO global')->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')->rows(3),
                    Forms\Components\TextInput::make('meta_keywords')->maxLength(255),
                ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $record = datos_empresa::query()->first() ?? new datos_empresa();
        $record->fill($data);
        $record->save();
        SiteSettings::forget();

        Notification::make()->title('Ajustes guardados')->success()->send();
    }
}
