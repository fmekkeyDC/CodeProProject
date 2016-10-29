<?php 

use Carbon\Carbon;

class report extends BaseController {

	public function getItemsBarCodes() {

	}


	public function getItemDataByBarCode () {
		$keyword = Input::get("q");
		$page = Input::get("page");
		$limit = 10;
		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} else { 
			$page=1; 
		}
		$start_from = ($page-1) * $limit; 

		if (preg_match('/^[0-9]+$/', $keyword)) {
			$column = "item_name";
			// $orColumn = "container_id";
		} else {
			$column = "item_name";
		}

		$searchQuery = DB::table('item_definer')->select("id","item_name","item_code")->where("item_name","LIKE","%".$keyword."%")->get();

		return Response::json(["items" => $searchQuery]);
	}

	public function print_barcodes (){
		$id = Input::get("id");

		$getData = DB::table("item_definer")->where("item_code","=",$id)->select("item_name","item_code","sell_dist_price")->first();

		$public_path = "public/layout/";
		return View::make("layout.print_barcodes")
		->with("public_path",$public_path)
		->with("getData",$getData);
	}

	function printBarCodes () {
		$item_code = Input::get("item_code");
		$count = Input::get("count");

		DB::select(" TRUNCATE TABLE  print_barcode ");
		for($index = 0 ; $index<count($item_code) ; $index++){
			$getData = DB::table("item_definer")->where("item_code",$item_code[$index])->select("item_name","item_code","sell_dist_price")->first();
			$insertBarcodeItems = DB::table("print_barcode")->insertGetId(
				[
					"quantity" => $count[$index],
					"item_code" => $item_code[$index],
					"item_name" => $getData->item_name,
					"sell_dist_price" => $getData->sell_dist_price,
					"created_at" => Carbon::now()
				]
			);
		}
		
		$getBarCodesData = DB::table("print_barcode")->get();
		
		$public_path = "public/layout/";
		return View::make("layout.print_barcodes")
		->with("public_path",$public_path)
		->with("getData",$getBarCodesData);
	}

	public function showSalesDetailReport () {
		$date_From = Input::get("date_From");
		$date_to = Input::get("date_to");

		$rules = [
			"date_From" => "required|date_format:Y-m-d",
			"date_to" => "required|date_format:Y-m-d",
		];

		$messages = [
			"date_From.required" => "فضلاً قم بإدخال تاريخ بداية عرض التقرير",
			"date_to.required" => "فضلاً قم بإدخال تاريخ نهاية عرض التقرير",
			"date_From.date_format" => "صيغة تاريخ البداية غير صحيحة و الصيغة الصحيحة هي سنة-شهر-يوم",
			"date_to.date_format" => "تاريخ النهاية غير صحيح و الصيغة الصحيحة هي سنة-شهر-يوم"
		];

		$validator = Validator::make(Input::all(), $rules, $messages);


		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else{
			$date_From = Carbon::parse($date_From)->format("Y-m-d");
			$date_to = Carbon::parse($date_to)->format("Y-m-d");

			$getSoldInvoices = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total ,t1.invoice_number , t1.items_discount , t1.addons
					FROM solditems t1
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
			");

			$getStoreItems = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total ,t1.invoice_number , t1.items_discount , t1.addons
					FROM store_items t1
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
			");

			$getReversingInvoices = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total , t1.items_discount , t1.addons , t1.invoice_number 
					FROM reversing_invoice t1
					INNER JOIN reversing_invoice t2 
				    	ON (t1.invoice_number = t2.invoice_parent)
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
				"
			);

			$getShowerServices = DB::select("
			    SELECT * 
			        FROM shower
			        where (shower.date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getShavingServices = DB::select("
		        SELECT * 
			        FROM shaving
			        where (shaving.date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getOtherServicesServices = DB::select("
			    SELECT * 
			        FROM other_services
			        where (other_services.check_date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getCheckServices = DB::select("
			    SELECT * 
			        FROM `check`
			        where (`check`.`check_date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getHostingPreEndServices = DB::select("
			    SELECT * 
			        FROM `hosting`
			        where (`hosting`.`start_date` BETWEEN '{$date_From}' AND '{$date_to}')
			        AND user_pay_before_end_date != 0;
				"
			);

			$getHostingEndServices = DB::select("
			    SELECT * 
			        FROM `hosting`
			        where (`hosting`.`end_date` BETWEEN '{$date_From}' AND '{$date_to}')
			        AND user_pay_before_end_date = 0;
				"
			);


		 	$getUsable = DB::select("
				 	SELECT * 
			        FROM `usable`
			        where (`usable`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getRevenu = DB::select("
				 SELECT * 
			        FROM `revenu`
			        where (`revenu`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getExport = DB::select("
				 	SELECT * 
			        FROM `export`
			        where (`export`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getExpenses = DB::select("
			 	SELECT * 
			        FROM `expenses`
			        where (`expenses`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getMonthlyCosts = DB::select("
			 	SELECT * 
			        FROM `monthlyCosts`
			        where (`monthlyCosts`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$addons = DB::select("
				SELECT (
			 	IFNULL((SELECT SUM(addons) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND addons != 0),0)) addons  ;
				"
			);

			$getStoreItemsData = DB::select(
				"
				SELECT( 
					    ((
					    IFNULL((SELECT SUM(solditems.item_price * solditems.item_quantity) - SUM(solditems.paid_price * solditems.item_quantity)
						FROM solditems 
					    	WHERE invoice_parent !=0 
					        AND (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    + 
					    IFNULL((SELECT SUM(addons) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND addons != 0),0)
						+
					    IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -- -
					    -- (
					    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    -- )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )
					   
					   -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `monthlyCosts` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )

					    -

					    IFNULL((SELECT SUM(items_discount) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND items_discount != 0),0)

						) totalRevnue
				"
			);

			$getStoreItemsDataWithPayment = DB::select(
				"
				SELECT( 
					    (IFNULL((SELECT SUM(`items_net_total`) FROM solditems where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -- -
					    -- (
					    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    -- )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM store_items where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )
			    ) totalRevnue
				"
			);

			$total_items_payment = DB::select("
				SELECT item_definer.item_name,solditems.item_code , 
				IFNULL(SUM(solditems.item_quantity),0) total_sold_quantity ,
			    (solditems.paid_price) item_paid_price,
			    (solditems.item_price) item_sell_price,
			    IFNULL(SUM(solditems.paid_price * solditems.item_quantity),0) total_paid , 
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity ),0) total_sold ,
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity )  - (solditems.paid_price * solditems.item_quantity),0) total_revenu
				FROM solditems
				INNER JOIN item_definer
			    	ON item_definer.item_code = solditems.item_code
			    WHERE (solditems.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				AND solditems.invoice_parent != 0
				GROUP BY solditems.item_code
			    HAVING (solditems.item_code) > 0;
			");

			$total_payment_details = DB::select("
			SELECT
				IFNULL(SUM(solditems.paid_price * solditems.item_quantity),0) total_paid,
				IFNULL(SUM(solditems.item_price * solditems.item_quantity ),0) total_sold,
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity )  - SUM(solditems.paid_price * solditems.item_quantity),0) total_revenu
				FROM solditems
			    WHERE (solditems.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				AND solditems.invoice_parent != 0
			");
			
    		$TotalExpensesValue = DB::select(" 
			    SELECT (
			    (
			    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    )
			    -- +
			    -- (
			    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    -- )
			    +
			    (
			    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    )
			    ) totalExpenses
			  ");

    		$totalServicesRevenu = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    + 
				    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
				    +
				    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    ) totalServicesRevenu
			  ");


    		$totalRevenuValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    	) totalRevenuValue
			  ");

    		$reversing_invoiceValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
			    	) reversing_invoiceValue
			  ");

    		$exportValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)) exportValue
			  ");

    		$monthlyCosts = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `monthlyCosts` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)) monthlyCosts
			  ");

    		$getDiscounts = DB::select("
    			SELECT (
		    		IFNULL((SELECT SUM(items_discount) FROM solditems WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')),0)) getDiscounts
    		");

			return Response::json(
				[
					"getSoldInvoices" => $getSoldInvoices,
					"getReversingInvoices" => $getReversingInvoices,
					"getShowerServices" => $getShowerServices,
					"getShavingServices" => $getShavingServices,
					"getOtherServicesServices" => $getOtherServicesServices,
					"getCheckServices" => $getCheckServices,
					"getHostingPreEndServices" => $getHostingPreEndServices,
					"getHostingEndServices" => $getHostingEndServices,
					"getUsable" => $getUsable,
					"getRevenu" => $getRevenu,
					"getExport" => $getExport,
					"getExpenses" => $getExpenses,
					"getStoreItemsData" => $getStoreItemsData,
					"getStoreItems" => $getStoreItems,
					"getStoreItemsDataWithPayment" => $getStoreItemsDataWithPayment,
					"total_items_payment" => $total_items_payment,
					"total_payment_details" => $total_payment_details,
					"TotalExpensesValue" => $TotalExpensesValue,
					"totalServicesRevenu" => $totalServicesRevenu,
					"TotalExpensesValue" => $TotalExpensesValue,
					"exportValue" => $exportValue,
					"reversing_invoiceValue" => $reversing_invoiceValue,
					"totalRevenuValue" => $totalRevenuValue,
					"getDiscounts" => $getDiscounts,
					"addons" => $addons,
					"monthlyCosts" => $monthlyCosts,
					"getMonthlyCosts" => $getMonthlyCosts
				]
			);
	 	}
	}


	public function showSalesDetailDailyReport() {
		$date_From = Input::get("date_From");
		$date_to = Input::get("date_to");

		$rules = [
			"date_From" => "required|date_format:Y-m-d",
			"date_to" => "required|date_format:Y-m-d",
		];

		$messages = [
			"date_From.required" => "فضلاً قم بإدخال تاريخ بداية عرض التقرير",
			"date_to.required" => "فضلاً قم بإدخال تاريخ نهاية عرض التقرير",
			"date_From.date_format" => "صيغة تاريخ البداية غير صحيحة و الصيغة الصحيحة هي سنة-شهر-يوم",
			"date_to.date_format" => "تاريخ النهاية غير صحيح و الصيغة الصحيحة هي سنة-شهر-يوم"
		];

		$validator = Validator::make(Input::all(), $rules, $messages);


		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else{
			$date_From = Carbon::parse($date_From)->format("Y-m-d");
			$date_to = Carbon::parse($date_to)->format("Y-m-d");

			$getSoldInvoices = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total ,t1.invoice_number , t1.items_discount , t1.addons
					FROM solditems t1
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
			");

			$getStoreItems = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total ,t1.invoice_number , t1.items_discount , t1.addons
					FROM store_items t1
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
			");

			$getReversingInvoices = DB::select("
				SELECT t1.invoice_date ,t1.items_net_total , t1.items_discount , t1.addons , t1.invoice_number 
					FROM reversing_invoice t1
					INNER JOIN reversing_invoice t2 
				    	ON (t1.invoice_number = t2.invoice_parent)
				    where (t1.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				    AND t1.invoice_parent = 0;
				"
			);

			$getShowerServices = DB::select("
			    SELECT * 
			        FROM shower
			        where (shower.date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getShavingServices = DB::select("
		        SELECT * 
			        FROM shaving
			        where (shaving.date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getOtherServicesServices = DB::select("
			    SELECT * 
			        FROM other_services
			        where (other_services.check_date BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getCheckServices = DB::select("
			    SELECT * 
			        FROM `check`
			        where (`check`.`check_date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getHostingPreEndServices = DB::select("
			    SELECT * 
			        FROM `hosting`
			        where (`hosting`.`start_date` BETWEEN '{$date_From}' AND '{$date_to}')
			        AND user_pay_before_end_date != 0;
				"
			);

			$getHostingEndServices = DB::select("
			    SELECT * 
			        FROM `hosting`
			        where (`hosting`.`end_date` BETWEEN '{$date_From}' AND '{$date_to}')
			        AND user_pay_before_end_date = 0;
				"
			);


		 	$getUsable = DB::select("
				 	SELECT * 
			        FROM `usable`
			        where (`usable`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getRevenu = DB::select("
				 SELECT * 
			        FROM `revenu`
			        where (`revenu`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getExport = DB::select("
				 	SELECT * 
			        FROM `export`
			        where (`export`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

		 	$getExpenses = DB::select("
			 	SELECT * 
			        FROM `expenses`
			        where (`expenses`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$getStoreItemsData = DB::select(
				"
				SELECT( 
					    ((
					    IFNULL((SELECT SUM(solditems.item_price * solditems.item_quantity)
						FROM solditems 
					    	WHERE invoice_parent !=0 
					        AND (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    +

					    +
					    IFNULL((SELECT SUM(addons) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND addons != 0),0)

						+
					    IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )

					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `monthlyCosts` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					   
					    -

					    IFNULL((SELECT SUM(items_discount) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND items_discount != 0),0)

						) totalRevnue
				"
			);

			$getStoreItemsDataWithPayment = DB::select(
				"
				SELECT( 
					    (IFNULL((SELECT SUM(`items_net_total`) FROM solditems where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    + 
					    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
					    +
					    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    +
					    IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -- -
					    -- (
					    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    -- )
					    -
					    (
					    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )
					    -
					    (
					    IFNULL((SELECT SUM(`items_net_total`) FROM store_items where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
					    )
			    ) totalRevnue
				"
			);

			$total_items_payment = DB::select("
				SELECT item_definer.item_name,solditems.item_code , 
				IFNULL(SUM(solditems.item_quantity),0) total_sold_quantity ,
			    -- (solditems.paid_price) item_paid_price,
			    (solditems.item_price) item_sell_price,
			    -- SUM(solditems.paid_price * solditems.item_quantity) total_paid , 
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity ) ,0) total_sold ,
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity),0)  total_revenu
				FROM solditems
				INNER JOIN item_definer
			    	ON item_definer.item_code = solditems.item_code
			    WHERE (solditems.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				AND solditems.invoice_parent != 0
				GROUP BY solditems.item_code
			    HAVING (solditems.item_code) > 0;
			");

			$total_payment_details = DB::select("
			SELECT
				IFNULL(SUM(solditems.paid_price * solditems.item_quantity),0) total_paid,
				IFNULL(SUM(solditems.item_price * solditems.item_quantity ),0) total_sold,
			    IFNULL(SUM(solditems.item_price * solditems.item_quantity ),0) total_revenu
				FROM solditems
			    WHERE (solditems.invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
				AND solditems.invoice_parent != 0
			");
			
    		$TotalExpensesValue = DB::select(" 
			    SELECT (
			    (
			    IFNULL((SELECT SUM(`expenses_value`) FROM `expenses` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    )
			    -- +
			    -- (
			    -- IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    -- )
			    +
			    (
			    IFNULL((SELECT SUM(`expenses_value`) FROM `usable` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    )
			    ) totalExpenses
			  ");

    		$totalServicesRevenu = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`price`) FROM shower where (date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    + 
				    IFNULL((SELECT SUM(`price`) FROM shaving where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
				    +
				    IFNULL((SELECT SUM(`total_remainig`) FROM hosting where (end_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`user_pay_before_end_date`) FROM hosting where (start_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `check` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0) 
				    +
				    IFNULL((SELECT SUM(`price`) FROM `other_services` where (check_date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    ) totalServicesRevenu
			  ");


    		$totalRevenuValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `revenu` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)
			    	) totalRevenuValue
			  ");

    		$reversing_invoiceValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`items_net_total`) FROM reversing_invoice where (invoice_date BETWEEN '{$date_From}' AND '{$date_to}') AND invoice_parent = 0),0)
			    	) reversing_invoiceValue
			  ");

    		$exportValue = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `export` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)) exportValue
			  ");

    		$getDiscounts = DB::select("
    			SELECT (
		    		IFNULL((SELECT SUM(items_discount) FROM solditems WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')),0)) getDiscounts
    		");

    		$addons = DB::select("
				SELECT (
			 	IFNULL((SELECT SUM(addons) FROM solditems
						WHERE (invoice_date BETWEEN '{$date_From}' AND '{$date_to}')
					    AND invoice_parent = 0
						AND addons != 0),0)) addons  ;
				"
			);

    		$getMonthlyCosts = DB::select("
			 	SELECT * 
			        FROM `monthlyCosts`
			        where (`monthlyCosts`.`date` BETWEEN '{$date_From}' AND '{$date_to}');
				"
			);

			$monthlyCosts = DB::select(" 
			    SELECT (
		    		IFNULL((SELECT SUM(`expenses_value`) FROM `monthlyCosts` where (date BETWEEN '{$date_From}' AND '{$date_to}')),0)) monthlyCosts
			  ");

			return Response::json(
				[
					"getSoldInvoices" => $getSoldInvoices,
					"getReversingInvoices" => $getReversingInvoices,
					"getShowerServices" => $getShowerServices,
					"getShavingServices" => $getShavingServices,
					"getOtherServicesServices" => $getOtherServicesServices,
					"getCheckServices" => $getCheckServices,
					"getHostingPreEndServices" => $getHostingPreEndServices,
					"getHostingEndServices" => $getHostingEndServices,
					"getUsable" => $getUsable,
					"getRevenu" => $getRevenu,
					"getExport" => $getExport,
					"getExpenses" => $getExpenses,
					"getStoreItemsData" => $getStoreItemsData,
					"getStoreItems" => $getStoreItems,
					"getStoreItemsDataWithPayment" => $getStoreItemsDataWithPayment,
					"total_items_payment" => $total_items_payment,
					"total_payment_details" => $total_payment_details,
					"TotalExpensesValue" => $TotalExpensesValue,
					"totalServicesRevenu" => $totalServicesRevenu,
					"TotalExpensesValue" => $TotalExpensesValue,
					"exportValue" => $exportValue,
					"reversing_invoiceValue" => $reversing_invoiceValue,
					"totalRevenuValue" => $totalRevenuValue,
					"getDiscounts" => $getDiscounts,
					"addons" => $addons,
					"monthlyCosts" => $monthlyCosts,
					"getMonthlyCosts" => $getMonthlyCosts
					
				]
			);
	 	}
	}
} 