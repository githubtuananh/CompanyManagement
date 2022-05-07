<?php
class TaskModel extends BaseModel
{
    function get_by_phongban($phongban)
    {
        $sql = 'SELECT nhiemvu.*, phongban FROM nhiemvu, nguoidung
        WHERE nhiemvu.manhanvien = nguoidung.manhanvien AND phongban = ? ORDER BY manhiemvu DESC';
        $param = array('s', &$phongban);
        return $this->query_prepared($sql, $param);
    }

    function get_by_nhanvien($manhanvien)
    {
        $sql = 'SELECT * FROM nhiemvu WHERE manhanvien = ? ORDER BY manhiemvu DESC';
        $param = array('s', &$manhanvien);
        return $this->query_prepared($sql, $param);
    }

    function get_by_manhiemvu($manhiemvu)
    {
        $sql = 'SELECT * FROM nhiemvu WHERE manhiemvu=?';
        $param = array('s', &$manhiemvu);
        return $this->query_prepared($sql, $param);
    }

    function get_lich_su($manhiemvu)
    {
        $sql = "SELECT * FROM lichsu WHERE manhiemvu=? ORDER BY thutu DESC";
        $param = array('s', &$manhiemvu);
        return $this->query_prepared($sql, $param);
    }

    function get_nhanvien($phongban)
    {
        $sql = "SELECT manhanvien FROM nguoidung WHERE phongban=? AND chucvu='Nhân viên'";
        $param = array('s', &$phongban);
        return $this->query_prepared($sql, $param);
    }

    function bat_dau($manhiemvu, $trangthai)
    {
        $sql = 'UPDATE nhiemvu SET trangthai=? WHERE manhiemvu=?';
        $param = array('ss', &$trangthai, &$manhiemvu);
        $result = $this->query_prepared($sql, $param);
        if ($result['code'] === 0) {
            return array('code' => 0, 'data' => 'In progress');
        } else {
            return array('code' => 1, 'message' => 'UPDATE failed');
        }
    }

    function nop_bai($manhiemvu, $manhanvien, $mota, $taptin, $ngaygui, $hanchot)
    {
        if ($hanchot == '') {
            $sql = "SELECT hanchot FROM nhiemvu WHERE manhiemvu=?";
            $param = array('s', &$manhiemvu);
            $hanchot = $this->query_prepared($sql, $param)['data'][0]['hanchot'];
        }
        $sql1 = 'SELECT COUNT(thutu) as thutu FROM lichsu WHERE manhiemvu=?';
        $param1 = array('s', &$manhiemvu);
        $thutu = $this->query_prepared($sql1, $param1)['data'][0]['thutu'] + 1;
        $sql2 = 'INSERT INTO lichsu(manhiemvu, manhanvien, thutu, mota, taptin, hanchot, ngaygui)
        VALUES(?,?,?,?,?,?,?)';
        $param2 = array('ssissss', &$manhiemvu, &$manhanvien, &$thutu, &$mota, &$taptin, &$hanchot, &$ngaygui);
        $result = $this->query_prepared($sql2, $param2);
        if ($result['code'] === 0) {
            $sql3 = "UPDATE nhiemvu SET trangthai = 'Waiting' WHERE manhiemvu=?";
            $param3 = array('s', &$manhiemvu);
            $this->query_prepared($sql3, $param3);
            return array('code' => 0, 'data' => array('manhanvien' => $manhanvien, 'mota' => $mota, 'taptin' => $taptin));
        } else {
            return array('code' => 1, 'message' => 'Submit failed');
        }
    }

    function tao_task($tieude, $mota, $hanchot, $taptin, $nhanvien, $matruongphong)
    {
        $manhiemvu = 'nv_';
        $num = $this->query("SELECT COUNT(manhiemvu) as total FROM nhiemvu")['data'][0]['total'];
        if (0 <= $num + 1 && $num + 1 < 10) {
            $manhiemvu .= '00' . strval($num + 1);
        } else if ($num + 1 < 100) {
            $manhiemvu .= '0' . strval($num + 1);
        } else {
            $manhiemvu .= strval($num + 1);
        }
        $trangthai = "New";
        $sql = 'INSERT 
        INTO nhiemvu(manhiemvu, matruongphong, manhanvien, tieude, mota, hanchot, taptin, trangthai) 
        VALUES(?,?,?,?,?,?,?,?)';
        $param = array('ssssssss', &$manhiemvu, &$matruongphong, &$nhanvien, &$tieude, &$mota, &$hanchot, &$taptin, &$trangthai);
        $result = $this->query_prepared($sql, $param);
        if ($result['code'] === 0) {
            return array(
                'code' => 0,
                'data' => array(
                    'manhiemvu' => $manhiemvu,
                    'tieude' => $tieude,
                    'tennhanvien' => $nhanvien,
                    'deadline' => $hanchot,
                    'trangthai' => $trangthai,
                    'taptin' => $taptin,
                    'mota' => $mota,
                )
            );
        } else {
            return array('code' => 1, 'message' => 'Create failed');
        }
    }

