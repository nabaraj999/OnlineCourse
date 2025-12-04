<?php

namespace App\Filament\Resources\CourseSeos;

use App\Filament\Resources\CourseSeos\Pages\CreateCourseSeo;
use App\Filament\Resources\CourseSeos\Pages\EditCourseSeo;
use App\Filament\Resources\CourseSeos\Pages\ListCourseSeos;
use App\Filament\Resources\CourseSeos\Schemas\CourseSeoForm;
use App\Filament\Resources\CourseSeos\Tables\CourseSeosTable;
use App\Models\CourseSeo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CourseSeoResource extends Resource
{
    protected static ?string $model = CourseSeo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?string $recordTitleAttribute = 'CourseSeo';
      protected static string | UnitEnum | null $navigationGroup = 'Seo Management';

    public static function form(Schema $schema): Schema
    {
        return CourseSeoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseSeosTable::configure($table);
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
            'index' => ListCourseSeos::route('/'),
            'create' => CreateCourseSeo::route('/create'),
            'edit' => EditCourseSeo::route('/{record}/edit'),
        ];
    }
}
