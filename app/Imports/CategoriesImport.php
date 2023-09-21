<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row): Category
    {
        return new Category([
            'code' => $row['code'] ?? Str::random(5),
            'name' => $row['name'],
        ]);
    }
}
