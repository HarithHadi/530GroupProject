<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TransactionResource;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class testChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int | string | array $columnSpan = 1;

    protected static int $borderWidth = 1;

    protected function getData(): array
    {
       
        return [
            'datasets' =>[
                ['label'=> 'Test',
                'data' => [300,499,100],
                'backgroundColor' =>['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                ]
            ],
            'labels' =>["Red","Blue","Green"],
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
