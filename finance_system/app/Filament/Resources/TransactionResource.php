<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\category;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BladeHeroicons;
use function Laravel\Prompts\table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Functions';
    protected static ?int $navigationSort = 1;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    // Select::make('user_id')
                    // ->options(User::all()->pluck('name', 'id'))  // Populate options with User names and IDs
                    // ->default(fn () => auth()->user()?->id) // Set the default value to the authenticated user's ID
                    // ->hidden()  // Keep the field hidden from the user
                    // ->required(),
                    // // ->hidden(),
                    
                    TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    // ->helperText('Please Enter Amount')
                    ->placeholder(placeholder: '19.99')
                    ->required(),

                    DateTimePicker::make('transaction_date')
                    ->label('Transaction Date')   // Label for the field
                    ->required()                  // Makes the field required
                    ->format('Y-m-d')              // Display format to show only the date (no time)
                    ->placeholder('YYYY-MM-DD'),
                    
                    Select::make('category_id')
                    ->label('Category')
                    ->options(\App\Models\category::all()->pluck('name', 'id'))
                    // ->default(auth()->id())
                    // ->hidden()
                    ->required(),

                    Textarea::make('description')
                    ->label('Description')
                    ->maxLength(1000)        // Optional: Set a maximum character length for the description
                    ->helperText('Provide a brief description of the transaction.') // Optional: Helper text
                    ->placeholder('Enter transaction details here...') // Optional: Placeholder text
                    ->columnSpan(3)
                    ->rows(4),

                    
                    
                    ])->columns(3),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        
        return $table
            

            ->modifyQueryUsing(function (Builder $query) { 

                return $query->where('user_id', auth()->id()); 
           })

            ->columns([
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money()
                    ->sortable(),
                TextColumn::make('transaction_date')
                    ->label('Transaction Date')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    // ->relationship('category','name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    
                    
                    
                    // ->formatStateUsing(function (string $state) {
                    //     $icons = [
                    //         'Food & Beverages' => '<x-heroicon-tv class="w-6 h-6" /> Food & Beverages', // Replace with the actual category name and desired icon
                    //         'Transport' => '🚗',
                    //         'Shopping' => '🛍️',
                    //     ];
                    //     return $icons[$state] ?? e($state);
                    // })
            ])
            ->filters([
                //
            ])
            ->actions([
                
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

   
}
