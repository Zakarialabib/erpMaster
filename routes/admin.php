<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\PurchasePaymentsController;
use App\Http\Controllers\Admin\PurchaseReturnPaymentsController;
use App\Http\Controllers\Admin\PurchasesReturnController;
use App\Http\Controllers\Admin\QuotationSalesController;
use App\Http\Controllers\Admin\SalesReturnController;
use App\Http\Controllers\Admin\SendQuotationEmailController;
use App\Http\Controllers\Admin\SettingController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\Profile as ProfileIndex;
use App\Livewire\Admin\Adjustment\Index as AdjustmentIndex;
use App\Livewire\Admin\Adjustment\Create as CreateAdjustment;
use App\Livewire\Admin\Adjustment\Edit as EditAdjustment;
use App\Livewire\Admin\Backup\Index as BackupIndex;
use App\Livewire\Admin\Blog\Index as BlogsIndex;
use App\Livewire\Admin\Brands\Index as BrandIndex;
use App\Livewire\Admin\BlogCategory\Index as BlogCategoryIndex;
use App\Livewire\Admin\Categories\Index as CategoryIndex;
use App\Livewire\Admin\CashRegister\Index as CashRegisterIndex;
use App\Livewire\Admin\Currency\Index as CurrencyIndex;
use App\Livewire\Admin\Customers\Index as CustomersIndex;
use App\Livewire\Admin\Customers\Details as CustomerDetails;
use App\Livewire\Admin\CustomerGroup\Index  as CustomerGroupIndex;
use App\Livewire\Admin\Delivery\Index  as DeliveryIndex;
use App\Livewire\Admin\Email\Index as EmailIndex;
use App\Livewire\Admin\Expense\Index as ExpensesIndex;
use App\Livewire\Admin\ExpenseCategories\Index as ExpenseCategoriesIndex;
use App\Livewire\Admin\FeaturedBanner\Index as FeaturedBannersIndex;
use App\Livewire\Admin\Faq\Index as FaqIndex;
use App\Livewire\Admin\Language\Index as LanguageIndex;
use App\Livewire\Admin\Language\EditTranslation;
use App\Livewire\Admin\Permission\Index as PermissionsIndex;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Products\Barcode as BarcodeIndex;
use App\Livewire\Admin\Reviews\Index as ReviewsIndex;
use App\Livewire\Admin\Role\Index as RolesIndex;
use App\Livewire\Admin\Section\Index as Sectionsindex;
use App\Livewire\Admin\Section\Settings as SectionSettings;
use App\Livewire\Admin\Slider\Index as SlidersIndex;
use App\Livewire\Admin\Subcategory\Index as SubcategoryIndex;
use App\Livewire\Admin\Suppliers\Index  as SuppliersIndex;
use App\Livewire\Admin\Suppliers\Details  as SupplierDetails;
use App\Livewire\Admin\Warehouses\Index as WarehouseIndex;
use App\Livewire\Admin\Shipping\Index as ShippingIndex;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Page\Index as PagesIndex;
use App\Livewire\Admin\Page\Edit as EditPage;
use App\Livewire\Admin\Page\Create as CreatePage;
use App\Livewire\Admin\Page\Settings as PageSettings;
use App\Livewire\Admin\Menu\Index as MenuIndex;
use App\Livewire\Admin\Order\Index as OrdersIndex;
use App\Livewire\Admin\Order\InvoicePrint as OrderInvoicePrint;
use App\Livewire\Admin\OrderForm\Index as OrderFormIndex;
use App\Livewire\Admin\Notification\Index as NotificationIndex;
use App\Livewire\Admin\Pos\Index as PosIndex;
use App\Livewire\Admin\Printer\Index as PrinterIndex;
use App\Livewire\Admin\Purchase\Index as PurchasesIndex;
use App\Livewire\Admin\Purchase\Create as CreatePurchase;
use App\Livewire\Admin\Purchase\Edit as EditPurchase;
use App\Livewire\Admin\PurchaseReturn\Index as PurchaseReturnIndex;
use App\Livewire\Admin\Quotations\Index as QuotationsIndex;
use App\Livewire\Admin\Quotations\Create as CreateQuotation;
use App\Livewire\Admin\Quotations\Edit as EditQuotation;
use App\Livewire\Admin\Transfer\Index as TransferIndex;
use App\Livewire\Admin\SaleReturn\Index as SaleReturnIndex;
use App\Livewire\Admin\Sales\Index as SalesIndex;
use App\Livewire\Admin\Sales\Create as CreateSale;
use App\Livewire\Admin\Sales\Edit as EditSale;
use App\Livewire\Admin\Settings\Index as SettingsIndex;
use App\Livewire\Admin\Settings\PopupSettings;
use App\Livewire\Admin\Settings\Redirects as RedirectsIndex;
use App\Livewire\Admin\Subscriber\Index as SubscriberIndex;
use App\Livewire\Admin\Contacts as ContactsIndex;
use App\Livewire\Admin\Settings\InvoiceTheme;
use App\Livewire\Utils\Logs as LogIndex;
use App\Livewire\Admin\Reports\CustomersReport;
use App\Livewire\Admin\Reports\ProfitLossReport;
use App\Livewire\Admin\Reports\PaymentsReport;
use App\Livewire\Admin\Reports\SalesReport;
use App\Livewire\Admin\Reports\PurchasesReport;
use App\Livewire\Admin\Reports\SalesReturnReport;
use App\Livewire\Admin\Reports\PurchasesReturnReport;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard
Route::get('/dashboard', Dashboard::class)->name('dashboard');

