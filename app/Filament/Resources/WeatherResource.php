<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeatherResource\Pages;
use App\Models\Weather;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
            'index' => Pages\ListWeather::route('/'),
            'create' => Pages\CreateWeather::route('/create'),
            'edit' => Pages\EditWeather::route('/{record}/edit'),
        ];
    }
}
