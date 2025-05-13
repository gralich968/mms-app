<?php

namespace App\Filament\Widgets;

use App\Models\Incomes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Loans;
use App\Models\States;
use App\Models\Expanses;
use App\Models\Repayments;

class MainWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $current_date = date("d-m-Y " , strtotime("now"));
        $today = Expanses::whereDate('date', date('Y-m-d'))->sum('price') / 100;
        $yesterday = Expanses::whereDate('date', date('Y-m-d', strtotime('-1 day')))->sum('price') / 100;
        $week = Expanses::whereBetween('date', [date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime(now()))])->get()->sum('price') / 100;
        $month = Expanses::whereBetween('date', [date('Y-m-d', strtotime('-1 month')), date('Y-m-d', strtotime(now()))])->get()->sum('price') / 100;
        $year = Expanses::whereBetween('date', [date('Y-m-d', strtotime('-1 year')), date('Y-m-d', strtotime(now()))])->get()->sum('price') / 100;
        $totalexp = Expanses::sum('price') /100;
        $totalrepay = Loans::sum('price') / 100 - Repayments::sum('repay') / 100;
        $balance = Incomes::sum('price') / 100 - Expanses::sum('price') / 100;

        return [
            Stat::make('Today Expanse', number_Format($today, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('jS F'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Yesterday Expense', number_format($yesterday, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('jS F', strtotime('yesterday')))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Last 7 Day Expense', number_format($week, 2))
            ->icon('heroicon-o-currency-pound')
            ->description('beetwen: '.date('jS F', strtotime('-1 week')). ' and: ' .date('jS F'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Last 30 Expense', number_format($month, 2))
            ->icon('heroicon-o-currency-pound')
            ->description('beetwen: ' .date('jS F', strtotime('-1 month')). ' and: ' .date('jS F'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('One Year Expense', number_format($year, 2))
            ->icon('heroicon-o-currency-pound')
            ->description('beetwen: ' .date('d F Y', strtotime('-1 year')). ' and: ' .date('d F Y'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Total Expense', number_format($totalexp, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('d/m/Y'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('DD State Expense', number_Format(States::sum('price')/100, 2))
            ->icon('heroicon-o-currency-pound')
            ->description('Total: ' .States::count())
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Total Income', number_Format(Incomes::sum('price')/100, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('F Y'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('BALANCE', number_Format($balance, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('F Y'))
            ->color('success')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Toatal Loans', number_Format(Loans::sum('price')/100, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('d/m/Y'))
            ->color('warning')
            ->chart([1, 3, 5, 10, 40]),
            Stat::make('Total Repayments', number_Format(Repayments::sum('repay')/100, 2))
            ->icon('heroicon-o-currency-pound')
            ->description(date('d/m/Y'))
            ->color('warning')
            ->chart([1, 3, 5, 10, 40]),
       
        

        ];
    }
}
