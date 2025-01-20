<?php

namespace App\Filament\Widgets;

use App\Models\bills;
use App\Models\transaction;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use PhpParser\Builder;


class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->where('is_active', true)
        ->where('user_id', Auth::id());
    }

    protected function getStats(): array
    {
        // $Bills = bills::where('user_id', auth()->id())->get();
        // dd($Bills);
        $userId = Auth::id();
        
        $totalDaily = bills::where('user_id', $userId)
        ->where('frequency', 'daily')
        ->sum('amount');

        $totalMonthly = bills::where('user_id', $userId)
        ->where('frequency', 'monthly')
        ->sum('amount');

        $totalYearly = Bills::where('user_id', $userId)
        ->where('frequency', 'yearly')
        ->sum('amount');

        
        $dailyColor = 'success'; // Default to green
        $dailyIcon = 'heroicon-m-arrow-trending-up'; // Default icon
        if ($totalDaily > 10 && $totalDaily <= 50) {
            $dailyDescription = 'Spending a little too much';
            $dailyColor = 'warning'; // Yellow
            $dailyIcon = 'heroicon-o-exclamation-circle'; // Warning icon
        } elseif ($totalDaily > 50) {
            $dailyDescription = 'You need to lower your bills';
            $dailyColor = 'danger'; // Red
            $dailyIcon = 'heroicon-o-exclamation-triangle'; // Danger icon
        } else {
            $dailyDescription = 'Your daily spending is within a safe range';
        }

        
        $monthlyColor = 'success'; // Default to green
        $monthlyIcon = 'heroicon-m-arrow-trending-up'; // Default icon
        if ($totalMonthly > 50 && $totalMonthly <= 100) {
            $monthlyDescription = 'Your monthly spending is moderate';
            $monthlyColor = 'warning'; // Yellow
            $monthlyIcon = 'heroicon-o-exclamation-circle'; // Warning icon
        } elseif ($totalMonthly > 100) {
            $monthlyDescription = 'You might be overspending monthly!';
            $monthlyColor = 'danger'; // Red
            $monthlyIcon = 'heroicon-o-exclamation-triangle'; // Danger icon
        } else {
            $monthlyDescription = 'Your monthly spending is under control';
        }

        
        $yearlyColor = 'success'; // Default to green
        $yearlyIcon = 'heroicon-m-arrow-trending-up'; // Default icon
        if ($totalYearly > 500 && $totalYearly <= 1000) {
            $yearlyDescription = 'Your yearly spending is significant';
            $yearlyColor = 'warning'; // Yellow
            $yearlyIcon = 'heroicon-o-exclamation-circle'; // Warning icon
        } elseif ($totalYearly > 1000) {
            $yearlyDescription = 'You might be in financial trouble yearly!';
            $yearlyColor = 'danger'; // Red
            $yearlyIcon = 'heroicon-o-exclamation-triangle'; // Danger icon
        } else {
            $yearlyDescription = 'Your yearly spending is under control';
        }

        return [
            // Stat for daily bills
            Stat::make('Total Daily Bills', 'RM ' . number_format($totalDaily, 2))
                ->description($dailyDescription)
                ->descriptionIcon($dailyIcon)
                ->color($dailyColor),

            // Stat for monthly bills
            Stat::make('Total Monthly Bills', 'RM ' . number_format($totalMonthly, 2))
                ->description($monthlyDescription)
                ->descriptionIcon($monthlyIcon)
                ->color($monthlyColor),

            // Stat for annual bills
            Stat::make('Total Annual Bills', 'RM ' . number_format($totalYearly, 2))
                ->description($yearlyDescription)
                ->descriptionIcon(  $yearlyIcon)
                ->color($yearlyColor),
        ];
    }

    
}
