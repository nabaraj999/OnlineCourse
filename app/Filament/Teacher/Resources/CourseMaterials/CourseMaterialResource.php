<?php

namespace App\Filament\Teacher\Resources\CourseMaterials;

use App\Filament\Teacher\Resources\CourseMaterials\Pages\CreateCourseMaterial;
use App\Filament\Teacher\Resources\CourseMaterials\Pages\EditCourseMaterial;
use App\Filament\Teacher\Resources\CourseMaterials\Pages\ListCourseMaterials;
use App\Filament\Teacher\Resources\CourseMaterials\Schemas\CourseMaterialForm;
use App\Filament\Teacher\Resources\CourseMaterials\Tables\CourseMaterialsTable;
use App\Models\CourseMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseMaterialResource extends Resource
{
    protected static ?string $model = CourseMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'CourseMaterial';

    public static function form(Schema $schema): Schema
    {
        return CourseMaterialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseMaterialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseMaterials::route('/'),
            'create' => CreateCourseMaterial::route('/create'),
            'edit' => EditCourseMaterial::route('/{record}/edit'),
        ];
    }
}
