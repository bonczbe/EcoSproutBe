<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeatherResource\Pages;
use App\Models\Weather;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WeatherResource extends Resource
{
    protected static ?string $model = Weather::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('city')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                TextColumn::make('date')
                    ->date('Y.m.d - D')
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),

                TextColumn::make('uv')
                    ->numeric()
                    ->default(0),

                TextColumn::make('max_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('Max')
                    ->suffix('℃')
                    ->sortable()
                    ->color(fn ($record) => $record->max_celsius > 35 ? 'danger' : ($record->max_celsius < 0 ? 'info' : 'default')),

                TextColumn::make('min_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('Min')
                    ->suffix('℃')
                    ->sortable()
                    ->color(fn ($record) => $record->min_celsius < 0 ? 'info' : 'default'),

                TextColumn::make('average_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('AVG')
                    ->suffix('℃')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('totalprecip_mm')
                    ->numeric()
                    ->default(0)
                    ->label('Precipitate')
                    ->tooltip('Total precipitation in millimeters')
                    ->sortable()
                    ->suffix('mm')
                    ->alignCenter(),

                TextColumn::make('rain_chance')
                    ->numeric()
                    ->default(0)
                    ->label('Rain')
                    ->suffix('%')
                    ->color(fn ($record) => $record->rain_chance > 50 ? 'warning' : 'default')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('snow_chance')
                    ->numeric()
                    ->default(0)
                    ->label('Snow')
                    ->suffix('%')
                    ->color(fn ($record) => $record->snow_chance > 50 ? 'info' : 'default')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('expected_maximum_rain')
                    ->numeric()
                    ->default(0)
                    ->label('Max Rain')
                    ->suffix('mm')
                    ->sortable(),

                TextColumn::make('expected_maximum_snow')
                    ->numeric()
                    ->default(0)
                    ->label('Max Snow')
                    ->suffix('mm')
                    ->sortable(),
                    TextColumn::make('rain_chance_tomorrow')
                    ->numeric()
                    ->default(0)
                    ->label('Rain Tomorrow')
                    ->suffix('%')
                    ->color(fn ($record) => $record->rain_chance_tomorrow > 50 ? 'warning' : 'default')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('snow_chance_tomorrow')
                    ->numeric()
                    ->default(0)
                    ->label('Snow Tomorrow')
                    ->suffix('%')
                    ->color(fn ($record) => $record->snow_chance_tomorrow > 50 ? 'info' : 'default')
                    ->sortable()
                    ->alignCenter(),


                TextColumn::make('expected_maximum_rain_tomorrow')
                    ->numeric()
                    ->default(0)
                    ->label('Max Rain Tomorrow')
                    ->suffix('mm')
                    ->sortable(),

                TextColumn::make('expected_maximum_snow_tomorrow')
                    ->numeric()
                    ->default(0)
                    ->label('Max Snow Tomorrow')
                    ->suffix('mm')
                    ->sortable(),
                    TextColumn::make('uv_tomorrow')
                        ->numeric()
                        ->default(0)
                        ->label('UV Tomorrow')
                        ->suffix('')
                        ->sortable()
                        ->alignCenter(),

                TextColumn::make('expected_max_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('Max Temp Tomorrow')
                    ->suffix('℃')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('expected_min_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('Min Temp Tomorrow')
                    ->suffix('℃')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('expected_avgtemp_celsius')
                    ->numeric()
                    ->default(0)
                    ->label('Avg Temp Tomorrow')
                    ->suffix('℃')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeather::route('/'),
            'create' => Pages\CreateWeather::route('/create'),
            'edit' => Pages\EditWeather::route('/{record}/edit'),
        ];
    }
}
