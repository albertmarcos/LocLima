<?php

namespace App\Filament\Resources\RoutineResource\Pages;

use App\Filament\Resources\RoutineResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Select;

class ViewRoutine extends ViewRecord
{
    protected static string $resource = RoutineResource::class;

    protected static ?string $title = 'Rota de tarefas';

    protected static ?string $label = 'Rota';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('addResponsible')
                ->label('Adicionar Responsável')
                ->form([
                    Select::make('responsible_id')
                        ->label('Responsável')
                        ->relationship('responsible', 'name')
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['responsible_id' => $data['responsible_id']]);
                }),
            Actions\Action::make('removeResponsible')
                ->label('Remover Responsável')
                ->action(function () {
                    $this->record->update(['responsible_id' => null]);
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detalhes da Rota')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome')
                            ->size('lg')->color('secondary'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->size('lg')->color('secondary'),
                        TextEntry::make('owner.name')
                            ->label('Quem criou')
                            ->size('lg')->color('secondary'),
                        TextEntry::make('responsible.name')
                            ->label('Responsável')
                            ->size('lg')->color('secondary'),
                    ]),
            ]);
    }
}
