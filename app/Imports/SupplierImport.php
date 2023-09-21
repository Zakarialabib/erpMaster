<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport implements ToModel
{
    public function model(array $row): Supplier
    {
        return new Supplier([
            'name'       => $row['name'],
            'phone'      => $row['phone'],
            'address'    => $row['address'] ?? null,
            'tax_number' => $row['tax_number'] ?? null,
        ]);
    }
}
