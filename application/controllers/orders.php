<?php

class Orders_Controller extends Base_Controller {

    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;

    public function __construct() {
	parent::__construct();
	$this->page = 'orders';
	$this->route = __('route.' . $this->page);
	$this->table = 'Order';
	$this->pk = 'OrderID';
	$this->caption = __('common.orders_caption');
	$this->detailcaption = __('common.orders_caption_detail');
	$this->fields = array(
	    0 => array('55px', __('common.orders_list_column1'), 'OrderNo'),
	    1 => array('', __('common.orders_list_column2'), 'Name'),
	    2 => array('150px', __('common.orders_list_column3'), 'Website'),
	    3 => array('150px', __('common.orders_list_column4'), 'Email'),
	    4 => array('75px', __('common.orders_list_column5'), 'OrderID')
	);
    }

    public function get_index() {
	$currentUser = Auth::user();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    try {
		$applicationID = (int) Input::get('applicationID', 0);
		$search = Input::get('search', '');
		$sort = Input::get('sort', $this->pk);
		$sort_dir = Input::get('sort_dir', 'DESC');
		$rowcount = (int) Config::get('custom.rowcount');
		$p = Input::get('page', 1);

		$sql = '' .
			'SELECT ' .
			'o.ApplicationID, ' .
			'o.OrderNo, ' .
			'o.Name, ' .
			'o.Description, ' .
			'o.Keywords, ' .
			'o.Website, ' .
			'o.Email, ' .
			'o.OrderID ' .
			'FROM `Order` AS o ' .
			'WHERE o.StatusID=1';

		$rs = DB::table(DB::raw('(' . $sql . ') t'))
			->where(function($query) use($applicationID, $search) {
			    if ($applicationID > 0) {
				$query->where('ApplicationID', '=', $applicationID);
			    }

			    if (strlen(trim($search)) > 0) {
				$query->where('ApplicationID', 'LIKE', '%' . $search . '%');
				$query->or_where('OrderNo', 'LIKE', '%' . $search . '%');
				$query->or_where('Name', 'LIKE', '%' . $search . '%');
				$query->or_where('Description', 'LIKE', '%' . $search . '%');
				$query->or_where('Keywords', 'LIKE', '%' . $search . '%');
				$query->or_where('OrderID', 'LIKE', '%' . $search . '%');
			    }
			})
			->order_by($sort, $sort_dir);

		$count = $rs->count();
		$results = $rs
			->for_page($p, $rowcount)
			->get();

		$rows = Paginator::make($results, $count, $rowcount);

		$data = array(
		    'page' => $this->page,
		    'route' => $this->route,
		    'caption' => $this->caption,
		    'pk' => $this->pk,
		    'fields' => $this->fields,
		    'search' => $search,
		    'sort' => $sort,
		    'sort_dir' => $sort_dir,
		    'rows' => $rows
		);
		return View::make('pages.' . Str::lower($this->table) . 'list', $data)
				->nest('filterbar', 'sections.filterbar', $data)
				->nest('commandbar', 'sections.commandbar', $data);
	    } catch (Exception $e) {
		throw new Exception($e->getMessage());
		//return Redirect::to(__('route.home'));
	    }
	}
	return Redirect::to(__('route.home'));
    }

    public function get_appForm() {
	$lastorderno = DB::table('Order')->order_by('OrderID', 'DESC')->first();
	return View::make('pages.applicationformcreate')->with('lastorderno', $lastorderno);
    }

    public function get_new() {
	$currentUser = Auth::user();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $data = array(
		'page' => $this->page,
		'route' => $this->route,
		'caption' => $this->caption,
		'detailcaption' => $this->detailcaption
	    );
	    return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
			    ->nest('filterbar', 'sections.filterbar', $data);
	}
	return Redirect::to(__('route.home'));
    }

    public function get_show($id) {
	$currentUser = Auth::user();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $row = Order::find($id);
	    if ($row) {
		$data = array(
		    'page' => $this->page,
		    'route' => $this->route,
		    'caption' => $this->caption,
		    'detailcaption' => $this->detailcaption,
		    'row' => $row
		);
		return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
				->nest('filterbar', 'sections.filterbar', $data);
	    } else {
		return Redirect::to($this->route);
	    }
	}
	return Redirect::to(__('route.home'));
    }

    //POST
    public function post_save() {
	$userID = 0;
	$currentUser = Auth::user();

	if ($currentUser !== NULL) {
	    $userID = (int) $currentUser->UserID;
	}

	$id = (int) Input::get($this->pk, '0');

	if ($userID == 0) {
	    $id = 0;
	}
	// Description alanında javascript ile alınan text uzunluğu ile sunucudan okunan text uzunluğu aynı olmadığı için aşağıdaki kontoller yapılmıştır.
	//Javascript 4000 karaktere olumlu cevap döndürürken sunucu daha fazla karakter okuduğu için formu post etmiyordu. \n\r sebebiyle iki karakter fazla çıkartıyordu.
	$tempDescription = Input::get('Description');
	Input::merge(array_map('trim', Input::all()));
	if (mb_strlen(str_replace(array("\n", "\r"), "", $tempDescription), 'utf8') < 4000) {
	    $rules = array(
		'OrderNo' => 'required',
		'Name' => 'required|max:14',
		'Description' => 'required',
		'Keywords' => 'required|max:100',
		'hdnPdfName' => 'required',
		'hdnImage1024x1024Name' => 'required'
	    );
	    $v = Validator::make(Input::all(), $rules);
	} else {
	    return base64_encode(__('common.orders_warning_maxdesc'));
	}
	$Description = Input::get('Description');
	$Description = preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", $Description);

	$appName = Input::get('Name');

	if ($v->passes()) {
	    $orderNo = Input::get('OrderNo');
	    $lastorderno = DB::table('Order')->order_by('OrderID', 'DESC')->first();
	    if ($orderNo == $lastorderno->OrderNo) {
		$orderNo = 'm000' . ($lastorderno->OrderID + 1);
	    }
	    //hdnPdfName
	    $sourcePdfFileName = Input::get('hdnPdfName');
	    $sourcePdfFilePath = 'files/temp';
	    $sourcePdfRealPath = path('public') . $sourcePdfFilePath;
	    $sourcePdfFileNameFull = $sourcePdfRealPath . '/' . $sourcePdfFileName;

	    //hdnImage1024x1024Name
	    $sourceImage1024x1024FileName = Input::get('hdnImage1024x1024Name');
	    $sourceImage1024x1024FilePath = 'files/temp';
	    $sourceImage1024x1024RealPath = path('public') . $sourceImage1024x1024FilePath;
	    $sourceImage1024x1024FileNameFull = $sourceImage1024x1024RealPath . '/' . $sourceImage1024x1024FileName;

	    //hdnImage640x960Name
	    $sourceImage640x960FileName = Input::get('hdnImage640x960Name');
	    $sourceImage640x960FilePath = 'files/temp';
	    $sourceImage640x960RealPath = path('public') . $sourceImage640x960FilePath;
	    $sourceImage640x960FileNameFull = $sourceImage640x960RealPath . '/' . $sourceImage640x960FileName;

	    //hdnImage640x1136Name
	    $sourceImage640x1136FileName = Input::get('hdnImage640x1136Name');
	    $sourceImage640x1136FilePath = 'files/temp';
	    $sourceImage640x1136RealPath = path('public') . $sourceImage640x1136FilePath;
	    $sourceImage640x1136FileNameFull = $sourceImage640x1136RealPath . '/' . $sourceImage640x1136FileName;

	    //hdnImage1536x2048Name
	    $sourceImage1536x2048FileName = Input::get('hdnImage1536x2048Name');
	    $sourceImage1536x2048FilePath = 'files/temp';
	    $sourceImage1536x2048RealPath = path('public') . $sourceImage1536x2048FilePath;
	    $sourceImage1536x2048FileNameFull = $sourceImage1536x2048RealPath . '/' . $sourceImage1536x2048FileName;

	    //hdnImage2048x1536Name
	    $sourceImage2048x1536FileName = Input::get('hdnImage2048x1536Name');
	    $sourceImage2048x1536FilePath = 'files/temp';
	    $sourceImage2048x1536RealPath = path('public') . $sourceImage2048x1536FilePath;
	    $sourceImage2048x1536FileNameFull = $sourceImage2048x1536RealPath . '/' . $sourceImage2048x1536FileName;

	    if ($id == 0) {
		$s = new Order();
	    } else {
		$s = Order::find($id);
	    }

	    $s->ApplicationID = (int) Input::get('ApplicationID');
	    $s->OrderNo = $orderNo;
	    $s->Name = Input::get('Name');
	    $s->Description = $Description;
	    $s->Keywords = Input::get('Keywords');
	    $s->Product = Input::get('Product', '');
	    $s->Qty = (int) Input::get('Qty', '0');
	    $s->Website = Input::get('Website', '');
	    $s->Email = Input::get('Email', '');
	    $s->Facebook = Input::get('Facebook', '');
	    $s->Twitter = Input::get('Twitter', '');

	    //hdnPdfName
	    if ((int) Input::get('hdnPdfSelected', 0) == 1 && File::exists($sourcePdfFileNameFull)) {
		$targetPdfFileName = 'file.pdf';
		$targetPdfFilePath = 'files/orders/order_' . $orderNo;
		$targetPdfRealPath = path('public') . $targetPdfFilePath;
		$targetPdfFileNameFull = $targetPdfRealPath . '/' . $targetPdfFileName;

		if (!File::exists($targetPdfRealPath)) {
		    File::mkdir($targetPdfRealPath);
		}

		File::move($sourcePdfFileNameFull, $targetPdfFileNameFull);

		$s->Pdf = $targetPdfFileName;
	    }

	    //hdnImage1024x1024Name
	    if ((int) Input::get('hdnImage1024x1024Selected', 0) == 1 && File::exists($sourceImage1024x1024FileNameFull)) {
		$targetImage1024x1024FileName = '1024x1024.png';
		$targetImage1024x1024FilePath = 'files/orders/order_' . $orderNo;
		$targetImage1024x1024RealPath = path('public') . $targetImage1024x1024FilePath;
		$targetImage1024x1024FileNameFull = $targetImage1024x1024RealPath . '/' . $targetImage1024x1024FileName;

		if (!File::exists($targetImage1024x1024RealPath)) {
		    File::mkdir($targetImage1024x1024RealPath);
		}

		File::move($sourceImage1024x1024FileNameFull, $targetImage1024x1024FileNameFull);

		$s->Image1024x1024 = $targetImage1024x1024FileName;
	    }

	    //hdnImage640x960Name
	    if ((int) Input::get('hdnImage640x960Selected', 0) == 1 && File::exists($sourceImage640x960FileNameFull)) {
		$targetImage640x960FileName = '640x960.png';
		$targetImage640x960FilePath = 'files/orders/order_' . $orderNo;
		$targetImage640x960RealPath = path('public') . $targetImage640x960FilePath;
		$targetImage640x960FileNameFull = $targetImage640x960RealPath . '/' . $targetImage640x960FileName;

		if (!File::exists($targetImage640x960RealPath)) {
		    File::mkdir($targetImage640x960RealPath);
		}

		File::move($sourceImage640x960FileNameFull, $targetImage640x960FileNameFull);

		$s->Image640x960 = $targetImage640x960FileName;
	    }

	    //hdnImage640x1136Name
	    if ((int) Input::get('hdnImage640x1136Selected', 0) == 1 && File::exists($sourceImage640x1136FileNameFull)) {
		$targetImage640x1136FileName = '640x1136.png';
		$targetImage640x1136FilePath = 'files/orders/order_' . $orderNo;
		$targetImage640x1136RealPath = path('public') . $targetImage640x1136FilePath;
		$targetImage640x1136FileNameFull = $targetImage640x1136RealPath . '/' . $targetImage640x1136FileName;

		if (!File::exists($targetImage640x1136RealPath)) {
		    File::mkdir($targetImage640x1136RealPath);
		}

		File::move($sourceImage640x1136FileNameFull, $targetImage640x1136FileNameFull);

		$s->Image640x1136 = $targetImage640x1136FileName;
	    }

	    //hdnImage1536x2048Name
	    if ((int) Input::get('hdnImage1536x2048Selected', 0) == 1 && File::exists($sourceImage1536x2048FileNameFull)) {
		$targetImage1536x2048FileName = '1536x2048.png';
		$targetImage1536x2048FilePath = 'files/orders/order_' . $orderNo;
		$targetImage1536x2048RealPath = path('public') . $targetImage1536x2048FilePath;
		$targetImage1536x2048FileNameFull = $targetImage1536x2048RealPath . '/' . $targetImage1536x2048FileName;

		if (!File::exists($targetImage1536x2048RealPath)) {
		    File::mkdir($targetImage1536x2048RealPath);
		}

		File::move($sourceImage1536x2048FileNameFull, $targetImage1536x2048FileNameFull);

		$s->Image1536x2048 = $targetImage1536x2048FileName;
	    }

	    //hdnImage2048x1536Name
	    if ((int) Input::get('hdnImage2048x1536Selected', 0) == 1 && File::exists($sourceImage2048x1536FileNameFull)) {
		$targetImage2048x1536FileName = '2048x1536.png';
		$targetImage2048x1536FilePath = 'files/orders/order_' . $orderNo;
		$targetImage2048x1536RealPath = path('public') . $targetImage2048x1536FilePath;
		$targetImage2048x1536FileNameFull = $targetImage2048x1536RealPath . '/' . $targetImage2048x1536FileName;

		if (!File::exists($targetImage2048x1536RealPath)) {
		    File::mkdir($targetImage2048x1536RealPath);
		}

		File::move($sourceImage2048x1536FileNameFull, $targetImage2048x1536FileNameFull);

		$s->Image2048x1536 = $targetImage2048x1536FileName;
	    }

	    if ($id == 0) {
		$s->StatusID = eStatus::Active;
		$s->CreatorUserID = $userID;
		$s->DateCreated = new DateTime();
	    }
	    $s->ProcessUserID = $userID;
	    $s->ProcessDate = new DateTime();
	    if ($id == 0) {
		$s->ProcessTypeID = eProcessTypes::Insert;
	    } else {
		$s->ProcessTypeID = eProcessTypes::Update;
	    }
	    $s->save();

	    $toEmail = array(
		"info@galepress.com",
		"denizkaracali@gmail.com",
		"deniz.karacali@detaysoft.com",
		"ercan.solcun@detaysoft.com"
	    );
	    $subject = "Yeni Bir Uygulama Formu Gönderildi!";
	    $msg = "Sayın Yetkili, \n\n" . $appName . " uygulaması için " . $orderNo . " siparis numarasına ait uygulama formunu lütfen işleme alınız.";
	    Message::send(function($m) use($toEmail, $subject, $msg) {
            $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
		$m->to($toEmail);
		$m->subject($subject);
		$m->body($msg);
	    });

	    return "success=" . base64_encode("true");
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    public function post_delete() {
	$currentUser = Auth::user();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $id = (int) Input::get($this->pk, '0');

	    $s = Order::find($id);
	    if ($s) {
		$s->StatusID = eStatus::Deleted;
		$s->ProcessUserID = $currentUser->UserID;
		$s->ProcessDate = new DateTime();
		$s->ProcessTypeID = eProcessTypes::Update;
		$s->save();
	    }
	    return "success=" . base64_encode("true");
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    public function post_uploadfile() {
	ob_start();

	$type = Input::get('type');
	$element = Input::get('element');

	$options = array();
	if ($type == 'uploadpdf') {
	    $options = array(
		'upload_dir' => path('public') . 'files/temp/',
		'upload_url' => URL::base() . '/files/temp/',
		'param_name' => $element,
		'accept_file_types' => '/\.(pdf)$/i'
	    );
	} else if ($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536') {
	    $options = array(
		'upload_dir' => path('public') . 'files/temp/',
		'upload_url' => URL::base() . '/files/temp/',
		'param_name' => $element,
		'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
	    );
	}

	$upload_handler = new UploadHandler($options);

	if (!Request::ajax())
	    return;

	$upload_handler->post(false);
	$ob = ob_get_contents();
	ob_end_clean();
	$json = get_object_vars(json_decode($ob));
	$arr = $json[$element];
	$obj = $arr[0];
	$tempFile = $obj->name;
	//var_dump($obj->name);

	Uploader::OrdersUploadFile($tempFile, $type);

	return Response::json(array(
		    'fileName' => $tempFile
	));
    }

}
