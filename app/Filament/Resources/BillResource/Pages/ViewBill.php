<?php

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Http\Request;

class ViewBill extends ViewRecord
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('pay')
                ->label('Pagar')
                ->form([
                    TextInput::make('paid_value')->label('Valor Pago')->required(),
                    TextInput::make('discount')->label('Desconto'),
                    TextInput::make('interest')->label('Juros'),
                    TextInput::make('fine')->label('Multa'),
                ])->modalHeading('Informar Valores de Pagamento')
                ->action(function (array $data) { $this->payBill($data); }),
                
                
        ];
    }

    protected function getFooterActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Informações da Cobrança')->schema([
                TextEntry::make('name')->label('Nome')->size('lg'),
                TextEntry::make('description')->label('Descrição')->columnSpanFull(),
                TextEntry::make('status')->label('Status')->badge(),
                TextEntry::make('type')->label('Tipo'),
                TextEntry::make('due_date')->label('Data de Vencimento'),
                TextEntry::make('payment_date')->label('Data de Pagamento'),
                Section::make('Valores')->schema([
                    TextEntry::make('value')->label('Valor')->size('lg'),
                    TextEntry::make('paid_value')->label('Valor Pago')->size('lg')->color('success')->default(0),
                    TextEntry::make('discount')->label('Desconto')->color('warning')->default(0),
                    TextEntry::make('interest')->label('Juros')->color('danger')->default(0),
                    TextEntry::make('fine')->label('Multa')->color('danger')->default(0),
                ])->columns(2)->columnSpanFull(),
            ])->columns(2)->columnSpanFull(),

            Grid::make()->columns(2)->schema([
                Section::make('Informações da Pessoa')->schema([
                    TextEntry::make('contract.people.name')->label('Nome'),
                    TextEntry::make('contract.people.email')->label('Email'),
                    TextEntry::make('contract.people.phone')->label('Telefone'),
                ])->columnSpan(1),

                Section::make('Informações do Contrato')->schema([
                    TextEntry::make('contract.contract_number')->label('Número do Contrato'),
                    TextEntry::make('contract.start')->label('Início'),
                    TextEntry::make('contract.end')->label('Fim'),
                    TextEntry::make('contract.value')->label('Valor do Contrato'),
                ])->columnSpan(1),
                
            ])->columnSpanFull(),
        ]);
    }

    public function payBill(array $data)
    {
        $this->record->update([
            'paid_value' => $data['paid_value'],
            'discount' => $data['discount'],
            'interest' => $data['interest'],
            'fine' => $data['fine'],
            'status' => 'paid',
            'payment_date' => now(),
        ]);
    }
}