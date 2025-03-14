<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'eos-task-alt';

    protected static ?string $navigationGroup = 'Atividades';


    protected static ?string $label = 'Tarefas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Hidden::make('owner_id')
                    ->default(fn () => auth()->user()->id),
                Forms\Components\Select::make('responsible_id')
                    ->relationship('responsible', 'name')
                    ->label('Responsável')
                    ->searchable(),
                Forms\Components\Select::make('type')
                    ->options([
                        'cobrança' => 'Cobrança',
                        'manutenção' => 'Manutenção',
                        'geral' => 'Geral',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set, $state) => $set('related_type', $state === 'cobrança' ? 'Bill' : ($state === 'manutenção' ? 'Equipament' : ''))),

                Forms\Components\Select::make('related_id')
                    ->label('ID Relacionado')
                    ->searchable()
                    ->visible(fn ($get) => $get('type') !== 'geral' && !is_null($get('type')))
                    ->options(fn ($get) => $get('type') === 'cobrança' ? \App\Models\Bill::pluck('name', 'id') : ($get('type') === 'manutenção' ? \App\Models\Equipament::pluck('name', 'id') : [])),
                Forms\Components\TextInput::make('related_type')
                    ->label('Tipo Relacionado')
                    ->default(fn ($get) => $get('type') === 'cobrança' ? 'Bill' : ($get('type') === 'manutenção' ? 'Equipament' : '')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Tarefa'),
                Tables\Columns\TextColumn::make('type')->label('Tipo'),
                Tables\Columns\TextColumn::make('responsible.name')->label('Responsável'),
                
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
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
