<?php
class ProfileController extends BaseController
{
    public function index()
    {

        // Controller View
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if ($this->first_use($_SESSION['user']['taikhoan'])) {
                header("Location: /");
            }
            $data = $_SESSION['user'];
            $this->render('profile', $data);
        }
    }

    // Request Processing
    public function ChangeAvatar()
    {
        if (isset($_POST['submit'])) {
            $filename = $_FILES['anhdaidien']['name'];

            $location = "avatar/" . $filename;
            if (move_uploaded_file($_FILES['anhdaidien']['tmp_name'], $location)) {
                $result =  $this->mAccount->change_avatar($_SESSION['user']['manhanvien'], $filename);
                $_SESSION['user']['anhdaidien'] = $filename;
            }
        } else {
            header("Location: /");
        }
        header("Location: /Profile");
    }
}
