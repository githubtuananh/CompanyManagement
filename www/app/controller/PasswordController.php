<?php
class PasswordController extends BaseController
{
    public function index()
    {
        $data = array();
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            $data['first-use'] = $this->first_use($_SESSION['user']['taikhoan']) ? true : false;
            $user = $_SESSION['user']['taikhoan'];
            if (isset($_POST['pass-new-1']) && isset($_POST['pass-new-2'])) {
                $newPass1 = $_POST['pass-new-1'];
                $newPass2 = $_POST['pass-new-2'];
                if ($newPass1 === $newPass2) {
                    if ($data['first-use']) {
                        $oldPass = $user;
                        $result = $this->mAccount->change_password($user, $oldPass, $newPass1);
                        if ($result['code'] === 0) {
                            header("Location: /");
                        }
                    } else {
                        if (isset($_POST['pass-old'])) {
                            $oldPass = $_POST['pass-old'];
                            $result = $this->mAccount->change_password($user, $oldPass, $newPass1);
                            if ($result['code'] === 0) {
                                header("Location: /");
                            } else {
                                $data['error'] = $result['message'];
                            }
                        }
                    }
                } else {
                    $data['error'] = "Mật khẩu không khớp";
                }
            }
            $this->render('password', $data);
        }
    }
}
