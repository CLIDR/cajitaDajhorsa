<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
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
            ]);
    }
}
