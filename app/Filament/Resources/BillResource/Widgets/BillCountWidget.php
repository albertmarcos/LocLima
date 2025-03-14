<?php

namespace App\Filament\Resources\BillResource\Widgets;

use App\Models\Bill;
use Filament\Widgets\ChartWidget;

class BillCountWidget extends ChartWidget
{
    protected static ?string $heading = 'Cobranças por Status';


    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $statuses = [
            'pending' => 'Pendente',
            'processing' => 'Em Processamento',
            'paid' => 'Pago',
            'overdue' => 'Atrasado',
            'canceled' => 'Cancelado',
            'refound' => 'Reembolsado',
            'parcial' => 'Parcial',
            'negocieted' => 'Negociado',
            'failed' => 'Erro no Pagamento',
        ];

        $data = [];
        foreach ($statuses as $status => $label) {
            $data[] = [
                'label' => $label,
                'value' => Bill::where('status', $status)->count(),
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cobranças',
                    'data' => array_column($data, 'value'),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FFCD56',
                        '#4BC0C0',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => array_column($data, 'label'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
