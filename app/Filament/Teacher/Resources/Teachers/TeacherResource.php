<?php

namespace App\Filament\Teacher\Resources\Teachers;

use App\Filament\Teacher\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Teacher\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Teacher\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Teacher\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Teacher\Resources\Teachers\Tables\TeachersTable;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    protected static ?string $recordTitleAttribute = 'Profile';
    // navigation title
    protected static ?string $navigationLabel = 'Profile';

     public static function canCreate(): bool
    {
        return false;
    }
    public static function getEloquentQuery(): Builder
    {
       return parent::getEloquentQuery()->where('id',Auth::guard('teacher')->user()->id);

    }

    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
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
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}
