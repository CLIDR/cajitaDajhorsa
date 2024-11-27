<?php

namespace App\Filament\Admin\Resources\CompanyResource\Pages;

use Filament\Actions;
use App\Models\Company;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\CompanyResource;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;

    protected function afterCreate(): void
    {
        $company = $this->record;
        $company->members()->attach(auth()->user());
    }
}
