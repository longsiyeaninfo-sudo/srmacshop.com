<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
      return $schema
            ->components([
           Tabs::make('Product Details')
                    ->tabs([
                        Tabs\Tab::make('General')
                       ->schema([
                    Select::make('category_id')
                         ->relationship('category', 'name')
                           ->required()
                         ->searchable()
                   ->preload(),
                       
                  TextInput::make('name.en')
                            ->label('Name (English)')
                 ->required()
                       ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                       TextInput::make('name.km')
                        ->label('Name (Khmer)'),
                                
                          TextInput::make('slug')
                         ->required()
                             ->unique(ignoreRecord: true),
              
                            TextInput::make('sku_prefix')
                        ->label('SKU Prefix'),
                              
                              Textarea::make('short_description.en')
             ->label('Short Description (English)')
                         ->rows(2)
                             ->columnSpanFull(),
                      
                         Textarea::make('short_description.km')
                             ->label('Short Description (Khmer)')
                          ->rows(2)
                               ->columnSpanFull(),
                         
                       Textarea::make('description.en')
                            ->label('Description (English)')
                             ->rows(4)
                                    ->columnSpanFull(),
                            
                       Textarea::make('description.km')
                             ->label('Description (Khmer)')
                               ->rows(4)
                             ->columnSpanFull(),
                     
                          TextInput::make('base_price')
                             ->required()
                         ->numeric()
                              ->prefix('$')
                           ->minValue(0),
                     
                            TextInput::make('sale_price')
                             ->numeric()
                          ->prefix('$')
                    ->minValue(0)
                          ->lte('base_price'),
                           
                              Select::make('condition')
                       ->options([
                           'new' => 'New',
                     'refurbished' => 'Refurbished',
                                  'used' => 'Used',
                                ])
                       ->required()
                               ->default('new'),
             
                      Toggle::make('is_featured')
                       ->label('Featured Product')
                                ->default(false),
                           
              Toggle::make('is_active')
                           ->label('Active')
                                 ->default(true),
                     ])->columns(2),
                   
                Tabs\Tab::make('Images')
                            ->schema([
                              SpatieMediaLibraryFileUpload::make('images')
                      ->collection('images')
                          ->multiple()
                    ->reorderable()
                           ->maxFiles(10)
                   ->image()
                                  ->imageEditor()
                     ->columnSpanFull(),
                    ]),
                  
              Tabs\Tab::make('Variants')
                       ->schema([
                     Repeater::make('variants')
                        ->relationship('variants')
                          ->schema([
                            TextInput::make('sku')
                           ->required()
                     ->unique(ignoreRecord: true),
                             TextInput::make('ram')
                                 ->label('RAM'),
                      TextInput::make('storage')
                   ->label('Storage'),
                              TextInput::make('color'),
                                    TextInput::make('price_modifier')
                                  ->numeric()
                          ->prefix('$')
                            ->default(0),
                                TextInput::make('stock_quantity')
                       ->numeric()
                                      ->default(0)
                                  ->minValue(0),
                           Toggle::make('is_active')
                          ->default(true),
                            ])
                                  ->columns(3)
                            ->columnSpanFull()
                          ->defaultItems(0),
                    ]),
                    
                  Tabs\Tab::make('Specifications')
                     ->schema([
                   Repeater::make('specs')
                            ->relationship('specs')
                                    ->schema([
                     TextInput::make('key')
                                       ->required()
                      ->placeholder('e.g., processor, display, battery'),
                          TextInput::make('value.en')
                                     ->label('Value (English)')
                            ->required(),
                               TextInput::make('value.km')
                               ->label('Value (Khmer)'),
                             TextInput::make('sort_order')
                        ->numeric()
                                 ->default(0),
                         ])
                          ->columns(2)
                                 ->columnSpanFull()
                                    ->defaultItems(0)
                               ->orderColumn('sort_order'),
                            ]),
                    
                    Tabs\Tab::make('SEO')
                            ->schema([
                              TextInput::make('meta_title.en')
                         ->label('Meta Title (English)')
                     ->maxLength(60),
                                
                          TextInput::make('meta_title.km')
                           ->label('Meta Title (Khmer)')
                                ->maxLength(60),
                      
                    Textarea::make('meta_description.en')
                           ->label('Meta Description (English)')
                            ->rows(3)
                  ->maxLength(160)
                      ->columnSpanFull(),
                              
                   Textarea::make('meta_description.km')
                             ->label('Meta Description (Khmer)')
                             ->rows(3)
                              ->maxLength(160)
                             ->columnSpanFull(),
                            ])->columns(2),
         ])
             ->columnSpanFull(),
            ]);
    }
}