//POS
Route::get('/pos', PosIndex::class)->name('pos.index');

//Product Adjustment
Route::get('/adjustments', AdjustmentIndex::class)->name('adjustments.index');
Route::get('/adjustment/create', CreateAdjustment::class)->name('adjustments.create');
Route::get('/adjustment/update/{id}', EditAdjustment::class)->name('adjustments.edit');

//Currencies
Route::get('/currencies', CurrencyIndex::class)->name('currencies.index');

//Cash Register
Route::get('/cash-registers', CashRegisterIndex::class)->name('cash-register.index');

//Expense Category
Route::get('/expense-categories', ExpenseCategoriesIndex::class)->name('expense-categories.index');

//Expense
Route::get('/expenses', ExpensesIndex::class)->name('expenses.index');

//Customers
Route::get('/customers', CustomersIndex::class)->name('customers.index');
Route::get('/customer/details/{id}', CustomerDetails::class)->name('customer.details');
Route::get('/customergroup', CustomerGroupIndex::class)->name('customer-group.index');

Route::get('/deliveries', DeliveryIndex::class)->name('deliveries.index');

Route::get('/suppliers', SuppliersIndex::class)->name('suppliers.index');
Route::get('/supplier/details/{id}', SupplierDetails::class)->name('supplier.details');

//Warehouses
Route::get('/warehouses', WarehouseIndex::class)->name('warehouses.index');

Route::get('/brands', BrandIndex::class)->name('brands.index');
Route::get('/product-categories', CategoryIndex::class)->name('product-categories.index');

Route::get('/subcategories', SubcategoryIndex::class)->name('product-subcategories.index');

Route::get('/products', ProductsIndex::class)->name('products.index');

Route::get('/products/print-barcode', BarcodeIndex::class)->name('barcode.print');
//Generate Quotation PDF
Route::get('/quotations/pdf/{id}', [ExportController::class, 'quotation'])->name('quotations.pdf');

//Send Quotation Mail
Route::get('/quotation/mail/{quotation}', SendQuotationEmailController::class)->name('quotation.email');

//Sales Form Quotation
Route::get('quotation-sales/{quotation}', QuotationSalesController::class)->name('quotation-sales.create');

//Quotations
Route::get('/quotations', QuotationsIndex::class)->name('quotations.index');
Route::get('/quotation/create', CreateQuotation::class)->name('quotation.create');
Route::get('/quotation/update/{id}', EditQuotation::class)->name('quotation.edit');

//Generate Purchase PDF
Route::get('/purchases/pdf/{id}', [ExportController::class, 'purchase'])->name('purchases.pdf');

//Purchases
Route::get('/purchases', PurchasesIndex::class)->name('purchases.index');
Route::get('/purchase/create', CreatePurchase::class)->name('purchase.create');
Route::get('/purchase/update/{id}', EditPurchase::class)->name('purchase.edit');

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

