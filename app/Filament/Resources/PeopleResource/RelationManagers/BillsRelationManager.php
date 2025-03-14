<?php

namespace App\Filament\Resources\PeopleResource\RelationManagers;

use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillsRelationManager extends RelationManager
{
    protected static string $relationship = 'bills';

    protected static ?string $label = 'Cobranças';

    protected static ?string $title = 'Cobranças';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')->label('Descrição')->columnSpanFull(),
                Forms\Components\TextInput::make('value')->label('Valor')->required(),
                Forms\Components\TextInput::make('paid_value')->label('Valor Pago'),
                Forms\Components\TextInput::make('discount')->label('Desconto'),
                Forms\Components\TextInput::make('interest')->label('Juros'),
                Forms\Components\TextInput::make('fine')->label('Multa'),
                Forms\Components\Select::make('status')->label('Status')->options([
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
                Forms\Components\Select::make('type')->label('Tipo')->options([
                    'monthly' => 'Mensal',
                    'annual' => 'Anual',
                    'usage' => 'Consumo',
                ])->required(),
                Forms\Components\DatePicker::make('due_date')->label('Data de Vencimento')->required(),
                Forms\Components\DatePicker::make('payment_date')->label('Data de Pagamento'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('value')->label('Valor'),
                Tables\Columns\TextColumn::make('status')->label('Status')->formatStateUsing(function ($state) {
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
                Tables\Columns\TextColumn::make('due_date')->label('Data de Vencimento')->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d M Y');
                }),
                Tables\Columns\TextColumn::make('payment_date')->label('Data de Pagamento')->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d M Y');
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('createTask')
                    ->label('Criar Tarefa')
                    ->form([
                        Forms\Components\TextInput::make('name')->label('Nome')->required(),
                        Forms\Components\Textarea::make('description')->label('Descrição'),
                        Forms\Components\Select::make('responsible_id')
                            ->relationship('responsible', 'name')
                            ->model(\App\Models\Task::class)
                            ->label('Responsável')
                            ->searchable()
                            ->required(),
                    ])->model('Task')
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
