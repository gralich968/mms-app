<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomesResource\Pages;
use App\Filament\Resources\IncomesResource\RelationManagers;
use App\Models\Incomes;
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

class IncomesResource extends Resource
{
    protected static ?string $model = Incomes::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Income Managment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')->required(),
                TextInput::make('item')->label('who')->required(),
                MoneyInput::make('price')->decimals(2)->currency('GBP')->locale('en_GB')->label('How Many')->required(),
                TextInput::make('email')->email()->nullable(),
                Hidden::make('created_at'),
                Hidden::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('date')->date('d-M-Y'),
               TextColumn::make('item'),
               MoneyColumn::make('price')->currency('GBP')->locale('en_GB'),
               TextColumn::make('created_at')->date('d-m-Y'),
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncomes::route('/create'),
            'edit' => Pages\EditIncomes::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
