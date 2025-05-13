<?php

namespace App\Filament\Resources\ExpansesResource\Pages;

use App\Filament\Resources\ExpansesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpanses extends EditRecord
{
    protected static string $resource = ExpansesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
