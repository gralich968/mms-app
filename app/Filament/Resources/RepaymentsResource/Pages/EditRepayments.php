<?php

namespace App\Filament\Resources\RepaymentsResource\Pages;

use App\Filament\Resources\RepaymentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepayments extends EditRecord
{
    protected static string $resource = RepaymentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
