<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
  protected static ?string $model = Post::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        // Main content information
        Section::make('Main Content')->schema([
          TextInput::make('title')
            ->live(debounce: 500)->required()->minLength(1)->maxLength(150)
            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
              if ($operation === 'edit') return;
              $set('slug', Str::slug($state));
            }),
          TextInput::make('slug')->required()->minLength(1)->maxLength(150)
            ->unique(ignoreRecord: true),
          RichEditor::make('body')
            ->required()
            ->fileAttachmentsDirectory('posts/images')
            ->columnSpanFull()
        ])->columns(2),
        // Meta information section
        Section::make('Meta')->schema([
          FileUpload::make('image')->image()->directory('posts/thumbnails')->visibility('public')
            ->preserveFilenames()->columnSpanFull(),
          DateTimePicker::make('published_at')->label('Publish Date')->default(now())->required(),
          Checkbox::make('is_featured')->label('Featured')->inline(),
          Select::make('user_id')
            ->relationship('author', 'name')
            ->required()
            ->searchable(),
          Select::make('categories')
            ->multiple()
            ->relationship('categories', 'title')
            ->searchable()
            ->preload(),
        ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        ImageColumn::make('image')
          ->label('Thumbnail'),
        TextColumn::make('title')->searchable()->sortable(),
        TextColumn::make('slug')->searchable()->sortable(),
        TextColumn::make('author.name')->searchable()->sortable(),
        TextColumn::make('published_at')->date('Y-m-d')->searchable()->sortable(),
        CheckboxColumn::make('is_featured')->label('Featured')->inline(),
      ])
      ->filters([
        Tables\Filters\TrashedFilter::make(),
      ])
      ->actions([
        Tables\Actions\EditAction::make()
          ->icon('heroicon-o-pencil')
          ->label('Edit Post'),
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
      'index' => Pages\ListPosts::route('/'),
      'create' => Pages\CreatePost::route('/create'),
      'edit' => Pages\EditPost::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->withoutGlobalScopes([
        SoftDeletingScope::class,
      ]);
  }
}
