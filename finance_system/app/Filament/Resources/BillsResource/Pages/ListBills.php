<?php

namespace App\Filament\Resources\BillsResource\Pages;

use App\Filament\Resources\BillsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use PhpParser\Builder;

class ListBills extends ListRecords
{
    protected static string $resource = BillsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user);
    }
}
