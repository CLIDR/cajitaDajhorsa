<?php

namespace App\Filament\Admin\Resources\CompanyFeeResource\Pages;

use App\Filament\Admin\Resources\CompanyFeeResource;
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
