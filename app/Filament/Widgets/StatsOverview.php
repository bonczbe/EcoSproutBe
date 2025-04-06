<?php

namespace App\Filament\Widgets;

use App\Models\CustomerPlant;
use App\Models\Device;
use App\Models\Plant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('Total Plants', Plant::count())
                ->description('All registered plants')
                ->descriptionIcon('heroicon-m-globe-europe-africa')
                ->color('success'),
            Stat::make('Total Customer Plants', CustomerPlant::count())
                ->description('All registered customer plants')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
            Stat::make('Total Devices', Device::count())
                ->description('All registered devices')
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('success'),
        ];
    }
}
