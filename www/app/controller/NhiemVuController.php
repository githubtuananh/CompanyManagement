<?php
class NhiemVuController extends BaseController
{
    private $mTask;
    public function __construct()
    {
        parent::__construct();
        $this->mTask = new TaskModel();
    }

    // Controller View
    public function TruongPhong($id = "")
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if (
                $this->first_use($_SESSION['user']['taikhoan']) ||
                $_SESSION['user']['chucvu'] === "Nhân viên" ||
                $_SESSION['user']['chucvu'] === "Giám đốc"
            ) {
                header("Location: /");
            }
            $data['param'] = $id;
            $data['nhiemvu'] = $this->mTask->get_by_phongban($_SESSION['user']['phongban'])['data'];
            $data['nhiemvuchitiet'] = $this->mTask->get_by_manhiemvu($id)['data'];
            $data['lichsu'] = $this->mTask->get_lich_su($id)['data'];
            $data['nhanvien'] = $this->mTask->get_nhanvien($_SESSION['user']['phongban'])['data'];
            if ($id !== "" && count($data['nhiemvuchitiet']) === 0) {
                header("Location: /Error");
            }
            $this->render('nhiem_vu_truong_phong', $data);
        }
    }

    public function NhanVien($id = "")
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        } else {
            if (
                $this->first_use($_SESSION['user']['taikhoan']) ||
                $_SESSION['user']['chucvu'] === "Trưởng phòng" ||
                $_SESSION['user']['chucvu'] === "Giám đốc"
            ) {
                header("Location: /");
            }
            $data['param'] = $id;
            $data['nhiemvu'] = $this->mTask->get_by_nhanvien($_SESSION['user']['manhanvien'])['data'];
            $data['nhiemvuchitiet'] = $this->mTask->get_by_manhiemvu($id)['data'];
            $data['lichsu'] = $this->mTask->get_lich_su($id)['data'];
            if ($id !== "" && count($data['nhiemvuchitiet']) === 0) {
                header("Location: /Error");
            }
            $this->render('nhiem_vu_nhan_vien', $data);
        }
    }

    // Request Processing
    public function BatDau()
    {
        if (isset($_POST['id']) || isset($_POST['status'])) {
            $result = $this->mTask->bat_dau($_POST['id'], $_POST['status']);
            if ($result['code'] === 0) {
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function Submit()
    {
        if (
            isset($_POST['manhiemvu']) ||
            isset($_POST['manhanvien']) ||
            isset($_POST['mota']) ||
            isset($_POST['ngaygui'])
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
            $hanchot = isset($_POST['hanchot']) ? $_POST['hanchot'] : "";
            $result = $this->mTask->nop_bai($_POST['manhiemvu'], $_POST['manhanvien'], $_POST['mota'], $file, $_POST['ngaygui'], $hanchot);
            if ($result['code'] === 0) {
                if ($file !== "") {
                    $location = "files/" . $file;
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                }
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function TaoTask()
    {
        if (
            isset($_POST['tieude']) ||
            isset($_POST['mota']) ||
            isset($_POST['hanchot']) ||
            isset($_POST['nhanvien']) ||
            isset($_POST['truongphong'])
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
            $result = $this->mTask->tao_task(
                $_POST['tieude'],
                $_POST['mota'],
                $_POST['hanchot'],
                $file,
                $_POST['nhanvien'],
                $_POST['truongphong']
            );
            if ($result['code'] === 0) {
                if ($file !== "") {
                    $location = "files/" . $file;
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                }
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function ChinhSuaTask()
    {
        if (
            isset($_POST['tieude']) ||
            isset($_POST['mota']) ||
            isset($_POST['hanchot']) ||
            isset($_POST['id'])
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
            $result = $this->mTask->chinh_sua_task($_POST['tieude'], $_POST['mota'], $_POST['hanchot'], $file, $_POST['id']);
            if ($result['code'] === 0) {
                if ($file !== "") {
                    $location = "files/" . $file;
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                }
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function HuyTask()
    {
        if (isset($_POST['id'])) {
            $result = $this->mTask->huy_task($_POST['id']);
            die(json_encode(array('code' => $result['code'])));
        } else {
            header("Location: /");
        }
    }

    public function HoanTat()
    {
        if (isset($_POST['id']) || isset($_POST['ngaygui'])) {
            $result = $this->mTask->hoan_tat_task($_POST['id'], $_POST['ngaygui']);
            die(json_encode(array('code' => $result['code'])));
        } else {
            header("Location: /");
        }
    }

    public function DanhGia()
    {
        if (isset($_POST['id']) || isset($_POST['mucdo'])) {
            $result = $this->mTask->danh_gia($_POST['id'], $_POST['mucdo']);
            if ($result['code'] === 0) {
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }

    public function TuChoi()
    {
        if (
            isset($_POST['id']) ||
            isset($_POST['nguoigui']) ||
            isset($_POST['mota']) ||
            isset($_POST['ngaygui'])
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
            $hanchot = isset($_POST['hanchot']) ? $_POST['hanchot'] : "";
            $result = $this->mTask->tu_choi($_POST['id'], $_POST['nguoigui'], $_POST['mota'], $hanchot,  $file, $_POST['ngaygui']);
            if ($result['code'] === 0) {
                if ($file !== "") {
                    $location = "files/" . $file;
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                }
                die(json_encode(array('code' => 0, 'data' => $result['data'])));
            } else {
                die(json_encode(array('code' => 1, 'message' => $result['message'])));
            }
        } else {
            header("Location: /");
        }
    }
}
