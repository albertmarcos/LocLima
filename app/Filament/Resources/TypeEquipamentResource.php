<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeEquipamentResource\Pages;
use App\Filament\Resources\TypeEquipamentResource\RelationManagers;
use App\Models\TypeEquipament;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypeEquipamentResource extends Resource
{
    protected static ?string $model = TypeEquipament::class;

    protected static ?string $navigationIcon = 'eos-phonelink-setup';

    protected static ?string $navigationGroup = 'Gestão';
    
    protected static ?string $label = "Tipos de Equipamentos";

    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->label('Nome Equipamento'),
                TextInput::make('description')->label('Descrição'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->label('Nome Equipamento')
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
            'index' => Pages\ListTypeEquipaments::route('/'),
            'create' => Pages\CreateTypeEquipament::route('/create'),
            'edit' => Pages\EditTypeEquipament::route('/{record}/edit'),
        ];
    }
}
