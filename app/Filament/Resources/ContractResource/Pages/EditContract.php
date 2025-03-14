<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\Person;
use Filament\Actions\DeleteAction;

class EditContract extends EditRecord
{
    protected static string $resource = ContractResource::class;


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $person = Person::find($data['peoples_id']);
        $data['person'] = [
            'name' => $person->name ?? '',
            'email' => $person->email ?? '',
            'phone' => $person->phone ?? '',
            'address' => $person->address ?? '',
        ];

        return $data;
    }


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
