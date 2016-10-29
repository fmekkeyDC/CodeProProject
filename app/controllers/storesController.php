<?php 
use Carbon\Carbon;

class storesController extends BaseController{
	public function store_item_definer () {
		return '';
	}

	public function addNewItemCard () {
		$item_code = Input::get("item_code");
		$item_name = Input::get("item_name");
		$item_description = Input::get("item_description");
		$item_picture = Input::file("item_picture");
		$item_profitability = Input::get("item_profitability");
		$item_type_id = Input::get("item_type_id");
		$paid_price = Input::get("paid_price");
		$re_request_point = Input::get("re_request_point");
		$sell_dist_price = Input::get("sell_dist_price");
		$started_quantity = Input::get("started_quantity");
		$wholesale_price = Input::get("wholesale_price");
		$non_storeable_item = Input::get("non_storeable_item",0);
		$none_active_item = Input::get("none_active_item",0);
		$time = time();
		$childPhotoRealPath = "";
		$childPhotoClientOriginalName = "";
		$childPhotoOriginalExtension = "";
		$childPhotogetSize = "";
		$upload_path = "";

		if (Input::get("oldItemID") && !empty(Input::get("oldItemID"))){
			$started_quantity = 0;
		}
		
		if (!empty($item_picture)){
			$childPhotoRealPath = $item_picture->getRealPath();
			$childPhotoClientOriginalName = $item_picture->getClientOriginalName();
			$childPhotoOriginalExtension = $item_picture->getClientOriginalExtension();
			$childPhotogetSize = $item_picture->getSize();
			$upload_path = "uploads/".date("Y")."/".date("m")."/".date("d")."/".$time.'.'.$childPhotoOriginalExtension;
		}

		$rules = [
			"item_code" => "required|unique:item_definer,item_code",
			"item_name" => "required|unique:item_definer,item_name",
			"item_type_id" => "required|exists:items_type_definer,id",
			"paid_price" => "required",
			"re_request_point" => "required",
			"sell_dist_price" => "required",
		];

		if (Input::get("oldItemID") && !empty(Input::get("oldItemID"))){
			$getItemName = DB::table("item_definer")->where("item_code","=",Input::get("oldItemID"))->select("item_name")->first()->item_name;
			
			if ($getItemName == $item_name){
				unset($rules["item_name"]);
			}
			unset($rules["item_code"]);
		}
		$messages = [
			"item_code.required" => "فضلاً ضع قيمة كود الصنف",
			"item_code.unique" => "كود الصنف مستخدم من قبل",
			"item_name.required" => "فضلاً ضع اسم الصنف",
			"item_name.unique" => "يوجد صنف بنفس الإسم",
			"item_type_id.required" => "فضلاً حدد نوع الصنف",
			"item_type_id.exists" => "نوع الصنف غير موجود بقاعدة بيانات انواع الأصناف",
			"paid_price.required" => "فضلاً حدد سعر شراء الصنف",
			"re_request_point.required" => "فضلاً ضع قيمة إعادة الطلب",
			"sell_dist_price.required" => "فضلاً حدد قيمة سعر البيع للصنف",

		];

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else {
			if (Input::get("oldItemID") && !empty(Input::get("oldItemID"))){
				$insertData = DB::table("item_definer")
				->where("item_code","=",Input::get("oldItemID"))
				->update([
					"item_code" =>  $item_code,
					"item_name" =>  $item_name,
					"item_description" =>  $item_description,
					"item_picture" =>  $upload_path,
					"item_profitability" =>  $item_profitability,
					"item_type_id" =>  $item_type_id,
					"paid_price" =>  $paid_price,
					"re_request_point" =>  $re_request_point,
					"sell_dist_price" =>  $sell_dist_price,
					// "started_quantity" =>  $started_quantity,
					"wholesale_price" =>  $wholesale_price,
					"non_storeable_item" =>  $non_storeable_item,
					"none_active_item" =>  $none_active_item,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]);
			}else{
				$insertData = DB::table("item_definer")
				->insertGetId([
					"item_code" =>  $item_code,
					"item_name" =>  $item_name,
					"item_description" =>  $item_description,
					"item_picture" =>  $upload_path,
					"item_profitability" =>  $item_profitability,
					"item_type_id" =>  $item_type_id,
					"paid_price" =>  $paid_price,
					"re_request_point" =>  $re_request_point,
					"sell_dist_price" =>  $sell_dist_price,
					"started_quantity" =>  $started_quantity,
					"wholesale_price" =>  $wholesale_price,
					"non_storeable_item" =>  $non_storeable_item,
					"none_active_item" =>  $none_active_item,
					"created_by" => Auth::user()->id,
					"created_at" => Carbon::now()
				]);
			}
			if ($insertData){
				$invoice_number_generated = HomeController::getNextItemsOnStoresID('store_items');
				if (!empty($started_quantity)){
					$data = [
						"invoice_number" => $invoice_number_generated ,
						"invoice_date" => Carbon::now() ,
						"provider_name" => "رصيد أول المدة" ,
						"started_quantity_flage" => 1,
						"items_total_price" => $paid_price * $started_quantity,
						"items_discount" => 0,
						"items_net_total" => $paid_price * $started_quantity,
						"addons" => 0,
						"invoice_notice" => "رصيد أول المدة",
						"started_quantity_flage" => 1,
						"created_by" => Auth::user()->id,
						"created_at" => Carbon::now()
					];
					$insert_started_quantity_query_invoice_data = DB::table("store_items")->insert($data);

					if ($insert_started_quantity_query_invoice_data){

						$data = [
							"invoice_parent" => $invoice_number_generated,
							"invoice_date" => Carbon::now() ,
							"item_code" => $item_code,
							"item_type" => $item_type_id,
							"item_name" =>  $item_code,
							"item_quantity" => $started_quantity,
							"item_price" => $paid_price,
							"item_total_price" => $paid_price * $started_quantity ,
							"created_by" => Auth::user()->id,
							"created_at" => Carbon::now()
						];
						$insert_item_invoice_items = DB::table("store_items")->insert($data);
					}
				}


				if (!empty($item_picture)){
					$uploader = $item_picture->move(public_path()."/uploads/".date("Y")."/".date("m")."/".date("d")."/",$time.'.'.$childPhotoOriginalExtension);
				}
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}

	public function getItemDataByCode () {
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
			$column = "item_code";
			$searchQuery = DB::select('
			SELECT
				`items_type_definer`.`item_type_name` as item_type_name,
				`item_definer`.`sell_dist_price` as sell_dist_price,
				`item_definer`.`paid_price` as paid_price,
				`item_definer`.`item_code` as item_code,
				`item_definer`.`id` as id,
				`item_definer`.`item_name` as item_name,
				`items_type_definer`.`id` as item_type_id,
				(SELECT sum(`solditems`.`item_quantity`) FROM solditems WHERE `solditems`.`item_code` = item_definer.item_code) as total_item_payment,
				(SELECT sum(`store_items`.`item_quantity`) FROM store_items WHERE `store_items`.`item_name` = item_definer.item_code) as total_item_quantity,
				(SELECT SUM(item_quantity) FROM delete_items_from_store where delete_items_from_store.item_code =  item_definer.item_code) as deletedQuantity,
				(SELECT IFNULL(sum(`store_items`.`item_quantity`),0) FROM store_items WHERE `store_items`.`item_name` = item_definer.item_code) + (SELECT IFNULL(SUM(item_quantity),0) FROM reversing_invoice where reversing_invoice.item_code =  item_definer.item_code) - (SELECT IFNULL(SUM(item_quantity),0) FROM delete_items_from_store where delete_items_from_store.item_code =  item_definer.item_code) - (SELECT IFNULL(sum(`solditems`.`item_quantity`),0) FROM solditems WHERE `solditems`.`item_code` = item_definer.item_code) as net_quantity
			FROM
				`item_definer`
			INNER JOIN `items_type_definer` ON `item_definer`.`item_type_id` = `items_type_definer`.`id`
			WHERE
				`item_definer`.`item_code` = '.$keyword.'
		');
		} else {
			$column = "item_code";
			$searchQuery = DB::select('
			SELECT
				`items_type_definer`.`item_type_name` as item_type_name,
				`item_definer`.`sell_dist_price` as sell_dist_price,
				`item_definer`.`paid_price` as paid_price,
				`item_definer`.`item_code` as item_code,
				`item_definer`.`id` as id,
				`item_definer`.`item_name` as item_name,
				`items_type_definer`.`id` as item_type_id,
				(SELECT sum(`solditems`.`item_quantity`) FROM solditems WHERE `solditems`.`item_code` = item_definer.item_code) as total_item_payment,
				(SELECT sum(`store_items`.`item_quantity`) FROM store_items WHERE `store_items`.`item_name` = item_definer.item_code) as total_item_quantity,
				(SELECT SUM(item_quantity) FROM delete_items_from_store where delete_items_from_store.item_code =  item_definer.item_code) as deletedQuantity,
				(SELECT IFNULL(sum(`store_items`.`item_quantity`),0) FROM store_items WHERE `store_items`.`item_name` = item_definer.item_code) + (SELECT IFNULL(SUM(item_quantity),0) FROM reversing_invoice where reversing_invoice.item_code =  item_definer.item_code) - (SELECT IFNULL(SUM(item_quantity),0) FROM delete_items_from_store where delete_items_from_store.item_code =  item_definer.item_code) - (SELECT IFNULL(sum(`solditems`.`item_quantity`),0) FROM solditems WHERE `solditems`.`item_code` = item_definer.item_code) as net_quantity
			FROM
				`item_definer`
			INNER JOIN `items_type_definer` ON `item_definer`.`item_type_id` = `items_type_definer`.`id`
			WHERE
				`item_definer`.`item_name` like "%'.$keyword.'%"
		');
		}

		
		return Response::json(["items" => $searchQuery]);
	}


	public function addItemsToStores(){
		
		$id = Input::get("id");
		$invoice_date = Input::get("invoice_date");
		$provider_name = Input::get("provider_name","");
		$items_total_price = Input::get("items_total_price");
		$items_discount = Input::get("items_discount");
		$items_net_total = Input::get("items_net_total");
		$item_code = Input::get("item_code");
		$item_name = Input::get("item_name");
		$item_quantity = Input::get("item_quantity");
		$item_price = Input::get("item_price");
		$payment_method = Input::get("payment_method");
		$invoice_notice = Input::get("invoice_notice");
		$item_type = Input::get("item_type");
		$item_total_price = Input::get("item_total_price");

		$rules = [];
		$messages = [];

		$rules["id"] = "required|unique:store_items,invoice_number";
		$rules["invoice_date"] = "required";
		$rules["items_total_price"] = "required";
		$rules["items_net_total"] = "required";

		$messages["id.required"] = "فضلاً ضع رقم الفاتورة";
		$messages["id.unique"] = "رقم الفاتورة موجود مستخدم من قبل";
		$messages["invoice_date.required"] = "فضلاً ضع تاريخ الفاتورة";
		$messages["items_total_price.required"] = "إجمالي قيمة الفاتورة غير معرف";
		$messages["items_net_total.required"] = "صافي الفاتورة غير معرف";


		for($index = 0 ; $index<count($item_code); $index++ ){

			$rules["item_type.".$index] = "required|exists:items_type_definer,id";
			$rules["item_name.".$index] = "required";
			$rules["item_quantity.".$index] = "required";
			$rules["item_price.".$index] = "required";

			$messages["item_type.".$index.".required"] = "فضلاً ضع نوع الصنف في الصف رقم {$index}" ;
			$messages["item_type.".$index.".exists"] = "لم نتمكن من تحديد نوع الصنف في الصف رقم  {$index} " ;
			$messages["item_name.".$index.".required"] = "فضلاً ضع اسم الصنف في الصف رقم  {$index} " ;
			$messages["item_quantity.".$index.".required"] = "فضلاً كمية الصنف في الصف رقم  {$index} " ;
			$messages["item_price.".$index.".required"] = "فضلاً ضع سعر الصنف في الصف رقم  {$index} " ;
		}

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else {
			$insertData = DB::table("store_items")
			->insert([
				"invoice_number" => $id,
				"invoice_parent" => "",
				"invoice_date" => $invoice_date,
				"provider_name" => $provider_name,
				"items_total_price" => $items_total_price,
				"items_discount" => $items_discount,
				"payment_method" => $payment_method,
				"items_net_total" => $items_net_total,
				"invoice_notice" => $invoice_notice,
				"started_quantity_flage" => 0,
				"created_by" => Auth::user()->id,
				"created_at" => Carbon::now()
			]);
			if ($insertData){
				for($index = 0 ; $index<count($item_code); $index++ ){
					$insertData = DB::table("store_items")
					->insert([
						"item_code" => $item_name[$index],
						"invoice_parent" => $id,
						"invoice_date" => $invoice_date,
						"item_name" => $item_name[$index],
						"item_type" => $item_type[$index],
						"item_quantity" => $item_quantity[$index],
						"item_price" => $item_price[$index],
						"item_total_price" => $item_total_price[$index],
						"created_by" => Auth::user()->id,
						"created_at" => Carbon::now()
					]);
				}
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}


	public function getInvoiceData(){
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
			$column = "invoice_number";
			// $orColumn = "container_id";
		} else {
			$column = "invoice_number";
		}

		$searchParentData = DB::table("store_items")
		->where("store_items.invoice_parent","=","")
		->where("store_items.".$column,"=",$keyword)
		->get();

		$searchChildrenDataData = DB::table("store_items")
		->leftjoin("item_definer","item_definer.item_code","=","store_items.item_name")
		->where("store_items.invoice_parent","!=","")
		->where("store_items.invoice_parent","=",$keyword)
		->get();
		return Response::json(array("incomplete_results"=>false,"items"=> $searchParentData,"total_countParents"=>count($searchParentData),"lookingFor"=>$column));
	}

	public function getChildrenData(){
		$keyword = Input::get("keyword");
		// $searchChildrenDataData = DB::table("store_items")
		// ->join("item_definer","item_definer.item_code","=","store_items.item_name")
		// ->join("items_type_definer","items_type_definer.id","=","store_items.item_type")
		// ->where("store_items.invoice_parent","!=","")
		// ->where("store_items.invoice_parent","=",$keyword)
		// ->select(
		// 	"store_items.item_name as store_items_item_name",
		// 	"item_definer.item_name as item_definer_item_name",
		// 	"items_type_definer.item_type_name as item_type_name",
		// 	"store_items.item_quantity as item_quantity",
		// 	"store_items.id as s_id"
		// )
		// ->get();

		$searchChildrenDataData = DB::select(
			" SELECT
				`store_items`.`item_name` AS `store_items_item_name`,	
				(SELECT sum(`solditems`.`item_quantity`) FROM solditems WHERE `solditems`.`item_code` = store_items_item_name) as total_item_payment,
				(SELECT sum(`store_items`.`item_quantity`) FROM store_items WHERE `store_items`.`item_name` = store_items_item_name) as total_item_quantity,
				(SELECT SUM(item_quantity) FROM delete_items_from_store where delete_items_from_store.item_code =  store_items_item_name) as deletedQuantity,
				(SELECT IFNULL(sum(`store_items`.`item_quantity`),0) FROM store_items WHERE `store_items`.`item_name` = store_items_item_name) - (SELECT IFNULL(SUM(item_quantity),0) FROM delete_items_from_store where delete_items_from_store.item_code =  store_items_item_name) +  (SELECT IFNULL(SUM(item_quantity),0) FROM reversing_invoice where reversing_invoice.item_code =  store_items_item_name) - (SELECT IFNULL(sum(`solditems`.`item_quantity`),0) FROM solditems WHERE `solditems`.`item_code` = store_items_item_name) as net_quantity,
				`item_definer`.`item_name` AS `item_definer_item_name`,
				`items_type_definer`.`item_type_name` AS `item_type_name`,
				`store_items`.`item_quantity` AS `item_quantity`,
				`store_items`.`id` AS `s_id`
			FROM
				`store_items`
			INNER JOIN `item_definer` ON `item_definer`.`item_code` = `store_items`.`item_name`
			INNER JOIN `items_type_definer` ON `items_type_definer`.`id` = `store_items`.`item_type`
			WHERE
				`store_items`.`invoice_parent` != ''
			AND `store_items`.`invoice_parent` = ".$keyword." "
		);

		return Response::json($searchChildrenDataData);
	}

	public function saveDeletedItems(){
		$item_code = Input::get("item_code");
		$invoice_parent = Input::get("invoice_parent");
		$delete_reason = Input::get("delete_reason","");
		$item_id = Input::get("item_id");
		$item_quantity = Input::get("item_quantity");
		$item_quantity_deleted = Input::get("item_quantity_deleted");

		 Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
	      $min_field = $parameters[0];
	      $data = $validator->getData();
	      $min_value = $data[$min_field];
	      return $value >= $min_value;
	    });   

	    Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
	      return str_replace(':field', $parameters[0], $message);
	    });

		$rules = [
			"item_code" => "required",
			"invoice_parent" => "required",
			"item_id" => "required",
			"item_quantity" => "required|greater_than_field:item_quantity_deleted",
			"item_quantity_deleted" => "required",
		];
		$messages = [
			"item_code.required" => "يرجي التأكد من إدخال كود الصنف",
			"invoice_parent.required" => "يرجي التأكد من إدخال رقم الفاتورة",
			"item_id.required" => "يرجي التأكد من إدخال معرف الصنف",
			"item_quantity.required" => "يرجي التأكد من إدخال الكمية الحالية للصنف",
			"item_quantity_deleted.required" => "يرجي التأكد من إدخال الكمية المراد حذفها",
			"item_quantity.greater_than_field" => "لايمكن حذف كمية اكبر من المتاح في المخزن",
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
			$check_item_net_quantity = DB::select(
				' SELECT 
				(
				(SELECT IFNULL(SUM(item_quantity),0) from store_items where item_code = '.$item_code.') - 
				(SELECT IFNULL(SUM(item_quantity),0) from solditems where item_code = '.$item_code.')  - 
				(SELECT IFNULL( SUM(item_quantity),0) from delete_items_from_store where item_code = '.$item_code.') + 
				(SELECT IFNULL( SUM(item_quantity),0) from reversing_invoice where item_code = '.$item_code.')
				) net_items '
			)[0]->net_items;
			if ($item_quantity <= $check_item_net_quantity){
				$insertDeletedData = DB::table("delete_items_from_store")->insert(
					[
						"invoice_number" => $invoice_parent,
						"item_id" => $item_id,
						"item_code" => $item_code,
						"item_quantity" => $item_quantity_deleted,
						"delete_reason" => $delete_reason,
						"created_by" => Auth::user()->id,
						"created_at" => Carbon::now()
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "لا يمكن صرف لأن الرصيد الصنف ".$item_code." غير كافي"
					]
				);
			}
		
			if ($insertDeletedData){
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}


	public function addSellInvoice(){
		$id = Input::get("id");
		$invoice_date = Input::get("invoice_date");
		$client_name = Input::get("client_name");
		$items_total_price = Input::get("items_total_price");
		$items_discount = Input::get("items_discount");
		$items_net_total = Input::get("items_net_total");
		$item_code = Input::get("item_code");
		$item_name = Input::get("item_name");
		$item_quantity = Input::get("item_quantity");
		$item_price = Input::get("item_price");
		$payment_method = Input::get("payment_method");
		$invoice_notice = Input::get("invoice_notice");
		$item_type = Input::get("item_type");
		$addons = Input::get("addons");
		$item_total_price = Input::get("item_total_price");

		$rules = [];
		$messages = [];

		$rules["id"] = "required|unique:solditems,invoice_number";
		$rules["invoice_date"] = "required";
		$rules["items_total_price"] = "required";
		$rules["items_net_total"] = "required";

		$messages["id.required"] = "فضلاً ضع رقم الفاتورة";
		$messages["id.unique"] = "رقم الفاتورة موجود مستخدم من قبل";
		$messages["invoice_date.required"] = "فضلاً ضع تاريخ الفاتورة";
		$messages["items_total_price.required"] = "إجمالي قيمة الفاتورة غير معرف";
		$messages["items_net_total.required"] = "صافي الفاتورة غير معرف";


		for($index = 0 ; $index<count($item_code); $index++ ){

			$rules["item_type.".$index] = "required|exists:items_type_definer,id";
			$rules["item_name.".$index] = "required";
			$rules["item_quantity.".$index] = "required";
			$rules["item_price.".$index] = "required";

			$messages["item_type.".$index.".required"] = "فضلاً ضع نوع الصنف في الصف رقم {$index}" ;
			$messages["item_type.".$index.".exists"] = "لم نتمكن من تحديد نوع الصنف في الصف رقم  {$index} " ;
			$messages["item_name.".$index.".required"] = "فضلاً ضع اسم الصنف في الصف رقم  {$index} " ;
			$messages["item_quantity.".$index.".required"] = "فضلاً كمية الصنف في الصف رقم  {$index} " ;
			$messages["item_price.".$index.".required"] = "فضلاً ضع سعر الصنف في الصف رقم  {$index} " ;
		}

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else {
			$insertData = DB::table("solditems")
			->insert([
				"invoice_number" => $id,
				"invoice_parent" => "",
				"invoice_date" => Carbon::parse($invoice_date)->format("Y-m-d"),
				"client_name" => $client_name,
				"items_total_price" => $items_total_price,
				"items_discount" => $items_discount,
				"payment_method" => $payment_method,
				"items_net_total" => $items_net_total,
				"invoice_notice" => $invoice_notice,
				"addons" => $addons,
				"created_by" => Auth::user()->id,
				"created_at" => Carbon::now()
			]);
			if ($insertData){
				for($index = 0 ; $index<count($item_code); $index++ ){
					$check_item_net_quantity = DB::select(
						' SELECT 
						(
						(SELECT IFNULL(SUM(item_quantity),0) from store_items where item_code = '.$item_name[$index].') - 
						(SELECT IFNULL(SUM(item_quantity),0) from solditems where item_code = '.$item_name[$index].')  - 
						(SELECT IFNULL( SUM(item_quantity),0) from delete_items_from_store where item_code = '.$item_name[$index].') +
						(SELECT IFNULL( SUM(item_quantity),0) from reversing_invoice where item_code = '.$item_name[$index].')
						) net_items '
					)[0]->net_items;

					if ($item_quantity[$index] > $check_item_net_quantity){
						$cleanData = DB::table("solditems")->where("invoice_number" , "=" , $id )->where("invoice_parent","=","")->delete();
						return $response = Response::json(
							[
								"errorsFounder" => 1,
								"messages"=> ["لا يمكن الصرف لأن رصيد الصنف ".$item_name[$index]." غير كافي"]
							]
						);
					}else{
						$getPaidPrice = DB::table("item_definer")->select("paid_price")->where("item_code","=",$item_name[$index])->first();
						$insertData = DB::table("solditems")
						->insert([
							"item_code" => $item_name[$index],
							"invoice_parent" => $id,
							"invoice_date" => Carbon::parse($invoice_date)->format("Y-m-d"),
							"item_type" => $item_type[$index],
							"item_quantity" => $item_quantity[$index],
							"item_price" => $item_price[$index],
							"paid_price" => $getPaidPrice->paid_price,
							"item_total_price" => $item_total_price[$index],
							"created_by" => Auth::user()->id,
							"created_at" => Carbon::now()
						]);
					}
				}
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}

	public function getStoreInvoiceItemsData () {
		$getStoreItemsData = DB::table("store_items")
		->where("invoice_parent","=","")
		->select(
			"store_items.invoice_number",
			"store_items.invoice_date",
			"store_items.provider_name"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getStoreReversingInvoiceItemsData () {
		$getStoreItemsData = DB::table("reversing_invoice")
		->where("invoice_parent","=","")
		->select(
			"reversing_invoice.invoice_number",
			"reversing_invoice.invoice_date",
			"reversing_invoice.provider_name"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getStoreItemsData () {
		$getStoreItemsData = DB::table("solditems")
		->where("invoice_parent","=","")
		->select(
			"solditems.invoice_number",
			"solditems.invoice_date",
			"solditems.items_net_total",
			"solditems.client_name",
			"solditems.invoice_notice"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getInvoiceDataTable() {
		$invoiceID = Input::get("invoiceID");
		$parentData = DB::table("solditems")
		->where("invoice_parent","=","")
		->where("invoice_number","=",$invoiceID)
		->select(
			"solditems.invoice_number",
			"solditems.invoice_date",
			"solditems.client_name",
			"solditems.invoice_notice",
			"solditems.items_net_total",
			"solditems.items_discount",
			"solditems.items_total_price",
			"solditems.addons"
		)
		->first();

		$childrenData = DB::table("solditems")
		->where("invoice_parent","=",$invoiceID)
		->join('items_type_definer','items_type_definer.id','=','solditems.item_type')
		->join('item_definer','item_definer.item_code','=','solditems.item_code')
		->get();

		return Response::json(["parent" => $parentData , "children" => $childrenData]);
	}

	public function getStoreItemsDataTable(){
		$invoiceID = Input::get("invoiceID");
		$parentData = DB::table("store_items")
		->where("invoice_parent","=","")
		->where("invoice_number","=",$invoiceID)
		->select(
			"store_items.invoice_number",
			"store_items.invoice_date",
			"store_items.provider_name",
			"store_items.invoice_notice",
			"store_items.items_net_total",
			"store_items.items_discount",
			"store_items.items_total_price",
			"store_items.addons"
		)
		->first();

		$childrenData = DB::table("store_items")
		->where("invoice_parent","=",$invoiceID)
		->join('items_type_definer','items_type_definer.id','=','store_items.item_type')
		->join('item_definer','item_definer.item_code','=','store_items.item_code')
		->get();

		return Response::json(["parent" => $parentData , "children" => $childrenData]);
	}

	public function getReversingInvoiceSingleItemsDataTable(){
		$invoiceID = Input::get("invoiceID");
		$parentData = DB::table("reversing_invoice")
		->where("invoice_parent","=","")
		->where("invoice_number","=",$invoiceID)
		->select(
			"reversing_invoice.invoice_number",
			"reversing_invoice.invoice_date",
			"reversing_invoice.provider_name",
			"reversing_invoice.invoice_notice",
			"reversing_invoice.items_net_total",
			"reversing_invoice.items_discount",
			"reversing_invoice.items_total_price",
			"reversing_invoice.addons"
		)
		->first();

		$childrenData = DB::table("reversing_invoice")
		->where("invoice_parent","=",$invoiceID)
		->join('items_type_definer','items_type_definer.id','=','reversing_invoice.item_type')
		->join('item_definer','item_definer.item_code','=','reversing_invoice.item_code')
		->get();

		return Response::json(["parent" => $parentData , "children" => $childrenData]);
	}

	public function getStoresItemsDataTable (){
		$getStoreItemsData = DB::table("item_definer")
		->join('items_type_definer','items_type_definer.id','=','item_definer.item_type_id')
		->select(
			"item_definer.item_code",
			"item_definer.item_name",
			"items_type_definer.item_type_name"
		);

		return Datatables::of($getStoreItemsData)->make();
	}

	public function getStoreItemDataTableInfo(){
		$invoiceID = Input::get("invoiceID");
		$parentData = DB::table("item_definer")
		->where("item_code","=",$invoiceID)
		->first();
		return Response::json(["parent" => $parentData]);
	}

	public function getItemSoldData(){
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
			$column = "invoice_number";
			// $orColumn = "container_id";
		} else {
			$column = "invoice_number";
		}


		$searchChildrenDataData = DB::table("solditems")
		->leftjoin("item_definer","item_definer.item_code","=","solditems.item_code")
		->where("solditems.invoice_parent","=","")
		->where("solditems.invoice_number","=",$keyword)
		->get();
		return Response::json(array("incomplete_results"=>false,"items"=> $searchChildrenDataData,"total_countParents"=>count($searchChildrenDataData),"lookingFor"=>$column));
	}

	public function getChildrenItemData() {
		$keyword = Input::get("keyword");
		$searchChildrenDataData = DB::select(
			" SELECT
				`solditems`.`item_code` AS `store_items_item_name`,	
				`item_quantity` as net_quantity,
				`item_definer`.`item_name` AS `item_definer_item_name`,
				`items_type_definer`.`item_type_name` AS `item_type_name`,
				`solditems`.`item_quantity` AS `item_quantity`,
				`solditems`.`id` AS `s_id`
			FROM
				`solditems`
			INNER JOIN `item_definer` ON `item_definer`.`item_code` = `solditems`.`item_code`
			INNER JOIN `items_type_definer` ON `items_type_definer`.`id` = `solditems`.`item_type`
			WHERE
				`solditems`.`invoice_parent` != ''
			AND `solditems`.`invoice_parent` = ".$keyword." "
		);

		return Response::json($searchChildrenDataData);
	}

	public function saveDeletedItemsSold(){
		$item_code = Input::get("item_code");
		$item_id = Input::get("item_id");
		$item_quantity = Input::get("item_quantity");
		$item_quantity_deleted = Input::get("item_quantity_deleted");

		 Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
	      $min_field = $parameters[0];
	      $data = $validator->getData();
	      $min_value = $data[$min_field];
	      return $value >= $min_value;
	    });   

	    Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
	      return str_replace(':field', $parameters[0], $message);
	    });

		$rules = [
			"item_code" => "required",
			"item_id" => "required",
			"item_quantity" => "required|greater_than_field:item_quantity_deleted",
			"item_quantity_deleted" => "required",
		];
		$messages = [
			"item_code.required" => "يرجي التأكد من إدخال كود الصنف",
			"item_id.required" => "يرجي التأكد من إدخال معرف الصنف",
			"item_quantity.required" => "يرجي التأكد من إدخال الكمية الحالية للصنف",
			"item_quantity_deleted.required" => "يرجي التأكد من إدخال الكمية المراد حذفها",
			"item_quantity.greater_than_field" => "لايمكن حذف كمية اكبر من المتاح في الفاتورة",
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

			$getItemsData = DB::table("solditems")->where("id","=",$item_id)->first();
			$invoice_parent = $getItemsData->invoice_parent;
			$getItemsDataInvoice = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoice_parent)->first();
			$invoice_notice = $getItemsDataInvoice->invoice_notice;
			
			// return Response::json(["item"=>$getItemsData,"invoice"=>$getItemsDataInvoice]);

			if ($item_quantity_deleted <= $getItemsData->item_quantity){
				$insertDeletedData = DB::table("solditems")->where("id","=",$item_id)->update(
					[
						"item_quantity" => $getItemsData->item_quantity - $item_quantity_deleted,
						"item_total_price" => ($getItemsData->item_quantity - $item_quantity_deleted) * $getItemsData->item_price,
						"created_by" => Auth::user()->id,
						"updated_at" => Carbon::now()
					]
				);

				if ($insertDeletedData){
					$insertDeletedInvoiceData_conf = DB::select(
						" SELECT SUM(item_total_price) as item_total_price FROM solditems WHERE invoice_parent = {$invoice_parent} AND invoice_parent != ''"
					);

					$checkIfItemsDiscountIsPercents = "";

					if (($getItemsDataInvoice->items_total_price - $getItemsDataInvoice->items_net_total) == ($getItemsDataInvoice->items_total_price ) * ($getItemsDataInvoice->items_discount / 100)){
						$checkIfItemsDiscountIsPercents = "percentage";
						$item_net_calc = ($insertDeletedInvoiceData_conf[0]->item_total_price) - (($insertDeletedInvoiceData_conf[0]->item_total_price) * $getItemsDataInvoice->items_discount / 100);
					}else{
						if ($getItemsDataInvoice->addons > 0){
							if ((($getItemsDataInvoice->items_total_price + $getItemsDataInvoice->addons) - $getItemsDataInvoice->items_net_total) == ($getItemsDataInvoice->items_total_price + $getItemsDataInvoice->addons) * ($getItemsDataInvoice->items_discount / 100)){
								$checkIfItemsDiscountIsPercents = "percentage";
								$item_net_calc = ($insertDeletedInvoiceData_conf[0]->item_total_price + $getItemsDataInvoice->addons) - (($insertDeletedInvoiceData_conf[0]->item_total_price + $getItemsDataInvoice->addons) * $getItemsDataInvoice->items_discount / 100);
							}else{
								$checkIfItemsDiscountIsPercents = "pureValue";
								$item_net_calc = ($insertDeletedInvoiceData_conf[0]->item_total_price + $getItemsDataInvoice->addons) - $getItemsDataInvoice->items_discount;
							}
						}else{
							$checkIfItemsDiscountIsPercents = "pureValue";
							$item_net_calc = ($insertDeletedInvoiceData_conf[0]->item_total_price + $getItemsDataInvoice->addons) - $getItemsDataInvoice->items_discount;
						}

					}

					if ($insertDeletedInvoiceData_conf[0]->item_total_price == 0){
						$insertDeletedInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoice_parent)->update(
							[
								"items_total_price" => 0,
								"items_net_total" => 0,
								"addons" => 0,
								"items_discount" => 0,
								"payment_method" => 0,
								"invoice_notice" => " {$invoice_notice} \n يوجد كمية مرتجعة لهذة الفاتورة [كود الصنف المرتجع : {$item_code} الكمية المرتجعة : {$item_quantity_deleted} ]",
								"created_by" => Auth::user()->id,
								"updated_at" => Carbon::now()
							]
						);
					}else{
						$insertDeletedInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoice_parent)->update(
							[
								"items_total_price" =>$insertDeletedInvoiceData_conf[0]->item_total_price,
								"items_net_total" => $item_net_calc,
								"invoice_notice" => " {$invoice_notice} \n يوجد كمية مرتجعة لهذة الفاتورة [كود الصنف المرتجع : {$item_code} الكمية المرتجعة : {$item_quantity_deleted} ]",
								"created_by" => Auth::user()->id,
								"updated_at" => Carbon::now()
							]
						);
					}
				}
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "لا يمكن صرف لأن الرصيد الصنف ".$item_code." في الفاتورة غير كافي"
					]
				);
			}
		
			if ($insertDeletedData){
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}

	public function editInvoiceDate(){
		if (Auth::user()->users_rights == 4){
			$invoiceID = Input::get("invoice_id");
			$invoice_date = Input::get("invoice_date");
			$getInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoiceID)->first();
			$invoice_notice = $getInvoiceData->invoice_notice;

			if ($invoice_date == "" || $invoiceID == ""){
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> ["لا يمكن إتمام العملية نظراً لعد توافر معرف الفاتورة علي النظام او ان تاريخ الفاتورة الجديد غير معرف"]
					]
				);
			}
			$insertDeletedInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoiceID)->update(
				[
					"invoice_date" => $invoice_date,
					"invoice_notice" => " {$invoice_notice} \n تم تعديل تاريخ الفاتورة من تاريخ {$getInvoiceData->invoice_date} إلي تاريخ {$invoice_date}",
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]
			);

