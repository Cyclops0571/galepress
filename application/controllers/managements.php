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
        $currentUser = Auth::User();
        if($currentUser != eUserTypes::Manager) {
            return Response::error(404);
        }
    }

    public function get_list() {
        $data = array();
        return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'list', $data);
    }

    public function post_save() {
        echo "zzzzz";
        var_dump($_POST);
        exit;
    }


}