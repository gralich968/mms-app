<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatesResource\Pages;
use App\Filament\Resources\StatesResource\RelationManagers;
use App\Models\States;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Filament\Tables\Columns\Summarizers\Sum;

class StatesResource extends Resource
{
    protected static ?string $model = States::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $navigationGroup = 'Expanses Managment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')->label('Date of Collection'),
                TextInput::make('item')->label('What for'),
                MoneyInput::make('price')->currency('GBP')->locale('en_GB')->label('How much to take'),
                TextInput::make('account'),

                Hidden::make('created_at'),
                Hidden::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('date')->date('d')->label('Collection Day')->sortable(),
               TextColumn::make('item'),
               MoneyColumn::make('price')->currency('GBP')->locale('en_GB')->label('Price In'),
               TextColumn::make('created_at')->date('d-m-Y')->label('recording date'),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateStates::route('/create'),
            'edit' => Pages\EditStates::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
