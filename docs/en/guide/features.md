---
title: Features
lang: en-US
---

# Livewire Features

| Controller/Path | Methods |
| --- | --- |
| Account/Index | mount: void, render |
| Account/Orders | mount($customer): void, render |
| Account/UserInfos | mount($customer): void, render, save: void |
| Adjustment/Create | mount: void, render, updatedWarehouseId($value): void, store, productSelected(array $product): void, removeProduct($key): void |
| Adjustment/Edit | mount($id): void, update, productSelected(array $product): void, removeProduct($key): void, updatedWarehouseId($value): void, warehouses, render |
| Adjustment/Index | render, deleteSelected: void, delete(Adjustment $adjustment): void |
| Adjustment/ProductTable | mount($adjustedProducts = null): void, render, productSelected($product): void, removeProduct($key): void |
| Adjustment/Show | render, showModal($adjustment): void |
| Auth/ConfirmPassword | confirmPassword, render |
| Auth/ForgotPassword | sendResetPasswordLink: void, broker, render |
| Auth/Login | authenticate, render |
| Auth/Register | mount: void, register, render |
| Auth/ResetPassword | mount(string $token): void, resetPassword: void, render |
| Auth/Verify | sendVerification: void, logout: void, render |
| Backup/Index | settingsModal: void, saveToDriveManually(string $filename): void, cleanBackups: void, backupToDrive: void, updateSettigns: void, generate: void, downloadBackup($file), delete($name): void, getContentsProperty, render |
| Blog/Create | render, createModal: void, create: void, blogCategories |
| Blog/Edit | blogCategories, editModal($id): void, render, update: void |
| Blog/Index | delete: void, deleteSelected: void, deleteModal($blog): void, render |
| BlogCategory/Create | render, createModal: void, create: void |
| BlogCategory/Edit | editModal($id): void, update: void, render: View |
| BlogCategory/Index | confirmed: void, deleteModal($blogcategory): void, delete: void, deleteSelected: void, render |
| Brands/Create | createModal: void, create: void, render |
| Brands/Edit | editModal($id): void, update: void, render |
| Brands/Index | render, showModal(Brand $brand): void, confirmed: void, deleteModal($brand): void, deleteSelected: void, delete: void, importModal: void, downloadSample, import: void |
| Brands/Show | showModal($id): void, render: View|Factory |
| CashRegister/Create | createModal: void, create: void, warehouses: \Illuminate\Support\Collection, render |
| CashRegister/Index | mount: void, filterByType($type): void, render, deleteSelected: void, delete(CashRegister $cashRegister): void |
| CashRegister/Show | showModal($id), close, render |
| Categories/Create | createModal: void, create: void, render |
| Categories/Edit | render, editModal($id): void, update: void |
| Categories/Import | importModal: void, downloadSample, import: void, render |
| Categories/Index | render: mixed, showModal(Category $category): void, confirmed: void, deleteModal($category): void, deleteSelected: void, delete: void |
| Admin/Contacts | render, deleteSelected: void, delete(Contact $contact): void |
| Currency/Create | render, createModal: void, create: void |
| Currency/Edit | render, editModal($id): void, update: void |
| Currency/Index | render, delete(Currency $currency): void |
| Currency/Show | showModal($id): void, render |
| CustomerGroup/Create | render, createModal: void, create: void |
| CustomerGroup/Edit | render, editModal($id): void, update: void |
| CustomerGroup/Index | render, showModal($id): void, deleteSelected: void, delete(CustomerGroup $customergroup): void |
| Customers/Create | createModal: void, create: void, render |
| Customers/Details | mount($id): void, sales, customerPayments, totalSales: int|float, totalSaleReturns: int|float, totalPayments: int|float, totalDue: int|float, profit: int|float, render |
| Customers/Edit | render, editModal($id): void, update: void |
| Customers/GoogleContact | showContacts, fetchContacts, listContacts: array, convertToCustomer(string $resourceName), render |
| Customers/Index | render: View|Factory, deleteSelected: void, delete(Customer $customer): void, downloadSelected: BinaryFileResponse|Response, downloadAll(Customer $customers): BinaryFileResponse|Response, exportSelected: BinaryFileResponse|Response, exportAll: BinaryFileResponse|Response, import: void, importExcel: void |
| Customers/PayDue | getSalesCustomerDueProperty, payModal($customer): void, makePayment: void, render |
| Customers/Show | showModal($id): void, render |
| Admin/Dashboard | render |
| Delivery/Create | render, createModal($item_id = null, $type = null): void, create: void, shippings, sales, orders |
| Delivery/Edit | render, editModal($id): void, update: void, shippings, sales, orders |
| Delivery/Index | mount: void, filterByType($type): void, render, deleteSelected: void, delete(Delivery $delivery): void |
| Delivery/Show | showModal($id): void, render |
| Email/Create | render: View|Factory, createModal: void, create: void |
| Email/Edit | updatedMessage($value): void, render: View|Factory, editModal($id): void, update: void |
| Email/Index | render: View|Factory, delete(EmailTemplate $email): void |
| Expense/Create | render, createModal: void, create: void, expenseCategories, warehouses |
| Expense/Edit | expenseCategories, warehouses, render, editModal($id): void, update: void |
| Expense/Index | mount: void, filterByType($type): void, render, deleteSelected: void, delete(Expense $expense): void, showModal($id): void, downloadSelected: BinaryFileResponse, downloadAll: BinaryFileResponse, exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse |
| ExpenseCategories/Create | render, createModal: void, create: void |
| ExpenseCategories/Edit | render, editModal($id): void, update: void |
| ExpenseCategories/Index | render, deleteSelected: void, delete(ExpenseCategory $expenseCategory): void |
| Faq/Create | render: View|Factory, createModal: void, create: void |
| Faq/Edit | editModal($faq): void, update: void, render: View |
| Faq/Index | render: View|Factory, deleteSelected: void, delete(Faq $faq): void |
| FeaturedBanner/Create | mount: void, render: View|Factory, createModal: void, create: void, initListsForFields: void |
| FeaturedBanner/Index | mount: void, render: View|Factory, setFeatured($id): void, editModal(FeaturedBanner $featuredbanner): void, update: void, showModal(FeaturedBanner $featuredbanner): void, delete(FeaturedBanner $featuredbanner): void |
| Language/Create | createModal: void, create: void, render |
| Language/Edit | editModal($id): void, update: void, render |
| Language/EditTranslation | mount($id): void, updateTranslation: void, render |
| Language/Index | languages, render, onSetDefault($id): void, sync($id): void, delete(Language $language): void |
| Menu/Index | mount: void, filterByPlacement($value): void, clone: void, render, update($id): void, store: void, updateMenuOrder($ids): void, predefinedMenu: void, delete(Menu $menu): void |
| Notification/Index | render |
| Order/Edit | render, editModal($id): void, shippings, customers, update: void |
| Order/Index | mount: void, filterByType($type): void, render: View|Factory |
| Order/InvoicePrint | mount($id), render |
| Order/Show | mount($id): void, render |
| OrderForm/Index | render: View|Factory |
| Page/Create | saveEditorState($editorJsonData): void, store, render |
| Page/Edit | saveEditorState($editorJsonData): void, mount($id): void, update: void, render |
| Page/Index | render, delete: void, deleteSelected: void, confirmed: void, deleteModal($page): void |
| Page/Settings | settings, sections, pages, deleteSection($type, $id, $index): void, getConfig($type, $id), reorderSections($sectionIndexes): void, editSection($type, $id, $index): void, updateSection: void, save: void, templates: array, selectBgColor($color): void, selectColor($color): void, delete(PageSetting $setting): void |
| Page/Template | mount: void, createModal: void, updatedSelectTemplate: void, store: void, render |
| Permission/Index | render, createModal: void, create: void, editModal(Permission $permission): void, update: void, deleteSelected: void, delete(Permission $permission): void |
| Pos/Index | mount: void, hydrate: void, render, store: void, proceed: void, calculateTotal: mixed, resetCart: void, updatedWarehouseId($value): void |
| Printer/Create | mount(Printer $printer): void, render, createPrinter: void, create: void |
| Printer/Index | render, showModal(Printer $printer): void, editModal(Printer $printer): void, update(Printer $printer): void, delete(Printer $printer): void |
| Products/Barcode | updatedWarehouseId($value): void, productSelected(array $product): void, generateBarcodes: void, downloadBarcodes, deleteProduct($productId): void, render |
| Products/Create | render, saveEditorState($editorJsonData): void, createModal: void, create: void, categories, brands, warehouses |
| Products/Edit | saveEditorState($editorJsonData): void, addOption: void, removeOption($index): void, fetchSubcategories: void, editModal($id): void, update: void, categories, brands, render |
| Products/Highlighted | highlightModal($id): void, saveHighlight: void, render: View|Factory |
| Products/Image | imageModal($id): void, saveImage: void, render: View|Factory |
| Products/Import | render: View|Factory, downloadSample, importModal: void, importUpdates: void, import: void, googleSheetImport |
| Products/Index | deleteModal($product): void, deleteSelectedModal: void, deleteSelected: void, delete: void, render, sendTelegram($product): void, downloadAll: BinaryFileResponse, exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse, downloadSelected, promoAllProducts: void, discountSelected: void |
| Products/ProductOptions | updatedOptions($options): void, addOption: void, removeOption($index): void, mount: void, render: View |
| Products/PromoPrices | promoModal: void, update: void, render: View|Factory |
| Products/Show | showModal($id): void, render |
| Purchase/Create | mount: void, render, hydrate: void, proceed: void, store: void, calculateTotal: mixed, resetCart: void, updatedWarehouseId($warehouse_id): void, updatedStatus($status): void, updatedPaymentMethod($payment_status): void |
| Purchase/Edit | mount($id): void, update: void, render, hydrate: void, calculateTotal: mixed, resetCart: void, updatedWarehouseId($warehouse_id): void, updatedStatus($value): void |
| Purchase/Index | filterByType($type): void, mount: void, render, deleteSelected: void, delete(Purchase $purchase): void |
| Payment/Index | mount($purchase): void, render, showPayments($purchase_id): void |
| Purchase/PaymentForm | render, paymentModal($id): void, paymentSave: void |
| Purchase/Show | showModal($id): void, render |
| PurchaseReturn/Create | mount: void, create: void, render |
| PurchaseReturn/Edit | editModal($id): void, update: void, render |
| PurchaseReturn/Index | render, deleteSelected: void, delete(PurchaseReturn $purchasereturn): void, paymentModal(PurchaseReturn $purchasereturn): void, paymentSave: void |
| PurchaseReturn/Show | showModal($id): void, render |
| Quotations/Create | proceed: void, mount: void, store, hydrate: void, calculateTotal: float|int|array, render, updatedWarehouseId($value): void |
| Quotations/Edit | mount($id): void, update, render, updatedWarehouseId($value): void |
| Quotations/Index | render, deleteSelected: void, delete(Quotation $product): void |
| Quotations/Show | render, showModal($id): void |
| Reports/CustomersReport | mount: void, sales, saleReturns, quotations, render, generateReport: void |
| Reports/PaymentsReport | mount: void, render, generateReport: void, updatedPayments($value): void, getQuery: void |
| Reports/ProductReport | render |
| Reports/ProfitLossReport | mount: void, render, generateReport: void, setValues: void, calculateProfit: int|float, calculatePaymentsReceived: int|float, calculatePaymentsSent: int|float |
| Reports/PurchasesReport | mount: void, render, generateReport: void |
| Reports/PurchasesReturnReport | mount: void, render, generateReport: void |
| Reports/SalesReport | mount: void, render, generateReport: void |
| Reports/SalesReturnReport | mount: void, render, generateReport: void |
| Reports/StockAlertReport | getProductAlertProperty, render |
| Reports/SuppliersReport | mount: void, getPurchasesProperty, render, generateReport: void |
| Reports/WarehouseReport | mount: void, purchases, sales, quotations, expenses, warehouseReport: void, render |
| Reviews/Index | render: View|Factory |
| Role/Create | mount: void, render, submit |
| Role/Edit | mount(Role $role): void, render, submit |
| Role/Index | render, deleteSelected: void, delete(Role $role): void |
| SaleReturn/Index | render, showModal(SaleReturn $salereturn): void, deleteSelected: void, delete(SaleReturn $product): void, paymentModal(SaleReturn $salereturn): void, paymentSave: void |
| Sales/Create | mount: void, hydrate: void, render, proceed: void, store: void, calculateTotal: float|int|array, resetCart: void, category, updatedWarehouseId($value): void, updatedStatus($value): void |
| Sales/Edit | mount($id): void, proceed: void, update: void, render, updatedWarehouseId($value): void, updatedStatus($value): void |
| Sales/Index | mount: void, filterByType($type): void, render, importModal: void, downloadSample: BinaryFileResponse, import: void, deleteSelected: void, delete: void, deleteModal($id): void, sendWhatsapp($sale), openWhatapp($url): void |
| Payment/Index | render, showPayments($id): void, delete($id): void |
| Sales/PaymentForm | paymentModal($id): void, paymentSave: void, render |
| Sales/Recent | render, showModal($id): void, recentSales: void |
| Sales/Show | showModal($id): void, render |
| Sales/SyncOrders |  |
| Section/Create | createModal: void, render, save: void, languages |
| Section/Edit | editModal($id): void, update: void, render: View, languages |
| Section/Index | render, delete: void, deleteSelected: void, confirmed: void, deleteModal($section): void, clone(Section $section): void |
| Section/Settings | updatedSectionId: void, mount, sections, save: void, templates: array, render |
| Section/Template | mount: void, createModal: void, updatedSelectTemplate: void, create: void, render |
| Settings/ApiToken | mount: void, createToken: void, deleteToken: void, countNotExistingProducts: int, render |
| Settings/Index | render, mount: void, update: void |
| Settings/InvoiceTheme | mount, sale($id): Response, render |
| Settings/Languages | mount: void, render: View|Factory, onSetDefault($id): void, sync($id): void, delete(Language $language): void |
| Settings/MaintenanceMode | mount: void, saveSettings: void, turnOff: RedirectResponse, turnOn: void, render |
| Settings/Messaging | mount: void, getProductsProperty, getCustomersProperty, getSalesProperty, updatedType: void, fillMessage($template): void, sendDueAmount($saleId): void, openProductModal: void, openClientModal: void, openTemplate: void, insertProduct($id): void, insertSale($id): void, selectCustomer($customerId): void, sendMessage: void, render |
| Settings/Page | render: View|Factory |
| Settings/PopupSettings | setDefault($id): void, popupModal($popup = null): void, create: void, update($popup): void, render |
| Settings/Redirects | editModal($id): void, update: void, delete(Redirect $redirect): void, render: View|Factory |
| Settings/Smtp | mount: void, render, update: void |
| Settings/Update | checkForUpdates: void, updateSystem: void, render |
| Shipping/Create | render, createModal: void, create: void |
| Shipping/Edit | render: View|Factory, editModal($id): void, update: void |
| Shipping/Index | confirmed: void, render: View|Factory, deleteModal($shipping): void, delete: void |
| Slider/Create | render, createModal: void, create: void |
| Slider/Edit | editModal($id): void, update: void, render: View |
| Slider/Index | render, setFeatured($id): void, showModal(Slider $slider): void, delete(Slider $slider): void |
| Stats/Transactions | mount: void, chart: void, topProducts, topCustomers, monthlyChartOptions: array, dailyChartOptions: array, paymentChart: array, render |
| Subcategory/Create | render: View|Factory, createModal: void, create: void, categories, languages |
| Subcategory/Edit | editModal($id): void, update: void, categories, languages, render: View |
| Subcategory/Index | confirmed: void, render: View|Factory, deleteModal($subcategory): void, delete: void, deleteSelected: void |
| Subscriber/Index | render: View|Factory |
| Suppliers/Create | render, createModal: void, create: void |
| Suppliers/Details | mount($id): void, TotalPurchases: float, TotalPurchaseReturns: float, TotalDue: float, TotalPayments: float, Debit: float, getPurchasesProperty, getSupplierPaymentsProperty, render |
| Suppliers/Edit | render, editModal($id): void, update: void |
| Suppliers/Index | render, delete(Supplier $supplier): void, deleteSelected: void, importModal: void, downloadSample, import: void, downloadSelected, downloadAll(Supplier $suppliers), exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse |
| Suppliers/PayDue | getPurchasesSupplierDueProperty, makePayment: void, render |
| Suppliers/Show | showModal($id): void, render |
| Sync/Login | loginModal: void, authenticate: void, render |
| Sync/Orders | updatedType: void, sync: void, render |
| Sync/Products | syncModal: void, recieveData: void, sendData, render |
| Users/Create | render, createModal: void, create: void, warehouses, roles |
| Users/Edit | editModal($id): void, update: void, roles, warehouses, render: View |
| Users/Index | filterRole($role): void, render, getRolesProperty, assignRole(User $user, $role): void, deleteSelected: void, delete(User $user): void, showModal(User $user): void |
| Users/Profile | mount: void, render, update: void, updatePassword: void |
| Users/Show | showModal($id): void, render |
| Warehouses/Create | render, createModal: void, create: void |
| Warehouses/Edit | render, editModal($id): void, update: void |
| Warehouses/Index | render, showModal(Warehouse $warehouse): void, deleteModal($warehouse): void, deleteSelectedModal: void, deleteSelected: void, delete: void |
| Auth/ConfirmPassword | confirmPassword, render |
| Auth/ForgotPassword | sendResetPasswordLink: void, broker, render |
| Auth/Login | authenticate, render |
| Auth/Register | mount: void, register, render |
| Auth/ResetPassword | mount(string $token): void, resetPassword: void, render |
| Auth/Verify | sendVerification: void, logout: void, render |
| Front/Account | mount: void, save: void, render |
| Front/AddToCart | mount(Product $product): void, AddToCart(Product $product_id): void, render: View|Factory |
| Front/Blogs | categorySelected($category): void, featuredBlogs, categories, sections, render |
| Front/BlogShow | mount($slug): void, featuredBlogs, categories, render |
| Front/BrandPage | filterProductCategories($category_id): void, filterProductSubcategories($subcategory_id): void, mount($brand): void, loadMore: void, render: View|Factory |
| Front/Brands | updatingPerPage: void, filterProducts($type, $value): void, clearFilter($filter): void, mount: void, loadMore: void, render: View|Factory |
| Front/CartBar | confirmed: void, showCart: void, decreaseQuantity($rowId): void, increaseQuantity($rowId): void, removeFromCart($rowId): void, cartBarUpdated: void, cartItems, cartTotal, render: View|Factory |
| Front/CartCount | mount: void, cartCountUpdated: void, render: View|Factory |
| Front/Catalog | filterProducts($type, $value): void, clearFilter($filter): void, mount: void, render: View|Factory |
| Front/Categories | filterProducts($type, $value): void, clearFilter($filter): void, mount: void, loadMore: void, render: View|Factory |
| Front/Checkout | confirmed: void, checkout, mount, updateCartTotal: void, decreaseQuantity($rowId): void, increaseQuantity($rowId): void, removeFromCart($rowId): void, shippings, cartTotal, cartItems, subTotal, render: View|Factory |
| Front/ContactForm | render, submit: void |
| Front/DynamicPage | mount(?string $slug = 'home'): void, sliders, aboutSection, contactSection, render |
| Front/Index | getSubcategoriesProperty: Collection, getFeaturedProductsProperty, getBestOffersProperty, getHotProductsProperty, getBrandsProperty: Collection, getSlidersProperty: Collection, getFeaturedbannerProperty, getSectionsProperty: Collection, render: View|Factory |
| Front/NewslettersForm | render: View|Factory, subscribe: void |
| Front/OrderForm | mount($product): void, render: View|Factory, save: void |
| Front/Popups | showDelay(int $delay): void, showDuration(int $duration): void, showInterval(int $interval): void, render, hide: void |
| Front/ProductShow | decreaseQuantity: void, increaseQuantity: void, AddToCart($id, $price): void, mount($slug): void, render: View|Factory |
| Front/SearchBox | updatedSearch: void, hideSearchResults: void, clearSearch: void, render: View|Factory |
| Front/StepWizard | nextStep: void, prevStep: void, updateGiftOrSelf($giftOrSelf): void, updateCategoryId($category_id): void, updateBrandId($brand_id): void, updatedMinPrice($value): void, updatedMaxPrice($value): void, updateSubcategoryId($subcategory_id): void, clearFilter($filter): void, render |
| Front/Subcategories | filterProductSubcategories($subcategory_id): void, subcategories, render: View|Factory |
| Front/SubcategoryPage | getBrandsProperty, filterProducts($type, $value): void, clearFilter($filter): void, mount($slug): void, loadMore: void, render: View|Factory |
| Front/SubscribeForm | mount($race): void, render: View|Factory, save: void |
| Front/ThankYou | mount($id): void, render: View|Factory |
| Livewire/ProductCart | mount($cartInstance, $data = null): void, productSelected(array $product): void, calculate(array $product): array, updatePrice($row_id, $product_id): void, updatedGlobalTax: void, updatedGlobalDiscount: void, updatedTotalShipping: void, updatedShippingAmount($value): void, discountModal($product_id, $row_id): void, updateQuantity($row_id, $product_id): void, removeItem($row_id): void, updatedDiscountType($value, $name): void, productDiscount($row_id, $product_id): void, updateCartOptions($row_id, $product_id, $cart_item, $discount_amount): void, updatedWarehouseId($value): void, render |
| Livewire/SearchProduct | loadMore: void, selectProduct($product): void, updatedWarehouseId($value): void, getCategoriesProperty, mount($warehouse_id = null): void, render, resetQuery: void, updatedQuery: void |
| Seo/VerifySite | mount, verifySiteModal, isVerified, getVerificationToken, verifySite, render |
| Admin/WIthMeta |  |
| Admin/WithModels | customers, suppliers, warehouses |
| Utils/Cache | render, onClearCache: void |
| Utils/Calculator | render, calculate: void, updated($property): void |
| Utils/ColorPicker | mount: void, showColorPalette($color): void, selectColor($color): void, render |
| Utils/Datatable | mountDatatable: void, sortingBy($field, $direction): void, selectedCount: int, refreshIndex: void, resetSelected: void |
| Utils/EditorJs | mount(, completedImageUpload(string $uploadedFileName, string $eventName, $fileName = null): void, loadImageFromUrl(string $url), save: void, render |
| Front/WithModels | categories, brands, subcategories |
| Utils/Livesearch | mount: void, render |
| Utils/Logs | render |
| Utils/Meta | render |
| Utils/Notifications | mount: void, loadMore: void, markAsRead($key): void, readAll: void, clear: void, render |
| Utils/QrGenerator | render: View, refresh: void, generateWebsiteUrl: void, data: void, generateQrCode($download = false): void, downloadQrCode |
| QueueMonitor/Index | mount: void, delete: void, render |
| Utils/Sidebar | render: View |
| Utils/ToggleButton | mount: void, updating($field, $value): void, render |
