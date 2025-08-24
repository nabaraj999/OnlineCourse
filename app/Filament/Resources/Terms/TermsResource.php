<?php

namespace App\Filament\Resources\Terms;

use App\Filament\Resources\Terms\Pages\CreateTerms;
use App\Filament\Resources\Terms\Pages\EditTerms;
use App\Filament\Resources\Terms\Pages\ListTerms;
use App\Filament\Resources\Terms\Schemas\TermsForm;
use App\Filament\Resources\Terms\Tables\TermsTable;
use App\Models\Terms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TermsResource extends Resource
{
    protected static ?string $model = Terms::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::NoSymbol;

    protected static ?string $recordTitleAttribute = 'Terms & Conditions';

    protected static ?string $navigationBadgeTooltip = 'Terms & Conditions';
    protected static ?string $navigationBadgeColor = 'success';


  public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return TermsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TermsTable::configure($table);
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
            'index' => ListTerms::route('/'),
            'create' => CreateTerms::route('/create'),
            'edit' => EditTerms::route('/{record}/edit'),
        ];
    }
}
