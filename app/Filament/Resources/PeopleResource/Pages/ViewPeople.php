<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Bill;

class ViewPeople extends ViewRecord
{
    protected static string $resource = PeopleResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        $contracts = $this->record->contracts;

        $totalBills = 0;
        $paidBills = 0;
        $dueBills = 0;
        $overdueBills = 0;

        foreach ($contracts as $contract) {
            $totalBills += $contract->bills()->count();
            $paidBills += $contract->bills()->where('status', 'paid')->count();
            $dueBills += $contract->bills()->where('status', 'due')->count();
            $overdueBills += $contract->bills()->where('status', 'overdue')->count();
        }

        return $infolist->schema([
            Grid::make()->columns([
                'sm' => 2,
                'xl' => 6,
                '2xl' => 8,
            ])->schema([
                Section::make('Informações Pessoais')->schema([
                    ImageEntry::make('profile_photo')->label('Foto de Perfil')->circular()->columnSpanFull(),
                    TextEntry::make('name')->label('Nome'),
                    TextEntry::make('last_name')->label('Sobrenome'),
                    TextEntry::make('surname')->label('Conhecido Por')->columnSpanFull(),
                    TextEntry::make('birthdate')->label('Data de Nascimento')->formatStateUsing(function ($state) {
                        return \Carbon\Carbon::parse($state)->format('d M Y');
                    }),
                    TextEntry::make('gender')->label('Gênero')->formatStateUsing(function ($state) {
                        return $state === 'male' ? 'Masculino' : ($state === 'female' ? 'Feminino' : 'Outro');
                    }),
                    TextEntry::make('nationality')->label('Nacionalidade'),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 4,
                    '2xl' => 5,
                ]),
                Section::make('Contato')->schema([
                    TextEntry::make('phone')->label('Telefone'),
                    TextEntry::make('email')->label('Email'),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 2,
                    '2xl' => 3,
                ]),
                Section::make('Documentos')->schema([
                    TextEntry::make('cpf')->label('CPF'),
                    TextEntry::make('rg')->label('RG'),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 4,
                    '2xl' => 5,
                ]),
                Section::make('Outras Informações')->schema([
                    TextEntry::make('description')->label('Anotações')->markdown(),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 2,
                    '2xl' => 3,
                ]),
                
                Section::make('Endereço')->schema([
                    TextEntry::make('address')->columnSpanFull()->label('Endereço'),
                    TextEntry::make('neighborhood')->label('Bairro'),
                    TextEntry::make('city')->label('Cidade'),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 4,
                    '2xl' => 5,
                ]),
                
                Section::make('Localização')->description('*Mapa Com Georeferenciamento em Desenvolvimento*')->schema([])->columnSpan([
                    'sm' => 2,
                    'xl' => 2,
                    '2xl' => 3,
                ]),
                 // Nova seção para informações de cobranças
                Section::make('Informações de Cobranças')->schema([
                    TextEntry::make('total_bills')->label('Total de Cobranças')->default($totalBills),
                    TextEntry::make('paid_bills')->label('Cobranças Pagas')->default($paidBills),
                    TextEntry::make('due_bills')->label('Cobranças a Vencer')->default($dueBills),
                    TextEntry::make('overdue_bills')->label('Cobranças Vencidas')->default($overdueBills),
                ])->columns(4)->columnSpan([
                    'sm' => 2,
                    'xl' => 4,
                    '2xl' => 8,
                ]),
            ]),
        ]);
    }

    public function getTitle(): string
    {
        return 'Cadastro do ' . $this->record->name ?? 'Visualizando Cliente';
    }

    protected function getActions(): array
    {
        return [
            EditAction::make('Edit')
        ];
    }
}
