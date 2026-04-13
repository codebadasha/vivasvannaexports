<?php

// Authentication admin Login Routes

use App\Http\Controllers\Admin\ClientCompanyController;
use App\Http\Controllers\Admin\ClientCompanyInvitationController;
use Illuminate\Support\Facades\Artisan;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Auth\LoginController@login')->name('admin.postlogin');
Route::get('logout/{id?}', 'Auth\LoginController@logout')->name('admin.logout');

//forget and reset password
Route::get('password/forgot', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.auth.password.reset');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.passwordemail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.resetpassword');

//Dashboard Route....
Route::get('/', 'AdminController@index')->name('admin.dashboard');

Route::get('/run-custom-migrations', function () {
    $migrations = [
		'database\migrations\2026_02_09_113428_add_zoho_fields_to_admin_table.php',
		'database\migrations\2026_02_09_155238_create_sales_orders_table.php',
		'database\migrations\2026_02_10_054354_create_sales_orders_documents_table.php',
		'database\migrations\2026_02_09_155210_create_investor_salesorder_table.php',
		'database\migrations\2026_02_10_150030_create_sales_order_invoices_table.php',
		'database\migrations\2026_02_10_150038_create_sales_order_invoice_documents_table.php',
		'database\migrations\2026_02_10_150047_create_sales_order_invoice_eway_bills_table.php',
		'database\migrations\2026_02_12_073030_add_column_to_sales_order_invoices_table.php',
		'database\migrations/2026_02_15_110814_create_jobs_table.php',
		'database\migrations\2026_02_18_202531_create_credit_requests_table.php',
		'database\migrations\2026_02_18_202545_create_credit_request_bank_statement_reports_table.php',
		'database\migrations\2026_02_18_202550_create_credit_request_gst_score_reports_table.php',
		'database\migrations\2026_02_18_202607_create_credit_request_balance_sheets_table.php',
		'database\migrations\2026_02_18_221405_add_perfios_institution_id_to_banks_table.php',
		'database\migrations\2026_02_18_224433_update_bank_report_table_add_txnid_and_report_files.php',
		'database\migrations\2026_02_19_124454_add_zoho_role_id_to_roles_table.php',
		'database\migrations\2026_02_20_123236_add_client_company_id_to_master_link_registrations_table.php',
		'database\migrations\2026_02_21_121722_add_zoho_fields_to_purchase_orders_table.php ',
		'database\migrations\2026_02_21_134017_convert_tables_to_innodb.php',
		'database\migrations/2026_02_21_131742_create_purchase_order_documents_table.php',
		'database\migrations/2026_02_22_053941_alter_client_companies_table.php',
		'database\migrations\2026_02_24_110453_add_zoho_fields_to_projects_table.php',
		'database\migrations\2026_02_26_182626_create_investor_client_table.php',
		'database\migrations\2026_02_27_103724_alter_sales_order_invoice_eway_bills_table.php',
    ];

    foreach ($migrations as $migration) {
        Artisan::call('migrate', [
            '--path' => $migration,
            '--force' => true, // skip confirmation in production
        ]);
    }

    return "✅ Custom migrations executed successfully!";
});
// Change Password Route
Route::get('/change-admin-password', 'AdminController@changeAdminPassword')->name('admin.changeAdminPassword');
Route::post('/update-admin-password', 'AdminController@updateAdminPassword')->name('admin.updateAdminPassword');

// Profile Route
Route::get('/editprofile', 'AdminController@editProfile')->name('admin.editProfile');
Route::post('/update-profile', 'AdminController@updateProfile')->name('admin.updateProfile');

// Role Route
Route::group(['prefix' => 'role'], function () {
	Route::get('/role-list', 'RoleController@roleList')->name('admin.roleList');
	Route::get('/add-role', 'RoleController@addRole')->name('admin.addRole');
	Route::post('/save-role', 'RoleController@saveRole')->name('admin.saveRole');
	Route::get('/edit-role/{id}', 'RoleController@editRole')->name('admin.editRole');
	Route::post('/update-role', 'RoleController@updateRole')->name('admin.updateRole');
	Route::get('/delete-role/{id}', 'RoleController@deleteRole')->name('admin.deleteRole');
	Route::post('/change-role-status', 'RoleController@changeRoleStatus')->name('admin.changeRoleStatus');
	Route::post('/check-role-exists', 'RoleController@checkRoleExist')->name('admin.checkRoleExist');

	Route::post('/get-role-action', 'RoleController@getRoleAction')->name('admin.getRoleAction');
});

