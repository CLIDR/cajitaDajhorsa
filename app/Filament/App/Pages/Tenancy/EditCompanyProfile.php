<?php

namespace App\Filament\App\Pages\Tenancy;

use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditCompanyProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Company profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('ruc')
                            ->label('N° RUC')
                            ->mask('99999999999')
                            ->placeholder('20600443268'),
                        TextInput::make('name')
                            ->label('RAZON SOCIAL')
                            ->autocapitalize('words')
                            ->placeholder('DAJHORSA ASESOR EMPRESARIAL EIRL'),
                        TextInput::make('address')
                            ->label('DIRECCIÓN FISCAL'),
                        TextInput::make('phone_number')
                            ->label('CELULAR')
                            ->prefix('+51')
                            ->mask('999999999'),
                    ])->columns(2),

                Section::make('Company Configuration')
                    ->schema([
                        Repeater::make('entity_keys')
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        'sunat' => 'Member',
                                        'administrator' => 'Administrator',
                                        'owner' => 'Owner',
                                    ])
                                    ->required(),
                                TextInput::make('username')->required(),
                                TextInput::make('value')->required(),
                            ])
                            ->columns(3)
                    ]),
            ]);
    }
}
