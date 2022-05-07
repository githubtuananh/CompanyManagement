<?php
class PhongBanController extends BaseController
{
    private $mDepartment;
    function __construct()
    {
        parent::__construct();
        $this->mDepartment = new DepartmentModal();
    }
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
            $data['phongban'] = $this->mDepartment->get_all()['data'];
            $this->render('phong_ban', $data);
        }
    }

    // Request Processing
    public function TaoPhongBan()
    {
        if (isset($_POST['tenphongban']) && isset($_POST['mota']) && isset($_POST['sophong'])) {
            $result = $this->mDepartment->create($_POST['tenphongban'], $_POST['mota'], $_POST['sophong']);
            if ($result['code'] === 1) {
                die(json_encode(array('code' => $result['code'], 'message' => $result['message'])));
            } else {
                die(json_encode(array('code' => $result['code'], 'data' => $result['data'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function ChinhSuaPhongBan()
    {
        if (isset($_POST['id']) && isset($_POST['tenphongban']) && isset($_POST['mota']) && isset($_POST['sophong'])) {
            $result = $this->mDepartment->update($_POST['id'], $_POST['tenphongban'], $_POST['mota'], $_POST['sophong']);
            die(json_encode(array('code' => $result['code'], 'message' => $result['message'])));
        } else {
            header("Location: /");
        }
    }

    public function DanhSachNhanVien()
    {
        if (isset($_POST['maphongban'])) {
            $result = $this->mDepartment->get_nv($_POST['maphongban']);
            if ($result['code'] === 0) {
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function BoNhiem()
    {
        if (isset($_POST['maphongban']) || isset($_POST['truongphong'])) {
            $result = $this->mDepartment->bo_nhiem($_POST['maphongban'], $_POST['truongphong']);
            if ($result['code'] === 0) {
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }
}
