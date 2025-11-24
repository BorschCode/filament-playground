<?php

namespace App\Filament\Pages;

use App\Filament\Resources\TaskResource\Widgets\ProjectsChart;
use App\Filament\Widgets\DealsChart;
use App\Filament\Widgets\TasksChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            ProjectsChart::class,
            DealsChart::class,
            TasksChart::class,
        ];
    }
}
