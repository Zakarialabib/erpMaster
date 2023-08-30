---
title: Features
lang: en-US
---

# Features

| Features | Status | Cool | Methods |
| --- | --- | --- | --- |
| Adjustment/Create | in progress | 😐 |  updatedWarehouseId($value), store, productSelected($product):, removeProduct($key): |
| Adjustment/Edit | in progress | 😐 | mount($adjustment), update, productSelected($product):, removeProduct($key):, updatedWarehouseId($value) |
| Adjustment/Index | in progress | 😐 | deleteSelected:, delete(Adjustment $adjustment): |
| Adjustment/ProductTable | in progress | 😐 | mount($adjustedProducts = null), productSelected($product):, removeProduct($key): |
| Adjustment/Show | in progress | 😐 | showModal($adjustment): |
| Auth/Login | in progress | 😐 | authenticate |
| Auth/Register | in progress | 😐 | register |
| Auth/Verify | in progress | 😐 | resend |
| Backup/Index | in progress | 😐 | settingsModal, saveToDriveManually($filename), cleanBackups, backupToDrive, updateSettigns, generate, downloadBackup($file), delete($name), getContentsProperty |
| Brands/Create | in progress | 😐 | createModal:, create: |
| Brands/Edit | in progress | 😐 | editModal($id):, update |
| Brands/Index | in progress | 😐 | selectAll, selectPage, showModal(Brand $brand):, confirmed, deleteModal($brand), deleteSelected:, delete:, importModal:, downloadSample, import: |
| Categories/Create | in progress | 😐 | createModal:, create: |
| Categories/Edit | in progress | 😐 | editModal($id):, update: |
| Categories/Index | in progress | 😐 | showModal(Category $category):, confirmed, deleteModal($category), deleteSelected:, delete:, importModal:, downloadSample, import: |
| Currency/Create | in progress | 😐 | createModal:, create: |
| Currency/Edit | in progress | 😐 | editModal($id):, update: |
| Currency/Index | in progress | 😐 | showModal(Currency $currency):, delete(Currency $currency): |
| CustomerGroup/Create | in progress | 😐 | createModal:, create: |
| CustomerGroup/Edit | in progress | 😐 | editModal($id):, update: |
| CustomerGroup/Index | in progress | 😐 | showModal($id):, deleteSelected:, delete(CustomerGroup $customergroup): |
| Customers/Create | in progress | 😐 | createCustomer:, create: |
| Customers/Details | in progress | 😐 | getSelectedCountProperty: int, updatingSearch:, resetSelected:, mount($customer):, getSalesProperty: mixed, getCustomerPaymentsProperty: mixed, getTotalSalesProperty: int|float, getTotalSaleReturnsProperty: int|float, getTotalPaymentsProperty: int|float, getTotalDueProperty: int|float, getProfitProperty: int|float |
| Customers/Edit | in progress | 😐 | editModal($id), update: |
| Customers/Index | in progress | 😐 | deleteSelected, delete(Customer $customer), showModal($id):, downloadSelected, downloadAll(Customer $customers), exportSelected, exportAll, import:, importExcel |
| Customers/PayDue | in progress | 😐 | getSalesCustomerDueProperty, payModal($customer), makePayment |
| Expense/Create | in progress | 😐 | createModal:, create:, getExpenseCategoriesProperty, getWarehousesProperty |
| Expense/Edit | in progress | 😐 | getExpenseCategoriesProperty, getWarehousesProperty, editModal(Expense $expense):, update: |
| Expense/Index | in progress | 😐 | filterByType($type), deleteSelected:, delete(Expense $expense):, showModal($id):, downloadSelected , downloadAll , exportSelected |
| ExpenseCategories/Create | in progress | 😐 | createModal:, create: |
| ExpenseCategories/Edit | in progress | 😐 | editModal($id):, update: |
| ExpenseCategories/Index | in progress | 😐 | showModal($id):, deleteSelected:, delete(ExpenseCategory $expenseCategory): |
| Language/Create | in progress | 😐 | createModal, create |
| Language/Edit | in progress | 😐 | editLanguage($id), update |
| Language/EditTranslation | in progress | 😐 | mount($code), updateTranslation |
| Language/Index | in progress | 😐 |  onSetDefault($id), sync($id), delete(Language $language) |
| Permission/Index | in progress | 😐 | createModal:, create:, editModal(Permission $permission):, update:, deleteSelected:, delete(Permission $permission): |
| Pos/Index | in progress | 😐 | mount($cartInstance):, hydrate:, store:, proceed:, calculateTotal: mixed, resetCart:, getCustomersProperty, getWarehousesProperty, updatedWarehouseId($value) |
| Printer/Create | in progress | 😐 | mount(Printer $printer):, createPrinter:, create: |
| Printer/Index | in progress | 😐 | showModal(Printer $printer):, editModal(Printer $printer):, update(Printer $printer):, delete(Printer $printer): |
| Products/Barcode | in progress | 😐 | updatedWarehouseId($value), productSelected($product):, generateBarcodes, downloadBarcodes, deleteProduct($productId), getWarehousesProperty |
| Products/Create | in progress | 😐 | createModal:, create:, getCategoriesProperty, getBrandsProperty, getWarehousesProperty |
| Products/Edit | in progress | 😐 | editModal($id), update, getCategoriesProperty, getBrandsProperty |
| Products/Index | in progress | 😐 | deleteSelected:, delete(Product $product):, selectAll, selectPage, sendTelegram($product):, importModal:, downloadSample, import:, downloadAll , exportSelected |
| Products/Show | in progress | 😐 | showModal($id) |
| Purchase/Create | in progress | 😐 | mount($cartInstance):, hydrate:, store, calculateTotal: mixed, resetCart:, getWarehousesProperty, updatedWarehouseId($warehouse_id), updatedStatus($value) |
| Purchase/Edit | in progress | 😐 | mount(Purchase $purchase), update, hydrate:, calculateTotal: mixed, resetCart:, getSupplierProperty, getWarehousesProperty, updatedWarehouseId($warehouse_id), updatedStatus($value) |
| Purchase/Index | in progress | 😐 | filterByType($type), deleteSelected:, delete(Purchase $purchase): |
| Purchase/PaymentForm | in progress | 😐 | paymentModal($id):, paymentSave: |
| Purchase/Show | in progress | 😐 | showModal($id) |
| PurchaseReturn/Index | in progress | 😐 | createModal:, create:, editModal(PurchaseReturn $purchasereturn), update:, showModal(PurchaseReturn $purchasereturn), deleteSelected, delete(PurchaseReturn $purchasereturn), paymentModal(PurchaseReturn $purchasereturn), paymentSave |
| Quotations/Index | in progress | 😐 | showModal(Quotation $quotation), deleteSelected, delete(Quotation $product) |
| Reports/CustomersReport | in progress | 😐 | getSalesProperty, getSaleReturnsProperty, getQuotationProperty, generateReport |
| Reports/PaymentsReport | in progress | 😐 | generateReport, updatedPayments($value), getQuery |
| Reports/ProductReport | not started | 😐 |  |
| Reports/ProfitLossReport | in progress | 😐 | generateReport, setValues, calculateProfit, calculatePaymentsReceived, calculatePaymentsSent |
| Reports/PurchasesReport | in progress | 😐 |  generateReport |
| Reports/PurchasesReturnReport | in progress | 😐 |  generateReport |
| Reports/SalesReport | in progress | 😐 |  generateReport |
| Reports/SalesReturnReport | in progress | 😐 |  generateReport |
| Reports/StockAlertReport | in progress | 😐 | getProductAlertProperty |
| Reports/SuppliersReport | in progress | 😐 | getPurchasesProperty, generateReport |
| Reports/WarehouseReport | in progress | 😐 | getPurchasesProperty, getSalesProperty, getQuotationsProperty, getExpensesProperty, warehouseReport |
| Role/Create | in progress | 😐 | selectAllPermissions, getIsAllSelectedProperty, getIsNoneSelectedProperty, deselectAllPermissions, createModal, store:, getPermissionsProperty |
| Role/Edit | in progress | 😐 | editModal($id), update:, selectAllPermissions, deselectAllPermissions, getIsAllSelectedProperty, getIsNoneSelectedProperty, getPermissionsProperty |
| Role/Index | in progress | 😐 | deleteSelected, delete(Role $role), confirmedDelete |
| SaleReturn/Index | in progress | 😐 | showModal(SaleReturn $salereturn), deleteSelected, delete(SaleReturn $product), paymentModal(SaleReturn $salereturn), paymentSave, refreshCustomers |
| Sales/Create | in progress | 😐 | rules, mount($cartInstance), hydrate:, proceed, store, calculateTotal, resetCart, getCustomersProperty, getCategoryProperty, updatedWarehouseId($value), updatedStatus($value), getWarehousesProperty |
| Sales/Edit | in progress | 😐 | mount(Sale $sale), proceed, update, getCustomersProperty, updatedWarehouseId($value), updatedStatus($value), getWarehousesProperty |
| Sales/Index | in progress | 😐 | filterByType($type), deleteSelected, delete(Sale $sale), importModal, downloadSample, import, refreshCustomers, sendWhatsapp($sale), openWhatapp($url) |
| Sales/PaymentForm | in progress | 😐 | paymentModal($id), paymentSave |
| Sales/Recent | in progress | 😐 | showModal($id), recentSales |
| Sales/Show | in progress | 😐 | showModal($id) |
| Sales/SyncOrders | Not Started | 😐 |  |
| Settings/ApiToken | in progress | 😐 | createToken, deleteToken, countNotExistingProducts |
| Settings/Index | in progress | 😐 | update: |
| Settings/Messaging | in progress | 😐 | getProductsProperty, getCustomersProperty, getSalesProperty, updatedType, fillMessage($template), sendDueAmount($saleId), openProductModal, openClientModal, openTemplate, insertProduct($id), insertSale($id), selectCustomer($customerId), sendMessage |
| Settings/Smtp | in progress | 😐 |  update |
| Settings/Update | in progress | 😐 | checkForUpdates, updateSystem |
| Stats/Transactions | in progress | 😐 | chart, getDailyChartOptionsProperty, getMonthlyChartOptionsProperty |
| Suppliers/Create | in progress | 😐 | createModal, create: |
| Suppliers/Details | in progress | 😐 | getSelectedCountProperty: int, updatingSearch:, resetSelected:, mount($supplier):, getTotalPurchasesProperty, getTotalPurchaseReturnsProperty, getTotalDueProperty, getTotalPaymentsProperty, getDebitProperty, getPurchasesProperty: mixed, getSupplierPaymentsProperty: mixed |
| Suppliers/Edit | in progress | 😐 | editModal($id), update: |
| Suppliers/Index | in progress | 😐 | showModal($id), delete(Supplier $supplier), deleteSelected, importModal, downloadSample, import, downloadSelected, downloadAll(Supplier $suppliers), exportSelected |
| Suppliers/PayDue | in progress | 😐 | getPurchasesSupplierDueProperty, makePayment |
| Sync/Login | in progress | 😐 | loginModal, authenticate |
| Sync/Orders | in progress | 😐 | updatedType:, sync |
| Sync/Products | in progress | 😐 | syncModal:, recieveData, sendData |
| Users/Create | in progress | 😐 | createModal:, create:, getRolesProperty, getWarehousesProperty |
| Users/Edit | in progress | 😐 | editModal($id), update:, getRolesProperty, getWarehousesProperty |
| Users/Index | in progress | 😐 | deleteSelected, delete(User $user) |
| Users/Profile | in progress | 😐 | update:, updatePassword |
| Users/Show | in progress | 😐 | showModal($id) |
| Warehouses/Create | in progress | 😐 | mount(Warehouse $warehouse):, createModal, create: |
| Warehouses/Index | in progress | 😐 | showModal(Warehouse $warehouse), editModal(Warehouse $warehouse), update:, delete(Warehouse $warehouse), deleteSelected |