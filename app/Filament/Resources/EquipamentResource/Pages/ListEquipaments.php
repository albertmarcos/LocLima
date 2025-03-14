<?php

namespace App\Filament\Resources\EquipamentResource\Pages;

use App\Filament\Resources\EquipamentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipaments extends ListRecords
{
    protected static string $resource = EquipamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
