<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantTypeResource\Pages;
use App\Models\PlantType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlantTypeResource extends Resource
{
    protected static ?string $model = PlantType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
