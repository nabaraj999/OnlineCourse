<?php

namespace App\Filament\Resources\Terms\Pages;

use App\Filament\Resources\Terms\TermsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTerms extends EditRecord
{
    protected static string $resource = TermsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
