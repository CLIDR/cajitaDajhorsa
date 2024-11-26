<?php

namespace App\Filament\App\Pages\Tenancy;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\District;
use App\Models\Province;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Forms\Components\Group;
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
                        Group::make()
                            ->relationship('information')
                            ->schema([
                                TextInput::make('email')
                                    ->label('CORREO ELECTRÓNICO')
                                    ->email(),
                                TextInput::make('phone')
                                    ->label('CELULAR')
                                    ->prefix('+51')
                                    ->mask('999999999'),
                            ])->columns(2)->columnSpanFull()
                    ])->columns(2),

                Section::make('Company Configuration')
                    ->relationship('information')
                    ->schema([
                        Section::make('Información de Dirección de Ubigeo')
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
                                    ->label('Dirección')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columns(3),

                        Section::make('CLAVES Y/O CONTRASEÑAS DE LA EMPRESA')
                            ->description('Este campo es usado para el registro de las claves que se administran a cerca de la empresa')
                            ->schema([
                                Repeater::make('entity_keys')
                                ->label('')
                                ->addActionLabel('Agregar Claves')
                                ->schema([
                                    Select::make('type')
                                        ->label('ENTIDAD')
                                        ->native(false)
                                        ->options([
                                            'SUNAT' => 'SUNAT SOL',
                                            'AFP' => 'AFP NET',
                                            'DETRACCION' => 'DETRACCIONES',
                                        ])
                                        ->required(),
                                    TextInput::make('username')
                                        ->label('USUARIO')
                                        ->required(),
                                    TextInput::make('password')
                                        ->label('CLAVE')
                                        ->required(),
                                ])
                                ->columns(3)
                            ])
                    ]),
            ]);
    }
}
