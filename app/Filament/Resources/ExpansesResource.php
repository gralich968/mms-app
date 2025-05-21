<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpansesResource\Pages;
use App\Filament\Resources\ExpansesResource\RelationManagers;
use Illuminate\Database\Eloquent\Relations\Relation;
use Filament\Forms\Components\Select;
use App\Models\Expanses;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Filament\Tables\Columns\Summarizers\Sum;


class ExpansesResource extends Resource
{
    protected static ?string $model = Expanses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Expanses Managment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                DatePicker::make('date')->required(),
				
                Select::make('item')->label('Item')->relationship('states', 'item')->searchable()->preload()->live()
                ->createOptionForm([
                DatePicker::make('date')->label('Date of Collection'),
                TextInput::make('item')->label('What for'),
                MoneyInput::make('price')->currency('GBP')->locale('en_GB')->label('How much to take'),
                TextInput::make('account'),
                Hidden::make('created_at'),
                Hidden::make('updated_at'),
                ])->required(),
				
                MoneyInput::make('price')->decimals(2)->currency('GBP')->locale('en_GB')->label('Sum')->required(),
				
                Hidden::make('created_at'),
				
                Hidden::make('updated_at'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('date')
            ->columns([
               TextColumn::make('date')->label('Pay Date')->date('d'),
               TextColumn::make('states.item')->label('Pay To'),
               MoneyColumn::make('price')->currency('GBP')->locale('en_GB'),               
               MoneyColumn::make('price')->summarize(Sum::make()->money('GBP', divideBy: 100)->label('TOTAL')),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListExpanses::route('/'),
            'create' => Pages\CreateExpanses::route('/create'),
            'edit' => Pages\EditExpanses::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
