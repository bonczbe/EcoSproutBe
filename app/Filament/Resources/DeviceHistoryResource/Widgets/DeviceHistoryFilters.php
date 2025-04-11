<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;

class DeviceHistoryFilters extends Widget implements HasForms
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
                    ->reactive()
                    ->label('Device')
                    ->nullable(false)
                    ->options(
                        Device::all()->mapWithKeys(function ($device) {
                            return [$device->id => "{$device->id} - {$device->name}"];
                        }))
                    ->default($this->data['name'])
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                Select::make('interval')
                    ->label('Interval')
                    ->reactive()
                    ->nullable(false)
                    ->options([
                        '5 minutes' => 'Every 5 Minutes',
                        'hour' => 'Hourly',
                        'day' => 'Daily',
                        'week' => 'Weekly',
                        'month' => 'Monthly',
                    ])
                    ->default($this->data['interval'])
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                DatePicker::make('date_start')
                    ->label('Start Date')
                    ->default($this->data['date_start'])
                    ->reactive()
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                DatePicker::make('date_end')
                    ->label('End Date')
                    ->default($this->data['date_end'])
                    ->reactive()
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),
            ]);
    }

    public function emitFilterChange(): void
    {
        $this->dispatch('changedDeviceHistoryFilter', $this->data);
    }
}
