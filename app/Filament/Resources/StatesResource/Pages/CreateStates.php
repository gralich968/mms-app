<?php

namespace App\Filament\Resources\StatesResource\Pages;

use App\Filament\Resources\StatesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStates extends CreateRecord
{
    protected static string $resource = StatesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
