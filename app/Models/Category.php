<?php

namespace App\Models;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function table(Table $table) : Table
    {
        return $table
        ->recordTitleAttribute('name')
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('parent.name')
            ->sortable()
            ->searchable(),
            IconColumn::make('active')

        ]);
    }
}
