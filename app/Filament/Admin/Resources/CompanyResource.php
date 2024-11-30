<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\District;
use App\Models\Province;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Admin\Resources\CompanyResource\Pages\EditCompany;
use App\Filament\Admin\Resources\CompanyResource\Pages\CreateCompany;
use App\Filament\Admin\Resources\CompanyResource\Pages\ListCompanies;
use App\Filament\Admin\Resources\CompanyResource\RelationManagers\UsersRelationManager;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns([
                        'sm' => 1,
                        'xl' => 3,
                        '2xl' => 3,
                    ])
                    ->schema([
                        Section::make('Información General')
                            ->schema([
                                TextInput::make('ruc')
                                    ->label('N° RUC')
                                    ->mask('99999999999')
                                    ->suffixAction(
                                        Action::make('ruc')
                                            ->label('SUNAT')
                                            ->icon('heroicon-m-magnifying-glass')
                                    )
                                    ->placeholder('20600443268'),
                                TextInput::make('name')
                                    ->label('RAZON SOCIAL')
                                    ->autocapitalize('words')
                                    ->placeholder('DAJHORSA ASESOR EMPRESARIAL EIRL'),

                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->preload()
                                    ->native(false),

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
                        Section::make('Información de la Empresa')
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
                                    ->label('DIRECCIÓN FISCAL')
                                    ->columnSpanFull(),

                                Section::make('CLAVES Y/O CONTRASEÑAS DE LA EMPRESA')
                                    ->description('Este campo es usado para el registro de las claves que se administran a cerca de la empresa')
                                    ->collapsible()
                                    ->persistCollapsed()
                                    ->hiddenOn('create')
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
                                    ])->columnSpanFull()
                            ])->columns(3),

                    ]),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_num')
                    ->label('DÍGITO'),
                TextColumn::make('ruc')
                    ->label('RUC'),
                TextColumn::make('name')
                    ->label('NOMBRE O RAZON SOCIAL'),
                IconColumn::make('status')
                    ->label('ESTADO')
                    ->boolean()
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
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'edit' => EditCompany::route('/{record}/edit'),
        ];
    }
}