			if ($insertDeletedInvoiceData){
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> ["خطأ في الإتصال بقاعدة البيانات"]
					]
				);
			}
		}else{
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=> ["عفواً لا تملك تصريح بإستخدام هذة الصلاحية"]
				]
			);
		}
	}

	public function deleteInvoiceDate(){
		if (Auth::user()->users_rights == 4){
			$invoiceID = Input::get("invoice_id");
			$getInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoiceID)->first();
			$invoice_notice = $getInvoiceData->invoice_notice;

			// return  Response::json($getInvoiceData);
			if ($invoiceID == ""){
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> ["لا يمكن إتمام العملية نظراً لعد توافر معرف الفاتورة علي النظام"]
					]
				);
			}
			$insertDeletedInvoiceData = DB::table("solditems")->where("invoice_parent","=","")->where("id","=",$invoiceID)->update(
				[
					"invoice_notice" => " {$invoice_notice} \n تم حذف رصيد هذة الفاتورة",
					"items_net_total" => 0,
					"items_total_price" => 0,
					"addons" => 0,
					"items_discount" => 0,
					"created_by" => Auth::user()->id,
					"updated_at" => Carbon::now()
				]
			);

			if ($insertDeletedInvoiceData){
				$insertDeletedInvoiceDataItems = DB::table("solditems")->where("invoice_parent","!=","")->where("invoice_parent","=",$invoiceID)->delete();
				if ($insertDeletedInvoiceDataItems){
					return $response = Response::json(
						[
							"errorsFounder" => 0,
							"messages"=> "تم حذف البيانات بنجاح"
						]
					);
				}else{
					return $response = Response::json(
						[
							"errorsFounder" => 1,
							"messages"=> ["خطأ في الإتصال بقاعدة البيانات"]
						]
					);
				}
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> ["خطأ في الإتصال بقاعدة البيانات"]
					]
				);
			}
		}else{
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=> ["عفواً لا تملك تصريح بإستخدام هذة الصلاحية"]
				]
			);
		}
	}

	public function add_reversing_invoice(){
		$id = Input::get("id");
		$invoice_date = Input::get("invoice_date");
		$provider_name = Input::get("provider_name","إرجاع اصناف");
		$items_total_price = Input::get("items_total_price");
		$items_discount = Input::get("items_discount");
		$items_net_total = Input::get("items_net_total");
		$item_code = Input::get("item_code");
		$item_name = Input::get("item_name");
		$item_quantity = Input::get("item_quantity");
		$item_price = Input::get("item_price");
		$payment_method = Input::get("payment_method");
		$invoice_notice = Input::get("invoice_notice");
		$item_type = Input::get("item_type");
		$item_total_price = Input::get("item_total_price");

		$rules = [];
		$messages = [];

		$rules["id"] = "required|unique:reversing_invoice,invoice_number";
		$rules["invoice_date"] = "required";
		$rules["items_total_price"] = "required";
		$rules["items_net_total"] = "required";

		$messages["id.required"] = "فضلاً ضع رقم الفاتورة";
		$messages["id.unique"] = "رقم الفاتورة موجود مستخدم من قبل";
		$messages["invoice_date.required"] = "فضلاً ضع تاريخ الفاتورة";
		$messages["items_total_price.required"] = "إجمالي قيمة الفاتورة غير معرف";
		$messages["items_net_total.required"] = "صافي الفاتورة غير معرف";


		for($index = 0 ; $index<count($item_code); $index++ ){

			$rules["item_type.".$index] = "required|exists:items_type_definer,id";
			$rules["item_name.".$index] = "required";
			$rules["item_quantity.".$index] = "required";
			$rules["item_price.".$index] = "required";

			$messages["item_type.".$index.".required"] = "فضلاً ضع نوع الصنف في الصف رقم {$index}" ;
			$messages["item_type.".$index.".exists"] = "لم نتمكن من تحديد نوع الصنف في الصف رقم  {$index} " ;
			$messages["item_name.".$index.".required"] = "فضلاً ضع اسم الصنف في الصف رقم  {$index} " ;
			$messages["item_quantity.".$index.".required"] = "فضلاً كمية الصنف في الصف رقم  {$index} " ;
			$messages["item_price.".$index.".required"] = "فضلاً ضع سعر الصنف في الصف رقم  {$index} " ;
		}

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()){
			return $response = Response::json(
				[
					"errorsFounder" => 1,
					"messages"=>$validator->errors()->toArray()
				]
			);
		}else {
			$insertData = DB::table("reversing_invoice")
			->insert([
				"invoice_number" => $id,
				"invoice_parent" => "",
				"invoice_date" => $invoice_date,
				"provider_name" => "إرجاع أصناف",
				"items_total_price" => $items_total_price,
				"items_discount" => $items_discount,
				"payment_method" => $payment_method,
				"items_net_total" => $items_net_total,
				"invoice_notice" => $invoice_notice,
				"started_quantity_flage" => 0,
				"created_by" => Auth::user()->id,
				"created_at" => Carbon::now()
			]);
			if ($insertData){
				for($index = 0 ; $index<count($item_code); $index++ ){
					$insertData = DB::table("reversing_invoice")
					->insert([
						"item_code" => $item_name[$index],
						"invoice_parent" => $id,
						"item_name" => $item_name[$index],
						"item_type" => $item_type[$index],
						"item_quantity" => $item_quantity[$index],
						"item_price" => $item_price[$index],
						"item_total_price" => $item_total_price[$index],
						"created_by" => Auth::user()->id,
						"created_at" => Carbon::now()
					]);
				}
				return $response = Response::json(
					[
						"errorsFounder" => 0,
						"messages"=> "تم إدخال البيانات بنجاح"
					]
				);
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> "خطأ في الإتصال بقاعدة البيانات"
					]
				);
			}
		}
	}

	public function deleteServiceFromInvoiceItem() {
		$link_id  = Input::get("link_id");

		$getLinkData = DB::table("sell_invoice_with_service")->where("id","=",$link_id)->first();

		if ($getLinkData){
			$deleteServiceFromList = DB::table("{$getLinkData->table_name}")->where("id","=",$getLinkData->service_id)->delete();
		}

		if ($deleteServiceFromList){
			$deleteLink =  DB::table("sell_invoice_with_service")->where("id","=",$link_id)->delete();
			return Response::json(
				[
					"errorsFounder" => 0,
					"messages"=> ["تم حذف بيانات الخدمة بنجاح"]
				]
			);
		}else{
			return Response::json(
				[
					"errorsFounder" => 1,
					"messages"=> ["خطأ في حذف بيانات الخدمة"]
				]
			);
		}
	}

	public function deleteAllServiceFromInvoiceItem(){
		$link_id  = Input::get("invoice_id");

		$getLinkData = DB::table("sell_invoice_with_service")->where("invoice_id","=",$link_id)->get();

		foreach($getLinkData as $data){
			$deleteServiceFromList = DB::table("{$data->table_name}")->where("id","=",$data->service_id)->delete();
		}

		if ($deleteServiceFromList){
			$deleteLink =  DB::table("sell_invoice_with_service")->where("invoice_id","=",$link_id)->delete();
			return Response::json(
				[
					"errorsFounder" => 0,
					"messages"=> ["تم حذف بيانات الخدمة بنجاح"]
				]
			);
		}else{
			return Response::json(
				[
					"errorsFounder" => 1,
					"messages"=> ["خطأ في حذف بيانات الخدمة"]
				]
			);
		}
	}
}