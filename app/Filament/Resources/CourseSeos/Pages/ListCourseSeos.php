<?php

namespace App\Filament\Resources\CourseSeos\Pages;

use App\Filament\Resources\CourseSeos\CourseSeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseSeos extends ListRecords
{
    protected static string $resource = CourseSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
