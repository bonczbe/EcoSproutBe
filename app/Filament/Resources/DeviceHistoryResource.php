<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceHistoryResource\Pages;
use App\Models\DeviceHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceHistoryResource extends Resource
{
    protected static ?string $model = DeviceHistory::class;

    protected static ?string $navigationGroup = 'Devices';

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
            'index' => Pages\ListDeviceHistories::route('/'),
            'create' => Pages\CreateDeviceHistory::route('/create'),
            'edit' => Pages\EditDeviceHistory::route('/{record}/edit'),
        ];
    }
}
