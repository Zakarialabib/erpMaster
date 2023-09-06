<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{
    use HasRoles;
    use HasAdvancedFilter;
    use HasUuid;
    use HasFactory;

    /** @var array<int, string> */
    public const ATTRIBUTES = [
        'id',
        'name',
        'email',
        'phone',
        'city',
        'country',
        'created_at',
        'updated_at',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'name', 'phone', 'email', 'city', 'country',
        'address', 'tax_number', 'password', 'wallet_id', 'status',
    ];

    /** @return HasOne<Wallet> */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /** @return HasOne<Sale> */
    public function sales(): HasOne
    {
        return $this->HasOne(Sale::class);
    }

    /**
     * Get the total sales attribute.
     *
     * @return int|float
     */
    public function getTotalSalesAttribute()
    {
        return $this->customerSum('total_amount', Sale::class);
    }

    /**
     * Get the total sales return attribute.
     *
     * @return int|float
     */
    public function getTotalSaleReturnsAttribute(): int|float
    {
        return $this->customerSum('total_amount', SaleReturn::class);
    }

    /**
     * Get the total purchases attribute.
     *
     * @return int|float
     */
    public function getTotalPaymentsAttribute(): int|float
    {
        return $this->customerSum('paid_amount', Sale::class);
    }

    /**
     * Get the total purchases attribute.
     *
     * @return int|float
     */
    public function getTotalDueAttribute(): int|float
    {
        return $this->customerSum('due_amount', Sale::class);
    }

    /**
     * Get the total purchases attribute.
     *
     * @return int|float
     */
    public function getProfit(): int|float
    {
        $sales = Sale::where('customer_id', $this->id)
            ->completed()->sum('total_amount');

        $sale_returns = SaleReturn::where('customer_id', $this->id)
            ->completed()->sum('total_amount');

        $product_costs = 0;

        foreach (Sale::where('customer_id', $this->id)->with('saleDetails', 'saleDetails.product')->get() as $sale) {
            foreach ($sale->saleDetails as $saleDetail) {
                $product_costs += $saleDetail->product->warehouses->sum(function ($warehouse) {
                    return $warehouse->pivot->cost * $warehouse->pivot->qty;
                });
            }
        }

        $revenue = ($sales - $sale_returns) / 100;

        return $revenue - $product_costs;
    }
}
