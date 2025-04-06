<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;

class Filters extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.device-history-resource.widgets.filters';

    protected int|string|array $columnSpan = 'full';

    public ?array $data;

    public function __construct()
    {
        $this->data = [
            'name' => Device::first()->id,
            'interval' => 'day',
            'date_start' => now()->subMonth()->toDateString(),
            'date_end' => now()->toDateString(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->columns(2)
            ->schema([
                Select::make('name')
                    ->label('Device')
                    ->nullable(false)
                    ->options(Device::all()->pluck('name', 'id'))
                    ->default(Device::first()->id)
                    ->afterStateUpdated(fn (?string $state) => $this->dispatch('updateDevice', deviceId: $state)),

                Select::make('interval')
                    ->label('Interval')
                    ->nullable(false)
                    ->options([
                        '5 minutes' => 'Every 5 Minutes',
                        'hour' => 'Hourly',
                        'day' => 'Daily',
                        'week' => 'Weekly',
                        'month' => 'Monthly',
                    ])
                    ->default('day')
                    ->afterStateUpdated(fn (?string $state) => $this->dispatch('updateInterval', interval: $state)),

                DatePicker::make('date_start')
                    ->label('Start Date')
                    ->default(now()->subMonth()->toDateString())
                    ->afterStateUpdated(fn (?string $state) => $this->dispatch('updateFromDate', from: $state)),

                DatePicker::make('date_end')
                    ->label('End Date')
                    ->default(now()->toDateString())
                    ->afterStateUpdated(fn (?string $state) => $this->dispatch('updateToDate', to: $state)),
            ]);
    }
}
