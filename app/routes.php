<?php
Route::group(["before" => "guest"],function(){
	Route::get("/login",["as" => "login" , "uses" =>"HomeController@login"]);
	Route::group(["before"=>"CSRF"],function(){
		Route::post("/loginToSystem",["as"=>"loginToSystem","uses"=>"HomeController@loginToSystem"]);
	});

	Route::get("/hash",function(){
		return Hash::make((Input::get("key")));
	});
});

Route::group(["before" => "auth"],function(){
	Route::get("/",["as"=>"home","uses"=>"HomeController@home"]);
	Route::get("/application_manager",["as"=>"application_manager","uses"=>"HomeController@application_manager"]);
	Route::get("/getAppsTable",["as" => "getAppsTable" , "uses" =>"applicationController@getAppsTable"]);
	Route::get("/store_item_definer",["as" => "store_item_definer" , "uses" =>"HomeController@store_item_definer"]);
	Route::get("/add_items_to_store",["as" => "add_items_to_store" , "uses" =>"HomeController@add_items_to_store"]);
	Route::get("/delete_item_from_stroe",["as" => "delete_item_from_stroe" , "uses" =>"HomeController@delete_item_from_stroe"]);
	Route::get("/define_item_groups",["as" => "define_item_groups" , "uses" =>"HomeController@define_item_groups"]);
	Route::get("/sell_invoice",["as" => "sell_invoice" , "uses" =>"HomeController@sell_invoice"]);
	Route::get("/cash_control",["as" => "cash_control" , "uses" =>"HomeController@cash_control"]);
	Route::get("/users_adminstraions",["as" => "users_adminstraions" , "uses" =>"HomeController@users_adminstraions"]);
	Route::get("/services_definer",["as" =>"services_definer" , "uses" =>"HomeController@services_definer"]);
	Route::get("/next_item_id",["as" =>"next_item_id" , "uses" =>"HomeController@next_item_id"]);
	Route::get("/getUsersTable",["as" => "getUsersTable" , "uses" =>"usersController@getUsersTable"]);
	Route::get("/logout",["as" => "logout" , "uses" =>"HomeController@logout"]);
	Route::get("/getItemDataByCode",["as" => "getItemDataByCode" , "uses" =>"storesController@getItemDataByCode"]);
	Route::get("/getInvoiceData",["as" => "getInvoiceData" , "uses" =>"storesController@getInvoiceData"]);
	Route::get("/getChildrenData",["as" => "getChildrenData" , "uses" =>"storesController@getChildrenData"]);
	Route::get("/getStoreItemsData",["as" => "getStoreItemsData" , "uses" =>"storesController@getStoreItemsData"]);
	Route::get("/getInvoiceDataTable",["as" => "getInvoiceDataTable" , "uses" =>"storesController@getInvoiceDataTable"]);
	Route::get("/getStoreInvoiceItemsData",["as" => "getStoreInvoiceItemsData" , "uses" =>"storesController@getStoreInvoiceItemsData"]);
	Route::get("/getStoreItemsDataTable",["as" => "getStoreItemsDataTable" , "uses" =>"storesController@getStoreItemsDataTable"]);
	Route::get("/Hosting",["as" => "Hosting" , "uses" =>"HomeController@Hosting"]);
	Route::get("/Check",["as" => "Check" , "uses" =>"HomeController@Check"]);
	Route::get("/shower",["as" => "shower" , "uses" =>"HomeController@shower"]);
	Route::get("/shaving",["as" => "shaving" , "uses" =>"HomeController@shaving"]);
	Route::get("/getStoresItemsDataTable",["as" => "getStoresItemsDataTable" , "uses" =>"storesController@getStoresItemsDataTable"]);
	Route::get("/getStoreItemDataTableInfo",["as" => "getStoreItemDataTableInfo" , "uses" =>"storesController@getStoreItemDataTableInfo"]);
	Route::get("/getServicesTypes",["as" => "getServicesTypes" , "uses" =>"serviceController@getServicesTypes"]);
	Route::get("/getServiceByID",["as" => "getServiceByID" , "uses" =>"serviceController@getServiceByID"]);
	Route::get("/getHostingServicesItems",["as" => "getHostingServicesItems" , "uses" =>"Hosting@getHostingServicesItems"]);
	Route::get("/getHostingByID",["as" => "getHostingByID" , "uses" =>"Hosting@getHostingByID"]);
	Route::get("/exitHosting",["as" => "exitHosting" , "uses" =>"Hosting@exitHosting"]);
	Route::get("/getCheckServices",["as" => "getCheckServices" , "uses" =>"check@getCheckServices"]);
	Route::get("/getCheckingByID",["as" => "getCheckingByID" , "uses" =>"check@getCheckingByID"]);
	Route::get("/getShowerServices",["as" => "getShowerServices" , "uses" =>"shower@getShowerServices"]);
	Route::get("/getShowerByID",["as" => "getShowerByID" , "uses" =>"shower@getShowerByID"]);
	Route::get("/getShavingServices",["as" => "getShavingServices" , "uses" =>"shaving@getShavingServices"]);
	Route::get("/getShavingByID",["as" => "getShavingByID" , "uses" =>"shaving@getShavingByID"]);
	Route::get("/barcode_report",["as" => "barcode_report" , "uses" =>"HomeController@barcode_report"]);
	Route::get("/getItemDataByBarCode",["as" => "getItemDataByBarCode" , "uses" =>"report@getItemDataByBarCode"]);
	Route::get("/print_barcodes",["as" => "print_barcodes" , "uses" =>"report@print_barcodes"]);
	Route::get("/getPriceForServices",["as" => "getPriceForServices" , "uses" =>"Hosting@getPriceForServices"]);
	Route::get("/getExpenses",["as" => "getExpenses" , "uses" =>"expenses@getExpenses"]);
	Route::get("/getExpensesByID",["as" => "getExpensesByID" , "uses" =>"expenses@getExpensesByID"]);
	Route::get("/getServicePrices",["as" => "getServicePrices" , "uses" =>"HomeController@getServicePrices"]);
	Route::get("/other_services",["as" => "other_services" , "uses" =>"HomeController@other_services"]);
	Route::get("/getOthrtServiceByID",["as" => "getOthrtServiceByID" , "uses" =>"otherServices@getOthrtServiceByID"]);
	Route::get("/getOtherServices",["as" => "getOtherServices" , "uses" =>"otherServices@getOtherServices"]);
	Route::get("/getOtherServicesNames",["as" => "getOtherServicesNames" , "uses" =>"otherServices@getOtherServicesNames"]);
	Route::get("/getCurrentCashBoxService",["as" => "getCurrentCashBoxService" , "uses" =>"expenses@getCurrentCashBoxService"]);
	Route::get("/getLastInvoiceNumber",["as" => "getLastInvoiceNumber" , "uses" =>"HomeController@getLastInvoiceNumber"]);
	Route::get("/reverseItems",["as" => "reverseItems" , "uses" =>"HomeController@reverseItems"]);
	Route::get("/getItemSoldData",["as" => "getItemSoldData" , "uses" =>"storesController@getItemSoldData"]);
	Route::get("/getChildrenItemData",["as" => "getChildrenItemData" , "uses" =>"storesController@getChildrenItemData"]);
	Route::get("/printBarCodesFromStoresInvoice",["as" => "printBarCodesFromStoresInvoice" , "uses" =>"HomeController@printBarCodesFromStoresInvoice"]);
	Route::get("/getServicesWithInvoice",["as" => "getServicesWithInvoice" , "uses" =>"HomeController@getServicesWithInvoice"]);
	Route::get("/reversing_invoice",["as" => "reversing_invoice" , "uses" =>"HomeController@reversing_invoice"]);
	Route::get("/getStoreReversingInvoiceItemsData",["as" => "getStoreReversingInvoiceItemsData" , "uses" =>"storesController@getStoreReversingInvoiceItemsData"]);
	Route::get("/getReversingInvoiceSingleItemsDataTable",["as" => "getReversingInvoiceSingleItemsDataTable" , "uses" =>"storesController@getReversingInvoiceSingleItemsDataTable"]);
	Route::get("/sales_details_report",["as" => "sales_details_report" , "uses" =>"HomeController@sales_details_report"]);
	Route::get("/store_inventory",["as" => "store_inventory" , "uses" =>"HomeController@store_inventory"]);
	Route::get("/migrateItems",["as" => "migrateItems" , "uses" =>"HomeController@migrateItems"]);
	Route::get("/deleteServiceFromInvoiceItem",["as" => "deleteServiceFromInvoiceItem" , "uses" =>"storesController@deleteServiceFromInvoiceItem"]);
	Route::get("/deleteAllServiceFromInvoiceItem",["as" => "deleteAllServiceFromInvoiceItem" , "uses" =>"storesController@deleteAllServiceFromInvoiceItem"]);
	Route::get("/sales_total_per_day",["as" => "sales_total_per_day" , "uses" =>"HomeController@sales_total_per_day"]);
	Route::get("/systemCheck",["as" => "systemCheck" , "uses" =>"HomeController@systemCheck"]);
	Route::get("/sha1Enc",["as" => "sha1Enc" , "uses" =>"HomeController@sha1Enc"]);

	// Route::get("/get_items_types",["as" => "get_items_types" , "uses" => "HomeController@get_items_types"]);

	Route::group(["before"=>"CSRF"],function(){
		Route::post("/addNewApplication",["as"=>"addNewApplication","uses"=>"applicationController@addNewApplication"]);
		Route::post("/addNewItemCard",["as"=>"addNewItemCard","uses"=>"storesController@addNewItemCard"]);
		Route::post("/addItemsToStores",["as"=>"addItemsToStores","uses"=>"storesController@addItemsToStores"]);
		Route::post("/addNewUser",["as"=>"addNewUser","uses"=>"usersController@addNewUser"]);
		Route::post("/addNewItemGroups",["as"=>"addNewItemGroups","uses"=>"itemsGroupController@addNewItemGroups"]);
		Route::post("/EditItemGroups",["as"=>"EditItemGroups","uses"=>"itemsGroupController@EditItemGroups"]);
		Route::post("/addItemsToStores",["as"=>"addItemsToStores","uses"=>"storesController@addItemsToStores"]);
		Route::post("/saveDeletedItems",["as"=>"saveDeletedItems","uses"=>"storesController@saveDeletedItems"]);
		Route::post("/addSellInvoice",["as"=>"addSellInvoice","uses"=>"storesController@addSellInvoice"]);
		Route::post("/addNewService",["as" => "addNewService" , "uses" =>"serviceController@addNewService"]);
		Route::post("/addNewHostingServices",["as" => "addNewHostingServices" , "uses" =>"Hosting@addNewHostingServices"]);
		Route::post("/paymentRecord",["as" => "paymentRecord" , "uses" =>"Hosting@paymentRecord"]);
		Route::post("/setRemainPrice",["as" => "paymentRecord" , "uses" =>"Hosting@setRemainPrice"]);
		Route::post("/addNewCheck",["as" => "addNewCheck" , "uses" =>"check@addNewCheck"]);
		Route::post("/addNewShowerService",["as" => "addNewShowerService" , "uses" =>"shower@addNewShowerService"]);
		Route::post("/addNewShavingService",["as" => "addNewShavingService" , "uses" =>"shaving@addNewShavingService"]);
		Route::post("/getItemsBarCodes",["as" => "getItemsBarCodes" , "uses" =>"report@getItemsBarCodes"]);
		Route::post("/printBarCodes",["as" => "printBarCodes" , "uses" =>"report@printBarCodes"]);
		Route::post("/addNewCash",["as" => "addNewCash" , "uses" =>"expenses@addNewCash"]);
		Route::post("/addNewOtherServices",["as" => "addNewOtherServices" , "uses" =>"otherServices@addNewOtherServices"]);
		Route::post("/saveDeletedItemsSold",["as" => "saveDeletedItemsSold" , "uses" =>"storesController@saveDeletedItemsSold"]);
		Route::post("/editInvoiceDate",["as" => "editInvoiceDate" , "uses" =>"storesController@editInvoiceDate"]);
		Route::post("/add_reversing_invoice",["as" => "add_reversing_invoice" , "uses" =>"storesController@add_reversing_invoice"]);
		Route::post("/showSalesDetailReport",["as" => "showSalesDetailReport" , "uses" =>"report@showSalesDetailReport"]);
		Route::post("/showSalesDetailDailyReport",["as" => "showSalesDetailDailyReport" , "uses" =>"report@showSalesDetailDailyReport"]);

	});

	Route::post('/updateApp',["as" => "updateApp" , "uses" => "applicationController@updateApp"]);
	Route::post('/updateUsers',["as" => "updateUsers" , "uses" => "usersController@updateUsers"]);

	Route::delete("/deleteApp",["as" => "deleteApp" , "uses" => "applicationController@deleteApp"]);
	Route::delete("/deleteUsers",["as" => "deleteUsers" , "uses" => "usersController@deleteApp"]);
	Route::delete("/deleteInvoiceDate",["as" => "deleteUsers" , "uses" => "storesController@deleteInvoiceDate"]);
});