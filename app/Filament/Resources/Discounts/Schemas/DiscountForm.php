<?php

namespace App\Filament\Resources\Discounts\Schemas;

use App\Models\Course;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class DiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., SUMMER10')
                    ->helperText('Unique discount code (max 50 characters)'),

                Select::make('type')
                    ->options(['percentage' => 'Percentage', 'fixed' => 'Fixed'])
                    ->default('percentage')
                    ->required()
                    ->helperText('Choose the discount type'),

                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                DatePicker::make('start_date')
                    ->required()
                    ->minDate(now())
                    ->maxDate(now()->addYear())
                    ->displayFormat('Y-m-d')
                    ->helperText('Start date of the discount (min today, max 1 year)'),

                DatePicker::make('end_date')
                    ->maxDate(now()->addYears(2))
                    ->displayFormat('Y-m-d')
                    ->helperText('Optional end date (must be after start date, max 2 years)'),

                Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->helperText('Enable or disable the discount'),
            ]);
    }
}
