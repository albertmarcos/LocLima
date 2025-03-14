<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditPeople extends EditRecord
{
    protected static string $resource = PeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Grid::make()->columns([
                'sm' => 2,
                'xl' => 6,
                '2xl' => 8,
            ])->schema([
                Section::make('Informações Pessoais')->schema([
                    TextInput::make('name')->label('Primeiro Nome')->required(),
                    TextInput::make('last_name')->label('Sobrenome')->required(),
                    TextInput::make('surname')->label('Tratamento')->columnSpanFull(),
                    DatePicker::make('birthdate')->label('Data de Nascimento')->required(),
                    Select::make('gender')->label('Gênero')->options([
                        'male' => 'Masculino',
                        'female' => 'Feminino',
                        'other' => 'Outro',
                    ])->required(),
                    TextInput::make('nationality')->label('Nacionalidade')->required(),
                    FileUpload::make('profile_photo')
                        ->label('Foto de Perfil')
                        ->image()
                        ->directory('storage/profile-photos')
                        ->disk('public')
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 8,
                ]),
                Section::make('Contato')->schema([
                    TextInput::make('phone')->label('Telefone')->tel()->mask('(99) 9 9999-9999')->required(),
                    TextInput::make('email')->label('Email')->email()->required(),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 8,
                ]),
                Section::make('Documentos')->schema([
                    TextInput::make('cpf')->label('CPF')->required()->mask('999.999.999-99')->rule('cpf'),
                    TextInput::make('rg')->label('RG')->required(),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 8,
                ]),
                Section::make('Endereço')->schema([
                    TextInput::make('address')->label('Endereço')->columnSpanFull()->required(),
                    TextInput::make('neighborhood')->label('Bairro')->required(),
                    TextInput::make('city')->label('Cidade')->required(),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 8,
                ]),
                Section::make('Outras Informações')->schema([
                    RichEditor::make('description')->label('Anotações')->columnSpanFull(),
                ])->columns(2)->columnSpan([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 8,
                ]),
                Hidden::make('type')->default('client'),
            ]),
        ]);
    }
}
