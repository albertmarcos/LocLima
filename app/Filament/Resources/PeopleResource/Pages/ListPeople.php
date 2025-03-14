<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListPeople extends ListRecords
{
    protected static string $resource = PeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('profile_photo')->label('Foto')->circular(),
            TextColumn::make('name')->label('Nome')->searchable(),
            TextColumn::make('phone')->label('Telefone')->searchable(),
            TextColumn::make('city')->label('Cidade')->searchable(),
        ])->actions([
            Action::make('Contrato')
        ]);
    }
}
