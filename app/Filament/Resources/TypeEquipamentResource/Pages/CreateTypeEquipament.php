<?php

namespace App\Filament\Resources\TypeEquipamentResource\Pages;

use App\Filament\Resources\TypeEquipamentResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeEquipament extends CreateRecord
{
    protected static string $resource = TypeEquipamentResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Nome Equipamento'),
                TextInput::make('description')->label('Descrição'),
        ]);
    }
}
