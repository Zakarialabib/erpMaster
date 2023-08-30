<?php

declare(strict_types=1);

use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchasePaymentsController;
use App\Http\Controllers\PurchaseReturnPaymentsController;
use App\Http\Controllers\PurchasesReturnController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationSalesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\SendQuotationEmailController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Backup\Index as BackupIndex;
use App\Livewire\Admin\Blog\Index as BlogsIndex;
use App\Livewire\Admin\Brands\Index as BrandIndex;
use App\Livewire\Admin\BlogCategory\Index as BlogCategoryIndex;
use App\Livewire\Admin\Categories\Index as CategoryIndex;
use App\Livewire\Admin\Comment\Index as CommentIndex;
use App\Livewire\Admin\Currency\Index as CurrencyIndex;
use App\Livewire\Admin\Customer\Index  as CustomersIndex;
// use App\Livewire\Admin\Customers\Index as CustomersIndex;
use App\Livewire\Admin\CustomerGroup\Index  as CustomerGroupIndex;
use App\Livewire\Admin\Expense\Index as ExpenseIndex;
use App\Livewire\Admin\ExpenseCategories\Index as ExpenseCategoriesIndex;
use App\Livewire\Admin\FeaturedBanner\Index as FeaturedBannerIndex;
use App\Livewire\Admin\Language\Index as LanguageIndex;
use App\Livewire\Admin\Language\EditTranslation;
use App\Livewire\Admin\Suppliers\Index  as SuppliersIndex;
use App\Livewire\Admin\Permission\Index as PermissionsIndex;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Role\Index as RolesIndex;
use App\Livewire\Admin\Section\Index as Sectionsindex;
use App\Livewire\Admin\Slider\Index as SlidersIndex;
use App\Livewire\Admin\Subcategory\Index as SubcategoryIndex;
use App\Livewire\Admin\Warehouses\Index as WarehouseIndex;
use App\Livewire\Admin\Shipping\Index as ShippingIndex;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Page\Index as PagesIndex;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:ADMIN', 'firewall.all']], function () {
    // change lang
    Route::get('/lang/{lang}', [HomeController::class, 'changeLanguage'])->name('changelanguage');
    // Route::get('/lang/{lang}', [DashboardController::class, 'changeLanguage'])->name('changelanguage');

    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Charts
    Route::get('/sales-purchases/chart-data', [HomeController::class, 'salesPurchasesChart'])->name('sales-purchases.chart');
    Route::get('/current-month/chart-data', [HomeController::class, 'currentMonthChart'])->name('current-month.chart');
    Route::get('/payment-flow/chart-data', [HomeController::class, 'paymentChart'])->name('payment-flow.chart');

    //Product Adjustment
    Route::resource('adjustments', AdjustmentController::class);

    //Currencies
    Route::get('currencies', CurrencyIndex::class)->name('currencies.index');

    //Expense Category
    Route::get('expense-categories', ExpenseCategoriesIndex::class)->name('expense-categories.index');

    //Expense
    Route::get('expenses', ExpenseIndex::class)->name('expenses.index');

    //Customers
    Route::get('customers', CustomersIndex::class)->name('customers.index');
    Route::get('customer/details/{id}', [CustomersController::class, 'show'])->name('customer.details');

    Route::get('customergroup', CustomerGroupIndex::class)->name('customer-group.index');

    Route::get('suppliers', SuppliersIndex::class)->name('suppliers.index');
    Route::get('supplier/details/{id}', [SuppliersController::class, 'show'])->name('supplier.details');

    //Warehouses
    Route::get('warehouses', WarehouseIndex::class)->name('warehouses.index');

    Route::get('/products/print-barcode', [BarcodeController::class, 'index'])->name('barcode.print');

    Route::get('brands', BrandIndex::class)->name('brands.index');
    Route::get('product-categories', CategoryIndex::class)->name('product-categories.index');

    Route::get('/subcategories', SubcategoryIndex::class)->name('subcategories');

    Route::get('/products', ProductsIndex::class)->name('products');

    //Generate Quotation PDF
    Route::get('/quotations/pdf/{id}', [ExportController::class, 'quotation'])->name('quotations.pdf');

    //Send Quotation Mail
    Route::get('/quotation/mail/{quotation}', SendQuotationEmailController::class)->name('quotation.email');

    //Sales Form Quotation
    Route::get('quotation-sales/{quotation}', QuotationSalesController::class)->name('quotation-sales.create');

    //Quotations
    Route::resource('quotations', QuotationController::class);

    //Generate Purchase PDF
    Route::get('/purchases/pdf/{id}', [ExportController::class, 'purchase'])->name('purchases.pdf');

    //Purchases
    Route::resource('purchases', PurchaseController::class);

    //Purchase Payments
    Route::get('/purchase-payments/{purchase_id}', [PurchasePaymentsController::class, 'index'])->name('purchase-payments.index');
    Route::get('/purchase-payments/{purchase_id}/create', [PurchasePaymentsController::class, 'create'])->name('purchase-payments.create');
    Route::post('/purchase-payments/{purchase_id}', [PurchasePaymentsController::class, 'store'])->name('purchase-payments.store');
    Route::get('/purchase-payments/{purchase_id}/edit/{purchasePayment}', [PurchasePaymentsController::class, 'edit'])->name('purchase-payments.edit');
    Route::patch('/purchase-payments/update/{purchasePayment}', [PurchasePaymentsController::class, 'update'])->name('purchase-payments.update');
    Route::delete('/purchase-payments/destroy/{purchasePayment}', [PurchasePaymentsController::class, 'destroy'])->name('purchase-payments.destroy');

    //Generate Purchase Return PDF
    Route::get('/purchase-returns/pdf/{id}', [ExportController::class, 'purchaseReturns'])->name('purchase-returns.pdf');

    //Purchase Returns
    Route::resource('purchase-returns', PurchasesReturnController::class);

    //Purchase Returns Payments
    Route::get('/purchase-return-payments/{purchaseReturn_id}', [PurchaseReturnPaymentsController::class, 'index'])->name('purchase-return-payments.index');

    Route::get('/purchase-return-payments/{purchase_return_id}/create', [PurchaseReturnPaymentsController::class, 'create'])
        ->name('purchase-return-payments.create');
    Route::post('/purchase-return-payments/store', [PurchaseReturnPaymentsController::class, 'store'])
        ->name('purchase-return-payments.store');
    Route::get('/purchase-return-payments/{purchase_return_id}/edit/{purchaseReturnPayment}', [PurchaseReturnPaymentsController::class, 'edit'])
        ->name('purchase-return-payments.edit');
    Route::patch('/purchase-return-payments/update/{purchaseReturnPayment}', [PurchaseReturnPaymentsController::class, 'update'])
        ->name('purchase-return-payments.update');
    Route::delete('/purchase-return-payments/destroy/{purchaseReturnPayment}', [PurchaseReturnPaymentsController::class, 'destroy'])
        ->name('purchase-return-payments.destroy');

    //Profit Loss Report
    Route::get('/profit-loss-report', [ReportsController::class, 'profitLossReport'])->name('profit-loss-report.index');
    //Payments Report
    Route::get('/payments-report', [ReportsController::class, 'paymentsReport'])->name('payments-report.index');
    //Sales Report
    Route::get('/sales-report', [ReportsController::class, 'salesReport'])->name('sales-report.index');
    //Purchases Report
    Route::get('/purchases-report', [ReportsController::class, 'purchasesReport'])->name('purchases-report.index');
    //Sales Return Report
    Route::get('/sales-return-report', [ReportsController::class, 'salesReturnReport'])->name('sales-return-report.index');
    //Purchases Return Report
    Route::get('/purchases-return-report', [ReportsController::class, 'purchasesReturnReport'])->name('purchases-return-report.index');

    //POS
    Route::get('/pos', [PosController::class, 'index'])->name('app.pos.index');
    Route::post('/app/pos', [PosController::class, 'store'])->name('app.pos.store');

    //Generate Sale PDF
    Route::get('/sales/pdf/{id}', [ExportController::class, 'sale'])->name('sales.pdf');
    Route::get('/sales/pos/pdf/{id}', [ExportController::class, 'salePos'])->name('sales.pos.pdf');

    //Sales
    Route::resource('sales', SaleController::class);

    //Generate Sale Returns PDF
    Route::get('/sale-returns/pdf/{id}', [ExportController::class, 'saleReturns'])->name('sale-returns.pdf');

    //Sale Returns
    Route::resource('sale-returns', SalesReturnController::class);

    //User Profile
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('profile.index');

    //Users
    Route::get('users', UsersIndex::class)->name('users.index');

    //Roles
    Route::get('roles', RolesIndex::class)->name('roles.index');

    // Permissions
    Route::get('permissions', PermissionsIndex::class)->name('permissions.index');

    //Logs
    Route::get('logs', LogController::class)->name('logs.index');

    //Language Settings
    Route::get('languages', LanguageIndex::class)->name('languages.index');
    Route::get('/translation/{code}', EditTranslation::class)->name('translation.index');

    //General Settings
    Route::get('/settings', SettingController::class)->name('settings.index');

    // Integrations
    Route::get('/integrations', IntegrationController::class)->name('integrations.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    Route::get('/sections',Sectionsindex::class)->name('sections');

    Route::get('/featuredBanners', [FeaturedBannerController::class, 'index'])->name('featuredBanners');
    Route::get('/pages', PagesIndex::class)->name('pages');
    Route::get('/order-forms', [PageController::class, 'orderForms'])->name('orderforms');
    Route::get('/page/settings', [PageController::class, 'settings'])->name('page.settings');

    Route::get('/sliders', SlidersIndex::class)->name('sliders');

    Route::get('/blogs', SliderIndex::class)->name('blogs');
    Route::get('/blog/category', BlogCategoryIndex::class)->name('blogcategories');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::get('/backup', BackupIndex::class)->name('setting.backup');
    Route::get('/shipping', ShippingIndex::class)->name('setting.shipping');
    Route::get('/popupsettings', [SettingController::class, 'popupsettings'])->name('setting.popupsettings');
    Route::get('/redirects', [SettingController::class, 'redirects'])->name('setting.redirects');

    Route::get('/report', [ReportController::class, 'index'])->name('report');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/smpt', [SmptController::class, 'index'])->name('smpt');

    Route::get('/currencies', [SettingController::class, 'currencies'])->name('currencies');

    Route::get('/comment', CommentIndex::class)->name('comments');
    Route::get('/contacts', App\Livewire\Admin\Contacts::class);


        Route::get('/email', App\Livewire\Admin\Email::class);
        Route::get('/faq', App\Livewire\Admin\Faq::class);
        Route::get('/menu', App\Livewire\Admin\Menu::class);
        Route::get('/order', App\Livewire\Admin\Order::class);
        Route::get('/orderform', App\Livewire\Admin\OrderForm::class);
        Route::get('/package', App\Livewire\Admin\Package::class);
        Route::get('/partner', App\Livewire\Admin\Partner::class);
        Route::get('/pos', App\Livewire\Admin\Pos::class);
        Route::get('/printer', App\Livewire\Admin\Printer::class);
        Route::get('/product', App\Livewire\Admin\Product::class);
        Route::get('/products', App\Livewire\Admin\Products::class);
        Route::get('/purchase', App\Livewire\Admin\Purchase::class);
        Route::get('/purchasereturn', App\Livewire\Admin\PurchaseReturn::class);
        Route::get('/quotations', App\Livewire\Admin\Quotations::class);
        Route::get('/reports', App\Livewire\Admin\Reports::class);
        Route::get('/role', App\Livewire\Admin\Role::class);
        Route::get('/salereturn', App\Livewire\Admin\SaleReturn::class);
        Route::get('/sales', App\Livewire\Admin\Sales::class);
        Route::get('/section', App\Livewire\Admin\Section::class);
        Route::get('/service', App\Livewire\Admin\Service::class);
        Route::get('/settings', App\Livewire\Admin\Settings::class);
        Route::get('/stats', App\Livewire\Admin\Stats::class);
        Route::get('/subscriber', App\Livewire\Admin\Subscriber::class);
        Route::get('/sync', App\Livewire\Admin\Sync::class);
});
