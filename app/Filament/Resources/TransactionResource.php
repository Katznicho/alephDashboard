<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationGroup = 'Payments';
    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->unique()
                    ->default(Str::random(10))
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->placeholder('for example, 1000')
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                         'Cash' => 'Cash',
                         'Transfer' => 'Transfer',
                         'Mobile Money' => 'Mobile Money',
                         'Card' => 'Card',
                    ])
                    ->preload()
                    ->searchable()
                    ->label('Transaction Type')
                    ,
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'Offertory' => 'Offertory',
                        'Donation' => 'Donation',
                        'Contribution' => 'Contribution',
                        'Sponsorship' => 'Sponsorship',
                        'Other' => 'Other',
                    ])
                    ->preload()
                    ->searchable()
                    ->label('Transaction Category')
                    ,
                Forms\Components\Select::make('currency')
                    ->required()
                    ->default('UGX')
                    ->options([
                        'UGX' => 'UGX',
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ])
                    ->preload()
                    ->searchable()
                    ->label('Currency')
                    ,
                Forms\Components\Select::make('provider')
                    ->options([
                        'MTN' => 'MTN',
                        'Airtel' => 'Airtel',
                        'Vodafone' => 'Vodafone',
                        'Tigo' => 'Tigo',
                        'Other' => 'Other',
                    ])
                    ->default(null),
                    Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->placeholder('for example, John Doe')
                    ->default(null),    
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->placeholder('email address forexample, 0V6oU@example.com')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->placeholder('phone number forexample +254712345678')
                    ->default(null),
                    Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->placeholder('for example, received from John Doe')
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
