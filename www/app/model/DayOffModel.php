<?php
class DayOffModel extends BaseModel
{
    function get_by_chucvu($chucvu)
    {
        $sql = 'SELECT donnghiphep.*, nguoidung.phongban, chucvu FROM donnghiphep, nguoidung 
                WHERE donnghiphep.manhanvien = nguoidung.manhanvien AND chucvu=?';
        $param = array('s', &$chucvu);
        return $this->query_prepared($sql, $param);
    }
    function get_by_phongban($phongban)
    {
        $sql = 'SELECT donnghiphep.*, nguoidung.phongban, chucvu FROM donnghiphep, nguoidung
                WHERE nguoidung.phongban=? AND donnghiphep.manhanvien = nguoidung.manhanvien AND chucvu="Nhân viên"';
        $param = array('s', &$phongban);
        return $this->query_prepared($sql, $param);
    }

    function get_by_id($id)
    {
        $sql = 'SELECT * FROM donnghiphep WHERE manhanvien=?';
        $param = array('s', &$id);
        return $this->query_prepared($sql, $param);
    }

    function trang_thai($status, $madon)
    {
        $sql1 = "SELECT manhanvien FROM donnghiphep WHERE madon=?";
        $param1 = array('i', &$madon);
        $manv = $this->query_prepared($sql1, $param1)['data'][0]['manhanvien'];

        $sql2 = "SELECT songaymuonnghi FROM donnghiphep WHERE manhanvien=? ORDER BY madon DESC";
        $param2 = array('s', &$manv);
        $day = $this->query_prepared($sql2, $param2)['data'][0]['songaymuonnghi'];

        if ($status === "Approved") {
            $sql3 = "UPDATE nguoidung
            SET songaynghi = songaynghi - ?
            WHERE manhanvien = ?";

            $param3 = array('is', &$day, &$manv);
            $this->query_prepared($sql3, $param3);
        }

        $sql4 = 'UPDATE donnghiphep SET trangthai=? WHERE madon=?';
        $param4 = array('ss', &$status, &$madon);
        return $this->query_prepared($sql4, $param4);
    }

    function create($manv, $hoten, $ngaynghi, $noidung, $ngaylap, $taptin)
    {
        if ($ngaynghi == 0) {
            return array('code' => 1, 'message' => "Ngày nghỉ phải lớn hơn 0");
        }
        $sql1 = 'SELECT * FROM donnghiphep WHERE manhanvien=? ORDER BY ngaylap DESC LIMIT 1';
        $param1 = array('s', &$manv);
        $result = $this->query_prepared($sql1, $param1);

        if (count($result['data']) > 0) {
            $date1 = new DateTime($ngaylap);
            $date2 = new DateTime($result['data'][0]['ngaylap']);
            $diff = $date1->diff($date2);
            $days = $diff->days;
            if ($days > 7) {
                $sql2 = "SELECT songaynghi FROM nguoidung WHERE manhanvien=?";
                $param2 = array('s', &$manv);
                $dayLeft = $this->query_prepared($sql2, $param2);
                if ($dayLeft['data'][0]['songaynghi'] < $ngaynghi) {
                    return array('code' => 1, 'message' => "Số ngày nghỉ còn lại không đủ. Còn lại $dayLeft ngày");
                }

                $sql4 = 'INSERT INTO donnghiphep(manhanvien, hoten, songaymuonnghi, noidung, ngaylap, taptin, trangthai) VALUES (?, ?, ?, ?, ?, ?, "Waiting")';
                $param4 = array('ssisss', &$manv, &$hoten, &$ngaynghi, &$noidung, &$ngaylap, &$taptin);
                $this->query_prepared($sql4, $param4);

                return array(
                    'code' => 0,
                    'data' => $this->query("SELECT MAX(madon) as madon FROM donnghiphep")['data'][0]
                );
            } else {
                return array('code' => 1, 'message' => "Chưa đủ ngày tạo đơn mới");
            }
        } else {
            $sql5 = "SELECT songaynghi FROM nguoidung WHERE manhanvien=?";
            $param5 = array('s', &$manv);
            $dayLeft = $this->query_prepared($sql5, $param5);
            if ($dayLeft['data'][0]['songaynghi'] < $ngaynghi) {
                return array('code' => 1, 'message' => "Số ngày nghỉ còn lại không đủ. Còn lại " . $dayLeft['data'][0]['songaynghi'] . " ngày");
            }

            $sql6 = 'INSERT INTO donnghiphep(manhanvien, hoten, songaymuonnghi, noidung, ngaylap, taptin, trangthai) VALUES (?, ?, ?, ?, ?, ?, "Waiting")';
            $param6 = array('ssisss', &$manv, &$hoten, &$ngaynghi, &$noidung, &$ngaylap, &$taptin);
            $this->query_prepared($sql6, $param6);

            return array(
                'code' => 0,
                'data' => $this->query("SELECT MAX(madon) as madon FROM donnghiphep")['data'][0]
            );
        }
    }

    public function da_dung($id)
    {
        $sql = "SELECT SUM(songaymuonnghi) as songaydadung FROM donnghiphep 
        WHERE manhanvien = ? AND ngaylap LIKE '2022%' AND trangthai = 'Approved'";
        $param = array('s', &$id);
        return $this->query_prepared($sql, $param);
    }

    public function con_lai($id)
    {
        $sql = "SELECT songaynghi as songayconlai FROM nguoidung WHERE manhanvien = ?";
        $param = array('s', &$id);
        return $this->query_prepared($sql, $param);
    }
}