Route::group(['prefix' => 'investor'], function () {
	Route::get('/list', 'InvestorController@index')->name('admin.investor.index');
	Route::get('/create', 'InvestorController@create')->name('admin.investor.create');
	Route::post('/store', 'InvestorController@store')->name('admin.investor.store');
	Route::get('/edit/{id}', 'InvestorController@edit')->name('admin.investor.edit');
	Route::post('/update', 'InvestorController@update')->name('admin.investor.update');
	Route::get('/delete/{id}', 'InvestorController@delete')->name('admin.investor.delete');
	Route::post('/check-investor-email', 'InvestorController@checkInvestorEmail')->name('admin.investor.checkInvestorEmail');
	Route::post('/check-investor-mobile', 'InvestorController@checkInvestorMobile')->name('admin.investor.checkInvestorMobile');
});

Route::group(['prefix' => 'supplier-company'], function () {
	Route::get('/list', 'SupplierCompanyController@index')->name('admin.supplier.index');
	Route::get('/create', 'SupplierCompanyController@create')->name('admin.supplier.create');
	Route::post('/store', 'SupplierCompanyController@store')->name('admin.supplier.store');
	Route::get('/edit/{id}', 'SupplierCompanyController@edit')->name('admin.supplier.edit');
	Route::post('/update', 'SupplierCompanyController@update')->name('admin.supplier.update');
	Route::get('/delete/{id}', 'SupplierCompanyController@delete')->name('admin.supplier.delete');
	Route::post('/check-supplier-company-email', 'SupplierCompanyController@checkSupplierGst')->name('admin.supplier.checkSupplierGst');

	Route::post('/get-product-list', 'SupplierCompanyController@getProductList')->name('admin.product.getProductList');
	Route::post('/get-authorized-person', 'SupplierCompanyController@getAuthorizedPerson')->name('admin.supplier.getAuthorizedPerson');
});

Route::group(['prefix' => 'policy'], function () {
	Route::match(['get', 'post'], '/policy-list', 'PolicyController@policyList')->name('admin.policyList');
	Route::get('/edit-policy/{key}', 'PolicyController@editPolicy')->name('admin.editPolicy');
	Route::post('/save-policy', 'PolicyController@savePolicy')->name('admin.savePolicy');
});

Route::group(['prefix' => 'team'], function () {
	Route::get('/list', 'TeamController@index')->name('admin.team.index');
	Route::get('/create', 'TeamController@create')->name('admin.team.create');
	Route::post('/store', 'TeamController@store')->name('admin.team.store');
	Route::get('/edit/{id}', 'TeamController@edit')->name('admin.team.edit');
	Route::post('/update', 'TeamController@update')->name('admin.team.update');
	Route::get('/delete/{id}', 'TeamController@delete')->name('admin.team.delete');
	Route::post('/change-team-member-status', 'TeamController@changeTeamMemberStatus')->name('admin.team.changeTeamMemberStatus');
	Route::post('/set-default-team-member ', 'TeamController@setDefaultTeamMember')->name('admin.team.setDefaultTeamMember');
	Route::post('/check-member-email', 'TeamController@checkMemberEmail')->name('admin.team.checkMemberEmail');
	Route::post('/check-member-mobile', 'TeamController@checkMemberMobile')->name('admin.team.checkMemberMobile');
	Route::get('/zoho/sync-users', 'TeamController@syncZohoUsers')->name('zoho.sync.users');
});


Route::group(['prefix' => 'invitations'], function () {
	Route::get('/list', [ClientCompanyInvitationController::class, 'index'])->name('admin.invitations.index');
	Route::get('/master-link-register/list', [ClientCompanyInvitationController::class, 'masterLink'])->name('admin.invitations.masterLink');
	Route::get('/send', [ClientCompanyInvitationController::class, 'create'])->name('admin.invitations.create');
	Route::post('/send', [ClientCompanyInvitationController::class, 'store'])->name('admin.invitations.store');
	Route::get('/master-link/create', [ClientCompanyInvitationController::class, 'createMasterInvitation'])->name('admin.invitations.createMasterInvitation');
	Route::get('/resend/{token}', [ClientCompanyInvitationController::class, 'resend'])->name('admin.invitations.resend');
});

