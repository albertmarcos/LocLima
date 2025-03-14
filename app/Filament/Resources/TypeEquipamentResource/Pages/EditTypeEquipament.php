<?php

namespace App\Filament\Resources\TypeEquipamentResource\Pages;

use App\Filament\Resources\TypeEquipamentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeEquipament extends EditRecord
{
    protected static string $resource = TypeEquipamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
