<?php

namespace App\Filament\Widgets;

use App\Models\bills;
use App\Models\transaction;
use App\Models\User;
use Auth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminWidgets extends BaseWidget
{
    
    protected function getStats(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->create(2024, 11, 25, 0, 0, 0),
                end: now()->endOfYear(),
            )
            ->perMonth() // Group by month
            ->count();   // Count users created each month

        // Map the data for the chart (labels and values)
        // dd($data);
        $chartData = $data->map(fn (TrendValue $value) => $value->aggregate)->toArray();

        $data2 = Trend::model(transaction::class)
            ->between(
                start: now()->create(2024, 11, 25, 0, 0, 0),
                end: now()->endOfYear(),
            )
            ->perMonth() // Group by month
            ->count();   // Count users created each month

        // Map the data for the chart (labels and values)
        // dd($data);
        $chartData2 = $data2->map(fn (TrendValue $value) => $value->aggregate)->toArray();

        // dd($chartData);
        return [
            Stat::make('Total Users', User::count()),
            // ->chart( $chartData)
            
            Stat::make('Total Transaction', transaction::count()),
            // ->chart( $chartData2)
            Stat::make('Total Bills', bills::count())
            // ->chart( $chartData2)

            

        ];
    }
   
    public static function canView(): bool 
    {
        return Auth::check() && Auth::user()->role === 'admin';
    } 
    // protected static function getColumnSpan(): string|int
    // {
    //     return 'full'; // Makes the widget span the full width
    // }
}
