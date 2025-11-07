<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use App\Models\PaymentMethods;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaymentMethodsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('method_name')
                    ->required()
                    ->maxLength(255)

                    ->label('Method Name')
                    ->placeholder('e.g. eSewa, Khalti, IME Pay'),
                Textarea::make('description')
                    ->required()
                    ->rows(4)
                    ->label('Payment Instructions')
                    ->placeholder('Send money to above number and attach screenshot...')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active methods appear during enrollment'),
                TextInput::make('account_holder')
                    ->required()
                    ->label('Account Holder Name')
                    ->placeholder('e.g. Ram Bahadur'),
                TextInput::make('amount_number')
                    ->required()
                    ->label('Account Number')
                    ->placeholder('9801234567')
                    ->helperText('Number where users send money'),
                FileUpload::make('qr')
                    ->label('QR Code')
                    ->image()
                    ->disk('public')
                    ->directory('payment-qr')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->maxSize(2048)
                    ->preserveFilenames()
                    ->helperText('Upload clear QR code (max 2MB)')
                    ->columnSpanFull(),
            ]);
    }
}
