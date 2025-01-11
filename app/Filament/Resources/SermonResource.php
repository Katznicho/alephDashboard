<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SermonResource\Pages;
use App\Filament\Resources\SermonResource\RelationManagers;
use App\Models\Sermon;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SermonResource extends Resource
{
    protected static ?string $model = Sermon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Sermons';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->placeholder('for example, The Word of God')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sermon_reading')
                    ->maxLength(255)
                    ->required()
                    ->placeholder('for example, John 3:16')
                    ->default(null),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->placeholder('for example, John 3:16')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('video_url')
                    ->maxLength(255)
                    ->placeholder('https://www.youtube.com/watch?v=')
                    ->default(null),
                Forms\Components\TextInput::make('audio_url')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->default(null)
                    ,
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->required()
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                ,
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sermon_reading')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('video_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('audio_url')
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
                             fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                         )
                         ->when(
                             $data['created_until'],
                             fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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
            'index' => Pages\ListSermons::route('/'),
            'create' => Pages\CreateSermon::route('/create'),
            'view' => Pages\ViewSermon::route('/{record}'),
            'edit' => Pages\EditSermon::route('/{record}/edit'),
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
