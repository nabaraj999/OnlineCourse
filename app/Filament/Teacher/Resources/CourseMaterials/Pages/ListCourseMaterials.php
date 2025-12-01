<?php

namespace App\Filament\Teacher\Resources\CourseMaterials\Pages;

use App\Filament\Teacher\Resources\CourseMaterials\CourseMaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseMaterials extends ListRecords
{
    protected static string $resource = CourseMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
