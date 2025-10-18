<?php

	// Authentication investor Login Routes
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('investor.login');
	Route::post('login', 'Auth\LoginController@login')->name('investor.postlogin');
	Route::get('logout/{id?}', 'Auth\LoginController@logout')->name('investor.logout');

	//forget and reset password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('investor.auth.password.reset');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('investor.passwordemail');
	Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('investor.auth.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('investor.resetpassword');

	//Dashboard Route....
	Route::get('/', 'InvestorController@index')->name('investor.dashboard');

	// Change Password Route
	Route::get('/change-investor-password', 'InvestorController@changeinvestorPassword')->name('investor.changeinvestorPassword');
	Route::post('/update-investor-password', 'InvestorController@updateinvestorPassword')->name('investor.updateinvestorPassword');

	// Profile Route
	Route::get('/editprofile', 'InvestorController@editProfile')->name('investor.editProfile');
	Route::post('/update-profile', 'InvestorController@updateProfile')->name('investor.updateProfile');

	Route::group(['prefix' => 'project'], function () {
		Route::get('/list', 'ProjectController@index')->name('investor.project.index');
	});

	Route::group(['prefix' => 'client-company'], function () {
		Route::get('/list', 'ClientCompanyController@index')->name('investor.client.index');
		Route::get('/download-document-zip/{id}', 'ClientCompanyController@downloadCompanyDocumentZip')->name('investor.client.downloadCompanyDocumentZip');
		Route::get('/client-dashboard/{id}', 'ClientCompanyController@clientDashboard')->name('investor.client.clientDashboard');
		Route::post('/get-company-authorized-person', 'ClientCompanyController@getCompanyAuthorizedPerson')->name('investor.client.getCompanyAuthorizedPerson');
	});

	Route::group(['prefix' => 'boq'], function () {
		Route::get('/list', 'BoqController@index')->name('investor.boq.index');
		Route::post('/view-boq', 'BoqController@viewBoq')->name('investor.boq.viewBoq');
	});


	Route::group(['prefix' => 'po'], function () {
		Route::get('/list', 'PurchaseOrderController@index')->name('investor.po.index');
		Route::get('/create', 'PurchaseOrderController@create')->name('investor.po.create');
		Route::post('/store', 'PurchaseOrderController@store')->name('investor.po.store');
		Route::get('/edit/{id}', 'PurchaseOrderController@edit')->name('investor.po.edit');
		Route::post('/update', 'PurchaseOrderController@update')->name('investor.po.update');
		Route::get('/delete/{id}', 'PurchaseOrderController@delete')->name('investor.po.delete');
		Route::get('/view-po-details/{id}', 'PurchaseOrderController@viewPurchaseOrder')->name('investor.po.viewPurchaseOrder');
		Route::post('/product-list', 'PurchaseOrderController@getProductList')->name('investor.po.getProductList');
		
		Route::get('/po-items/{id}', 'PurchaseOrderController@poItems')->name('investor.po.poItems');
		Route::post('/post-supplier-item', 'PurchaseOrderController@postSupplierItem')->name('investor.po.postSupplierItem');
		Route::post('/supplier-list', 'PurchaseOrderController@supplierList')->name('investor.po.supplierList');

		Route::post('/get-project', 'PurchaseOrderController@getProject')->name('investor.po.getProject');
		Route::post('/get-boq', 'PurchaseOrderController@getBoq')->name('investor.po.getBoq');
		Route::post('/get-boq-item', 'PurchaseOrderController@getBoqItem')->name('investor.po.getBoqItem');
	});

	Route::group(['prefix' => 'invoice'], function () {
		Route::get('/list/{po_id}', 'PurchaseOrderController@invoiceList')->name('investor.po.invoiceList');
		Route::get('/create/{po_id}', 'PurchaseOrderController@addInvoice')->name('investor.po.addInvoice');
		Route::post('/store', 'PurchaseOrderController@saveInvoice')->name('investor.po.saveInvoice');
		Route::get('/edit/{id}', 'PurchaseOrderController@editInvoice')->name('investor.po.editInvoice');
		Route::post('/update', 'PurchaseOrderController@saveEditedInvoice')->name('investor.po.saveEditedInvoice');
		Route::get('/delete/{id}', 'PurchaseOrderController@deleteInvoice')->name('investor.po.deleteInvoice');
		Route::get('/download-invoice-document-zip/{id}', 'PurchaseOrderController@downloadInvoiceDocumentZip')->name('investor.po.downloadInvoiceDocumentZip');
		Route::get('/all', 'PurchaseOrderController@allInvoice')->name('investor.invoice.index');
	});