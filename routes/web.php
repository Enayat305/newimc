<?php

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

include_once('install_r.php');

Route::middleware(['authh'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/business/register', 'BusinessController@getRegister')->name('business.getRegister');
    Route::post('/business/register', 'BusinessController@postRegister')->name('business.postRegister');
    Route::post('/business/register/check-username', 'BusinessController@postCheckUsername')->name('business.postCheckUsername');
    Route::post('/business/register/check-email', 'BusinessController@postCheckEmail')->name('business.postCheckEmail');

    Route::get('/invoice/{token}', 'SellPosController@showInvoice')
        ->name('show_invoice');
});

//Routes for authenticated users only
Route::middleware(['auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu','AdminSidebarMenuLab', 'CheckUserLogin'])->group(function () {
    Route::resource('los', 'Lab\SellPosController');
    Route::get('get-recent-transactions', 'Lab\SellPosController@getRecentTransactions');
    
    
    Route::group(['prefix' => 'lab'], function () {
    Route::resource('doctor', 'Lab\DoctorCommissionController');
    Route::get('/get_commission', 'Lab\DoctorCommissionController@getTotalSellCommission');
    //Transaction payments...
    // Route::get('/payments/opening-balance/{contact_id}', 'TransactionPaymentController@getOpeningBalancePayments');
    Route::get('/payments/show-child-payments/{payment_id}', 'Lab\TransactionPaymentController@showChildPayments');
    Route::get('/payments/view-payment/{payment_id}', 'Lab\TransactionPaymentController@viewPayment');
    Route::get('/payments/add_payment/{transaction_id}', 'Lab\TransactionPaymentController@addPayment');
    Route::get('/payments/pay-contact-due/{contact_id}', 'Lab\TransactionPaymentController@getPayContactDue');
    Route::post('/payments/pay-contact-due', 'Lab\TransactionPaymentController@postPayContactDue');
    Route::resource('payments', 'Lab\TransactionPaymentController');

        Route::get('/user/profile', 'UserController@getProfile')->name('user.getProfile');
        Route::post('/user/update', 'UserController@updateProfile')->name('user.updateProfile');
        Route::post('/user/update-password', 'UserController@updatePassword')->name('user.updatePassword');
        Route::resource('roles', 'Lab\RoleController');

        Route::resource('users', 'Lab\ManageUserController');
        //Stock adjsment
        Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', 'Lab\StockAdjustmentController@removeExpiredStock');
    Route::post('/stock-adjustments/get_product_row', 'Lab\StockAdjustmentController@getProductRow');
    Route::resource('stock-adjustments', 'Lab\StockAdjustmentController');
           //Reports...
    Route::get('/reports/register-report', 'Lab\LaboratoryReportController@getRegisterReport');
    Route::get('/reports/profit-loss', 'Lab\LaboratoryReportController@getProfitLoss');




    Route::get('/reports/service-staff-report', 'Lab\LaboratoryReportController@getServiceStaffReport');
    Route::get('/reports/service-staff-line-orders', 'Lab\LaboratoryReportController@serviceStaffLineOrders');
    Route::get('/reports/table-report', 'Lab\LaboratoryReportController@getTableReport');
    Route::get('/reports/get-opening-stock', 'Lab\LaboratoryReportController@getOpeningStock');
    Route::get('/reports/purchase-sell', 'Lab\LaboratoryReportController@getPurchaseSell');
    Route::get('/reports/customer-supplier', 'Lab\LaboratoryReportController@getCustomerSuppliers');
    Route::get('/reports/stock-report', 'Lab\LaboratoryReportController@getStockReport');
    Route::get('/reports/stock-details', 'Lab\LaboratoryReportController@getStockDetails');
    Route::get('/reports/tax-report', 'Lab\LaboratoryReportController@getTaxReport');
    Route::get('/reports/trending-products', 'Lab\LaboratoryReportController@getTrendingProducts');
    Route::get('/reports/expense-report', 'Lab\LaboratoryReportController@getExpenseReport');
    Route::get('/reports/stock-adjustment-report', 'Lab\LaboratoryReportController@getStockAdjustmentReport');
   
    Route::get('/reports/sales-representative-report', 'Lab\LaboratoryReportController@getSalesRepresentativeReport');
    Route::get('/reports/sales-representative-total-expense', 'Lab\LaboratoryReportController@getSalesRepresentativeTotalExpense');
    Route::get('/reports/sales-representative-total-sell', 'Lab\LaboratoryReportController@getSalesRepresentativeTotalSell');
    Route::get('/reports/sales-representative-total-commission', 'Lab\LaboratoryReportController@getSalesRepresentativeTotalCommission');
    Route::get('/reports/stock-expiry', 'Lab\LaboratoryReportController@getStockExpiryReport');
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', 'Lab\LaboratoryReportController@getStockExpiryReportEditModal');
    Route::post('/reports/stock-expiry-update', 'Lab\LaboratoryReportController@updateStockExpiryReport')->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', 'Lab\LaboratoryReportController@getCustomerGroup');
    Route::get('/reports/product-purchase-report', 'Lab\LaboratoryReportController@getproductPurchaseReport');
    Route::get('/reports/product-sell-report', 'Lab\LaboratoryReportController@getproductSellReport');
    Route::get('/reports/product-sell-grouped-report', 'Lab\LaboratoryReportController@getproductSellGroupedReport');
    Route::get('/reports/lot-report', 'Lab\LaboratoryReportController@getLotReport');
    Route::get('/reports/purchase-payment-report', 'Lab\LaboratoryReportController@purchasePaymentReport');
    Route::get('/reports/sell-payment-report', 'Lab\LaboratoryReportController@sellPaymentReport');
    Route::get('/reports/product-stock-details', 'Lab\LaboratoryReportController@productStockDetails');
    Route::get('/reports/adjust-product-stock', 'Lab\LaboratoryReportController@adjustProductStock');
    Route::get('/reports/get-profit/{by?}', 'Lab\LaboratoryReportController@getProfit');
    Route::get('/reports/items-report', 'Lab\LaboratoryReportController@itemsReport');
            //Print Labels
    Route::get('/labels/show', 'Lab\LabelsController@show');
    Route::get('/labels/add-product-row', 'Lab\LabelsController@addProductRow');
    Route::get('/labels/preview', 'Lab\LabelsController@preview');
    
    Route::get('/repinvoice/{token}', 'Lab\TestReportController@showInvoice')
        ->name('lab_show_invoice');
          
    Route::get('/invoice/{token}', 'Lab\PrescriptionController@showInvoice')
    ->name('cal_show_invoice');
         Route::resource('departments', 'Lab\DepartmentController');
        Route::resource('tests', 'Lab\TestController');
        Route::resource('testparticular', 'Lab\TestParticularController');
        Route::resource('cash-register', 'Lab\CashRegisterController');
        Route::get('/labcash-register', 'Lab\CashRegisterController@labcreate');
        Route::get('/cash-registersss/register-detailsss', 'Lab\CashRegisterController@getRegisterDetail');
        Route::post('/cash-register/close-register', 'Lab\CashRegisterController@postCloseRegister');
        Route::get('/cash-r/close-register', 'Lab\CashRegisterController@getCloseRegister');

        Route::post('get_test_product_entry_row', 'Lab\TestController@getPurchaseEntryRow');
        Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', 'Lab\SellPosController@getProductRow');
        Route::resource('labsells', 'Lab\SellController');
        Route::get('/test/list', 'Lab\TestController@getTests');

        Route::post('purchases/check_test_code', 'Lab\TestController@check_test_code');

        Route::get('/sells/{transaction_id}/print', 'Lab\SellPosController@printInvoice')->name('labsell.printInvoice');
  
          Route::resource('test_reports', 'Lab\TestReportController');
          Route::resource('multi', 'Lab\Multi_ReportController');
          Route::get('/list/get_invoice', 'Lab\Multi_ReportController@getinvoice');
          Route::get('/multi/get_row/{variation_id}', 'Lab\Multi_ReportController@getRow');
          Route::post('/test_reports/bulk-print', 'Lab\TestReportController@bulkprint');
          Route::post('/test_reports/bulk-edit', 'Lab\TestReportController@bulkEdit');
        //   Route::get('/add_test_report/{id}', 'Lab\TestReportController@AddResult');
        Route::get('/test_report/print/{id}', 'Lab\TestReportController@printInvoice');
        Route::resource('diets', 'Lab\DietController');
         Route::resource('allergies', 'Lab\AllergieController');
        Route::resource('familyhistory', 'Lab\FamilyHistoryController');
        Route::resource('nonpathologicalhistory', 'Lab\NonPathologicalHistoryController');
        Route::resource('pathologicalhistory', 'Lab\PathologicalHistoryController');
        Route::resource('phychiatrichistory', 'Lab\PhychiatricHistoryController');
        Route::resource('vaccine', 'Lab\VaccineController');
        Route::resource('patients', 'Lab\PatientController');
        Route::resource('schedule', 'Lab\ScheduleController');
        Route::resource('appointment', 'Lab\AppointmentController');
        Route::post('/appointments/update-status', 'Lab\AppointmentController@updateStatus');
        Route::get('/get_schedule', 'Lab\AppointmentController@getSchedules');
        Route::get('/get_patient', 'Lab\PrescriptionController@get_Patient');
        Route::resource('prescription', 'Lab\PrescriptionController');
        Route::get('/prescr/get_products', 'Lab\PrescriptionController@getProducts');
        Route::post('/prescr/get_purchase_entry_row', 'Lab\PrescriptionController@getPurchaseEntryRow');

        Route::get('/home', 'Lab\HomeController@index')->name('lab_home');
        Route::get('/home/get-totals', 'Lab\HomeController@getTotals');
        Route::get('/home/product-stock-alert', 'Lab\HomeController@getProductStockAlert');
        Route::get('/home/purchase-payment-dues', 'Lab\HomeController@getPurchasePaymentDues');
        Route::get('/home/sales-payment-dues', 'Lab\HomeController@getSalesPaymentDues');


    Route::get('/contacts/stock-report/{supplier_id}', 'Lab\ContactController@getSupplierStockReport');
    Route::get('/contacts/ledger', 'Lab\ContactController@getLedger');
    Route::post('/contacts/send-ledger', 'Lab\ContactController@sendLedger');
    Route::get('/contacts/import', 'Lab\ContactController@getImportContacts')->name('contacts.import');
    Route::post('/contacts/import', 'Lab\ContactController@postImportContacts');
    Route::post('/contacts/check-contact-id', 'Lab\ContactController@checkContactId');
    Route::get('/contacts/customers', 'Lab\ContactController@getCustomers');
    Route::resource('contacts', 'Lab\ContactController');
    // Route::resource('variation-templates', 'VariationTemplateController');

    // Route::get('/delete-media/{media_id}', 'ProductController@deleteMedia');
    Route::post('/products/mass-deactivate', 'Lab\ProductController@massDeactivate');
    Route::get('/products/activate/{id}', 'Lab\ProductController@activate');
    Route::get('/products/view-product-group-price/{id}', 'Lab\ProductController@viewGroupPrice');
    Route::get('/products/add-selling-prices/{id}', 'Lab\ProductController@addSellingPrices');
    Route::post('/products/save-selling-prices', 'Lab\ProductController@saveSellingPrices');
    Route::post('/products/mass-delete', 'Lab\ProductController@massDestroy');
    Route::get('/products/view/{id}', 'Lab\ProductController@view');
    Route::get('/products/list', 'Lab\ProductController@getProducts');
    Route::get('/products/list-no-variation', 'Lab\ProductController@getProductsWithoutVariations');
    Route::post('/products/bulk-edit', 'Lab\ProductController@bulkEdit');
    Route::post('/products/bulk-update', 'Lab\ProductController@bulkUpdate');
    Route::post('/products/bulk-update-location', 'Lab\ProductController@updateProductLocation');
    Route::get('/products/get-product-to-edit/{product_id}', 'Lab\ProductController@getProductToEdit');
    
    Route::post('/products/get_sub_categories', 'Lab\ProductController@getSubCategories');
    Route::get('/products/get_sub_units', 'Lab\ProductController@getSubUnits');
    Route::post('/products/product_form_part', 'Lab\ProductController@getProductVariationFormPart');
    Route::post('/products/get_product_variation_row', 'Lab\ProductController@getProductVariationRow');
    Route::post('/products/get_variation_template', 'Lab\ProductController@getVariationTemplate');
    Route::get('/products/get_variation_value_row', 'Lab\ProductController@getVariationValueRow');
    Route::post('/products/check_product_sku', 'Lab\ProductController@checkProductSku');
    Route::get('/products/quick_add', 'Lab\ProductController@quickAdd');
    Route::post('/products/save_quick_product', 'Lab\ProductController@saveQuickProduct');
    Route::get('/products/get-combo-product-entry-row', 'Lab\ProductController@getComboProductEntryRow');
    
    Route::resource('products', 'Lab\ProductController');
    Route::resource('brands', 'Lab\BrandController');
    Route::resource('tax-rates', 'Lab\TaxRateController');
    Route::resource('units', 'Lab\UnitController');
    Route::resource('purchases', 'Lab\PurchaseController');
    
    Route::post('/purchases/update-status', 'Lab\PurchaseController@updateStatus');
    Route::get('/pu/get_products', 'Lab\PurchaseController@getProducts');
    Route::get('/pu/get_suppliers', 'Lab\PurchaseController@getSuppliers');
    Route::post('/purchases/get_purchase_entry_row', 'Lab\PurchaseController@getPurchaseEntryRow');
    Route::post('/purchases/check_ref_number', 'Lab\PurchaseController@checkRefNumber');
    Route::get('/purchases/print/{id}', 'Lab\PurchaseController@printInvoice');

       //Sell return
       Route::resource('sell-return', 'Lab\SellReturnController');
       Route::get('sell-return/get-product-row', 'Lab\SellReturnController@getProductRow');
       Route::get('/sell-return/print/{id}', 'Lab\SellReturnController@printInvoice');
       Route::get('/sell-return/add/{id}', 'Lab\SellReturnController@add');
        //Expense Categories...
    Route::resource('expense-categories', 'Lab\ExpenseCategoryController');

    //Expenses...
    Route::resource('expenses', 'Lab\ExpenseController');  
     });
     
    
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/get-totals', 'HomeController@getTotals');
    Route::get('/home/product-stock-alert', 'HomeController@getProductStockAlert');
    Route::get('/home/purchase-payment-dues', 'HomeController@getPurchasePaymentDues');
    Route::get('/home/sales-payment-dues', 'HomeController@getSalesPaymentDues');
    
    Route::post('/test-email', 'BusinessController@testEmailConfiguration');
    Route::post('/test-sms', 'BusinessController@testSmsConfiguration');
    Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
    Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');
    Route::get('/user/profile', 'UserController@getProfile')->name('user.getProfile');
    Route::post('/user/update', 'UserController@updateProfile')->name('user.updateProfile');
    Route::post('/user/update-password', 'UserController@updatePassword')->name('user.updatePassword');

    Route::resource('brands', 'BrandController');
    
    Route::resource('payment-account', 'PaymentAccountController');

    Route::resource('tax-rates', 'TaxRateController');

    Route::resource('units', 'UnitController');

    Route::get('/contacts/map', 'ContactController@contactMap');
    Route::get('/contacts/update-status/{id}', 'ContactController@updateStatus');
    Route::get('/contacts/stock-report/{supplier_id}', 'ContactController@getSupplierStockReport');
    Route::get('/contacts/ledger', 'ContactController@getLedger');
    Route::post('/contacts/send-ledger', 'ContactController@sendLedger');
    Route::get('/contacts/import', 'ContactController@getImportContacts')->name('contacts.import');
    Route::post('/contacts/import', 'ContactController@postImportContacts');
    Route::post('/contacts/check-contact-id', 'ContactController@checkContactId');
    Route::get('/contacts/customers', 'ContactController@getCustomers');
    Route::resource('contacts', 'ContactController');

    Route::get('taxonomies-ajax-index-page', 'TaxonomyController@getTaxonomyIndexPage');
    Route::resource('taxonomies', 'TaxonomyController');

    Route::resource('variation-templates', 'VariationTemplateController');

    Route::get('/delete-media/{media_id}', 'ProductController@deleteMedia');
    Route::post('/products/mass-deactivate', 'ProductController@massDeactivate');
    Route::get('/products/activate/{id}', 'ProductController@activate');
    Route::get('/products/view-product-group-price/{id}', 'ProductController@viewGroupPrice');
    Route::get('/products/add-selling-prices/{id}', 'ProductController@addSellingPrices');
    Route::post('/products/save-selling-prices', 'ProductController@saveSellingPrices');
    Route::post('/products/mass-delete', 'ProductController@massDestroy');
    Route::get('/products/view/{id}', 'ProductController@view');
    Route::get('/products/list', 'ProductController@getProducts');
    Route::get('/products/list-no-variation', 'ProductController@getProductsWithoutVariations');
    Route::post('/products/bulk-edit', 'ProductController@bulkEdit');
    Route::post('/products/bulk-update', 'ProductController@bulkUpdate');
    Route::post('/products/bulk-update-location', 'ProductController@updateProductLocation');
    Route::get('/products/get-product-to-edit/{product_id}', 'ProductController@getProductToEdit');
    
    Route::post('/products/get_sub_categories', 'ProductController@getSubCategories');
    Route::get('/products/get_sub_units', 'ProductController@getSubUnits');
    Route::post('/products/product_form_part', 'ProductController@getProductVariationFormPart');
    Route::post('/products/get_product_variation_row', 'ProductController@getProductVariationRow');
    Route::post('/products/get_variation_template', 'ProductController@getVariationTemplate');
    Route::get('/products/get_variation_value_row', 'ProductController@getVariationValueRow');
    Route::post('/products/check_product_sku', 'ProductController@checkProductSku');
    Route::get('/products/quick_add', 'ProductController@quickAdd');
    Route::post('/products/save_quick_product', 'ProductController@saveQuickProduct');
    Route::get('/products/get-combo-product-entry-row', 'ProductController@getComboProductEntryRow');
    
    Route::resource('products', 'ProductController');

    Route::post('/purchases/update-status', 'PurchaseController@updateStatus');
    Route::get('/purchases/get_products', 'PurchaseController@getProducts');
    Route::get('/purchases/get_suppliers', 'PurchaseController@getSuppliers');
    Route::post('/purchases/get_purchase_entry_row', 'PurchaseController@getPurchaseEntryRow');
    Route::post('/purchases/check_ref_number', 'PurchaseController@checkRefNumber');
    Route::resource('purchases', 'PurchaseController')->except(['show']);

    Route::get('/toggle-subscription/{id}', 'SellPosController@toggleRecurringInvoices');
    Route::post('/sells/pos/get-types-of-service-details', 'SellPosController@getTypesOfServiceDetails');
    Route::get('/sells/subscriptions', 'SellPosController@listSubscriptions');
    Route::get('/sells/duplicate/{id}', 'SellController@duplicateSell');
    Route::get('/sells/drafts', 'SellController@getDrafts');
    Route::get('/sells/quotations', 'SellController@getQuotations');
    Route::get('/sells/draft-dt', 'SellController@getDraftDatables');
    Route::resource('sells', 'SellController')->except(['show']);

    Route::get('/import-sales', 'ImportSalesController@index');
    Route::post('/import-sales/preview', 'ImportSalesController@preview');
    Route::post('/import-sales', 'ImportSalesController@import');
    Route::get('/revert-sale-import/{batch}', 'ImportSalesController@revertSaleImport');

    Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', 'SellPosController@getProductRow');
    Route::post('/sells/pos/get_payment_row', 'SellPosController@getPaymentRow');
    Route::post('/sells/pos/get-reward-details', 'SellPosController@getRewardDetails');
    Route::get('/sells/pos/get-recent-transactions', 'SellPosController@getRecentTransactions');
    Route::get('/sells/pos/get-product-suggestion', 'SellPosController@getProductSuggestion');
    Route::resource('pos', 'SellPosController');

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'ManageUserController');

    Route::resource('group-taxes', 'GroupTaxController');

    Route::get('/barcodes/set_default/{id}', 'BarcodeController@setDefault');
    Route::resource('barcodes', 'BarcodeController');

    //Invoice schemes..
    Route::get('/invoice-schemes/set_default/{id}', 'InvoiceSchemeController@setDefault');
    Route::resource('invoice-schemes', 'InvoiceSchemeController');

    //Print Labels
    Route::get('/labels/show', 'LabelsController@show');
    Route::get('/labels/add-product-row', 'LabelsController@addProductRow');
    Route::get('/labels/preview', 'LabelsController@preview');

    //Reports...
    Route::get('/reports/purchase-report', 'ReportController@purchaseReport');
    Route::get('/reports/sale-report', 'ReportController@saleReport');
    Route::get('/reports/service-staff-report', 'ReportController@getServiceStaffReport');
    Route::get('/reports/service-staff-line-orders', 'ReportController@serviceStaffLineOrders');
    Route::get('/reports/table-report', 'ReportController@getTableReport');
    Route::get('/reports/profit-loss', 'ReportController@getProfitLoss');
    Route::get('/reports/get-opening-stock', 'ReportController@getOpeningStock');
    Route::get('/reports/purchase-sell', 'ReportController@getPurchaseSell');
    Route::get('/reports/customer-supplier', 'ReportController@getCustomerSuppliers');
    Route::get('/reports/stock-report', 'ReportController@getStockReport');
    Route::get('/reports/stock-details', 'ReportController@getStockDetails');
    Route::get('/reports/tax-report', 'ReportController@getTaxReport');
    Route::get('/reports/trending-products', 'ReportController@getTrendingProducts');
    Route::get('/reports/expense-report', 'ReportController@getExpenseReport');
    Route::get('/reports/stock-adjustment-report', 'ReportController@getStockAdjustmentReport');
    Route::get('/reports/register-report', 'ReportController@getRegisterReport');
    Route::get('/reports/sales-representative-report', 'ReportController@getSalesRepresentativeReport');
    Route::get('/reports/sales-representative-total-expense', 'ReportController@getSalesRepresentativeTotalExpense');
    Route::get('/reports/sales-representative-total-sell', 'ReportController@getSalesRepresentativeTotalSell');
    Route::get('/reports/sales-representative-total-commission', 'ReportController@getSalesRepresentativeTotalCommission');
    Route::get('/reports/stock-expiry', 'ReportController@getStockExpiryReport');
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', 'ReportController@getStockExpiryReportEditModal');
    Route::post('/reports/stock-expiry-update', 'ReportController@updateStockExpiryReport')->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', 'ReportController@getCustomerGroup');
    Route::get('/reports/product-purchase-report', 'ReportController@getproductPurchaseReport');
    Route::get('/reports/product-sell-report', 'ReportController@getproductSellReport');
    Route::get('/reports/product-sell-report-with-purchase', 'ReportController@getproductSellReportWithPurchase');
    Route::get('/reports/product-sell-grouped-report', 'ReportController@getproductSellGroupedReport');
    Route::get('/reports/lot-report', 'ReportController@getLotReport');
    Route::get('/reports/purchase-payment-report', 'ReportController@purchasePaymentReport');
    Route::get('/reports/sell-payment-report', 'ReportController@sellPaymentReport');
    Route::get('/reports/product-stock-details', 'ReportController@productStockDetails');
    Route::get('/reports/adjust-product-stock', 'ReportController@adjustProductStock');
    Route::get('/reports/get-profit/{by?}', 'ReportController@getProfit');
    Route::get('/reports/items-report', 'ReportController@itemsReport');
    Route::get('/reports/get-stock-value', 'ReportController@getStockValue');
    
    Route::get('business-location/activate-deactivate/{location_id}', 'BusinessLocationController@activateDeactivateLocation');

    //Business Location Settings...
    Route::prefix('business-location/{location_id}')->name('location.')->group(function () {
        Route::get('settings', 'LocationSettingsController@index')->name('settings');
        Route::post('settings', 'LocationSettingsController@updateSettings')->name('settings_update');
    });

    //Business Locations...
    Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
    Route::resource('business-location', 'BusinessLocationController');

    //Invoice layouts..
    Route::resource('invoice-layouts', 'InvoiceLayoutController');

    //Expense Categories...
    Route::resource('expense-categories', 'ExpenseCategoryController');

    //Expenses...
    Route::resource('expenses', 'ExpenseController');

    //Transaction payments...
    // Route::get('/payments/opening-balance/{contact_id}', 'TransactionPaymentController@getOpeningBalancePayments');
    Route::get('/payments/show-child-payments/{payment_id}', 'TransactionPaymentController@showChildPayments');
    Route::get('/payments/view-payment/{payment_id}', 'TransactionPaymentController@viewPayment');
    Route::get('/payments/add_payment/{transaction_id}', 'TransactionPaymentController@addPayment');
    Route::get('/payments/pay-contact-due/{contact_id}', 'TransactionPaymentController@getPayContactDue');
    Route::post('/payments/pay-contact-due', 'TransactionPaymentController@postPayContactDue');
    Route::resource('payments', 'TransactionPaymentController');

    //Printers...
    Route::resource('printers', 'PrinterController');

    Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', 'StockAdjustmentController@removeExpiredStock');
    Route::post('/stock-adjustments/get_product_row', 'StockAdjustmentController@getProductRow');
    Route::resource('stock-adjustments', 'StockAdjustmentController');

    Route::get('/cash-register/register-details', 'CashRegisterController@getRegisterDetails');
    Route::get('/cash-register/close-register', 'CashRegisterController@getCloseRegister');
    Route::post('/cash-register/close-register', 'CashRegisterController@postCloseRegister');
    Route::resource('cash-register', 'CashRegisterController');

    //Import products
    Route::get('/import-products', 'ImportProductsController@index');
    Route::post('/import-products/store', 'ImportProductsController@store');

    //Sales Commission Agent
    Route::resource('sales-commission-agents', 'SalesCommissionAgentController');

    //Stock Transfer
    Route::get('stock-transfers/print/{id}', 'StockTransferController@printInvoice');
    Route::resource('stock-transfers', 'StockTransferController');
    
    Route::get('/opening-stock/add/{product_id}', 'OpeningStockController@add');
    Route::post('/opening-stock/save', 'OpeningStockController@save');

    //Customer Groups
    Route::resource('customer-group', 'CustomerGroupController');

    //Import opening stock
    Route::get('/import-opening-stock', 'ImportOpeningStockController@index');
    Route::post('/import-opening-stock/store', 'ImportOpeningStockController@store');

    //Sell return
    Route::resource('sell-return', 'SellReturnController');
    Route::get('sell-return/get-product-row', 'SellReturnController@getProductRow');
    Route::get('/sell-return/print/{id}', 'SellReturnController@printInvoice');
    Route::get('/sell-return/add/{id}', 'SellReturnController@add');
    
    //Backup
    Route::get('backup/download/{file_name}', 'BackUpController@download');
    Route::get('backup/delete/{file_name}', 'BackUpController@delete');
    Route::resource('backup', 'BackUpController', ['only' => [
        'index', 'create', 'store'
    ]]);

    Route::get('selling-price-group/activate-deactivate/{id}', 'SellingPriceGroupController@activateDeactivate');
    Route::get('export-selling-price-group', 'SellingPriceGroupController@export');
    Route::post('import-selling-price-group', 'SellingPriceGroupController@import');

    Route::resource('selling-price-group', 'SellingPriceGroupController');

    Route::resource('notification-templates', 'NotificationTemplateController')->only(['index', 'store']);
    Route::get('notification/get-template/{transaction_id}/{template_for}', 'NotificationController@getTemplate');
    Route::post('notification/send', 'NotificationController@send');

    Route::post('/purchase-return/update', 'CombinedPurchaseReturnController@update');
    Route::get('/purchase-return/edit/{id}', 'CombinedPurchaseReturnController@edit');
    Route::post('/purchase-return/save', 'CombinedPurchaseReturnController@save');
    Route::post('/purchase-return/get_product_row', 'CombinedPurchaseReturnController@getProductRow');
    Route::get('/purchase-return/create', 'CombinedPurchaseReturnController@create');
    Route::get('/purchase-return/add/{id}', 'PurchaseReturnController@add');
    Route::resource('/purchase-return', 'PurchaseReturnController', ['except' => ['create']]);

    Route::get('/discount/activate/{id}', 'DiscountController@activate');
    Route::post('/discount/mass-deactivate', 'DiscountController@massDeactivate');
    Route::resource('discount', 'DiscountController');

    Route::group(['prefix' => 'account'], function () {
        Route::resource('/account', 'AccountController');
        Route::get('/fund-transfer/{id}', 'AccountController@getFundTransfer');
        Route::post('/fund-transfer', 'AccountController@postFundTransfer');
        Route::get('/deposit/{id}', 'AccountController@getDeposit');
        Route::post('/deposit', 'AccountController@postDeposit');
        Route::get('/debit/{id}', 'AccountController@getDebit');
        Route::post('/debit', 'AccountController@postDebit');
        Route::get('/close/{id}', 'AccountController@close');
        Route::get('/delete-account-transaction/{id}', 'AccountController@destroyAccountTransaction');
        Route::get('/get-account-balance/{id}', 'AccountController@getAccountBalance');
        Route::get('/balance-sheet', 'AccountReportsController@balanceSheet');
        Route::get('/trial-balance', 'AccountReportsController@trialBalance');
        Route::get('/payment-account-report', 'AccountReportsController@paymentAccountReport');
        Route::get('/link-account/{id}', 'AccountReportsController@getLinkAccount');
        Route::post('/link-account', 'AccountReportsController@postLinkAccount');
        Route::get('/cash-flow', 'AccountController@cashFlow');

    });
    
    Route::resource('account-types', 'AccountTypeController');

    //Restaurant module
    Route::group(['prefix' => 'modules'], function () {
        Route::resource('tables', 'Restaurant\TableController');
        Route::resource('modifiers', 'Restaurant\ModifierSetsController');

        //Map modifier to products
        Route::get('/product-modifiers/{id}/edit', 'Restaurant\ProductModifierSetController@edit');
        Route::post('/product-modifiers/{id}/update', 'Restaurant\ProductModifierSetController@update');
        Route::get('/product-modifiers/product-row/{product_id}', 'Restaurant\ProductModifierSetController@product_row');

        Route::get('/add-selected-modifiers', 'Restaurant\ProductModifierSetController@add_selected_modifiers');

        Route::get('/kitchen', 'Restaurant\KitchenController@index');
        Route::get('/kitchen/mark-as-cooked/{id}', 'Restaurant\KitchenController@markAsCooked');
        Route::post('/refresh-orders-list', 'Restaurant\KitchenController@refreshOrdersList');
        Route::post('/refresh-line-orders-list', 'Restaurant\KitchenController@refreshLineOrdersList');

        Route::get('/orders', 'Restaurant\OrderController@index');
        Route::get('/orders/mark-as-served/{id}', 'Restaurant\OrderController@markAsServed');
        Route::get('/data/get-pos-details', 'Restaurant\DataController@getPosDetails');
        Route::get('/orders/mark-line-order-as-served/{id}', 'Restaurant\OrderController@markLineOrderAsServed');
    });

    Route::get('bookings/get-todays-bookings', 'Restaurant\BookingController@getTodaysBookings');
    Route::resource('bookings', 'Restaurant\BookingController');

    Route::resource('types-of-service', 'TypesOfServiceController');
    Route::get('sells/edit-shipping/{id}', 'SellController@editShipping');
    Route::put('sells/update-shipping/{id}', 'SellController@updateShipping');
    Route::get('shipments', 'SellController@shipments');

    Route::post('upload-module', 'Install\ModulesController@uploadModule');
    Route::resource('manage-modules', 'Install\ModulesController')
        ->only(['index', 'destroy', 'update']);
    Route::resource('warranties', 'WarrantyController');

    Route::resource('dashboard-configurator', 'DashboardConfiguratorController')
    ->only(['edit', 'update']);

    //common controller for document & note
    Route::get('get-document-note-page', 'DocumentAndNoteController@getDocAndNoteIndexPage');
    Route::post('post-document-upload', 'DocumentAndNoteController@postMedia');
    Route::resource('note-documents', 'DocumentAndNoteController');
});


Route::middleware(['EcomApi'])->prefix('api/ecom')->group(function () {
    Route::get('products/{id?}', 'ProductController@getProductsApi');
    Route::get('categories', 'CategoryController@getCategoriesApi');
    Route::get('brands', 'BrandController@getBrandsApi');
    Route::post('customers', 'ContactController@postCustomersApi');
    Route::get('settings', 'BusinessController@getEcomSettings');
    Route::get('variations', 'ProductController@getVariationsApi');
    Route::post('orders', 'SellPosController@placeOrdersApi');
});

//common route
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware(['auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    Route::get('/load-more-notifications', 'HomeController@loadMoreNotifications');
    Route::get('/get-total-unread', 'HomeController@getTotalUnreadNotifications');
    Route::get('/purchases/print/{id}', 'PurchaseController@printInvoice');
    Route::get('/purchases/{id}', 'PurchaseController@show');
    Route::get('/sells/{id}', 'SellController@show');
    Route::get('/sells/{transaction_id}/print', 'SellPosController@printInvoice')->name('sell.printInvoice');
    Route::get('/sells/invoice-url/{id}', 'SellPosController@showInvoiceUrl');
});
