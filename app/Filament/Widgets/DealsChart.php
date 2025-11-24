<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Filament\Widgets\ChartWidget;

class DealsChart extends ChartWidget
{
    protected static ?string $heading = 'Deals by Stage';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $deals = Deal::all()->groupBy('stage')->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Deals',
                    'data' => array_values($deals->toArray()),
                    'backgroundColor' => [
                        '#3B82F6',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                    ],
                ],
            ],
            'labels' => array_keys($deals->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
