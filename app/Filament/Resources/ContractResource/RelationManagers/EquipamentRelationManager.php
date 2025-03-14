<?php

namespace App\Filament\Resources\ContractResource\RelationManagers;

use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipamentRelationManager extends RelationManager
{
    protected static string $relationship = 'equipaments';

    protected static ?string $label = 'Equipamentos';

    protected static ?string $title = 'Equipamentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                DatePicker::make('made'),
                Select::make('status')
                    ->options([
                        'new' => 'New',
                        'medium' => 'Medium',
                        'old' => 'Old',
                        'trash' => 'Trash',
                    ]),
                TextInput::make('current'),
                Hidden::make('contract_id')
                    ->default(fn ($record) => $this->ownerRecord->id)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('status')->label('Status')->formatStateUsing(function ($state) {
                    return match ($state) {
                        'new' => 'Novo',
                        'medium' => 'Usado',
                        'old' => 'Velho',
                        'trash' => 'Descarte',
                        default => 'Desconhecido',
                    };
              }),
                Tables\Columns\TextColumn::make('made')->label('Data de Fabricação'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('vincularEquipamento')
                    ->label('Vincular Equipamento')
                    ->action(function (array $data) {
                        $equipament = \App\Models\Equipament::find($data['equipament_id']);
                        $equipament->contract_id = $this->ownerRecord->id;
                        $equipament->save();
                    })
                    ->form([
                        Select::make('equipament_id')
                            ->label('Equipamento')
                            ->options(\App\Models\Equipament::whereNull('contract_id')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ]),
            ])
            ->actions([
                Action::make('edit')
                    ->label('Edit')
                    ->url(fn ($record) => route('filament.admin.resources.equipaments.edit', $record)),
                Action::make('desvincular')
                    ->label('Desvincular')
                    ->action(function ($record) {
                        $record->contract_id = null;
                        $record->save();
                    }),
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
                            'type' => 'manutenção',
                            'owner_id' => auth()->user()->id,
                            'responsible_id' => $data['responsible_id'],
                            'related_id' => $record->id,
                            'related_type' => 'Equipament',
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('desvincular')
                        ->label('Desvincular em Massa')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->contract_id = null;
                                $record->save();
                            }
                        }),
                ]),
            ]);
    }
}
