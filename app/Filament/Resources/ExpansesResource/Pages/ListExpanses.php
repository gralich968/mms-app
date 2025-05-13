<?php

namespace App\Filament\Resources\ExpansesResource\Pages;

use App\Filament\Resources\ExpansesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpanses extends ListRecords
{
    protected static string $resource = ExpansesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
