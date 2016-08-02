<?php
/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 15.12.2015
 * Time: 14:28
 */
class Managements_Controller extends Base_Controller {
    public $restful = true;
    public $table = 'Management';

    public function __construct()
    {
        parent::__construct();
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->UserTypeID != eUserTypes::Manager) {
            echo Response::error(404);
            exit;
        }
    }

    public function get_list() {
        $customerSizes = Customer::CustomerFileSize();
//        dd($customerSizes);
        $data = array();
        $data['rows'] = $customerSizes;
        return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'list', $data);
    }

    public function post_importlanguages()
    {
        LaravelLang::Import();
        return ajaxResponse::success("Import işlemi başarıyla tamamlandı.");
    }

    public function post_exportlanguages()
    {
        LaravelLang::Export();
        return ajaxResponse::success("Export işlemi başarıyla tamamlandı.");
    }


}