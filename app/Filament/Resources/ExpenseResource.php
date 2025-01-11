<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_name')
                    ->required()
                    ->placeholder('for example, water bill')
                ,
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->placeholder('for example, 1000')
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('category')
                    ->options([
                        'Utility' => 'Utility',
                        'Transportation' => 'Transportation',
                        'Supplies' => 'Supplies',
                        'Salary' => 'Salary',
                        'Maintenance' => 'Maintenance',
                        'Other' => 'Other',
                    ])
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('payment_method')
                    ->required()
                    ->options([
                        'Cash' => 'Cash',
                        'Check' => 'Check',
                        'Credit Card' => 'Credit Card',
                        'Debit Card' => 'Debit Card',
                        'Mobile Money' => 'Mobile Money',
                    ])
                    ->searchable()
                    ->preload()
                    ->placeholder('for example, Cash')
                    ,
                Forms\Components\TextInput::make('received_by')
                    ->maxLength(255)
                    ->required()
                    ->placeholder('for example, John Doe')
                    ->default(null),
                Forms\Components\TextInput::make('received_from')
                    ->maxLength(255)
                    ->required()
                    ->placeholder('for example, John Doe')
                    ->default("Pastor Tonny Musisi"),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->placeholder('for example, John Doe paid for water bill')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable(),
                Tables\Columns\TextColumn::make('item_name')
                    ->searchable()
                    ->sortable()
                    ->label('Expense Item')
                    ,
                Tables\Columns\TextColumn::make('amount')
                    ->money("UGX")
                    ->sortable()
                    ->summarize([
                        Sum::make('amount') 
                            ->label('Total Amount')
                            ->money("UGX")
                    ])
                    ,
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('received_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('received_from')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('category')
                    ->options([
                        'Utility' => 'Utility',
                        'Transportation' => 'Transportation',
                        'Supplies' => 'Supplies',
                        'Salary' => 'Salary',
                        'Maintenance' => 'Maintenance',
                        'Other' => 'Other',
                    ])
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->label('Category'),
                SelectFilter::make('payment_method')
                    ->options([
                        'Cash' => 'Cash',
                        'Check' => 'Check',
                        'Credit Card' => 'Credit Card',
                        'Debit Card' => 'Debit Card',
                        'Mobile Money' => 'Mobile Money',
                ])
                ->searchable()
                ->multiple()
                ->preload()
                 ->label('Payment Method'),

                 Filter::make('date')
                 ->form([
                     DatePicker::make('created_from')
                         ->label('From'),
                     DatePicker::make('created_until')
                         ->label('To'),
                 ])
                 ->query(function (Builder $query, array $data): Builder {
                     return $query
                         ->when(
                             $data['created_from'],
                             fn(Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                         )
                         ->when(
                             $data['created_until'],
                             fn(Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                         );
                 })
                 ->indicateUsing(function (array $data): array {
                     $indicators = [];

                     if ($data['from'] ?? null) {
                         $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                             ->removeField('from');
                     }

                     if ($data['until'] ?? null) {
                         $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                             ->removeField('until');
                     }

                     return $indicators;
                 }),
                    
                    ], FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'view' => Pages\ViewExpense::route('/{record}'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
             ->orderBy('created_at', 'desc')
            ;
    }
}
