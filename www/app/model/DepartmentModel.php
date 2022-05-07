<?php
class DepartmentModal extends BaseModel
{
    public function get_all()
    {
        return $this->query('SELECT * from phongban');
    }

    public function create($tenphongban, $mota, $sophong)
    {
        $sql = "SELECT * FROM phongban WHERE tenphongban=?";
        $param = array('s', &$tenphongban);
        if (count($this->query_prepared($sql, $param)['data']) !== 0) {
            return array('code' => 1, 'message' => 'Phòng ban đã tồn tại');
        } else {
            $sql1 = "INSERT INTO phongban(tenphongban, mota, sophong) VALUES (?, ?, ?)";
            $param1 = array('sss', &$tenphongban, &$mota, &$sophong);
            $this->query_prepared($sql1, $param1);

            $sql2 = "SELECT maphongban FROM phongban WHERE tenphongban = ?";
            $param2 = array("s", &$tenphongban);
            $maphongban = $this->query_prepared($sql2, $param2)['data'];

            return array('code' => 0, 'data' => array(
                'tenphongban' => $tenphongban,
                'sophong' => $sophong,
                'mota' => $mota,
                'truongphong' => "",
                'maphongban' => $maphongban
            ));
        }
    }

    public function update($id, $tenphongban, $mota, $sophong)
    {
        $sql1 = 'SELECT maphongban, tenphongban FROM phongban WHERE tenphongban = ?';
        $param1 = array("s", &$tenphongban);
        $result1 = $this->query_prepared($sql1, $param1);
        if (count($result1['data']) > 0) {
            if ($result1['data'][0]['maphongban'] != $id) {
                return array('code' => 1, 'message' => 'Tên phòng ban đã tồn tại');
            }
        }
        $sql2 = 'UPDATE phongban SET tenphongban = ?, mota = ?, sophong = ? WHERE maphongban = ?';
        $param2 = array('ssis', &$tenphongban, &$mota, &$sophong, &$id);
        $this->query_prepared($sql2, $param2);
        return array('code' => 0, 'message' => 'Update successed');
    }

    public function get_nv($maphongban)
    {
        $sql = 'SELECT hoten FROM nguoidung, phongban 
        WHERE phongban.tenphongban = nguoidung.phongban AND maphongban=? AND chucvu!="Trưởng phòng"';
        $param = array('s', &$maphongban);
        $result = $this->query_prepared($sql, $param);
        if (count($result['data']) !== 0) {
            return array('code' => 0, 'data' => $result['data']);
        } else {
            return array('code' => 1, 'message' => 'Phòng ban không có nhân viên');
        }
    }
    public function bo_nhiem($maphongban, $truongphong)
    {
        if ($truongphong == "") {
            return array('code' => 1, 'message' => 'Bổ nhiệm thất bại');
        } else {
            $sql = 'UPDATE nguoidung SET chucvu="Nhân viên", songaynghi=songaynghi-3 WHERE phongban=(SELECT tenphongban FROM phongban WHERE maphongban=?) AND chucvu="Trưởng phòng"';
            $param = array('s', &$maphongban);
            $this->query_prepared($sql, $param);

            $sql2 = 'UPDATE nguoidung SET chucvu="Trưởng phòng", songaynghi=songaynghi+3 WHERE hoten=?';
            $param2 = array('s', &$truongphong);
            $this->query_prepared($sql2, $param2);

            $sql3 = 'UPDATE phongban SET truongphong=? WHERE maphongban=?';
            $param3 = array('ss', &$truongphong, &$maphongban);
            $this->query_prepared($sql3, $param3);

            return array('code' => 0, 'data' => $truongphong);
        }
    }
}
