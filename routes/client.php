<?php

	// Authentication admin Login Routes
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('client.login');
	Route::post('login', 'Auth\LoginController@login')->name('client.postlogin');
	Route::get('logout/{id?}', 'Auth\LoginController@logout')->name('client.logout');

	Route::get('register', 'ClientController@showClientRegisterForm')->name('client.register');
	Route::post('post-register', 'ClientController@postRegister')->name('client.postregister');
	



	//forget and reset password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('client.auth.password.reset');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('client.passwordemail');
	Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('client.auth.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('client.resetpassword');



	//Dashboard Route....
	Route::get('/', 'ClientController@index')->name('client.dashboard');

	Route::post('/check-gst', 'ClientController@checkGst')->name('client.checkGst');
	Route::post('/check-cin', 'ClientController@checkcin')->name('client.checkcin');

	Route::get('/accept-terms', 'ClientController@acceptTerms')->name('client.acceptTerms');
	
	// Change Password Route
	Route::get('/change-password', 'ClientController@changeClientPassword')->name('client.changePassword');
	Route::post('/update-password', 'ClientController@updateClientPassword')->name('client.updatePassword');

	// Profile Route
	Route::get('/edit-profile', 'ClientController@editCompanyProfile')->name('client.editCompanyProfile');
	Route::post('/update-profile', 'ClientController@updateCompanyProfile')->name('client.updateCompanyProfile');

	Route::group(['prefix' => 'project'], function () {
		Route::get('/list', 'ProjectController@index')->name('client.project.index');
		Route::get('/create', 'ProjectController@create')->name('client.project.create');
		Route::post('/store', 'ProjectController@store')->name('client.project.store');
		Route::get('/edit/{id}', 'ProjectController@edit')->name('client.project.edit');
		Route::post('/update', 'ProjectController@update')->name('client.project.update');
		Route::get('/delete/{id}', 'ProjectController@delete')->name('client.project.delete');
	});

	Route::group(['prefix' => 'boq'], function () {
		Route::get('/list', 'BoqController@index')->name('client.boq.index');
		Route::get('/create', 'BoqController@create')->name('client.boq.create');
		Route::post('/store', 'BoqController@store')->name('client.boq.store');
		Route::get('/edit/{id}', 'BoqController@edit')->name('client.boq.edit');
		Route::post('/update', 'BoqController@update')->name('client.boq.update');
		Route::get('/delete/{id}', 'BoqController@delete')->name('client.boq.delete');

		Route::post('/get-new-item', 'BoqController@getNewItem')->name('client.boq.getNewItem');
		Route::post('/get-product-variation', 'BoqController@getProductVariation')->name('client.boq.getProductVariation');
		Route::post('/get-unit', 'BoqController@getUnit')->name('client.boq.getUnit');
		Route::post('/view-boq', 'BoqController@viewBoq')->name('client.boq.viewBoq');
		Route::post('/boq-name', 'BoqController@boqName')->name('client.boq.boqName');
		Route::post('/get-client-project', 'BoqController@getClientProject')->name('client.boq.getClientProject');
	});

	Route::group(['prefix' => 'po'], function () {
		Route::get('/list', 'PurchaseOrderController@index')->name('client.po.index');
		Route::get('/create', 'PurchaseOrderController@create')->name('client.po.create');
		Route::post('/store', 'PurchaseOrderController@store')->name('client.po.store');
		Route::get('/edit/{id}', 'PurchaseOrderController@edit')->name('client.po.edit');
		Route::post('/update', 'PurchaseOrderController@update')->name('client.po.update');
		Route::get('/delete/{id}', 'PurchaseOrderController@delete')->name('client.po.delete');
		Route::get('/view-po-details/{id}', 'PurchaseOrderController@viewPurchaseOrder')->name('client.po.viewPurchaseOrder');
		Route::post('/product-list', 'PurchaseOrderController@getProductList')->name('client.po.getProductList');
		
		Route::get('/po-items/{id}', 'PurchaseOrderController@poItems')->name('client.po.poItems');
		Route::post('/post-supplier-item', 'PurchaseOrderController@postSupplierItem')->name('client.po.postSupplierItem');
		Route::post('/supplier-list', 'PurchaseOrderController@supplierList')->name('client.po.supplierList');

		Route::post('/get-project', 'PurchaseOrderController@getProject')->name('client.po.getProject');
		Route::post('/get-boq', 'PurchaseOrderController@getBoq')->name('client.po.getBoq');
		Route::post('/get-boq-item', 'PurchaseOrderController@getBoqItem')->name('client.po.getBoqItem');
	});

	Route::group(['prefix' => 'invoice'], function () {
		Route::get('/list/{po_id}', 'PurchaseOrderController@invoiceList')->name('client.po.invoiceList');
		Route::get('/create/{po_id}', 'PurchaseOrderController@addInvoice')->name('client.po.addInvoice');
		Route::post('/store', 'PurchaseOrderController@saveInvoice')->name('client.po.saveInvoice');
		Route::get('/edit/{id}', 'PurchaseOrderController@editInvoice')->name('client.po.editInvoice');
		Route::post('/update', 'PurchaseOrderController@saveEditedInvoice')->name('client.po.saveEditedInvoice');
		Route::get('/delete/{id}', 'PurchaseOrderController@deleteInvoice')->name('client.po.deleteInvoice');
		Route::get('/download-invoice-document-zip/{id}', 'PurchaseOrderController@downloadInvoiceDocumentZip')->name('client.po.downloadInvoiceDocumentZip');
		Route::get('/all', 'PurchaseOrderController@allInvoice')->name('client.invoice.index');
	});

	Route::group(['prefix' => 'transaction'], function () {
		Route::get('/list', 'TransactionController@index')->name('client.transaction.index');
	});

	Route::group(['prefix' => 'credit'], function () {
		Route::get('/apply', 'CreditController@add')->name('client.credit.add');
		Route::post('/store', 'CreditController@store')->name('client.credit.store');
		Route::post('/get-statement', 'CreditController@getStatement')->name('client.credit.getStatement');
	});