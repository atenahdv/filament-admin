<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Textarea::make('content')
                ->rows(6)
                ->maxLength(1000)
                ->columnSpanFull(),

            Toggle::make('is_published')
                ->label('Published'),

            FileUpload::make('image')
                ->label('image')
                ->image()
                ->visibility('public')
                ->preserveFilenames(),
        ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('title')->limit(30)->sortable()->searchable(),
                TextColumn::make('slug')->limit(40)->sortable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('image')
                    ->disk('public')
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
