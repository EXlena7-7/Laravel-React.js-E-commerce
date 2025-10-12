<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Forms\Form $form): Forms\Form
    {
        $department = $this->getOwnerRecord();
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')->options(function() use($department) {
                    return Category::query()
                    ->where('department_id', $department->id)
                    ->pluck('name', 'id')
                    ->toArray();
                })
                ->label('Parent Category')
                ->preload()
                ->searchable(),
                Forms\Components\Checkbox::make('active')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
                 Tables\Columns\TextColumn::make('parent.name')
                ->sortable()
                ->searchable(),
                IconColumn::make('active')
            ])


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
