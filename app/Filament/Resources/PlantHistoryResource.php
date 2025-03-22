<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantHistoryResource\Pages;
use App\Models\PlantHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlantHistoryResource extends Resource
{
    protected static ?string $model = PlantHistory::class;

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
            'index' => Pages\ListPlantHistories::route('/'),
            'create' => Pages\CreatePlantHistory::route('/create'),
            'edit' => Pages\EditPlantHistory::route('/{record}/edit'),
        ];
    }
}
