<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stats;

use App\Enums\OrderType;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ProductWarehouse;
use App\Models\OrderForms;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\SaleDetails;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Subscriber;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Transactions extends Component
{
    public $typeChart = 'monthly';

    public $categoriesCount;

    public $topProducts;

    public $productCount;

    public $salesCount;

    public $profit;

    public $purchase;

    public $purchaseCount;

    public $lastPurchases;

    public $supplierCount;

    public $customerCount;

    public $profitCount;

    public $bestSales;

    public $lastSales;

    public $charts;

    public $purchases;

    public $purchases_count;

    public $sales;

    public $sales_count;

    public $subscribersCount;

    public $orderFormProduct;

    public $ordersCount;

    public $recentOrders;

    public $contactsCount;

    public $recentContacts;

    public $startDate;

    public $endDate;

    public $purchasesCount;

    public $salesTotal;

    public $stockValue;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();

        $this->categoriesCount = Category::count('id');

        $this->productCount = Product::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $this->supplierCount = Supplier::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $this->customerCount = Customer::whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        $this->subscribersCount = Subscriber::whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        $this->orderFormProduct = OrderForms::where('type', OrderType::PRODUCT)->whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        $this->ordersCount = Order::with('products')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();

        $this->recentOrders = Order::select('created_at', 'total_amount', 'reference', 'id')->orderBy('created_at', 'desc')->take(10)->get();

        $this->contactsCount = Contact::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $this->recentContacts = Contact::select('created_at', 'type', 'subject', 'name', 'id')->orderBy('created_at', 'desc')->take(10)->get();


        $this->salesCount = Sale::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
        $this->purchasesCount = Purchase::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();


        $this->salesTotal = Sale::whereDate('created_at', [$this->startDate, $this->endDate])->sum('total_amount') / 100;

        $this->stockValue = ProductWarehouse::whereDate('created_at', [$this->startDate, $this->endDate])->sum(DB::raw('qty * cost'));


        $this->lastSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get(['id', 'reference', 'total_amount', 'status', 'customer_id', 'user_id', 'date']);

        $this->lastPurchases = Purchase::with('supplier')
            ->latest()
            ->take(5)
            ->get(['id', 'reference', 'total_amount', 'status', 'supplier_id', 'date', 'user_id']);

        $this->bestSales = Sale::query()
            ->select('sales.*', 'customers.name')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->with('user', 'customer')
            ->whereMonth('sales.created_at', Carbon::now()->startOfMonth())
            ->orderBy('sales.total_amount', 'desc')
            ->take(5)
            ->get();

        $this->topProducts = SaleDetails::query()
            ->selectRaw(
                'SUM(sale_details.quantity) as qtyItem, products.name as name, products.code as code, SUM(sale_details.sub_total) as totalSalesAmount, sale_details.id'
            )
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->whereMonth('sale_details.created_at', Carbon::now()->startOfMonth())->groupBy(['sale_details.id', 'sale_details.product_id', 'products.name', 'products.code'])
            ->orderByDesc('qtyItem')
            ->limit(5)
            ->get();

        $this->purchases_count = Purchase::where('date', '>=', Carbon::now()->subWeek())
            ->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as purchases'))
            ->groupBy('date')
            ->pluck('purchases');

        $this->sales_count = Sale::whereDate('date', '>=', Carbon::now()->subWeek())
            ->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as sales'))
            ->groupBy('date')
            ->pluck('sales');

        $this->chart();
    }

    public function chart()
    {
        $query = Sale::selectRaw('SUM(total_amount) as total, SUM(due_amount) as due_amount')
            ->when($this->typeChart === 'monthly', static fn($q) => $q->selectRaw('MONTH(date) as labels, COUNT(*) as sales')
                ->whereYear('date', '=', date('Y'))
                ->groupByRaw('MONTH(date)'), static fn($q) => $q->selectRaw('YEAR(date) as labels, COUNT(*) as sales')
                ->groupByRaw('YEAR(date)'))
            ->get()
            ->toArray();

        $sales = [
            'total'      => array_column($query, 'total'),
            'due_amount' => array_map(static fn($total, $dueAmount) => $total - $dueAmount, array_column($query, 'total'), array_column($query, 'due_amount')),
            'labels' => array_column($query, 'labels'),
        ];

        $query = Purchase::selectRaw('SUM(total_amount) as total, SUM(due_amount) as due_amount')
            ->when($this->typeChart === 'monthly', static fn($q) => $q->selectRaw('MONTH(date) as labels, COUNT(*) as purchases')
                ->whereYear('date', '=', date('Y'))
                ->groupByRaw('MONTH(date)'), static fn($q) => $q->selectRaw('YEAR(date) as labels, COUNT(*) as purchases')
                ->groupByRaw('YEAR(date)'))
            ->get()
            ->toArray();

        $purchases = [
            'total'      => array_column($query, 'total'),
            'due_amount' => array_map(static fn($total, $dueAmount) => $total - $dueAmount, array_column($query, 'total'), array_column($query, 'due_amount')),
            'labels' => array_column($query, 'labels'),
        ];

        $this->charts = json_encode([
            'total' => [
                'sales'    => $sales['total'],
                'purchase' => $purchases['total'],
            ],
            'due_amount' => [
                'sales'    => $sales['due_amount'],
                'purchase' => $purchases['due_amount'],
            ],
            'labels' => $sales['labels'],
        ], JSON_THROW_ON_ERROR);
    }

    protected function getChart($sales, $purchases)
    {
        $dataarray = [];
        $i = 0;

        foreach ($sales as $sale) {
            $dataarray['total']['sales'][$i] = $sale['total'];
            $dataarray['due_amount']['sales'][$i] = $sale['total'] - $sale['due_amount'];
            $dataarray['labels'][$i] = $sale['labels'];
            ++$i;
        }

        $i = 0;

        foreach ($purchases as $purchase) {
            $dataarray['total']['purchase'][$i] = $purchase['total'];
            $dataarray['due_amount']['purchase'][$i] = $purchase['total'] - $purchase['due_amount'];
            ++$i;
        }

        return json_encode($dataarray, JSON_THROW_ON_ERROR);
    }

    #[Computed]
    public function dailyChartOptions()
    {
        $currentMonth = Carbon::now()->startOfMonth();

        // Get all days in the current month
        $daysInMonth = [];
        $currentDay = Carbon::now()->startOfMonth();

        while ($currentDay->month === $currentMonth->month) {
            $daysInMonth[] = $currentDay->format('Y-m-d');
            $currentDay->addDay();
        }

        // Get sales data for each day in the current month
        $salesData = Sale::selectRaw('DATE(date) as day, SUM(total_amount) as total_sales')
            ->whereBetween('date', [$currentMonth, Carbon::now()->endOfMonth()])
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        // Get purchase data for each day in the current month
        $purchasesData = Purchase::selectRaw('DATE(date) as day, SUM(total_amount) as total_purchases')
            ->whereBetween('date', [$currentMonth, Carbon::now()->endOfMonth()])
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        // Combine sales and purchase data
        $chartData = [];

        foreach ($daysInMonth as $day) {
            $sale = $salesData->where('day', $day)->first();
            $purchase = $purchasesData->where('day', $day)->first();
            $chartData[] = [
                'day'       => $day,
                'sales'     => ($sale) ? $sale->total_sales : 0,
                'purchases' => ($purchase) ? $purchase->total_purchases : 0,
            ];
        }

        // Create stacked bar chart options
        $dailyChartOptions = [
            'chart' => [
                'type'    => 'bar',
                'stacked' => true,
                'width'   => '100%',
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal'  => false,
                    'endingShape' => 'flat',
                    'columnWidth' => '70%',
                ],
            ],
            'series' => [
                [
                    'name' => __('Sales'),
                    'data' => array_column($chartData, 'sales'),
                ],
                [
                    'name' => __('Purchases'),
                    'data' => array_column($chartData, 'purchases'),
                ],
            ],
            'xaxis' => [
                'categories' => array_column($chartData, 'day'),
                'labels'     => [
                    'rotateAlways' => true,
                    'rotate'       => -45,
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => __('Amount'),
                ],
            ],
            'legend' => [
                'position'        => 'top',
                'horizontalAlign' => 'center',
                'offsetX'         => 40,
            ],
            'colors' => ['#4CAF50', '#F44336'],
        ];

        return $dailyChartOptions;
    }

    public function getMonthlyChartOptionsProperty()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Get payment data for the month
        $salePayments = SalePayment::whereBetween('created_at', [$startDate, $endDate])->get();
        $purchasePayments = PurchasePayment::whereBetween('created_at', [$startDate, $endDate])->get();

        // Calculate total payment amounts
        $totalPayments = [
            'sent'     => $salePayments->sum('amount'),
            'received' => $purchasePayments->sum('amount'),
        ];

        // Create the chart options array
        $monthlyChartOptions = [
            'chart' => [
                'type'  => 'donut',
                'width' => '100%',
            ],
            'series' => [$totalPayments['sent'], $totalPayments['received']],
            'labels' => [__('Payment Sent'), __('Payment Received')],
        ];

        return $monthlyChartOptions;
    }

    public function render()
    {
        return view('livewire.admin.stats.transactions');
    }
}
