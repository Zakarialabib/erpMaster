<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;

class Review extends Model
{
    use HasAdvancedFilter;

    public const ATTRIBUTES = [
        'id',
        'rating',
        'comment',
        'product_id',
        'user_id',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'rating',
        'comment',
        'product_id',
        'customer_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
