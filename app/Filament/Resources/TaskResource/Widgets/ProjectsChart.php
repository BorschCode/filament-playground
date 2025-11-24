<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectsChart extends ChartWidget
{
    protected static ?string $heading = 'Projects Overview';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $projects = Project::all()->groupBy('status')->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Projects by Status',
                    'data' => array_values($projects->toArray()),
                    'backgroundColor' => [
                        '#10B981', // green
                        '#F59E0B', // yellow
                        '#EF4444', // red
                        '#3B82F6', // blue
                    ],
                ],
            ],
            'labels' => array_keys($projects->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
