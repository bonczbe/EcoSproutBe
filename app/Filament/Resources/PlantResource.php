<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantResource\Pages;
use App\Models\Plant;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlantResource extends Resource
{
    protected static ?string $model = Plant::class;

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
                TextColumn::make('name_botanical'),
                TextColumn::make('name_en')
                    ->label('English Name'),
                TextColumn::make('name_hu')
                    ->label('Hungarian Name'),
                    TextColumn::make('family')
                        ->label('Family')
                        ->badge()
                        ->color('info'),
                        TextColumn::make('family_hu')
                            ->label('Family (HU)')
                            ->badge()
                            ->color('info'),
                ImageColumn::make('default_image'),
                TextColumn::make('species_epithet'),
                TextColumn::make('genus'),
                TextColumn::make('plantType.type')
                    ->label('Plant Type (EN)'),
                TextColumn::make('plantType.type_hu')
                    ->label('Plant Type (HU)'),
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
            'index' => Pages\ListPlants::route('/'),
            'create' => Pages\CreatePlant::route('/create'),
            'edit' => Pages\EditPlant::route('/{record}/edit'),
        ];
    }
}