Route::group(['prefix' => 'client-company'], function () {
	Route::get('/get-client-projects/{clientId}', 'ClientCompanyController@getClientProjects')->name('admin.client.getClientProjects');
	Route::get('/list', 'ClientCompanyController@index')->name('admin.client.index');
	Route::get('/create', 'ClientCompanyController@create')->name('admin.client.create');
	Route::get('/client-gstin-check', [ClientCompanyController::class, 'gstVerification'])->name('admin.client.gst.validate');
	Route::post('/store', 'ClientCompanyController@store')->name('admin.client.store');
	Route::get('/edit/{id}', 'ClientCompanyController@edit')->name('admin.client.edit');
	Route::post('/update', 'ClientCompanyController@update')->name('admin.client.update');
	Route::get('/delete/{id}', 'ClientCompanyController@delete')->name('admin.client.delete');
	Route::get('invitations/download/{filename}', function ($filename) {
		$filepath = storage_path('app/' . $filename);
		if (file_exists($filepath)) {
			return response()->download($filepath)->deleteFileAfterSend(true);
		}
		abort(404);
	})->name('admin.invitations.download');

	Route::post('/change-team-member-status', 'ClientCompanyController@changeTeamMemberStatus')->name('admin.client.changeTeamMemberStatus');
	Route::post('/check-member-email', 'ClientCompanyController@checkMemberEmail')->name('admin.client.checkMemberEmail');
	Route::post('/check-member-mobile', 'ClientCompanyController@checkMemberMobile')->name('admin.client.checkMemberMobile');

	Route::get('/assign-team/{id}', 'ClientCompanyController@assignTeamMember')->name('admin.client.assignTeamMember');
	Route::post('/store-team-member', 'ClientCompanyController@storeTeamMember')->name('admin.client.storeTeamMember');
	Route::get('/download-document-zip/{id}', 'ClientCompanyController@downloadCompanyDocumentZip')->name('admin.client.downloadCompanyDocumentZip');
	Route::post('/get-company-authorized-person', 'ClientCompanyController@getCompanyAuthorizedPerson')->name('admin.client.getCompanyAuthorizedPerson');
	Route::post('/get-contact-persons', 'ClientCompanyController@getCompanyContactPersons')->name('admin.client.getContactPersons');
	Route::post('/update-contact-person', 'ClientCompanyController@updateContactPerson')->name('admin.client.updateContactPersons');
	Route::post('/delete-contact-person', 'ClientCompanyController@deleteContactPerson')->name('admin.client.deleteContactPersons');
	Route::post('/set-primary-contact', 'ClientCompanyController@setPrimaryContact')->name('admin.client.setPrimaryContactPersons');


	Route::post('/overdue-intrest-setting', 'ClientCompanyController@overdueIntrestSetting')->name('admin.client.overdueIntrestSetting');
	Route::post('/update-tax-setting', 'ClientCompanyController@updateTaxSetting')->name('admin.client.updateTaxSetting');
	Route::post('/change-company-status', 'ClientCompanyController@changeCompanyStatus')->name('admin.client.changeCompanyStatus');
	Route::post('/verify-cin', 'ClientCompanyController@verifyCinNumber')->name('admin.client.verifyCin');

	Route::get('/dashboard/{id}', 'ClientCompanyController@clientDashboard')->name('admin.client.clientDashboard');

	Route::post('/verify-company', 'ClientCompanyController@verifyCompany')->name('admin.client.verify-company');
	Route::post('/assign-and-verify-company', 'ClientCompanyController@assignAndVerifyCompany')->name('admin.client.assign-and-verify-company');
});

Route::group(['prefix' => 'product'], function () {
	Route::get('/list', 'ProductController@index')->name('admin.product.index');
	Route::get('/create', 'ProductController@create')->name('admin.product.create');
	Route::post('/store', 'ProductController@store')->name('admin.product.store');
	Route::get('/edit/{id}', 'ProductController@edit')->name('admin.product.edit');
	Route::post('/update', 'ProductController@update')->name('admin.product.update');
	Route::get('/delete/{id}', 'ProductController@delete')->name('admin.product.delete');
	Route::post('/change-team-member-status', 'ProductController@changeTeamMemberStatus')->name('admin.product.changeTeamMemberStatus');
	Route::post('/check-product-type', 'ProductController@checkProductName')->name('admin.product.checkProductName');
});

