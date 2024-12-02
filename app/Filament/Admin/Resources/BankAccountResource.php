<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Code;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BankAccount;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\BankAccountResource\Pages;
use App\Filament\Admin\Resources\BankAccountResource\RelationManagers;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationGroup = 'Configuración del Sistema';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bank_id')
                    ->label('BANCO')
                    ->relationship('bank', 'description')
                    ->native(false),
                TextInput::make('description')
                    ->label('TIPO O NOMBRE DE CUENTA'),
                TextInput::make('number')
                    ->label('NUMERO DE CUENTA'),
                Select::make('currency_type_id')
                    ->label('MONEDA')
                    ->preload()
                    ->native(false)
                    ->options(Code::byCatalog('02')->pluck('description','id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank.description')
                    ->label('BANCO'),
                TextColumn::make('description')
                    ->label('TIPO DE CUENTA'),
                TextColumn::make('number')
                    ->label('NÚMERO DE CUENTA'),
                TextColumn::make('currency_type.code')
                    ->label('MONEDA'),
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}
