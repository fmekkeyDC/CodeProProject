<?php

class HomeController extends BaseController {

	protected $public_path;
	protected $system_name;
	protected $system_lang;
	protected $tpl_name;
	protected $userdata;

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function __construct(){
		$this->public_path = "public/layout/";
		$this->system_name = "CodePro|MyZoo project";
		$this->system_lang = "AR";
		$this->tpl_name = "content";
		$this->userdata = Auth::user();
		$this->systemCheck();
		$this->checkRight();
	}

	//routing handler

	public function login(){
		return View::make('layout.login')
		->with("public_path",$this->public_path)
		->with("system_name",$this->system_name."|LOGIN")
		// ->with("system_apps",$this->getAppsData())
		->with("tpl_name",$this->tpl_name)
		->with("system_lang",$this->system_lang);
	}

	public function loginToSystem() {
		$username = Input::get("username");
		$userpassword = Input::get("userpassword");
		// $user = User::find(1);

		// return Auth::login($user);
		$rules = [
			"username" => "required",
			"userpassword" => "required",
		];

		$messages = [
			"username.required" => "فضلاً ضع اسم المستخدم",
			"userpassword.required" => "فضلاً ضع كلمة المرور للمستخدم",
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
			// return Auth::attempt(array('username' => $username, 'userpassword' => $userpassword));
			if (Auth::attempt(array('username' => $username, 'userpassword' => $userpassword)))
			{
			    return $response = [
					"errorsFounder" => 0,
					"messages"=> ["جاري تسجيل الدخول للنظام"]
				];
			}else{
				return $response = Response::json(
					[
						"errorsFounder" => 1,
						"messages"=> ["خطأ في إسم المستخدم او كلمة المرور"]
					]
				);
			}
		}
	}
	public function logout(){
		Auth::logout();
		return Redirect::intended('/');
	}

	public function home () {
		return View::make('layout.holder')
		->with("public_path",$this->public_path)
		->with("system_name",$this->system_name)
		->with("system_apps",$this->getAppsData())
		->with("tpl_name",$this->tpl_name)
		->with("system_lang",$this->system_lang);
	}

