<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    //*creating new ection for posts
    protected static ?string $navigationGroup = 'Content';
    //

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //wrap  all layout under card
                Forms\Components\Card::make()
                    ->schema([
                        //wrapping title and under one layout, with two columns so they appear side by side
                        Forms\Components\Grid::make(columns: 2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(2048)
                                    //generate slug
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, $state) {
                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(2048),

                            ]),


                        //Adding editor to body
                        Forms\Components\RichEditor::make('body')
                            ->disableToolbarButtons([
                                'strike',
                                'italic',
                                // 'underline',

                            ])
                            ->required(),
                        Forms\Components\TextInput::make('meta_title'),
                        Forms\Components\TextInput::make('meta_description'),
                        //toggle
                        Forms\Components\Toggle::make('active')
                            ->required(),
                        //add datetime picker
                        Forms\Components\DatePicker::make('published_at')  
                        ->maxDate(now()),


                    ])->columnSpan(span: 8),
                Forms\Components\Card::make()
                    ->schema([
                        //converting thumbnail to file upload
                        Forms\Components\FileUpload::make('thumbnail')
                            ->preserveFilenames(),
                            //->image()
                            //->imageResizeMode('cover')
                            //->imageCropAspectRatio('16:9')
                            //->imageResizeTargetWidth('640')
                            //->imageResizeTargetHeight('395'),
                        //defining relationship
                        Forms\Components\Select::make('category_id')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->required(),


                    ])->columnSpan(span: 4)

            ])->columns(columns: 12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('title')->words(10)
                ->searchable(['title', 'body'])->sortable(),
                Tables\Columns\IconColumn::make('active')->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('published_at', $direction);
                    }),
                // Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
               
            ])
            ->filters([
                //
            ])
            ->actions([
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
