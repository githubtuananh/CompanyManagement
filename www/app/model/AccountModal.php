<?php
class AccountModal extends BaseModel
{
    public function log_in($user, $pass)
    {
        if (count($this->get_user_data($user)) !== 0) {
            if ($this->first_use($user)) {
                if ($this->get_user_data($user)['matkhau'] === $pass) {
                    $_SESSION['user'] = $this->get_user_data($user);
                    return array('code' => 0, 'message' => 'Đăng nhập thành công');
                } else {
                    return array('code' => '1', 'message' => "Sai tài khoản hoặc mật khẩu");
                }
            } else {
                $hash_pass = $this->get_user_data($user)['matkhau'];
                if (!password_verify($pass, $hash_pass)) {
                    return array('code' => '1', 'message' => "Sai tài khoản hoặc mật khẩu");
                } else {
                    $_SESSION['user'] = $this->get_user_data($user);
                    return array('code' => 0, 'message' => 'Đăng nhập thành công');
                }
            }
        } else {
            return array('code' => 1, 'message' => 'Tài khoản không tồn tại');
        }
    }

    public function first_use($user)
    {
        $sql = "SELECT * FROM nguoidung WHERE taikhoan = matkhau AND taikhoan = ?";
        $param = array('s', &$user);

        $result = $this->query_prepared($sql, $param)['data'];
        return count($result) == 0 ? false : true;
    }

    public function change_password($user, $oldPass, $newPass)
    {
        if ($this->check_password($user, $oldPass)) {
            $sql = "UPDATE nguoidung SET matkhau=? WHERE taikhoan=?";
            $hash = password_hash($newPass, PASSWORD_BCRYPT);
            $param = array('ss', &$hash, &$user);
            $this->query_prepared($sql, $param);
            return array('code' => 0, 'message' => 'Đổi mật khẩu thành công');
        } else {
            return array('code' => 1, 'message' => 'Mật khẩu không đúng');
        }
    }

    public function reset_password($manv)
    {
        $sql = "UPDATE nguoidung SET matkhau=taikhoan WHERE manhanvien=?";
        $param = array('s', &$manv);
        $result = $this->query_prepared($sql, $param);
        if ($result['code'] === 0) {
            return array('code' => 0, 'message' => 'Đặt lại mật khẩu thành công');
        } else {
            return array('code' => 0, 'message' => 'Đặt lại mật khẩu thất bại');
        }
    }

    public function register($hoten, $taikhoan, $phongban, $chucvu)
    {
        $sql = "SELECT * FROM nguoidung WHERE taikhoan=?";
        $param = array('s', &$taikhoan);
        if (count($this->query_prepared($sql, $param)['data']) !== 0) {
            return array('code' => 1, 'message' => 'Tài khoản đã tồn tại');
        } else {
            // Xu li tach ten phnong ban -> ki tu
            $a = explode(' ', $phongban);
            $arr = array();
            foreach ($a as $i) {
                array_push($arr, strtolower(substr($i, 0, 1)));
            }
            $pb = implode('', $arr);

            $sql1 = "SELECT * FROM nguoidung WHERE phongban=?";
            $param1 = array('s', &$phongban);
            $result = count($this->query_prepared($sql1, $param1)['data']);
            $num = $result + 1 < 10 ? "00" . $result + 1 : ($result + 1 < 100 ? "0" . $result + 1 : $result + 1);
            $manv = "nv_" . $pb . "_" . $num;
            $avatar = "avatar.png";

            $sql2 = "INSERT INTO nguoidung(manhanvien, hoten, taikhoan, matkhau, phongban, chucvu, anhdaidien, songaynghi) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 12)";
            $param2 = array('sssssss', &$manv, &$hoten, &$taikhoan, &$taikhoan, &$phongban, &$chucvu, &$avatar);
            $result = $this->query_prepared($sql2, $param2);
            if ($result['code'] === 0) {
                return array('code' => 0, 'data' => array(
                    'manv' => $manv,
                    'hoten' => $hoten,
                    'phongban' => $phongban,
                    'chucvu' => $chucvu,
                ));
            } else {
                return array('code' => 1, 'message' => $result['error']);
            }
        }
    }

    public function get_all_user()
    {
        return $this->query("SELECT * FROM nguoidung");
    }

    public function get_all_phongban()
    {
        return $this->query("SELECT tenphongban FROM phongban");
    }

    private function check_password($user, $pass)
    {
        $result = $this->get_user_data($user);
        if ($this->first_use($user)) {
            if ($pass !== $result['matkhau']) {
                return false;
            }
        } else {
            if (!password_verify($pass, $result['matkhau'])) {
                return false;
            }
        }
        return true;
    }

    private function get_user_data($user)
    {
        $sql = "SELECT * FROM nguoidung WHERE taikhoan=?";
        $param = array('s', &$user);

        return $this->query_prepared($sql, $param)['data'][0];
    }

    public function change_avatar($manhanvien, $avatar)
    {
        $sql = "UPDATE nguoidung set anhdaidien = ? where manhanvien=?";
        $param = array('ss',   &$avatar, &$manhanvien);
        return $this->query_prepared($sql, $param);
    }
}
