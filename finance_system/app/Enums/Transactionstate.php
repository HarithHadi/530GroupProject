<?php
namespace App\Enums;

// use Filament\Actions\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum Transactionstate:string implements HasIcon
{
    case Food = 'Food & Beverage';

    public static function fromcategoryId (int $catid): ?self
    {
        return match ($catid) {
            2 =>self::Food,
        };
    }
    
    
    public function getIcon(): ?string
    {
        return match($this){
            self :: Food => 'heroicon-o-cake'
        };
    }
}