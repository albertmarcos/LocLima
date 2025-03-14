<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'eos-monetization-on-o';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Atividades';

    protected static ?string $label = "Cobranças";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('value')->label('Valor'),
                Tables\Columns\TextColumn::make('paid_value')->label('Valor Pago'),
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
                Tables\Columns\TextColumn::make('type')->label('Tipo')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'monthly' => 'Mensal',
                        'annual' => 'Anual',
                        'usage' => 'Consumo',
                        default => 'Desconhecido',
                    };
                }),
                Tables\Columns\TextColumn::make('due_date')->label('Data de Vencimento'),
                Tables\Columns\TextColumn::make('payment_date')->label('Data de Pagamento'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
            'view' => Pages\ViewBill::route('/{record}'),
        ];
    }
}
