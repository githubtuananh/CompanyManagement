<?php
class HomeController extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
        } else {
            if ($this->first_use($_SESSION['user']['taikhoan'])) {
                header("Location: /password");
            } else {
                if ($_SESSION['user']['chucvu'] === "Nhân viên") {
                    header("Location: /NhiemVu/NhanVien");
                }
                if ($_SESSION['user']['chucvu'] === "Trưởng phòng") {
                    header("Location: /NhiemVu/TruongPhong");
                }
                if ($_SESSION['user']['chucvu'] === "Giám đốc") {
                    header("Location: /TaiKhoan");
                }
            }
        }
    }
}
