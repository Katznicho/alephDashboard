<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Filament\Resources\SocialMediaResource\RelationManagers;
use App\Models\SocialMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaResource extends Resource
{
    protected static ?string $model = SocialMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('instagram')
                    ->maxLength(255)
                    ->placeholder('https://www.instagram.com/')
                    ->default(null),
                Forms\Components\TextInput::make('x')
                    ->maxLength(255)
                    ->placeholder('https://www.x.com/')
                    ->default(null),
                Forms\Components\TextInput::make('facebook')
                    ->maxLength(255)
                    ->placeholder('https://www.facebook.com/')
                    ->default(null),
                Forms\Components\TextInput::make('linkedin')
                    ->maxLength(255)
                    ->placeholder('https://www.linkedin.com/')
                    ->default(null),
                Forms\Components\TextInput::make('tiktok')
                    ->maxLength(255)
                    ->placeholder('https://www.tiktok.com/')
                    ->default(null),
                Forms\Components\TextInput::make('youtube')
                    ->maxLength(255)
                    ->placeholder('https://www.youtube.com/')
                    ->default(null),
                Forms\Components\TextInput::make('telegram')
                    ->placeholder('https://t.me/')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('snapchat')
                    ->maxLength(255)
                    ->placeholder('https://www.snapchat.com/')
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instagram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('x')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook')
                    ->searchable(),
                Tables\Columns\TextColumn::make('linkedin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tiktok')
                    ->searchable(),
                Tables\Columns\TextColumn::make('youtube')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('snapchat')
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
            'index' => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'view' => Pages\ViewSocialMedia::route('/{record}'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
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
