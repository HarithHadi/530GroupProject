<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TransactionResource;
use App\Models\transaction;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use PhpParser\Builder;
use \App\Models\category;


class testChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int | string | array $columnSpan = 1;

    protected static int $borderWidth = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user() ? auth()->user()->id : null);
    }
    protected function getData(): array
    {
       $categoryCounts = [];
       $categoryName = [];
       $colors = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 
            'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 99, 132)', 'rgb(105, 105, 105)',
        ];
        $colorIndex = 0;

        $transactions = Transaction::where('user_id', auth()->id())->get();

        //loop through each transsaction to count categories
        foreach ($transactions as $transaction)
        {
            // Count how many transactions belong to each category
            if (!isset($categoryCounts[$transaction->category_id])) //if $categoryCount[1] doesnt exist it will make categoryCounts[1] = 1
            {
                $categoryCounts[$transaction->category_id] = 1;
            } else { // if it does just add 1
                $categoryCounts[$transaction->category_id]++;
            }
            //Store the category name (only once per category)
            if(!isset($categoryName[$transaction->category_id])) //if $categoryName[1] doesnt exist it will make 1
            {
                $categoryName[$transaction->category_id] = category::find($transaction->category_id)->name;// categoryName[1] = Food & beverages
            }
        }

        // Prepare the chart data
        $labels = [];
        $data = [];
        $backgroundColor = [];
        // dd($categoryCounts);
        foreach ($categoryCounts as $categoryId =>$count){
            // Assign the category name, count, and color
            $labels[] = $categoryName[$categoryId];
            $data[] = $count;
            $backgroundColor[] = $colors[$colorIndex % count($colors)];
            $colorIndex++; 

        }
        
        // Output the final $counter array to inspect the counts for each category_id
        // dd($counter);
        
        return [
            'datasets' =>[
                ['label'=> 'Test',
                'data' => $data,
                'backgroundColor' =>$backgroundColor
                ]
            ],
            'labels' => $labels,
        ];
    }



    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'cutout' => '80%', // Adjust this value to make the doughnut thinner (higher percentage = thinner)
        ];
    }

}