	public function application_manager(){
		$this->tpl_name = "application_manager";
		$listOfOptions = [1 => "فعال" , 2 => "غير فعال"];

		$appsParents = [0=>"تطبيق رئيسي"];

		foreach($this->getAppsParents()["parent"] as $parents){
			$appsParents[$parents->id] = $parents->app_name;
		}

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("listOfOptions",$listOfOptions)
			->with("appsParents",$appsParents)
			->with("getAppsParents",$this->getAppsParents("all"))
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("listOfOptions",$listOfOptions)
			->with("appsParents",$appsParents)
			->with("getAppsParents",$this->getAppsParents("all"))
			->with("system_lang",$this->system_lang);
		}
	}

	public function store_item_definer(){
		$this->tpl_name = "store_item_definer";

		$listOfItemsTypes = [""];

		foreach($this->get_items_types() as $itemTypes){
			$listOfItemsTypes[$itemTypes->id] = $itemTypes->item_type_name;
		}

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("listOfItemsTypes",$listOfItemsTypes)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("listOfItemsTypes",$listOfItemsTypes)
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	public function add_items_to_store () {
		$this->tpl_name = "add_items_to_store";

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('store_items'))
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('store_items'))
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	public function reversing_invoice () {
		$this->tpl_name = "reversing_invoice";

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('reversing_invoice'))
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('reversing_invoice'))
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	

	public function delete_item_from_stroe () {
		$this->tpl_name = "delete_item_from_stroe";

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	public function reverseItems () {
		$this->tpl_name = "reverseItems";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	

	public function define_item_groups () {
		$this->tpl_name = "define_item_groups";

		$getItemsGroups = DB::table("items_type_definer")->get();

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getItemsGroups",$getItemsGroups)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getItemsGroups",$getItemsGroups)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	public function sell_invoice () {
		$this->tpl_name = "sell_invoice";

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('solditems'))
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("getNextItemsOnStoresID",$this->getNextItemsOnStoresID('solditems'))
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}
	
	public function cash_control () {
		$this->tpl_name = "cash_control";

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}
	}

	public function users_adminstraions(){
		$this->tpl_name = "users_adminstraions";

		$listOfOptions = [1 => "الإطلاع" , 2 => "الإضافة" , 3 => "تعديل" , 4 => "الحذف"];
		$usersAppsRight = [];

		foreach($this->getAppsData()["children"] as $apps){
			$usersAppsRight[$apps->id] = $apps->app_name;
		}

		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("usersAppsRight",$usersAppsRight)
			->with("listOfOptions",$listOfOptions)
			->with("getAppsParents",$this->getAppsParents("all"))
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("usersAppsRight",$usersAppsRight)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("listOfOptions",$listOfOptions)
			->with("getAppsParents",$this->getAppsParents("all"))
			->with("system_lang",$this->system_lang);
		}
	}


	public function services_definer (){
		$this->tpl_name = "services_definer";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}
	public function Hosting (){

		$getHostingServicesType = DB::table("services_definer")->where("service_type","=",1)->get();

		$listOfServices = [];

		foreach($getHostingServicesType as $servicesList){
			$listOfServices[$servicesList->id] = $servicesList->service_name;
		}

		$this->tpl_name = "Hosting";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("listOfServices",$listOfServices)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("listOfServices",$listOfServices)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}
	public function Check (){
		$this->tpl_name = "Check";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}

	public function other_services (){
		$this->tpl_name = "other_services";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}

	
	public function shower (){
		$getHostingServicesType = DB::table("services_definer")->where("service_plan","=",4)->get();

		// return Response::json($getHostingServicesType);
		$listOfServices = [];

		foreach($getHostingServicesType as $servicesList){
			$listOfServices[$servicesList->id] = $servicesList->service_name;
		}
		$this->tpl_name = "shower";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("listOfServices",$listOfServices)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("listOfServices",$listOfServices)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}
	public function shaving (){
		$getHostingServicesType = DB::table("services_definer")->where("service_plan","=",6)->get();
		$getHostingServicesType_2 = DB::table("services_definer")->where("service_plan","=",5)->get();

		// return Response::json($getHostingServicesType);
		$listOfServices = [];
		$listOfServices_2 = [];

		foreach($getHostingServicesType as $servicesList){
			$listOfServices[$servicesList->id] = $servicesList->service_name;
		}

		foreach($getHostingServicesType_2 as $servicesList_2){
			$listOfServices_2[$servicesList_2->id] = $servicesList_2->service_name;
		}
		
		$this->tpl_name = "shaving";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("listOfServices",$listOfServices)
			->with("listOfServices_2",$listOfServices_2)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("listOfServices",$listOfServices)
			->with("listOfServices_2",$listOfServices_2)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}
	
	// reports

	public function barcode_report () {
		$getBarCodesData = DB::table("print_barcode")->get();
		$this->tpl_name = "barcode_report";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("getBarCodesData",$getBarCodesData)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("getBarCodesData",$getBarCodesData)
			->with("system_lang",$this->system_lang);
		}
	}

	public function sales_details_report () {
		$this->tpl_name = "sales_details_report";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}

	public function sales_total_per_day () {
		$this->tpl_name = "sales_total_per_day";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}

	

	public function store_inventory () {
		$this->tpl_name = "store_inventory";

		$getReportQuery = DB::select("
				SELECT DISTINCT item_definer.item_name , item_definer.item_code , item_definer.re_request_point , 
				(SELECT IFNULL(sum(`store_items`.`item_quantity`),0) FROM store_items WHERE `store_items`.`item_name` = item_definer.item_code) + (SELECT IFNULL(SUM(item_quantity),0) FROM reversing_invoice where reversing_invoice.item_code =  item_definer.item_code) - (SELECT IFNULL(SUM(item_quantity),0) FROM delete_items_from_store where delete_items_from_store.item_code =  item_definer.item_code) - (SELECT IFNULL(sum(`solditems`.`item_quantity`),0) FROM solditems WHERE `solditems`.`item_code` = item_definer.item_code) as net_quantity
					FROM item_definer
					LEFT JOIN store_items
				    	ON store_items.item_name = item_definer.item_code 
		");
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang)
			->with("getReportQuery",$getReportQuery)
			->with("getReportQueryLength",count($getReportQuery));
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang)
			->with("getReportQuery",$getReportQuery)
			->with("getReportQueryLength",count($getReportQuery));
		}
	}
	
	public function printBarCodesFromStoresInvoice () {
		$this->tpl_name = "printBarCodesFromStoresInvoice";
		if (Request::ajax()){
			return View::make('layout.'.$this->tpl_name)
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("system_apps",$this->getAppsData())
			->with("tpl_name",$this->tpl_name)
			->with("system_lang",$this->system_lang);
		}else{
			return View::make('layout.holder')
			->with("public_path",$this->public_path)
			->with("system_name",$this->system_name)
			->with("tpl_name",$this->tpl_name)
			->with("system_apps",$this->getAppsData())
			->with("system_lang",$this->system_lang);
		}
	}
	

	//core handler



	public function get_items_types(){
		$items_type_query = DB::table("items_type_definer")->get();
		return $items_type_query;
	}

	public function getAppsData(){
		if (Auth::user()->id == 1){
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->where("parent","!=",0)->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}
			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->orderBy("sort","ASC")->get();
		}else{
			$getUserApps = DB::table("users")->where("id","=",$this->userdata->id)->select("users_apps")->first();
			$getAppsQuery = unserialize($getUserApps->users_apps);
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->whereIn("id",$getAppsQuery)->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}
			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->orderBy("sort","ASC")->whereIn("id",$apps_child_lists)->get();
		}
		return ["parent" => $getParent,"children" => $getChildren];
	}

	public static function getAppsParents ($returnMethod="normal") {
		if (Auth::user()->id == 1){
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}

			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->orderBy("sort","asc")->get();
			
		}else{
			$getUserApps = DB::table("users")->where("id","=",Auth::user()->id)->select("users_apps")->first();
			$getAppsQuery = unserialize($getUserApps->users_apps);
			$getChildren = DB::table("applications")->where("app_active","=",1)->where("parent","!=",0)->whereIn("id",$getAppsQuery)->orderBy("sort","asc")->get();
			$apps_child_lists = [];
			foreach($getChildren as $childs){
				$apps_child_lists [] = $childs->parent;
			}

			$getParent = DB::table("applications")->where("app_active","=",1)->where("parent","=",0)->whereIn("id",$apps_child_lists)->orderBy("sort","asc")->get();
		}

		if ($returnMethod == "normal"){
			return ["parent"=>$getParent,"children"=>$getChildren];
		}else if ($returnMethod == "all"){

			$getAllParents = DB::select("SELECT * FROM applications where app_active = 1 order by sort ASC");
			return $getAllParents;

		}else{
			App::abort(500, 'badRequestMethod');
		}
	}

	public static function next_item_id(){
		$result = DB::select("
		    SHOW TABLE STATUS LIKE 'item_definer'
		");
		return $next_increment = $result[0]->Auto_increment;
	}

	public static function getNextItemsOnStoresID ($tableName) {
		$result = DB::select("
		    SHOW TABLE STATUS LIKE '".$tableName."'
		");
		return $next_increment = $result[0]->Auto_increment;
	}


	public static function getServicePrices(){
		$id = Input::get("id");
		$servicePrice = DB::table("services_definer")->where("id","=",$id)->select("service_price")->first()->service_price;
		return Response::json(["servicePrice" => $servicePrice]);
	}

	public static function getLastInvoiceNumber(){
		$query = "";
		if (DB::table("solditems")->select("id")->where("invoice_parent","=","")->orderBy("id","desc")->limit(1)->count() > 0){
			$query = DB::table("solditems")->select("id")->where("invoice_parent","=","")->orderBy("id","desc")->limit(1)->first()->id;
		}
		return Response::json(["lastInvoiceNumber"=>$query]);
	}

	public function getServicesWithInvoice () {
		$getServiceData = DB::table("sell_invoice_with_service")->where("invoice_id","=",Input::get("invoice_id"))->get();
		$totalPrice = DB::select(" SELECT SUM(price) totalPrice FROM sell_invoice_with_service WHERE invoice_id = ".Input::get('invoice_id')."")[0]->totalPrice;
		return Response::json(["data" => $getServiceData , "totalPrice" => $totalPrice]);
	}


	public function migrateItems () {
		$getparentIDs = DB::table("store_items")->select("invoice_number")->where("invoice_parent","=","")->get();

		foreach($getparentIDs as $parent_id){
			$getchildrenItemPrices = DB::table("store_items")
			->where("invoice_parent","!=",0)
			->where("invoice_parent" , "=" , $parent_id->invoice_number)
			->select("invoice_parent","items_total_price","items_discount","items_net_total","addons")
			->get();

			foreach($getchildrenItemPrices as $childrenPricse){
				// $updateRecords = DB::table("store_items")
				// ->where("invoice_parent","=","")
				// ->where("id" , "=" , $childrenPricse->invoice_parent)
				// ->update(
				// 	[
				// 		"items_total_price" => $childrenPricse->items_total_price ,
				// 		"items_net_total" => $childrenPricse->items_net_total ,
				// 		"items_discount" => $childrenPricse->items_discount ,
				// 		"addons" => $childrenPricse->addons 
				// 	]
				// 	);

				$updateRecords = DB::table("store_items")
				->where("invoice_parent","!=","")
				->where("invoice_parent" , "=" , $parent_id->invoice_number)
				->update(
					[
						"items_total_price" => 0 ,
						"items_net_total" => 0 ,
						"items_discount" => 0 ,
						"addons" => 0
					]
					);

				echo "<pre>";
				echo $parent_id->invoice_number . " => " . $childrenPricse->invoice_parent;
				echo "</pre>";
			}
		}
	}

	public function checkRight() {
		if (Auth::check() && Auth::user()->id != 1 && (in_array(explode("@", Route::currentRouteAction())[1] ,["home","logout","login"]) == false) ){
			$route_name =  (explode("@", Route::currentRouteAction())[1]);

			$getRouteID = DB::table("applications")->where("parent","!=",0)->where("app_route","=",$route_name)->first();

			if (count($getRouteID) > 0){
				$userPrs = unserialize(Auth::user()->users_apps);
				if (in_array($getRouteID->id, array_values($userPrs)) == false){
					return App::abort("401", "Unauthorized codepro security system");
				}
			}
		}
	}


	public function systemCheck(){
		$command = exec('GETMAC -nh');
		$command = trim(explode(" \Device\Tcpip_",$command)[0]);
		$laravel_cmd_code = Config::get("app.laravel_cmd_code");
		// return;
		if (!Hash::check($command, $laravel_cmd_code)){
			// throw new \InvalidArgumentException('please contact with code pro systems 01147338385 - 01100773924');
			return App::abort("401","please contact with code pro systems 01147338385 - 01100773924");
		}
	}

	public function sha1Enc(){
		$code = Hash::make((Input::get("code",0)));
		return $code;
	}
}