Route::get('/customers-report', CustomersReport::class)->name('customers-report.index');
Route::get('/profit-loss-report', ProfitLossReport::class)->name('profit-loss-report.index');
Route::get('/sales-report', SalesReport::class)->name('sales-report.index');
Route::get('/sales-return-report', SalesReturnReport::class)->name('sales-return-report.index');
Route::get('/purchases-report', PurchasesReport::class)->name('purchases-report.index');
Route::get('/purchases-return-report', PurchasesReturnReport::class)->name('purchases-return-report.index');
Route::get('/payments-report', PaymentsReport::class)->name('payments-report.index');

//Generate Sale PDF
Route::get('/sales/pdf/{id}', [ExportController::class, 'sale'])->name('sales.pdf');
Route::get('/sales/pos/pdf/{id}', [ExportController::class, 'salePos'])->name('sales.pos.pdf');

//Sales
Route::get('/sales', SalesIndex::class)->name('sales.index');
Route::get('/sale/create', CreateSale::class)->name('sale.create');
Route::get('/sale/update/{id}', EditSale::class)->name('sale.edit');

//Generate Sale Returns PDF
Route::get('/sale-returns/pdf/{id}', [ExportController::class, 'saleReturns'])->name('sale-returns.pdf');

//Sale Returns
Route::resource('sale-returns', SalesReturnController::class);

Route::get('/transfers', TransferIndex::class)->name('tranfers.index');

//User Profile
Route::get('/user/profile', ProfileIndex::class)->name('profile.index');

//Users
Route::get('users', UsersIndex::class)->name('users.index');

//Roles
Route::get('roles', RolesIndex::class)->name('roles.index');

// Permissions
Route::get('permissions', PermissionsIndex::class)->name('permissions.index');

//Logs
Route::get('logs', LogIndex::class)->name('logs.index');

//Language Settings
Route::get('languages', LanguageIndex::class)->name('languages.index');
Route::get('/translation/{id}', EditTranslation::class)->name('translation');

//General Settings
Route::get('/settings', SettingsIndex::class)->name('settings.index');

Route::get('/invoices-theme', InvoiceTheme::class)->name('invoices.index');

// Integrations
Route::get('/integrations', IntegrationController::class)->name('integrations.index');

Route::get('/orders', OrdersIndex::class)->name('orders.index');
Route::get('/order-forms', OrderFormIndex::class)->name('orderforms');
Route::get('/order/print/{id}', OrderInvoicePrint::class)->name('order.pdf');

Route::get('/sections', Sectionsindex::class)->name('sections.index');
Route::get('/section/settings', SectionSettings::class)->name('section.settings');

Route::get('/featuredBanners', FeaturedBannersIndex::class)->name('featuredBanners');

Route::get('/pages', PagesIndex::class)->name('pages.index');
Route::get('/page/create', CreatePage::class)->name('page.create');
Route::get('/page/{id}/edit', EditPage::class)->name('page.edit');
Route::get('/page/settings', PageSettings::class)->name('page.settings');

Route::get('/sliders', SlidersIndex::class)->name('sliders.index');

Route::get('/blogs', BlogsIndex::class)->name('blogs.index');
Route::get('/blog/category', BlogCategoryIndex::class)->name('blog-categories.index');

Route::get('/backup', BackupIndex::class)->name('setting.backup');
Route::get('/shipping', ShippingIndex::class)->name('shipping.index');
Route::get('/popupsettings', PopupSettings::class)->name('setting.popupsettings');
Route::get('/redirects', RedirectsIndex::class)->name('setting.redirects');

Route::get('/notification', NotificationIndex::class)->name('notification');

Route::get('/reviews', ReviewsIndex::class)->name('reviews.index');
Route::get('/contacts', ContactsIndex::class)->name('contacts.index');

Route::get('/email-settings', EmailIndex::class)->name('email-settings');
Route::get('/faqs', FaqIndex::class)->name('faqs');
Route::get('/menus', MenuIndex::class)->name('menus');
Route::get('/printers', PrinterIndex::class)->name('printers');
Route::get('/subscribers', SubscriberIndex::class)->name('subscribers.index');

// Route::get('/package', PackageIndex::class);
// Route::get('/partner', PartnerIndex::class);
// Route::get('/purchasereturn', PurchaseReturnIndex::class);
// Route::get('/salereturn', SaleReturnIndex::class);
