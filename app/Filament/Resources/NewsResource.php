<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use App\Models\NewsCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Str;
use Symfony\Contracts\Service\Attribute\Required;
use Termwind\Components\Span;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('author_id')
                  ->relationship('author','name')
                  ->required(),

                Forms\Components\Select::make('news_Category_id')
                  ->relationship('newsCategory','title')
                  ->required(),
                  
                 Forms\Components\TextInput::make('title')
                 ->live(onBlur: true)
                 ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ->required(),
                
                Forms\Components\TextInput::make('slug')
                  ->readOnly(),

                Forms\Components\FileUpload::make('thumbnail')
                  ->image() 
                  ->required()
                  ->columnSpanFull(),
                  
                Forms\Components\RichEditor::make('content')
                   ->required()
                   ->columnSpanFull(),

                 Forms\Components\Toggle::make('is_featured')
            ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('newsCategory.title')
                ->label('News Category'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\ToggleColumn::make('is_featured')
                ])
            ->filters([
                Tables\Filters\SelectFilter::make('author_id')
                ->relationship('author','name')
                ->label('Select Author'),

                Tables\Filters\SelectFilter::make('news_Category_id')
                ->relationship('newsCategory', 'title')
                ->label('Select Category')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

           ->query(fn () => News::with(['author', 'newsCategory']));

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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
