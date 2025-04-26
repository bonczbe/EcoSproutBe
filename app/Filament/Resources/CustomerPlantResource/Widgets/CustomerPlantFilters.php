<?php

namespace App\Filament\Resources\CustomerPlantResource\Widgets;

use App\Models\Device;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Widgets\Widget;

class CustomerPlantFilters extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.device-history-resource.widgets.filters';

    protected int|string|array $columnSpan = 'full';

    public ?array $data;

    public function __construct()
    {
        $this->data = [
            'user_name' => User::first()->name ?? null,
            'device_id' => null,
            'plant_id' => null,
            'interval' => '5 minutes',
            'date_start' => now()->startOfDay()->subMonth()->toDateTimeString(),
            'date_end' => now()->endOfDay()->toDateTimeString(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->columns(8)
            ->schema([
                Select::make('user_name')
                    ->reactive()
                    ->searchable()
                    ->live()
                    ->label('User Name')
                    ->columnSpan(2)
                    ->nullable(condition: false)
                    ->options(
                        User::all()->sortBy('name')->mapWithKeys(function ($user) {
                            return [$user->name => $user->name];
                        }))
                    ->default($this->data['user_name'])
                    ->afterStateUpdated(function (Set $set) {
                        $set('device_id', null);
                        $set('plant_id', null);
                        $this->emitFilterChange();
                    }),

                Select::make('device_id')
                    ->reactive()
                    ->live()
                    ->searchable()
                    ->label('Device Name')
                    ->columnSpan(2)
                    ->nullable(condition: false)
                    ->options(function (Get $get) {

                        $userName = $get('user_name');
                        $user = User::where('name', $userName)->with('devices')->first();

                        return $user?->devices()->orderBy('name')->pluck('devices.name', 'devices.id');

                    }
                    )
                    ->default($this->data['user_name'])
                    ->afterStateUpdated(fn (Set $set) => $set('plant_id', null)),
                Select::make('plant_id')
                    ->reactive()
                    ->live()
                    ->searchable()
                    ->label('Plant Name')
                    ->columnSpan(2)
                    ->nullable(condition: false)
                    ->options(function (Get $get) {
                        $deviceName = $get('device_id');
                        $device = Device::with('customer_plants.plant')->find($deviceName);
                        $customerPlants = $device?->customer_plants ?? collect([]);

                        $plants = $customerPlants->mapWithKeys(function ($customerPlant) {
                            return [$customerPlant->id => $customerPlant->plant?->name_en];
                        })->filter() ?? [];

                        return $plants;
                    }
                    )
                    ->default($this->data['user_name'])
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                Select::make('interval')
                    ->label('Interval')
                    ->reactive()
                    ->nullable(false)
                    ->columnSpan(2)
                    ->options([
                        '5 minutes' => 'Every 5 Minutes',
                        'hour' => 'Hourly',
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
                    ->columnSpan(4)
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),

                DateTimePicker::make('date_end')
                    ->label('End Date')
                    ->default($this->data['date_end'])
                    ->reactive()
                    ->columnSpan(4)
                    ->afterStateUpdated(fn () => $this->emitFilterChange()),
            ]);
    }

    public function emitFilterChange(): void
    {
        $this->dispatch('changedWeatherFilter', $this->data);
    }
}