Route::group(['prefix' => 'purchase-order'], function () {
	Route::get('/list', 'PurchaseOrderController@index')->name('admin.po.index');
	Route::get('/create', 'PurchaseOrderController@create')->name('admin.po.create');
	Route::post('/store', 'PurchaseOrderController@store')->name('admin.po.store');
	Route::get('/edit/{id}', 'PurchaseOrderController@edit')->name('admin.po.edit');
	Route::post('/update', 'PurchaseOrderController@update')->name('admin.po.update');
	Route::get('/delete/{id}', 'PurchaseOrderController@delete')->name('admin.po.delete');
	Route::get('/view-po-details/{id}', 'PurchaseOrderController@viewPurchaseOrder')->name('admin.po.viewPurchaseOrder');
	Route::post('/product-list', 'PurchaseOrderController@getProductList')->name('admin.po.getProductList');

	Route::get('/po-items/{id}', 'PurchaseOrderController@poItems')->name('admin.po.poItems');
	Route::post('/post-supplier-item', 'PurchaseOrderController@postSupplierItem')->name('admin.po.postSupplierItem');
	Route::post('/supplier-list', 'PurchaseOrderController@supplierList')->name('admin.po.supplierList');

	Route::post('/get-project', 'PurchaseOrderController@getProject')->name('admin.po.getProject');
	Route::post('/get-boq', 'PurchaseOrderController@getBoq')->name('admin.po.getBoq');
	Route::post('/get-boq-item', 'PurchaseOrderController@getBoqItem')->name('admin.po.getBoqItem');

	Route::post('/get-item-detail', 'PurchaseOrderController@getItemDetail')->name('admin.po.getItemDetail');

	Route::get('/purchase-order-download/{id}', 'PurchaseOrderController@purchaseorderdownload')->name('admin.po.purchaseorderdownload');
});

Route::group(['prefix' => 'sales-order'], function () {
	Route::get('/list', 'SalesOrdersController@index')->name('admin.so.index');
	Route::post('/open-document', 'SalesOrdersController@openDocument')->name('admin.so.openDocument');
	Route::post('/assign-project', 'SalesOrdersController@assignProject')->name('admin.so.assignProject');
	Route::post('/assign-investor', 'SalesOrdersController@assignInvestor')->name('admin.so.assignInvestor');
	Route::get('/view-so-details/{id}', 'SalesOrdersController@view')->name('admin.so.viewso');
	Route::get('/sales-order-download/{id}', 'SalesOrdersController@salesorderdownload')->name('admin.so.salesorderdownload');
	// Route::get('/create', 'PurchaseOrderController@create')->name('admin.po.create');
	// Route::post('/store', 'PurchaseOrderController@store')->name('admin.po.store');
	// Route::get('/edit/{id}', 'PurchaseOrderController@edit')->name('admin.po.edit');
	// Route::post('/update', 'PurchaseOrderController@update')->name('admin.po.update');
	// Route::get('/delete/{id}', 'PurchaseOrderController@delete')->name('admin.po.delete');
	// Route::post('/product-list', 'PurchaseOrderController@getProductList')->name('admin.po.getProductList');

	// Route::get('/po-items/{id}', 'PurchaseOrderController@poItems')->name('admin.po.poItems');
	// Route::post('/post-supplier-item', 'PurchaseOrderController@postSupplierItem')->name('admin.po.postSupplierItem');
	// Route::post('/supplier-list', 'PurchaseOrderController@supplierList')->name('admin.po.supplierList');

	// Route::post('/get-project', 'PurchaseOrderController@getProject')->name('admin.po.getProject');
	// Route::post('/get-boq', 'PurchaseOrderController@getBoq')->name('admin.po.getBoq');
	// Route::post('/get-boq-item', 'PurchaseOrderController@getBoqItem')->name('admin.po.getBoqItem');

	// Route::post('/get-item-detail', 'PurchaseOrderController@getItemDetail')->name('admin.po.getItemDetail');
});

