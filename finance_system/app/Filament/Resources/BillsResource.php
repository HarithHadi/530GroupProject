<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillsResource\Pages;
use App\Filament\Resources\BillsResource\RelationManagers;
use App\Models\Bills;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use App\Enums\BillSatus;

class BillsResource extends Resource
{
    protected static ?string $model = Bills::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Functions';
    protected static ?int $navigationSort = 3;

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('user_id', auth()->user);
    // }

    public static function form(Form $form): Form
    {
        $values = [];

        foreach (BillSatus::cases() as $value) {
            $values[$value->name] = $value->value;
        };
        
        return $form
        
        ->schema([
            Group::make()
                ->schema([

                    Section::make()
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                        
                
                        // Select::make('transactions_id')
                        // ->label('Transactions')
                        // // ->default(fn () => auth()->user()?->id)
                        // ->options(fn () => \App\Models\transaction::query()
                        //     ->where('user_id',auth()->id())
                        //     ->pluck('description','id')
                        // )
                        // ->required(),

                    
                    Forms\Components\TextInput::make('amount')
                        ->required()
                        ->numeric(),
                    Forms\Components\Select::make('frequency')
                        ->options(BillSatus::class)
                        // ->options($values)
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('Date')
                        ->columnSpanFull(),
                        ])
                ])->columns(3),

                
                Group::make()
                ->schema([
                    Section::make()
                    ->schema([
                        
                        Forms\Components\Select::make('user_id')
                        ->options(User::all()->pluck('name', 'id'))  // Populate options with User names and IDs
                        ->default(fn () => auth()->user()?->id) // Set the default value to the authenticated user's ID
                        // ->hidden()  // Keep the field hidden from the user
                        ->required(),

                        Select::make('category_id')
                        ->label('Category')
                        ->options(\App\Models\category::all()->pluck('name', 'id'))
                        // ->default(auth()->id())
                        // ->hidden()
                        ->required(),
                        ])

                
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->modifyQueryUsing(function (Builder $query) { 
                return $query->where('user_id', auth()->id()); 
            })
            
            ->columns([
            
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Date')
                    ->searchable(),

                Tables\Columns\TextColumn::make('frequency')
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBills::route('/create'),
            'view' => Pages\ViewBills::route('/{record}'),
            'edit' => Pages\EditBills::route('/{record}/edit'),
        ];
    }
}
