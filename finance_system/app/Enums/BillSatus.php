<?php

namespace App\Enums;

use Filament\Actions\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum BillSatus:string
{

    
    case Daily = 'daily';
    case Monthly = 'monthly';
    case Annually = 'yearly';

}
