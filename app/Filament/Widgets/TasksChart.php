<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;

class TasksChart extends ChartWidget
{
    protected static ?string $heading = 'Tasks by Status';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $tasks = Task::all()->groupBy('status')->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tasks',
                    'data' => array_values($tasks->toArray()),
                    'backgroundColor' => [
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                        '#6B7280',
                    ],
                ],
            ],
            'labels' => array_keys($tasks->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
