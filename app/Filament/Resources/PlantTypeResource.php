<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantTypeResource\Pages;
use App\Models\PlantType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlantTypeResource extends Resource
{
    protected static ?string $model = PlantType::class;

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
                TextColumn::make('type'),
                TextColumn::make('type_hu'),
                TextColumn::make('min_soil_moisture')
                    ->label('min soil moisture')
                    ->suffix('%'),
                TextColumn::make('max_soil_moisture')
                    ->label('max soil moisture')
                    ->suffix('%'),
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
            'index' => Pages\ListPlantTypes::route('/'),
            'create' => Pages\CreatePlantType::route('/create'),
            'edit' => Pages\EditPlantType::route('/{record}/edit'),
        ];
    }
}
