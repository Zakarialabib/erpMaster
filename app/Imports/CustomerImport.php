<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row): Customer
    {
        return new Customer([
            'name'       => $row['name'],
            'phone'      => $row['phone'],
            'address'    => $row['address'] ?? null,
            'tax_number' => $row['tax_number'] ?? null,
            'email'      => $row['email'] ?? null,
            'city'       => $row['city'] ?? null,
            'country'    => $row['country'] ?? null,
        ]);
    }
}
