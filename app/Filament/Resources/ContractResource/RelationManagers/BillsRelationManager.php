<?php

namespace App\Filament\Resources\ContractResource\RelationManagers;

use App\Http\Controllers\BillBulkController;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;

class BillsRelationManager extends RelationManager
{
    protected static string $relationship = 'bills';

    protected static ?string $label = 'Cobranças';

    protected static ?string $title = 'Cobranças';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('description')->label('Descrição')->columnSpanFull(),
                TextInput::make('value')->label('Valor')->required(),
                Select::make('status')->label('Status')->options([
                    'pending' => 'Aberta',
                    'processing' => 'Processando',
                    'paid' => 'Pago',
                    'overdue' => 'Vencido',
                    'canceled' => 'Cancelado',
                    'refound' => 'Estornado',
                    'partially' => 'Parcial',
                    'negotiated' => 'Negociado',
                    'failed' => 'Falha no Pagamento'
                ])->required(),
                Select::make('type')->label('Tipo')->options([
                    'monthly' => 'Mensal',
                    'annual' => 'Anual',
                    'usage' => 'Consumo',
                ])->required(),
                DatePicker::make('due_date')->label('Data de Vencimento')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('value')->label('Valor'),
                TextColumn::make('paid_value')->label('Valor Pago'),
                TextColumn::make('status')->label('Status')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'pending' => 'Pendente',
                        'processing' => 'Em Processamento',
                        'paid' => 'Pago',
                        'overdue' => 'Atrasado',
                        'canceled' => 'Cancelado',
                        'refound' => 'Reembolsado',
                        'parcial' => 'Parcial',
                        'negocieted' => 'Negociado',
                        'failed' => 'Error no Pagamento',
                        default => 'Desconhecido',
                    };
                }),
                TextColumn::make('type')->label('Tipo')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'monthly' => 'Mensal',
                        'annual' => 'Anual',
                        'usage' => 'Consumo',
                        default => 'Desconhecido',
                    };
                }),
                TextColumn::make('due_date')->label('Data de Vencimento'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                CreateAction::make('createBulkBills')
                        ->label('Criar Cobranças em Lote')
                        ->action(function (array $data) {
                            $contract = $this->ownerRecord;
                            $controller = new BillBulkController();
                            $request = new Request($data);
                            $controller->createBulkBills($request, $contract);
                        })
                        ->form([
                            TextInput::make('name')->label('Nome')->required(),
                            TextInput::make('description')->label('Descrição')->columnSpanFull(),
                            TextInput::make('due_day')
                                ->label('Dia do Vencimento')
                                ->required()
                                ->numeric(),
                            TextInput::make('value')
                                ->label('Valor')
                                ->required()
                                ->default(fn ($record) => $this->ownerRecord->value),
                            DatePicker::make('start_date')
                                ->label('Data de Início')
                                ->required()
                                ->default(fn ($record) => $this->ownerRecord->start),
                            DatePicker::make('end_date')
                                ->label('Data de Fim')
                                ->required()
                                ->default(fn ($record) => $this->ownerRecord->end),
                        ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('createTask')
                    ->label('Criar Tarefa')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('Nome')->required(),
                        Forms\Components\Textarea::make('description')->label('Descrição'),
                        Forms\Components\Select::make('responsible_id')
                            ->relationship('responsible', 'name')
                            ->label('Responsável')
                            ->model(\App\Models\Task::class)
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        Task::create([
                            'name' => $data['name'],
                            'description' => $data['description'],
                            'type' => 'cobrança',
                            'owner_id' => auth()->user()->id,
                            'responsible_id' => $data['responsible_id'],
                            'related_id' => $record->id,
                            'related_type' => 'Bill',
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
