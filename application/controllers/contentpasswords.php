<?php

/**
 * Class ContentPasswords_Controller
 */
class ContentPasswords_Controller extends Base_Controller {

	/**
	 * @var bool
     */
	public $restful = true;
	/**
	 * @var string
     */
	public $page = '';
	/**
	 * @var \Laravel\Lang|string
     */
	public $route = '';
	/**
	 * @var string
     */
	public $table = '';
	/**
	 * @var string
     */
	public $pk = '';

	/**
	 * ContentPasswords_Controller constructor.
     */
	public function __construct() {
		parent::__construct();
		$this->page = 'contentpasswords';
		$this->route = __('route.' . $this->page);
		$this->table = 'ContentPassword';
		$this->pk = 'ContentPasswordID';
	}

	/**
	 * @return int|\Laravel\View
	 * @throws Exception
     */
	public function get_index() {
		$currentUser = Auth::user();

		try {
			$contentID = (int) Input::get('contentID', 0);

			$rows = DB::table('ContentPassword')
					->where('ContentID', '=', $contentID)
					->where('StatusID', '=', eStatus::Active)
					->order_by('Name', 'ASC')
					->get();

			if ((int) Auth::user()->UserTypeID == eUserTypes::Customer) {
				$rows = DB::table('Customer AS c')
						->join('Application AS a', function($join) {
							$join->on('a.CustomerID', '=', 'c.CustomerID');
							$join->on('a.StatusID', '=', DB::raw(eStatus::Active));
						})
						->join('Content AS cn', function($join) use ($contentID) {
							$join->on('cn.ContentID', '=', DB::raw($contentID));
							$join->on('cn.ApplicationID', '=', 'a.ApplicationID');
							$join->on('cn.StatusID', '=', DB::raw(eStatus::Active));
						})
						->join('ContentPassword AS cp', function($join) {
							$join->on('cp.ContentID', '=', 'cn.ContentID');
							$join->on('cp.StatusID', '=', DB::raw(eStatus::Active));
						})
						->where('c.CustomerID', '=', $currentUser->CustomerID)
						->where('c.StatusID', '=', eStatus::Active)
						->order_by('cp.Name', 'ASC')
						->get('cp.*');
			}

			$data = array(
				'page' => $this->page,
				'route' => $this->route,
				'pk' => $this->pk,
				'rows' => $rows,
				'contentID' => $contentID
			);
			$type = Input::get('type', '');
			if ($type == "qty") {
				$qty = 0;
				foreach ($rows as $row) {
					$qty = $qty + (int) $row->Qty;
				}
				return $qty;
			}
			return View::make('pages.' . Str::lower($this->table) . 'list', $data);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			//return Redirect::to('home');
		}
	}

	/**
	 * @return string
     */
	public function post_save() {
		$currentUser = Auth::user();

		$rules = array(
			'ContentPasswordID' => 'required|integer',
			'ContentPasswordContentID' => 'required|integer',
			'ContentPasswordName' => 'required',
			'ContentPasswordPassword' => 'required',
			'ContentPasswordQty' => 'required|integer|min:1'
		);
		$v = Validator::make(Input::all(), $rules);
		if (!$v->passes()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}

		$id = (int) Input::get('ContentPasswordID', '0');
		$contentID = (int) Input::get('ContentPasswordContentID', '0');

		$chk = Common::CheckContentOwnership($contentID);
		if (!$chk) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}

		if ($id == 0) {
			$s = new ContentPassword();
		} else {
			$chk = Common::CheckContentPasswordOwnership($id);
			if (!$chk) {
				return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
			}
			$s = ContentPassword::find($id);
		}
		//$s->ApplicationID = (int)Input::get('CategoryApplicationID');

		/** @var  $s ContentPassword */
		$s->ContentID = $contentID;
		$s->Name = Input::get('ContentPasswordName');
		if (strlen(trim(Input::get('ContentPasswordPassword'))) > 0) {
			$s->Password = Hash::make(Input::get('ContentPasswordPassword'));
		}
		$s->Qty = (int) Input::get('ContentPasswordQty');
		if ($id == 0) {
			$s->StatusID = eStatus::Active;
			$s->CreatorUserID = $currentUser->UserID;
			$s->DateCreated = new DateTime();
		}
		$s->ProcessUserID = $currentUser->UserID;
		$s->ProcessDate = new DateTime();
		if ($id == 0) {
			$s->ProcessTypeID = eProcessTypes::Insert;
		} else {
			$s->ProcessTypeID = eProcessTypes::Update;
		}
		$s->save();
		return "success=" . base64_encode("true");
	}

	/**
	 * @return string
     */
	public function post_delete() {
		$currentUser = Auth::user();

		$id = (int) Input::get($this->pk, '0');

		$chk = Common::CheckContentPasswordOwnership($id);
		if ($chk) {
			$s = ContentPassword::find($id);
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

}
