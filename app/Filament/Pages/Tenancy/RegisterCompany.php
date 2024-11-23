<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterCompany extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Registrar Empresa';
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

    protected function handleRegistration(array $data): Company
    {
        $company = Company::create($data);

        $company->members()->attach(auth()->user());

        return $company;
    }
}
