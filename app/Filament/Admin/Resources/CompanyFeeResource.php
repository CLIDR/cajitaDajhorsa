<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\CompanyFee;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\CompanyFeeType;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\CompanyFeeResource\Pages;
use App\Filament\Admin\Resources\CompanyFeeResource\RelationManagers;

class CompanyFeeResource extends Resource
{
    protected static ?string $model = CompanyFee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // dd(auth()->user()->companies);
        return $form
            ->schema([
                Select::make('company_id')
                    ->preload()
                    ->relationship('company', 'name')
                    ->native(false)
                    ->searchable(),
                DatePicker::make('date')
                    ->native(false)
                    ->displayFormat('m/Y')
                    ->default(now())
                    ->maxDate(now())
                    ->minDate(now()->subYears(5)),
                Radio::make('feeType')
                    ->options(CompanyFeeType::pluck('description', 'id'))
                    ->default(1)
                    ->inline()
                    ->inlineLabel(false),
                TextInput::make('description')
                    ->columnSpan(2),
                TextInput::make('amount')
                    ->prefix('S/.')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                RichEditor::make('observation')
                    ->columnSpanFull(),
            ])->columns(3);
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
            'index' => Pages\ListCompanyFees::route('/'),
            'create' => Pages\CreateCompanyFee::route('/create'),
            'edit' => Pages\EditCompanyFee::route('/{record}/edit'),
        ];
    }
}
