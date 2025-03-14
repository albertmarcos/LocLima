<?php

namespace App\Filament\Resources\RoutineResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $label = 'Tarefas';

    protected static ?string $title = 'Tarefas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('linkTask')
                    ->label('Vincular Task')
                    ->action(function (array $data, RelationManager $livewire) {
                        $routine = $livewire->ownerRecord;
                        if (!$routine->tasks()->where('task_id', $data['task_id'])->exists()) {
                            $routine->tasks()->attach($data['task_id']);
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('task_id')
                            ->label('Task')
                            ->options(function () {
                                return \App\Models\Task::whereNull('responsible_id')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ]),
                Tables\Actions\Action::make('assignTasksToResponsible')
                    ->label('Atribuir Tarefas ao Responsável')
                    ->action(function (RelationManager $livewire) {
                        $routine = $livewire->ownerRecord;
                        if ($routine->responsible_id) {
                            $routine->tasks()->update(['responsible_id' => $routine->responsible_id]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('unlinkTask')
                    ->label('')
                    ->icon('heroicon-m-link-slash')
                    ->action(function (RelationManager $livewire, $record) {
                        $routine = $livewire->ownerRecord;
                        $taskId = $record->id;
                        $routine->tasks()->detach($taskId);
                    }),
                Tables\Actions\Action::make('toggleResponsible')
                    ->label('')
                    ->color(fn ($record) => $record->responsible_id ? 'danger' : 'primary')
                    ->icon(fn ($record) => $record->responsible_id ? 'heroicon-o-user-minus' : 'heroicon-o-user-plus')
                    ->action(function (RelationManager $livewire, $record) {
                        $routine = $livewire->ownerRecord;
                        if ($record->responsible_id) {
                            $record->update(['responsible_id' => null]);
                        } else {
                            if ($routine->responsible_id) {
                                $record->update(['responsible_id' => $routine->responsible_id]);
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
