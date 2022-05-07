<?php
class LoginController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            if ($this->first_use($_SESSION['user']['taikhoan'])) {
                header("Location: /password");
            } else {
                header("Location: /home");
            }
        } else {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $result = $this->mAccount->log_in($_POST['username'], $_POST['password']);
                $code = $result['code'];

                if ($code == 0) {
                    if ($this->first_use($_POST['username'])) {
                        header("Location: /password");
                    } else {
                        header("Location: /home");
                    }
                } else {
                    $data['error'] = $result['message'];
                }
            } else {
                $data['error'] = "";
            }
            $this->render('login', $data);
        }
    }
}
