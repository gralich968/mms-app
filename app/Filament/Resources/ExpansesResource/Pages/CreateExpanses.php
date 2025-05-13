<?php

namespace App\Filament\Resources\ExpansesResource\Pages;

use App\Filament\Resources\ExpansesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpanses extends CreateRecord
{
    protected static string $resource = ExpansesResource::class;

   protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
