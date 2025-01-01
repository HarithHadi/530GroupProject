<?php

namespace App\Filament\Resources\BillsResource\Pages;

use App\Filament\Resources\BillsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use PhpParser\Builder;

class ViewBills extends ViewRecord
{
    protected static string $resource = BillsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user);
    }
}
