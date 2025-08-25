<?php

namespace App\Filament\Teacher\Resources\Teachers\Pages;

use App\Filament\Teacher\Resources\Teachers\TeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
