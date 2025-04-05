<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceHistoryResource\Pages;
use App\Models\DeviceHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('device.id')
                    ->label('Device ID'),
                TextColumn::make('device.users.name')
                    ->label('User Name'),
                TextColumn::make('device.city')
                    ->label('City'),
                TextColumn::make('device.name')
                    ->label('Device Name'),
                TextColumn::make('water_level')
                    ->numeric()
                    ->default(0),
                TextColumn::make('temperature')
                    ->suffix('℃')
                    ->numeric()
                    ->default(0),
                TextColumn::make('created_at')
                    ->dateTime('Y.m.d - H:i'),
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
