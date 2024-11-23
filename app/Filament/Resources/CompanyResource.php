<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('company_ruc')
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
                Select::make('department_id')
                    ->label('DEPARTAMENTO'),
                Select::make('province_id')
                    ->label('PROVINCIA'),
                Select::make('district_id')
                    ->label('DISTRITO'),
                TextInput::make('address')
                    ->label('DIRECCIÓN FISCAL'),
                TextInput::make('phone_number')
                    ->label('CELULAR')
                    ->prefix('+51')
                    ->mask('999999999'),
                // Select::make('user_id')
                //     ->label('ADMINISTRATOR')
                //     ->relationship('user', 'name')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
