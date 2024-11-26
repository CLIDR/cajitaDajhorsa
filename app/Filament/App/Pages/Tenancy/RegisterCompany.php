<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Team;
use App\Models\Company;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\District;
use App\Models\Province;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
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
                    ->placeholder('EMPRESA DEMO EIRL'),
                Section::make('Información de Dirección de Ubigeo')
                    ->relationship('information')
                    ->schema([
                        Select::make('department_id')
                            ->searchable()
                            ->preload()
                            ->options(Department::all()->pluck('name', 'id'))
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set){
                                $set('province_id', '');
                                $set('district_id', '');
                            })
                            ->label('Departamento'),
                        Select::make('province_id')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->options(function(Get $get){
                                return Province::where('department_id', $get('department_id'))->pluck('name', 'id');
                            })
                            ->live()
                            ->afterStateUpdated(function (Set $set){
                                $set('district_id', '');
                            })
                            ->label('Provincia'),
                        Select::make('district_id')
                            ->searchable()
                            ->preload()
                            ->options(function(Get $get){
                                return District::where('province_id', $get('province_id'))->pluck('name', 'id');
                            })
                            ->live()
                            ->required()
                            ->label('Distrito'),
                        TextInput::make('address')
                            ->label('DIRECCIÓN FISCAL'),
                        TextInput::make('phone_number')
                            ->label('CELULAR')
                            ->prefix('+51')
                            ->mask('999999999'),
                        TextInput::make('email')
                            ->label('CORREO ELECTRÓNICO')
                            ->email(),
                    ]),
            ]);
    }

    protected function handleRegistration(array $data): Company
    {
        $company = Company::create($data);

        $company->members()->attach(auth()->user());

        return $company;
    }
}
