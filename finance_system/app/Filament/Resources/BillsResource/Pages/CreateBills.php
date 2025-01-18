<?php

namespace App\Filament\Resources\BillsResource\Pages;

use App\Filament\Resources\BillsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBills extends CreateRecord
{
    protected static string $resource = BillsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id();
 
    return $data;
}
}
