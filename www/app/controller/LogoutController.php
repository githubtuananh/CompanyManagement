<?php
class LogoutController extends BaseController
{
    public function index()
    {
        $data = array();
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            unset($_SESSION['user']);
            $this->render('logout', $data);
        }
    }
}
