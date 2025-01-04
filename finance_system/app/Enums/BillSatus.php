<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum BillSatus:string implements HasLabel, HasColor
{

    
    case Daily = 'daily';
    case Monthly = 'monthly';
    case Annually = 'yearly';

    /**
     * @inheritDoc
     */
    public function getLabel(): ?string
    {
        return $this ->name;
    }

    

    public function getColor(): ?string
    {
        return match($this){
            self::Daily =>'danger',
            self::Monthly =>'warning',
            self::Annually =>'success'
        };
    }
}