Route::group(['prefix' => 'invoice'], function () {
	Route::get('/list', 'SalesOrdersController@allInvoice')->name('admin.so.allinvoice.index');
	Route::get('/view-invoice/{id}', 'SalesOrdersController@viewinvoice')->name('admin.so.viewinvoice');
	Route::get('/invoice-download/{id}', 'SalesOrdersController@invoicedownload')->name('admin.so.invoicedownload');
	Route::get('/ewaybill/{id}', 'SalesOrdersController@viewEwayBill')->name('admin.invoice.ewaybill');
	Route::get('/download-zip/{id}', 'SalesOrdersController@downloadInvoiceZip')->name('admin.so.invoicezip');

	Route::get('/all-invoice-add', 'PurchaseOrderController@addAllInvoice')->name('admin.po.addAllInvoice');
	Route::post('/get-all-purchase-order', 'PurchaseOrderController@getAllPurchaseOrder')->name('admin.po.getAllPurchaseOrder');
	Route::post('/get-all-po-items', 'PurchaseOrderController@getPoItems')->name('admin.po.getPoItems');
});

Route::group(['prefix' => 'invoice'], function () {
	Route::get('/list/{po_id}', 'PurchaseOrderController@invoiceList')->name('admin.po.invoiceList');
	Route::get('/create/{po_id}', 'PurchaseOrderController@addInvoice')->name('admin.po.addInvoice');
	Route::post('/store', 'PurchaseOrderController@saveInvoice')->name('admin.po.saveInvoice');
	Route::get('/edit/{id}', 'PurchaseOrderController@editInvoice')->name('admin.po.editInvoice');
	Route::post('/update', 'PurchaseOrderController@saveEditedInvoice')->name('admin.po.saveEditedInvoice');
	Route::get('/delete/{id}', 'PurchaseOrderController@deleteInvoice')->name('admin.po.deleteInvoice');
	Route::get('/download-invoice-document-zip/{id}', 'PurchaseOrderController@downloadInvoiceDocumentZip')->name('admin.po.downloadInvoiceDocumentZip');
	
});

Route::group(['prefix' => 'project'], function () {
	Route::get('/list', 'ProjectController@index')->name('admin.project.index');
	Route::get('/create', 'ProjectController@create')->name('admin.project.create');
	Route::post('/store', 'ProjectController@store')->name('admin.project.store');
	Route::get('/edit/{id}', 'ProjectController@edit')->name('admin.project.edit');
	Route::post('/update', 'ProjectController@update')->name('admin.project.update');
	Route::get('/delete/{id}', 'ProjectController@delete')->name('admin.project.delete');
});

// Route::group(['prefix' => 'boq'], function () {
// 	Route::get('/list', 'BoqController@index')->name('admin.boq.index');
// 	Route::get('/create', 'BoqController@create')->name('admin.boq.create');
// 	Route::post('/store', 'BoqController@store')->name('admin.boq.store');
// 	Route::get('/edit/{id}', 'BoqController@edit')->name('admin.boq.edit');
// 	Route::post('/update', 'BoqController@update')->name('admin.boq.update');
// 	Route::get('/delete/{id}', 'BoqController@delete')->name('admin.boq.delete');

// 	Route::post('/get-new-item', 'BoqController@getNewItem')->name('admin.boq.getNewItem');
// 	Route::post('/get-product-variation', 'BoqController@getProductVariation')->name('admin.boq.getProductVariation');
// 	Route::post('/get-unit', 'BoqController@getUnit')->name('admin.boq.getUnit');
// 	Route::post('/view-product', 'BoqController@viewProduct')->name('admin.boq.viewproduct');
// 	Route::post('/boq-name', 'BoqController@boqName')->name('admin.boq.boqName');
// 	Route::post('/get-client-project', 'BoqController@getClientProject')->name('admin.boq.getClientProject');
// });

// Route::group(['prefix' => 'transaction'], function () {
// 	Route::get('/list', 'TransactionController@index')->name('admin.transaction.index');
// });

Route::group(['prefix' => 'credit'], function () {
	Route::get('/list', 'CreditController@index')->name('admin.credit.index');
	Route::get('/view-form/{id}', 'CreditController@viewCreditForm')->name('admin.credit.viewCreditForm');
	Route::get('/download-credit-document/{id}', 'CreditController@downloadCreditDocument')->name('admin.credit.download-credit-document');
	Route::get('/approve/{id}', 'CreditController@approve')->name('admin.credit.approve');
	Route::get('/reject/{id}', 'CreditController@reject')->name('admin.credit.reject');
});
