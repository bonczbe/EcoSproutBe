<?php

namespace App\Filament\Resources\WeatherResource\Widgets;

use App\Models\Weather;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;

class WeatherFilters extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.device-history-resource.widgets.filters';

    protected int|string|array $columnSpan = 'full';

    public ?array $data;

    public function __construct()
    {
        $this->data = [
            'city' => Weather::first()->city,
            'interval' => 'day',
            'date_start' => now()->startOfDay()->subMonth()->toDateTimeString(),
            'date_end' => now()->endOfDay()->toDateTimeString(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->columns(2)
            ->schema([
                Select::make('city')
                    ->reactive()
                    ->label('Cities')
                    ->nullable(false)
                    ->options(
                        Weather::all()->mapWithKeys(function ($device) {
                            return [$device->city => ucfirst($device->city)];
                        }))
                    ->default($this->data['city'])
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                Select::make('interval')
                    ->label('Interval')
                    ->reactive()
                    ->nullable(false)
                    ->options([
                        'day' => 'Daily',
                        'week' => 'Weekly',
                        'month' => 'Monthly',
                    ])
                    ->default($this->data['interval'])
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                DateTimePicker::make('date_start')
                    ->label('Start Date')
                    ->default($this->data['date_start'])
                    ->reactive()
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                    DateTimePicker::make('date_end')
                    ->label('End Date')
                    ->default($this->data['date_end'])
                    ->reactive()
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),
            ]);
    }

    public function emitFilterChange(): void
    {
        $this->dispatch('changedWeatherFilter', $this->data);
    }
}
