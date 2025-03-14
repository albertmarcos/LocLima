<?php

namespace App\Filament\Resources\PeopleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'contracts';

    protected static ?string $label = 'Contratos';
    
    protected static ?string $title = 'Contratos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start')->format('Y-m-d')->label('Inicio'),
                DatePicker::make('end')->format('Y-m-d')->label('Final'),
                TextInput::make('year')->label('Vigencia'),
                TextInput::make('value')->label('valor'),
                Select::make('type')->options([
                    
                ]),
                Checkbox::make('recursive')->label('Renovação Automatica')->default(true)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('contract_number')
            ->columns([
                Tables\Columns\TextColumn::make('contract_number')->label('Número do Contrato'),
                Tables\Columns\TextColumn::make('start')->label('Início')->date(),
                Tables\Columns\TextColumn::make('end')->label('Final')->date(),
                Tables\Columns\TextColumn::make('year')->label('Vigência'),
                Tables\Columns\TextColumn::make('value')->label('Valor'),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'monthly' => 'Mensal',
                        'annual' => 'Anual',
                        'usage' => 'Consumo',
                        default => 'Desconhecido',
                    };
              }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
