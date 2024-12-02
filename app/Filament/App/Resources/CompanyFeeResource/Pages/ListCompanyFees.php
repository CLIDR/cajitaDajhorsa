<?php

namespace App\Filament\App\Resources\CompanyFeeResource\Pages;

use App\Filament\App\Resources\CompanyFeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyFees extends ListRecords
{
    protected static string $resource = CompanyFeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
