<?php

namespace App\Filament\Resources\PaymentMethods\Pages;

use App\Filament\Resources\PaymentMethods\PaymentMethodsResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentMethods extends CreateRecord
{
    protected static string $resource = PaymentMethodsResource::class;
}