    function chinh_sua_task($tieude, $mota, $hanchot, $taptin, $manhiemvu)
    {
        $sql = "UPDATE nhiemvu SET tieude=?, mota=?, hanchot=?, taptin=? WHERE manhiemvu=?";
        $param = array('sssss', &$tieude, &$mota, &$hanchot, &$taptin, &$manhiemvu);
        $result = $this->query_prepared($sql, $param);
        if ($result['code'] === 0) {
            return array(
                'code' => 0,
                'data' => array(
                    'tieude' => $tieude,
                    'deadline' => $hanchot,
                    'mota' => $mota
                )
            );
        } else {
            return array('code' => 1, 'message' => 'Update failed');
        }
    }

    function huy_task($manhiemvu)
    {
        $sql = "UPDATE nhiemvu SET trangthai='Canceled' WHERE manhiemvu=?";
        $param = array('s', &$manhiemvu);
        return $this->query_prepared($sql, $param);
    }

    function hoan_tat_task($id, $ngaygui)
    {
        $sql = 'SELECT hanchot FROM nhiemvu WHERE manhiemvu=?';
        $param = array('s', &$id);
        $deadline = $this->query_prepared($sql, $param)['data'][0]['hanchot'];
        $date1 = strtotime($deadline);
        $date2 = strtotime($ngaygui);
        $days = ($date1 - $date2) / 86400;

        if ($days < 0) {
            return array('code' => 1);
        } else {
            return array('code' => 0);
        }
    }

    function danh_gia($id, $mucdo)
    {
        $sql = "UPDATE nhiemvu SET trangthai=?, danhgia=? WHERE manhiemvu=?";
        $trangthai = "Completed";
        $param = array("sss", &$trangthai, &$mucdo, &$id);
        $result = $this->query_prepared($sql, $param);
        if ($result['code'] === 0) {
            return array('code' => 0, 'data' => 'Completed');
        } else {
            return array('code' => 1, 'message' => 'Update failed');
        }
    }

    function tu_choi($id, $nguoigui, $mota, $hanchot, $taptin, $ngaygui)
    {
        if ($hanchot == '') {
            $sql = "SELECT hanchot FROM nhiemvu WHERE manhiemvu=?";
            $param = array('s', &$id);
            $hanchot = $this->query_prepared($sql, $param)['data'][0]['hanchot'];
        } else {
            $sql = "UPDATE nhiemvu SET hanchot=? WHERE manhiemvu=?";
            $param = array('ss', &$hanchot, &$id);
            $this->query_prepared($sql, $param);
        }
        $sql1 = 'SELECT COUNT(thutu) as thutu FROM lichsu WHERE manhiemvu=?';
        $param1 = array('s', &$id);
        $thutu = $this->query_prepared($sql1, $param1)['data'][0]['thutu'] + 1;
        $sql2 = "INSERT INTO lichsu(manhiemvu, manhanvien, thutu, mota, hanchot, taptin, ngaygui) VALUES(?,?,?,?,?,?,?)";
        $param2 = array('ssissss', &$id, &$nguoigui, &$thutu, &$mota, &$hanchot, &$taptin, &$ngaygui);
        $result = $this->query_prepared($sql2, $param2);
        if ($result['code'] === 0) {
            $sql3 = "UPDATE nhiemvu SET trangthai = 'Rejected' WHERE manhiemvu=?";
            $param3 = array('s', &$id);
            $this->query_prepared($sql3, $param3);
            return array('code' => 0, 'data' => array('manhanvien' => $nguoigui, 'mota' => $mota, 'taptin' => $taptin, 'hanchot' => $hanchot));
        } else {
            return array('code' => 1, 'message' => 'Submit failed');
        }
    }
}
