<?php

namespace App\Filament\Resources\EquipamentResource\Pages;

use App\Filament\Resources\EquipamentResource;
use App\Models\TypeEquipament;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditEquipament extends EditRecord
{
    protected static string $resource = EquipamentResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                    TextInput::make('name')->label('Equipamento')->columnSpanFull(),
                    RichEditor::make('description')->label('Descrição')->columnSpanFull(),
                    DatePicker::make('made')->label('Fabricação'),
                    Select::make('status')->options([
                        'new'=>  'Novo' ,
                        'medium'=>  'Usado' ,
                        'old'=>  'Velho' ,
                        'trash' => 'Descarte'
                    ]),
                    Select::make('type_equipament_id')
                    ->options( function ()
                    {
                        return TypeEquipament::query()->pluck('name', 'id');
                    }  
                    )
                    ->label('Tipo do Equipamento'),
                    TextInput::make('location_id')->label('Localização'),
                    Toggle::make('current')->label('Alugado'),
                ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
