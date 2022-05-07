<?php
class TaiKhoanController extends BaseController
{
    //Controller view
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if (
                $this->first_use($_SESSION['user']['taikhoan']) ||
                $_SESSION['user']['chucvu'] === "Trưởng phòng" ||
                $_SESSION['user']['chucvu'] === "Nhân viên"
            ) {
                header("Location: /");
            }
            $data['account'] = $this->mAccount->get_all_user()['data'];
            $data['phongban'] = $this->mAccount->get_all_phongban()['data'];
            $this->render('tai_khoan', $data);
        }
    }

    // Request Processing
    public function TaoTaiKhoan()
    {
        if (
            isset($_POST['hoten']) &&
            isset($_POST['taikhoan']) &&
            isset($_POST['phongban']) &&
            isset($_POST['chucvu'])
        ) {
            $result = $this->mAccount->register($_POST['hoten'], $_POST['taikhoan'], $_POST['phongban'], $_POST['chucvu']);
            if ($result['code'] === 1) {
                die(json_encode(array('code' => $result['code'], 'message' => $result['message'])));
            } else {
                die(json_encode(array('code' => $result['code'], 'data' => $result['data'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function ResetPassword()
    {
        if (isset($_POST['manv'])) {
            $result = $this->mAccount->reset_password($_POST['manv']);
            die(json_encode(array('code' => $result['code'], 'message' => $result['message'])));
        } else {
            header("Location: /");
        }
    }
}
