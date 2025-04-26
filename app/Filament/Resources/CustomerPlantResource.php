<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerPlantResource\Pages;
use App\Models\CustomerPlant;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerPlantResource extends Resource
{
    protected static ?string $model = CustomerPlant::class;

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
                TextColumn::make('id'),
                TextColumn::make('device.users.name')
                    ->label('User Name'),
                TextColumn::make('pot_size')
                    ->label('Pot Size'),
                TextColumn::make('dirt_type'),
                TextColumn::make('maximum_moisture')
                    ->suffix('%'),
                TextColumn::make('minimum_moisture')
                    ->suffix('%'),
                TextColumn::make('plant.name_en')
                    ->label('Plant Name (EN)'),
                TextColumn::make('plant.name_hu')
                    ->label('Plant Name (HU)'),
                ImageColumn::make('plant_img')
                    ->label('Image'),
                TextColumn::make('plant.customer_plants.type')
                    ->label('Plant Type (EN)'),
                TextColumn::make('plant.customer_plants.type_hu')
                    ->label('Plant Type (HU)'),
                TextColumn::make('Moisture Level')
                    ->getStateUsing(fn ($record) => $record->histories->last()->moisture_level ?? 0)
                    ->suffix('%')
                    ->color(function ($record) {
                        $moistureLevel = $record->histories->last()->moisture_level ?? 0;
                        $minMoisture = $record->minimum_moisture ?? 0;

                        return $moistureLevel < $minMoisture ? 'danger' : null;
                    }),
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
            'index' => Pages\ListCustomerPlants::route('/'),
            'create' => Pages\CreateCustomerPlant::route('/create'),
            'edit' => Pages\EditCustomerPlant::route('/{record}/edit'),
        ];
    }
}
