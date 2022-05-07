<?php
class NghiPhepController extends BaseController
{
    private $mDayOff;
    public function __construct()
    {
        parent::__construct();
        $this->mDayOff = new DayOffModel();
    }

    // Controller View
    public function DuyetDon()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if (
                $this->first_use($_SESSION['user']['taikhoan']) ||
                $_SESSION['user']['chucvu'] === "Nhân viên"
            ) {
                header("Location: /");
            }
            if ($_SESSION['user']['chucvu'] === "Giám đốc") {
                $data = $this->mDayOff->get_by_chucvu("Trưởng phòng")['data'];
            } else {
                $data = $this->mDayOff->get_by_phongban($_SESSION['user']['phongban'])['data'];
            }
            $this->render('duyet_don', $data);
        }
    }

    public function TaoDon()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if (
                $this->first_use($_SESSION['user']['taikhoan']) ||
                $_SESSION['user']['chucvu'] === "Giám đốc"
            ) {
                header("Location: /");
            }
            $data['data'] = $this->mDayOff->get_by_id($_SESSION['user']['manhanvien'])['data'];
            $data['dadung'] = $this->mDayOff->da_dung($_SESSION['user']['manhanvien'])['data'][0]['songaydadung'];
            $data['conlai'] = $this->mDayOff->con_lai($_SESSION['user']['manhanvien'])['data'][0]['songayconlai'];
            $this->render('tao_don', $data);
        }
    }

    // Request Processing
    public function DuyetDonNghiPhep()
    {
        if (isset($_POST['trangthai']) && isset($_POST['madon'])) {
            $this->mDayOff->trang_thai($_POST['trangthai'], $_POST['madon']);
            die(json_encode(array('tinhtrang' => $_POST['trangthai'])));
        } else {
            header("Location: /");
        }
    }

    public function TaoDonMoi()
    {
        if (
            isset(
                $_POST['manhanvien']
            ) &&
            isset($_POST['hoten']) &&
            isset($_POST['songaymuonnghi']) &&
            isset($_POST['noidung']) &&
            isset($_POST['ngaylap'])
        ) {
            $list_extendsion = array(
                'exe', 'sh', 'cmd', 'bat'
            );
            $file = "";
            if (isset($_FILES['file'])) {
                $file_e = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if (str_contains(implode(" ", $list_extendsion), $file_e)) {
                    die(json_encode(array('code' => 1, 'message' => 'Tập tin sai định dạng')));
                } else {
                    $file = $_FILES['file']['name'];
                }
            }
            $result = $this->mDayOff->create(
                $_POST['manhanvien'],
                $_POST['hoten'],
                $_POST['songaymuonnghi'],
                $_POST['noidung'],
                $_POST['ngaylap'],
                $file
            );
            if ($result['code'] === 1) {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            } else {
                if ($file !== "") {
                    $location = "files/" . $file;
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                }
                die(json_encode(array('code' => 0, 'data' => array(
                    'madon' => $result['data']['madon'],
                    'songaymuonnghi' => $_POST['songaymuonnghi'],
                    'noidung' => $_POST['noidung'],
                    'ngaylap' => $_POST['ngaylap'],
                    'file' => $file,
                    'trangthai' => 'Waiting'
                ))));
            }
        } else {
            header("Location: /");
        }
    }
}
