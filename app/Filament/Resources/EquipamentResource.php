<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipamentResource\Pages;
use App\Filament\Resources\EquipamentResource\RelationManagers;
use App\Models\Equipament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipamentResource extends Resource
{
    protected static ?string $model = Equipament::class;

    protected static ?string $navigationIcon = 'eos-phonelink';

    protected static ?string $navigationGroup = 'Gestão';

    protected static ?string $label = "Equipamentos";

    protected static ?int $navigationSort = 3;


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
                TextColumn::make('name')
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
            'index' => Pages\ListEquipaments::route('/'),
            'create' => Pages\CreateEquipament::route('/create'),
            'edit' => Pages\EditEquipament::route('/{record}/edit'),
        ];
    }
}
