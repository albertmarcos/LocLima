<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Filament\Resources\ContractResource\RelationManagers\BillsRelationManager;
use App\Filament\Resources\ContractResource\RelationManagers\EquipamentRelationManager;
use App\Models\Contract;
use App\Models\Person;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'eos-insert-drive-file-o';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Gestão';

    protected static ?string $label = "Contratos";
    
    protected static ?string $title = 'teste';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('peoples_id')
                    ->label('Pessoa')
                    ->options(function () {
                        return Person::query()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $person = Person::find($state);
                        $set('person.name', $person->name ?? '');
                        $set('person.email', $person->email ?? '');
                        $set('person.phone', $person->phone ?? '');
                        $set('person.address', $person->address ?? '');
                    }),
                
                Section::make('Informações da Pessoa')
                    ->schema([
                        TextInput::make('person.name')->label('Nome')->disabled(),
                        TextInput::make('person.email')->label('Email')->disabled(),
                        TextInput::make('person.phone')->label('Telefone')->disabled(),
                        TextInput::make('person.address')->label('Endereço')->disabled(),
                    ])
                    ->visible(fn ($get) => $get('peoples_id')),

                TextInput::make('contract_number')
                    ->default(function () {
                        $lastId = Contract::max('id') ?? 0;
                        $nextId = $lastId + 1;
                        $mesAtual = Carbon::now()->locale('pt_BR')->isoFormat('MMM');                     
                        $mesAtual = Str::upper($mesAtual);
                        $anoAtual = Carbon::now()->year;
                        return sprintf('%s%s%d', $mesAtual, $anoAtual, $nextId);
                    })
                    ->label('Número do Contrato')
                    ->hidden()
                    ->required(),
                DatePicker::make('start')->label('Inicio'),
                DatePicker::make('end')->label('Fim'),
                TextInput::make('year')->label('Referencia Ano'),
                TextInput::make('value')->label('Valor do contrato'),
                Toggle::make('recursive')->label('Renovação Automatica?'),
                Select::make('type')->options([
                    'monthly' => 'mensal',
                    'anual' => 'anual',
                    'usage' => 'consumo'
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('people.name')->label('Cliente'),
                TextColumn::make('contract_number')->label('Contrato'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            EquipamentRelationManager::class,
            BillsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
