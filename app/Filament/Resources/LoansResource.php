<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoansResource\Pages;
use App\Filament\Resources\LoansResource\RelationManagers;
use App\Models\Loans;
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

class LoansResource extends Resource
{
    protected static ?string $model = Loans::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Loans Managment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('item')->label('name')->required(),
                DatePicker::make('date')->required(),
                MoneyInput::make('price')->decimals(2)->currency('GBP')->locale('en_GB')->label('Loan')->required(),
                Hidden::make('created_at'),
                Hidden::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('item')
            ->columns([
                TextColumn::make('date')->date('d-m-Y')->label('Date of Collection'),
                TextColumn::make('item'),
                MoneyColumn::make('price')->decimals(2)->currency('GBP')->locale('en_GB')->label('sum'),
                TextColumn::make('created_at')->date('d-m-Y')->label('Recording Date'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoans::route('/create'),
            'edit' => Pages\EditLoans::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
