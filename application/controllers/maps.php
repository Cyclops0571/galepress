<?php

class Maps_Controller extends Base_Controller {

	public $restful = true;
	public $table = 'GoogleMap';
	public $pk = 'GoogleMapID';
	public $page = 'maps';
	public $route = '';
	public $fields = '';
	public $caption = '';

	public function __construct() {
		parent::__construct();
		$this->route = __('route.' . $this->page);
		$this->caption = __('common.maps_caption');
		$this->fields = array();
		$this->fields[] = array(__('common.maps_list_name'), 'Name');
		$this->fields[] = array(__('common.maps_list_address'), 'Address');
		$this->fields[] = array(__('common.maps_list_description'), 'Description');
		$this->fields[] = array(__('common.maps_list_latitude'), 'Latitude');
		$this->fields[] = array(__('common.maps_list_longitude'), 'Longitude');
		$this->fields[] = array(__('common.maps_list_google_map_id'), 'GoogleMapID');
		if (Auth::User() && (int) Auth::User()->UserTypeID == eUserTypes::Manager) {
			$this->fields = array();
			$this->fields[] = array(__('common.maps_list_customer'), 'CustomerName');
			$this->fields[] = array(__('common.maps_list_application'), 'ApplicationName');
			$this->fields[] = array(__('common.maps_list_name'), 'Name');
			$this->fields[] = array(__('common.maps_list_latitude'), 'Latitude');
			$this->fields[] = array(__('common.maps_list_longitude'), 'Longitude');
			$this->fields[] = array(__('common.maps_list_google_map_id'), 'GoogleMapID');
		}
	}

	public function get_index() {
		$search = trim(Input::get('search', ''));
		$applicationID = (int) Input::get("applicationID", 0);
		$rowCount = (int) Config::get('custom.rowcount');
		$sort = Input::get('sort', $this->pk);
		$sort_dir = Input::get('sort_dir', 'DESC');
		$page = Input::get('page', 1);

		if (!Common::CheckApplicationOwnership($applicationID)) {
			return Redirect::to(__('route.home'));
		}

		$markerSetQuery = DB::table('GoogleMap')
				->where('StatusID', '=', eStatus::Active);
		if (!empty($search)) {
			$markerSetQuery->where(function($query) use ($search) {
				$searchWord = '%' . $search . '%';
				$query->where('Name', 'LIKE', $searchWord);
				$query->or_where('Address', 'LIKE', $searchWord);
				$query->or_where('Description', 'LIKE', $searchWord);
			});
		}
		if ((int) Auth::User()->UserTypeID != eUserTypes::Manager) {
			$markerSetQuery->where('ApplicationID', '=', $applicationID);
		} else {
			$markerSetQuery->join('Application as a', function($join) {
				$join->on('a.ApplicationID', '=', 'GoogleMap.ApplicationID');
				$join->on('a.StatusID', '=', eStatus::Active);
			});

			$markerSetQuery->join('Customer AS c', function($join) {
				$join->on('a.CustomerID', '=', 'c.CustomerID');
				$join->on('c.StatusID', '=', eStatus::Active);
			});
		}

		$markerSetCount = $markerSetQuery->count();
		$markerSet = $markerSetQuery->order_by($sort, $sort_dir)->for_page($page, $rowCount)->get();
		$rows = Paginator::make($markerSet, $markerSetCount, $rowCount);

		$data = array();
		$data['route'] = $this->route;
		$data['caption'] = $this->caption;
		$data['pk'] = $this->pk;
		$data['search'] = $search;
		$data['sort'] = $sort;
		$data['sort_dir'] = $sort_dir;
		$data['page'] = $this->page;
		$data['fields'] = $this->fields;
		$data['rows'] = $rows;

		return View::make("pages." . Str::lower($this->table) . "list", $data)
						->nest('filterbar', 'sections.filterbar', $data)
						->nest('commandbar', 'sections.commandbar', $data);
	}

	public function get_show($id) {
		$googleMap = GoogleMap::find($id);
		if (!$googleMap) {
			return Redirect::to($this->route);
		}

		$data = array();
		$data["applicationID"] = (int) Input::get('applicationID', '0');
		$data["googleMap"] = $googleMap;
		return View::make("pages." . Str::lower($this->table) . "detail", $data);
	}

	public function get_new() {
		$data = array();
		$data["ApplicationID"] = (int) Input::get('applicationID', '0');
		$data["googleMap"] = FALSE;
		return View::make('pages.' . Str::lower($this->table) . 'detail', $data);
	}

	public function post_save() {
		$applicationID = (int) Input::get('applicationID', '0');
		$GoogleMapID = (int) Input::get($this->pk, '0');
		$name = Input::get('name', '');
		$address = Input::get('address', '');
		$description = Input::get('description', '');
		$latitude = Input::get('latitude', '');
		$longitude = Input::get('langitude', '');
		$chk = Common::CheckApplicationOwnership($applicationID);
		$rules = array(
			'applicationID' => 'required|integer|min:1',
			'latitude' => 'required',
			'langitude' => 'required',
			'name' => 'required'
		);
		$v = Validator::make(Input::all(), $rules);
		if (!$v->passes()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_incorrect_input'));
		}
		if (!$chk) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}

		if ($GoogleMapID == 0) {
			$googleMap = new GoogleMap();
			$googleMap->ApplicationID = $applicationID; //after first create appID can not be changed;
		} else {
			$googleMap = GoogleMap::find($GoogleMapID);
			if (!$googleMap->CheckOwnership($applicationID)) {
				throw new Exception("Unauthorized user attempt");
			}
		}

		$googleMap->Name = $name;
		$googleMap->Address = $address;
		$googleMap->Description = $description;
		$googleMap->Latitude = $latitude;
		$googleMap->Longitude = $longitude;
		$googleMap->StatusID = eStatus::Active;
		$googleMap->save();
		return "success=" . base64_encode("true");
	}

	public function get_location($applicationID) {
		if (!Common::CheckApplicationOwnership($applicationID)) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		
		$googleMapSet = GoogleMap::where('ApplicationID', '=', $applicationID)->where("statusID", "=", eStatus::Active)->get();
		
		$data = array();
		$data["googleMapSet"] = $googleMapSet;
		return View::make("pages." . Str::lower($this->table) . "location", $data);
	}
	
	public function get_webview($applicationID) {
		$application = Application::find($applicationID);
		if (!$application) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		
		$googleMapSet = GoogleMap::where('ApplicationID', '=', $application->ApplicationID)->where("statusID", "=", eStatus::Active)->get();
		
		$data = array();
		$data["googleMapSet"] = $googleMapSet;
		return View::make("pages." . Str::lower($this->table) . "webview", $data);
	}

}
