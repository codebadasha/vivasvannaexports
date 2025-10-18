<?php

// Authentication admin Login Routes

use App\Http\Controllers\Admin\ClientCompanyController;
use App\Http\Controllers\Admin\ClientCompanyInvitationController;
use Illuminate\Support\Facades\Artisan;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Auth\LoginController@login')->name('admin.postlogin');
Route::get('logout/{id?}', 'Auth\LoginController@logout')->name('admin.logout');

//forget and reset password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.passwordemail');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('admin.auth.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.resetpassword');

//Dashboard Route....
Route::get('/', 'AdminController@index')->name('admin.dashboard');

Route::get('/run-custom-migrations', function () {
    $migrations = [
        'database/migrations/2025_08_18_040538_create_api_call_log_table.php',
        'database/migrations/2025_08_24_164152_update_client_companies_table.php',
        'database/migrations/2025_08_25_040939_create_client_gst_details_table.php',
        'database/migrations/2025_08_27_165801_create_client_company_invitations_table.php',
        'database/migrations/2025_08_30_021032_add_is_default_to_admins_table.php',
        'database/migrations/2025_08_31_094620_create_master_link_registrations_table.php',
        'database/migrations/2025_08_31_154451_update_client_companies_table.php',
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
});


Route::group(['prefix' => 'client-company'], function () {
	Route::get('/list', 'ClientCompanyController@index')->name('admin.client.index');
	Route::get('/create', 'ClientCompanyController@create')->name('admin.client.create');
	Route::get('/client-gstin-check', [ClientCompanyController::class, 'gstVerification'])->name('admin.client.gst.validate');
	Route::post('/store', 'ClientCompanyController@store')->name('admin.client.store');
	Route::get('/edit/{id}', 'ClientCompanyController@edit')->name('admin.client.edit');
	Route::post('/update', 'ClientCompanyController@update')->name('admin.client.update');
	Route::get('/delete/{id}', 'ClientCompanyController@delete')->name('admin.client.delete');
	Route::get('/invitations/list', [ClientCompanyInvitationController::class, 'index'])->name('admin.invitations.index');
	Route::get('/invitations/master-link/list', [ClientCompanyInvitationController::class, 'masterLink'])->name('admin.invitations.masterLink');
	Route::get('/invitation/send/', [ClientCompanyInvitationController::class, 'create'])->name('admin.invitations.create');
	Route::post('/invitation/send/', [ClientCompanyInvitationController::class, 'store'])->name('admin.invitations.store');
	Route::get('/create/master/invitation', [ClientCompanyInvitationController::class, 'createMasterInvitation'])->name('admin.invitations.createMasterInvitation');

	Route::get('invitations/download/{filename}', function ($filename) {
		$filepath = storage_path('app/' . $filename);
		if (file_exists($filepath)) {
			return response()->download($filepath)->deleteFileAfterSend(true);
		}
		abort(404);
	})->name('admin.invitations.download');

	Route::get('invitation/resend/{token}', [ClientCompanyInvitationController::class, 'resend'])->name('admin.invitations.resend');
	Route::post('/change-team-member-status', 'ClientCompanyController@changeTeamMemberStatus')->name('admin.client.changeTeamMemberStatus');
	Route::post('/check-member-email', 'ClientCompanyController@checkMemberEmail')->name('admin.client.checkMemberEmail');
	Route::post('/check-member-mobile', 'ClientCompanyController@checkMemberMobile')->name('admin.client.checkMemberMobile');

	Route::get('/assign-team/{id}', 'ClientCompanyController@assignTeamMember')->name('admin.client.assignTeamMember');
	Route::post('/store-team-member', 'ClientCompanyController@storeTeamMember')->name('admin.client.storeTeamMember');
	Route::get('/download-document-zip/{id}', 'ClientCompanyController@downloadCompanyDocumentZip')->name('admin.client.downloadCompanyDocumentZip');
	Route::post('/get-company-authorized-person', 'ClientCompanyController@getCompanyAuthorizedPerson')->name('admin.client.getCompanyAuthorizedPerson');
	Route::post('/overdue-intrest-setting', 'ClientCompanyController@overdueIntrestSetting')->name('admin.client.overdueIntrestSetting');
	Route::post('/update-tax-setting', 'ClientCompanyController@updateTaxSetting')->name('admin.client.updateTaxSetting');
	Route::post('/change-company-status', 'ClientCompanyController@changeCompanyStatus')->name('admin.client.changeCompanyStatus');
	Route::post('/verify-cin', 'ClientCompanyController@verifyCinNumber')->name('admin.client.verifyCin');

	Route::get('/client-dashboard/{id}', 'ClientCompanyController@clientDashboard')->name('admin.client.clientDashboard');
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

Route::group(['prefix' => 'po'], function () {
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
});


Route::group(['prefix' => 'invoice'], function () {
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
	Route::get('/all', 'PurchaseOrderController@allInvoice')->name('admin.invoice.index');
});

Route::group(['prefix' => 'project'], function () {
	Route::get('/list', 'ProjectController@index')->name('admin.project.index');
	Route::get('/create', 'ProjectController@create')->name('admin.project.create');
	Route::post('/store', 'ProjectController@store')->name('admin.project.store');
	Route::get('/edit/{id}', 'ProjectController@edit')->name('admin.project.edit');
	Route::post('/update', 'ProjectController@update')->name('admin.project.update');
	Route::get('/delete/{id}', 'ProjectController@delete')->name('admin.project.delete');
});

Route::group(['prefix' => 'boq'], function () {
	Route::get('/list', 'BoqController@index')->name('admin.boq.index');
	Route::get('/create', 'BoqController@create')->name('admin.boq.create');
	Route::post('/store', 'BoqController@store')->name('admin.boq.store');
	Route::get('/edit/{id}', 'BoqController@edit')->name('admin.boq.edit');
	Route::post('/update', 'BoqController@update')->name('admin.boq.update');
	Route::get('/delete/{id}', 'BoqController@delete')->name('admin.boq.delete');

	Route::post('/get-new-item', 'BoqController@getNewItem')->name('admin.boq.getNewItem');
	Route::post('/get-product-variation', 'BoqController@getProductVariation')->name('admin.boq.getProductVariation');
	Route::post('/get-unit', 'BoqController@getUnit')->name('admin.boq.getUnit');
	Route::post('/view-boq', 'BoqController@viewBoq')->name('admin.boq.viewBoq');
	Route::post('/boq-name', 'BoqController@boqName')->name('admin.boq.boqName');
	Route::post('/get-client-project', 'BoqController@getClientProject')->name('admin.boq.getClientProject');
});

Route::group(['prefix' => 'transaction'], function () {
	Route::get('/list', 'TransactionController@index')->name('admin.transaction.index');
});

Route::group(['prefix' => 'credit'], function () {
	Route::get('/list', 'CreditController@index')->name('admin.credit.index');
	Route::get('/view-form/{id}', 'CreditController@viewCreditForm')->name('admin.credit.viewCreditForm');
	Route::get('/download-credit-document/{id}', 'CreditController@downloadCreditDocument')->name('admin.credit.download-credit-document');
});
