<?php

namespace App\Filament\Resources\CourseSeos\Pages;

use App\Filament\Resources\CourseSeos\CourseSeoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseSeo extends EditRecord
{
    protected static string $resource = CourseSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
