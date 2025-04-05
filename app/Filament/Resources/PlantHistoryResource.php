<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantHistoryResource\Pages;
use App\Models\PlantHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlantHistoryResource extends Resource
{
    protected static ?string $model = PlantHistory::class;

    protected static ?string $navigationGroup = 'Plants';

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
                TextColumn::make('customerPlant.id')
                    ->label('Plant ID')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('moisture_level')
                    ->label('Moisture Level')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('maximum_moisture')
                    ->label('Max Moisture')
                    ->getStateUsing(fn ($record) =>
                        ($record->customerPlant->maximum_moisture === null || $record->customerPlant->maximum_moisture < 0)
                            ? $record->customerPlant->plant?->plantType?->max_soil_moisture
                            : $record->customerPlant->maximum_moisture
                    )
                    ->sortable()
                    ->suffix('%')
                    ->alignRight(),
                    TextColumn::make('minimum_moisture')
                        ->label('Min Moisture')
                        ->getStateUsing(fn ($record) =>
                            ($record->customerPlant->minimum_moisture === null || $record->customerPlant->minimum_moisture < 0)
                                ? $record->customerPlant->plant?->plantType?->min_soil_moisture
                                : $record->customerPlant->minimum_moisture
                        )
                        ->sortable()
                        ->suffix('%')
                        ->alignRight(),
            ])
            ->filters([
                        //
                    ])
            ->actions([
                        Tables\Actions\EditAction::make(),
                    ])
            ->bulkActions([
                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                        ]),
                    ]);
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
            'index' => Pages\ListPlantHistories::route('/'),
            'create' => Pages\CreatePlantHistory::route('/create'),
            'edit' => Pages\EditPlantHistory::route('/{record}/edit'),
        ];
    }
}
