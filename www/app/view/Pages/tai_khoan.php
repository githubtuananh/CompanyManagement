<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h1 class="ms-5 mt-4 mb-3">DANH SÁCH TÀI KHOẢN</h1>
                <button class="btn btn-primary btn-them mx-5 mb-3 mt-4" style="max-width: 200px;" data-bs-toggle="modal" data-bs-target="#tao-tk-modal">
                    <span>Tạo tài khoản</span>
                </button>
            </div>
            <div class="card mx-5" id="tai-khoan-list">
                <div class="row thead">
                    <div class="col-3 col-sm-7-m">
                        ID
                    </div>
                    <div class="col-4 none">
                        Họ tên
                    </div>
                    <div class="col-3 none">
                        Phòng ban
                    </div>
                    <div class="col-2 col-sm-5-m">
                        Đặt lại mật khẩu
                    </div>
                </div>
                <?php
                foreach ($data['account'] as $d) {
                ?>
                    <div class="row row-hover row-click" data-bs-toggle="modal" data-bs-target="#xem-tai-khoan-modal">
                        <div class="col-3 col-sm-7-m tk-manv">
                            <?= $d['manhanvien'] ?>
                        </div>
                        <div class="col-4 none tk-hoten">
                            <?= $d['hoten'] ?>
                        </div>
                        <div class="col-3 none tk-phongban">
                            <?= $d['phongban'] ?>
                        </div>
                        <input class="form-control tk-chucvu" type="hidden" value="<?= $d['chucvu'] ?>">
                        <div class="col-2 col-sm-5-m">
                            <button class="btn btn-danger btn-reset" data-bs-toggle="modal" data-bs-target="#reset-password-modal">Reset</button>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Xem Tai Khoan Modal -->
<div class="modal fade" id="xem-tai-khoan-modal" tabindex="-1" aria-labelledby="tai-khoan-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tai-khoan-modal-label">Xem thông tin tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Mã nhân viên</div>
                    <div class="col-7" id="tk-manv">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Họ và tên</div>
                    <div class="col-7" id="tk-hoten">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Phòng ban</div>
                    <div class="col-7" id="tk-phongban">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Chức vụ</div>
                    <div class="col-7" id="tk-chucvu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tao TK Modal -->
<div class="modal fade" id="tao-tk-modal" tabindex="-1" aria-labelledby="tao-tk-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tao-tk-modal-label">Tạo tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Họ và tên</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-tk-ho-ten" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Tên tài khoản</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-tk-tai-khoan" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Phòng ban</div>
                    <div class="col-7">
                        <select class="form-select" id="tao-tk-phong-ban" aria-label="Default select">
                            <?php
                            foreach ($data['phongban'] as $p) {
                            ?>
                                <option class="p-2"><?= $p['tenphongban'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Chức vụ</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-tk-chuc-vu" type="text" value="Nhân viên" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="tao-tk">Tạo tài khoản</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="reset-password-modal" tabindex="-1" aria-labelledby="reset-password-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reset-password-modal-label">Đặt lại mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 mb-2">
                    Bạn có chắc chắn muốn đặt lại mật khẩu ?
                </div>
                <div class="modal-footer">
                    <button id="tai-khoan-reset-password" type="button" class="btn btn-danger" data-bs-dismiss="modal">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warning-tk-modal" tabindex="-1" aria-labelledby="warning-tk-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warning-tk-modal-label">Tạo tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <p id="warning-tk-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
</div>