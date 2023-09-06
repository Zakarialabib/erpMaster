---
title: Features
lang: en-US
---

# Features

| Features | Status | Cool | Methods |
| --- | --- | --- | --- |
| Account/Index | in progress | 😐 | mount, render |
| Account/Orders | in progress | 😐 | mount, render |
| Account/UserInfos | in progress | 😐 | mount($user), render, save |
| Adjustment/Create | in progress | 😐 | mount, render, updatedWarehouseId($value), store, productSelected($product): , removeProduct($key): , warehouses |
| Adjustment/Edit | in progress | 😐 | mount($id), update, productSelected($product): , removeProduct($key): , updatedWarehouseId($value), warehouses, render |
| Adjustment/Index | in progress | 😐 | mount: , render, deleteSelected: , delete(Adjustment $adjustment): void |
| Adjustment/ProductTable | in progress | 😐 | mount($adjustedProducts = null), render, productSelected($product): , removeProduct($key): void |
| Adjustment/Show | in progress | 😐 | render, showModal($adjustment): void |
| Backup/Index | in progress | 😐 | settingsModal, saveToDriveManually($filename), cleanBackups, backupToDrive, updateSettigns, generate, downloadBackup($file), delete($name), getContentsProperty, render |
| Blog/Create | in progress | 😐 | render, createModal, create, blogCategories |
| Blog/Edit | in progress | 😐 | blogCategories, editModal($id), render, update |
| Blog/Index | in progress | 😐 | mount, delete, deleteSelected, deleteModal($blog), render |
| BlogCategory/Create | in progress | 😐 | render, createModal, create |
| BlogCategory/Edit | in progress | 😐 | editModal($id), update, render |
| BlogCategory/Index | in progress | 😐 | confirmed, mount, deleteModal($blogcategory), delete, deleteSelected, render |
| Brands/Create | in progress | 😐 | createModal: , create: , render |
| Brands/Edit | in progress | 😐 | editModal($id): , update, render |
| Brands/Index | in progress | 😐 | mount: , render, showModal(Brand $brand): , confirmed, deleteModal($brand), deleteSelected: , delete: , importModal: , downloadSample, import: void |
| Brands/Show | in progress | 😐 | showModal($id), render|Factory |
| Categories/Create | in progress | 😐 | createModal: , create: , render |
| Categories/Edit | in progress | 😐 | render, editModal($id): , update: void |
| Categories/Import | in progress | 😐 | importModal: , downloadSample: BinaryFileResponse, import: , render |
| Categories/Index | in progress | 😐 | mount: , render: mixed, showModal(Category $category): , confirmed, deleteModal($category), deleteSelected: , delete: void |
| Admin/Contacts | in progress | 😐 | mount, render, deleteSelected, delete(Contact $contact) |
| Currency/Create | in progress | 😐 | render, createModal: , create: void |
| Currency/Edit | in progress | 😐 | render, editModal($id): , update: void |
| Currency/Index | in progress | 😐 | mount: , render, showModal(Currency $currency): , delete(Currency $currency): void |
| CustomerGroup/Create | in progress | 😐 | render, createModal: , create: void |
| CustomerGroup/Edit | in progress | 😐 | render, editModal($id): , update: void |
| CustomerGroup/Index | in progress | 😐 | mount: , render, showModal($id): , deleteSelected: , delete(CustomerGroup $customergroup): void |
| Customers/Create | in progress | 😐 | createCustomer: , create: , render |
| Customers/Details | in progress | 😐 | mount($id): , getSalesProperty: mixed, getCustomerPaymentsProperty: mixed, getTotalSalesProperty: int|float, getTotalSaleReturnsProperty: int|float, getTotalPaymentsProperty: int|float, getTotalDueProperty: int|float, getProfitProperty: int|float, render |
| Customers/Edit | in progress | 😐 | render, editModal($id), update: void |
| Customers/Index | in progress | 😐 | mount: , render|Factory, deleteSelected, delete(Customer $customer), showModal($id): , downloadSelected: BinaryFileResponse|Response, downloadAll(Customer $customers): BinaryFileResponse|Response, exportSelected: BinaryFileResponse|Response, exportAll: BinaryFileResponse|Response, import: , importExcel |
| Customers/PayDue | in progress | 😐 | getSalesCustomerDueProperty, payModal($customer), makePayment, render |
| Admin/Dashboard | in progress | 😐 | render |
| Email/Create | in progress | 😐 | render|Factory, createModal, create |
| Email/Edit | in progress | 😐 | updatedMessage($value), render|Factory, editModal($id), update |
| Email/Index | in progress | 😐 | mount, render|Factory, delete(EmailTemplate $email) |
| Expense/Create | in progress | 😐 | render, createModal: , create: , getExpenseCategoriesProperty, getWarehousesProperty |
| Expense/Edit | in progress | 😐 | getExpenseCategoriesProperty, getWarehousesProperty, render, editModal($id): , update: void |
| Expense/Index | in progress | 😐 | mount: , filterByType($type), render, deleteSelected: , delete(Expense $expense): , showModal($id): , downloadSelected: BinaryFileResponse, downloadAll: BinaryFileResponse, exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse |
| ExpenseCategories/Create | in progress | 😐 | render, createModal: , create: void |
| ExpenseCategories/Edit | in progress | 😐 | render, editModal($id): , update: void |
| ExpenseCategories/Index | in progress | 😐 | mount: , render, showModal($id): , deleteSelected: , delete(ExpenseCategory $expenseCategory): void |
| Faq/Create | in progress | 😐 | render|Factory, createModal, create |
| Faq/Edit | in progress | 😐 | editModal($faq), update, render |
| Faq/Index | in progress | 😐 | mount, render|Factory, deleteSelected, delete(Faq $faq) |
| FeaturedBanner/Create | in progress | 😐 | mount, render|Factory, createModal, create, initListsForFields |
| FeaturedBanner/Index | in progress | 😐 | mount, render|Factory, setFeatured($id), editModal(FeaturedBanner $featuredbanner), update, showModal(FeaturedBanner $featuredbanner), delete(FeaturedBanner $featuredbanner) |
| Language/Create | in progress | 😐 | createLanguage, create, render |
| Language/Edit | in progress | 😐 | editLanguage($id), update, render |
| Language/EditTranslation | in progress | 😐 | mount($language), updateTranslation, render |
| Language/Index | in progress | 😐 | mount, render, onSetDefault($id), sync($id), delete(Language $language) |
| Menu/Index | in progress | 😐 | mount, render, update, store, updateMenuOrder($ids), predefinedMenu: , delete(Menu $menu) |
| Notification/Index | in progress | 😐 | render |
| Order/Index | in progress | 😐 | mount, render|Factory |
| Order/Show | in progress | 😐 | mount($id), render |
| OrderForm/Index | in progress | 😐 | mount, render|Factory |
| Page/Create | in progress | 😐 | saveEditorState($editorJsonData), store, render |
| Page/Edit | in progress | 😐 | saveEditorState($editorJsonData), mount($id), update, render |
| Page/Index | in progress | 😐 | mount, render, delete, deleteSelected, confirmed, deleteModal($page) |
| Page/Settings | in progress | 😐 | render |
| Page/Template | in progress | 😐 | mount, createTemplate, updatedSelectTemplate, store, render |
| Partner/Create | in progress | 😐 | render, createModal, store |
| Partner/Edit | in progress | 😐 | editModal($id), update, render |
| Partner/Index | in progress | 😐 | confirmed, mount, render, showModal(Partner $partner), deleteModal($partner), deleteSelected, delete |
| Permission/Index | in progress | 😐 | mount: , render, createModal: , create: , editModal(Permission $permission): , update: , deleteSelected: , delete(Permission $permission): void |
| Pos/Index | in progress | 😐 | rules: array, mount($cartInstance): , hydrate: , render, store: , proceed: , calculateTotal: mixed, resetCart: , getCustomersProperty, getWarehousesProperty, updatedWarehouseId($value) |
| Printer/Create | in progress | 😐 | mount(Printer $printer): , render, createPrinter: , create: void |
| Printer/Index | in progress | 😐 | mount: , render, showModal(Printer $printer): , editModal(Printer $printer): , update(Printer $printer): , delete(Printer $printer): void |
| Product/Create | in progress | 😐 | updatedProductSubcategories, fetchSubcategories, render|Factory, createModal, create |
| Product/Edit | in progress | 😐 | updatedProductSubcategories, fetchSubcategories, addOption, removeOption($index), editModal($id), update, render|Factory |
| Product/Index | in progress | 😐 | confirmed, mount, render|Factory, deleteModal($product), delete, deleteSelected: , clone(Product $product), updateSelected($field, $productId), expand(Product $product) |
| Product/Show | in progress | 😐 | showModal($id), render|Factory |
| Products/Barcode | in progress | 😐 | updatedWarehouseId($value), productSelected($product): , generateBarcodes, downloadBarcodes, deleteProduct($productId), getWarehousesProperty, render |
| Products/Create | in progress | 😐 | render, createModal: , create: , categories, brands, warehouses |
| Products/Edit | in progress | 😐 | editModal($id), update, categories, brands, render |
| Products/Highlighted | in progress | 😐 | highlightModal($id), saveHighlight, render|Factory |
| Products/Image | in progress | 😐 | imageModal($id), saveImage, render|Factory |
| Products/Import | in progress | 😐 | render|Factory, downloadSample: BinaryFileResponse, importModal, importUpdates, import, googleSheetImport |
| Products/Index | in progress | 😐 | mount: , deleteSelected: , delete(Product $product): , render, selectAll, selectPage, sendTelegram($product): , downloadAll: BinaryFileResponse, exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse, downloadSelected, clone(Product $product), promoAllProducts, discountSelected |
| Products/ProductOptions | in progress | 😐 | updatedOptions($options), addOption, removeOption($index), mount, render |
| Products/PromoPrices | in progress | 😐 | promoModal, update, render|Factory |
| Products/Show | in progress | 😐 | showModal($id), render |
| Purchase/Create | in progress | 😐 | mount: , render, hydrate: , store, calculateTotal: mixed, resetCart: , getWarehousesProperty, updatedWarehouseId($warehouse_id), updatedStatus($value) |
| Purchase/Edit | in progress | 😐 | mount($id), update, render, hydrate: , calculateTotal: mixed, resetCart: , getSupplierProperty, getWarehousesProperty, updatedWarehouseId($warehouse_id), updatedStatus($value) |
| Purchase/Index | in progress | 😐 | filterByType($type), mount: , render, deleteSelected: , delete(Purchase $purchase): void |
| Payment/Index | in progress | 😐 | mount($purchase): , render, showPayments($purchase_id): void |
| Purchase/PaymentForm | in progress | 😐 | render, paymentModal($id): , paymentSave: void |
| Purchase/Show | in progress | 😐 | showModal($id), render |
| PurchaseReturn/Index | in progress | 😐 | mount: , render, createModal: , create: , editModal(PurchaseReturn $purchasereturn), update: , showModal(PurchaseReturn $purchasereturn), deleteSelected, delete(PurchaseReturn $purchasereturn), paymentModal(PurchaseReturn $purchasereturn), paymentSave |
| Quotations/Create | in progress | 😐 | proceed, mount, store, render, updatedWarehouseId($value), customers, warehouses |
| Quotations/Edit | in progress | 😐 | mount($id), update, render, updatedWarehouseId($value), customers, warehouses |
| Quotations/Index | in progress | 😐 | mount: , render, deleteSelected, delete(Quotation $product) |
| Quotations/Show | in progress | 😐 | render, showModal($id) |
| Reports/CustomersReport | in progress | 😐 | mount, getSalesProperty, getSaleReturnsProperty, getQuotationProperty, render, generateReport |
| Reports/PaymentsReport | in progress | 😐 | mount: , render, generateReport, updatedPayments($value), getQuery |
| Reports/ProductReport | in progress | 😐 | render |
| Reports/ProfitLossReport | in progress | 😐 | mount: , render, generateReport, setValues, calculateProfit, calculatePaymentsReceived, calculatePaymentsSent |
| Reports/PurchasesReport | in progress | 😐 | mount, render, generateReport |
| Reports/PurchasesReturnReport | in progress | 😐 | mount, render, generateReport |
| Reports/SalesReport | in progress | 😐 | mount, render, generateReport |
| Reports/SalesReturnReport | in progress | 😐 | mount, render, generateReport |
| Reports/StockAlertReport | in progress | 😐 | getProductAlertProperty, render |
| Reports/SuppliersReport | in progress | 😐 | mount, getPurchasesProperty, render, generateReport |
| Reports/WarehouseReport | in progress | 😐 | mount, getPurchasesProperty, getSalesProperty, getQuotationsProperty, getExpensesProperty, warehouseReport, render |
| Reviews/Index | in progress | 😐 | mount, render|Factory |
| Role/Create | in progress | 😐 | mount, render, submit |
| Role/Edit | in progress | 😐 | mount(Role $role), render, submit |
| Role/Index | in progress | 😐 | mount, render, deleteSelected, delete(Role $role) |
| SaleReturn/Index | in progress | 😐 | mount: , render, showModal(SaleReturn $salereturn), deleteSelected, delete(SaleReturn $product), paymentModal(SaleReturn $salereturn), paymentSave, refreshCustomers |
| Sales/Create | in progress | 😐 | mount, hydrate: , render, proceed, store, calculateTotal, resetCart, customers, category, updatedWarehouseId($value), updatedStatus($value), warehouses |
| Sales/Edit | in progress | 😐 | mount($id), proceed, update, render, updatedWarehouseId($value), updatedStatus($value), customers, warehouses |
| Sales/Index | in progress | 😐 | mount: , filterByType($type), render, deleteSelected, delete(Sale $sale), importModal, downloadSample, import, refreshCustomers, sendWhatsapp($sale), openWhatapp($url) |
| Payment/Index | in progress | 😐 | mount($sale), render, showPayments($sale_id) |
| Sales/PaymentForm | in progress | 😐 | paymentModal($id), paymentSave, render |
| Sales/Recent | in progress | 😐 | mount: , render, showModal($id), recentSales |
| Sales/Show | in progress | 😐 | showModal($id), render |
| Sales/SyncOrders | in progress | 😐 |  |
| Section/Create | in progress | 😐 | createModal, render, save, languages |
| Section/Edit | in progress | 😐 | editModal($id), update, render, languages |
| Section/Index | in progress | 😐 | mount, render, delete, deleteSelected, confirmed, deleteModal($section), clone(Section $section) |
| Section/Template | in progress | 😐 | mount, createTemplate, updatedSelectTemplate, create, render |
| Service/Create | in progress | 😐 | createModal, render, submit |
| Service/Edit | in progress | 😐 | editModal($id), render, submit, getLanguagesProperty |
| Service/Index | in progress | 😐 | mount, render, showModal(Service $service), delete, deleteSelected, confirmed, deleteModal($service), clone(Service $service) |
| Service/Options | in progress | 😐 | updatedOptions($options), addOption, removeOption($index), mount, render |
| Settings/ApiToken | in progress | 😐 | mount, createToken, deleteToken, countNotExistingProducts, render |
| Settings/Index | in progress | 😐 | render, mount: , update: void |
| Settings/Languages | in progress | 😐 | mount, render|Factory, onSetDefault($id), sync($id), delete(Language $language) |
| Settings/Messaging | in progress | 😐 | mount, getProductsProperty, getCustomersProperty, getSalesProperty, updatedType, fillMessage($template), sendDueAmount($saleId), openProductModal, openClientModal, openTemplate, insertProduct($id), insertSale($id), selectCustomer($customerId), sendMessage, render |
| Settings/Page | in progress | 😐 | render|Factory |
| Settings/PopupSettings | in progress | 😐 | getSelectedCountProperty, updatingSearch, updatingPerPage, resetSelected, setDefault($id), popupModal($popup = null), create, update($popup), render |
| Settings/Redirects | in progress | 😐 | mount, editModal($id), update, delete(Redirect $redirect), render|Factory |
| Settings/Smtp | in progress | 😐 | mount, render, update |
| Settings/Update | in progress | 😐 | checkForUpdates, updateSystem, render |
| Shipping/Create | in progress | 😐 | render, createModal, create |
| Shipping/Edit | in progress | 😐 | render|Factory, editModal($id), update |
| Shipping/Index | in progress | 😐 | confirmed, mount, render|Factory, deleteModal($shipping), delete |
| Slider/Create | in progress | 😐 | render, createModal, create |
| Slider/Edit | in progress | 😐 | editModal($id), update, render |
| Slider/Index | in progress | 😐 | mount, render, setFeatured($id), showModal(Slider $slider), delete(Slider $slider) |
| Stats/Transactions | in progress | 😐 | mount, chart, dailyChartOptions, getMonthlyChartOptionsProperty, render |
| Subcategory/Create | in progress | 😐 | render|Factory, createModal, create, categories, languages |
| Subcategory/Edit | in progress | 😐 | editModal($id), update, categories, languages, render |
| Subcategory/Index | in progress | 😐 | confirmed, mount, render|Factory, deleteModal($subcategory), delete, deleteSelected |
| Subscriber/Index | in progress | 😐 | mount, render|Factory |
| Suppliers/Create | in progress | 😐 | render, createModal, create: void |
| Suppliers/Details | in progress | 😐 | mount($id): , getTotalPurchasesProperty, getTotalPurchaseReturnsProperty, getTotalDueProperty, getTotalPaymentsProperty, getDebitProperty, getPurchasesProperty: mixed, getSupplierPaymentsProperty: mixed, render |
| Suppliers/Edit | in progress | 😐 | render, editModal($id), update: void |
| Suppliers/Index | in progress | 😐 | mount: , render, showModal($id), delete(Supplier $supplier), deleteSelected, importModal, downloadSample, import, downloadSelected, downloadAll(Supplier $suppliers), exportSelected: BinaryFileResponse, exportAll: BinaryFileResponse |
| Suppliers/PayDue | in progress | 😐 | getPurchasesSupplierDueProperty, makePayment, render |
| Sync/Login | in progress | 😐 | loginModal, authenticate, render |
| Sync/Orders | in progress | 😐 | updatedType: , sync, render |
| Sync/Products | in progress | 😐 | syncModal: , recieveData, sendData, render |
| Users/Create | in progress | 😐 | render, createModal, create |
| Users/Edit | in progress | 😐 | editModal($user), update, render |
| Users/Index | in progress | 😐 | filterRole($role), mount, render, getRolesProperty, assignRole(User $user, $role), deleteSelected, delete(User $user), showModal(User $user) |
| Users/Profile | in progress | 😐 | mount: , render, update: , updatePassword |
| Users/Show | in progress | 😐 | showModal($id), render |
| Warehouses/Create | in progress | 😐 | render, createModal, create: void |
| Warehouses/Edit | in progress | 😐 | render, editModal($id), update: void |
| Warehouses/Index | in progress | 😐 | mount: , render, showModal(Warehouse $warehouse), delete(Warehouse $warehouse), deleteSelected |
| Auth/Index | in progress | 😐 | render |
| Auth/Login | in progress | 😐 | authenticate, render |
| Passwords/Confirm | in progress | 😐 | confirm, render |
| Passwords/Email | in progress | 😐 | sendResetPasswordLink, broker, render |
| Passwords/Reset | in progress | 😐 | mount($token), resetPassword, broker, render |
| Auth/Register | in progress | 😐 | mount, register, render |
| Auth/SocialAuth | in progress | 😐 | redirectToFacebook, handleFacebookCallback, redirectToGoogle, handleGoogleCallback, render |
| Auth/Verify | in progress | 😐 | resend, render |
| Front/Account | in progress | 😐 | mount, save, render |
| Front/AddToCart | in progress | 😐 | mount(Product $product), AddToCart(Product $product_id), render|Factory |
| Front/Blogs | in progress | 😐 | categorySelected($category), featuredBlogs, categories, sections, render |
| Front/BlogShow | in progress | 😐 | mount($slug), featuredBlogs, categories, render |
| Front/BrandPage | in progress | 😐 | filterProductCategories($category_id), filterProductSubcategories($subcategory_id), mount($brand), loadMore, render|Factory |
| Front/Brands | in progress | 😐 | updatingPerPage, filterProducts($type, $value), clearFilter($filter), mount, loadMore, render|Factory |
| Front/CartBar | in progress | 😐 | confirmed, showCart, decreaseQuantity($rowId), increaseQuantity($rowId), removeFromCart($rowId), cartBarUpdated, getCartItemsProperty, getSubTotalProperty, render|Factory |
| Front/CartCount | in progress | 😐 | mount, cartCountUpdated, render|Factory |
| Front/Catalog | in progress | 😐 | filterProducts($type, $value), clearFilter($filter), mount, render|Factory |
| Front/Categories | in progress | 😐 | filterProducts($type, $value), clearFilter($filter), mount, loadMore, render|Factory |
| Front/Checkout | in progress | 😐 | confirmed, getCartItemsProperty, getSubTotalProperty, checkout, updateCartTotal, decreaseQuantity($rowId), increaseQuantity($rowId), removeFromCart($rowId), getShippingsProperty, getCartTotalProperty, render|Factory |
| Front/Contact | in progress | 😐 | mount, render|Factory, submit |
| Front/ContactForm | in progress | 😐 | render, submit |
| Front/DynamicPage | in progress | 😐 | mount(?string $slug = 'home'), sliders, aboutSection, contactSection, render |
| Front/Index | in progress | 😐 | getSubcategoriesProperty: Collection, getFeaturedProductsProperty, getBestOffersProperty, getHotProductsProperty, getBrandsProperty: Collection, getSlidersProperty: Collection, getFeaturedbannerProperty, getSectionsProperty: Collection, render|Factory |
| Front/Newsletters | in progress | 😐 | render|Factory, subscribe |
| Front/NewslettersForm | in progress | 😐 | render|Factory, subscribe |
| Front/OrderForm | in progress | 😐 | mount($product), render|Factory, save |
| Front/Popups | in progress | 😐 | showDelay($delay), showDuration($duration), showInterval($interval), render, hide |
| Front/ProductShow | in progress | 😐 | decreaseQuantity, increaseQuantity, AddToCart($product_id), mount($slug), render|Factory |
| Front/SearchBox | in progress | 😐 | updatedSearch, hideSearchResults, clearSearch, render|Factory |
| Front/StepWizard | in progress | 😐 | nextStep, prevStep, updateGiftOrSelf($giftOrSelf), updateCategoryId($category_id), updateBrandId($brand_id), updatedMinPrice($value), updatedMaxPrice($value), updateSubcategoryId($subcategory_id), clearFilter($filter), render |
| Front/Subcategories | in progress | 😐 | filterProductSubcategories($subcategory_id), mount, subcategories, render|Factory |
| Front/SubcategoryPage | in progress | 😐 | getBrandsProperty, filterProducts($type, $value), clearFilter($filter), mount($slug), loadMore, render|Factory |
| Front/SubscribeForm | in progress | 😐 | mount($race), render|Factory, save |
| Front/ThankYou | in progress | 😐 | mount($order), render|Factory |
| Livewire/ProductCart | in progress | 😐 | mount($cartInstance, $data = null), productSelected($product): , calculate($product): array, removeItem($row_id), updatedGlobalTax, updatedGlobalDiscount, discountModal($product_id, $row_id): , updateQuantity($row_id, $product_id), updatedDiscountType($value, $name), productDiscount($row_id, $product_id): , updateCartOptions($row_id, $product_id, $cart_item, $discount_amount), updatePrice($row_id, $product_id), updatedWarehouseId($value), render |
| Livewire/SearchProduct | in progress | 😐 | loadMore, selectProduct($product), updatedWarehouseId($value), getCategoriesProperty, mount($warehouse_id = null): , render, resetQuery, updatedQuery |
| Utils/Cache | in progress | 😐 | render, onClearCache |
| Utils/Calculator | in progress | 😐 | render, calculate, updated($property) |
| Utils/Datatable | in progress | 😐 | mountDatatable: , sortBy(string $field): , reverseSort: string, selectedCount: int, resetSelected: , refreshIndex: void |
| Utils/EditorJs | in progress | 😐 | mount(, completedImageUpload(string $uploadedFileName, string $eventName, $fileName = null), loadImageFromUrl(string $url), save, render |
| Utils/Livesearch | in progress | 😐 | mount: , render |
| Utils/Notifications | in progress | 😐 | mount, loadMore, markAsRead($key), readAll, clear, render |
| Utils/QrGenerator | in progress | 😐 | render, refresh: , generateWebsiteUrl: , data: , generateQrCode($download = false): , downloadQrCode |
| QueueMonitor/Index | in progress | 😐 | mount, delete, render |
| Utils/Sidebar | in progress | 😐 | render |
| Utils/ToggleButton | in progress | 😐 | mount: , updating($field, $value), render |
| Utils/WithModels | in progress | 😐 | categories, brands, subcategories |
| --- | --- | --- | --- |
