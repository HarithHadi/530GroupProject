<?php

namespace App\Filament\Widgets;

use App\Models\transaction;
use Filament\Forms\Components\Field;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 2;
   
    // protected static ?int $columnSpan = 2;
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user() ? auth()->user()->id : null);
    }


    protected function getData(): array
    {
        $userId = Auth::id();

        $transactions = Transaction::where('user_id', auth()->id())->get();
        
        // $data = Trend::model(transaction::where('user_id',$userId))
        // ->dateColumn('transaction_date')
        // // ->filter(fn ($query) => $query->where('user_id', Auth::id()))
        // ->between(
        //     start: now()->startOfYear(),
        //     end: now()->endOfYear(),
        // )
        // ->perMonth()
        // ->sum('amount');


        $data = Trend::query(transaction::query()->where('user_id', $userId) )
            ->dateColumn('transaction_date')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');
        // ->count();

        // dd($data);
 
    return [
        'datasets' => [
            [
                'label' => 'Transactions',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getMaxHeight(): string
    {
        return '500px'; // Increase the height of the chart
    }

    protected function getMaxWidth(): string
    {
        return '100%'; // Make it take the full width
    }
}
// test