<?php

namespace App\Filament\Resources\BillsResource\Pages;

use App\Filament\Resources\BillsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBills extends EditRecord
{
    protected static string $resource = BillsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
