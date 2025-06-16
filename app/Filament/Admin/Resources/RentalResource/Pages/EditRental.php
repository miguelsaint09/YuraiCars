<?php

namespace App\Filament\Admin\Resources\RentalResource\Pages;

use App\Filament\Admin\Resources\RentalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditRental extends EditRecord
{
    protected static string $resource = RentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $newAmount = $this->data['additional_amount'] ?? 0;
        $newAmount = str_replace(['$', ','], '', $newAmount);
        
        if ($newAmount > 0) {
            DB::transaction(function () use ($newAmount) {
                $rental = $this->record;
                if ($rental->payment) {
                    $rental->payment->update([
                        'amount' => $newAmount
                    ]);
                }
            });
        }

        return $data;
    }
}
