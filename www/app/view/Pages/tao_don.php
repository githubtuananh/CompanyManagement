<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <div class="d-flex flex-row flex-column-m justify-content-between">
                <h1 class="ms-5 mt-4 mb-3 col-6">LỊCH SỬ ĐƠN NGHỈ PHÉP</h1>
                <div class="col-6 col-sm-12-m d-flex flex-row justify-content-center align-items-center">
                    <div class="col-6 col-sm-9-m">
                        <div class="d-flex flex-row justify-content-end justify-content-start-m">
                            <div class="col-6 col-sm-8-m ms-5-m">Số ngày đã dùng: </div>
                            <div class="col-1"><?= $data['dadung'] ? $data['dadung'] : 0 ?></div>
                        </div>
                        <div class="d-flex flex-row justify-content-end justify-content-start-m">
                            <div class="col-6 col-sm-8-m ms-5-m">Số ngày còn lại: </div>
                            <div class="col-1"><?= $data['conlai'] ?></div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-them mx-5 mb-3 mt-4 col-6 col-sm-3-m" style="max-width: 100px;" data-bs-toggle="modal" data-bs-target="#tao-don-modal">
                        <span>Tạo đơn</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tao Don Modal -->
<div class="modal fade" id="tao-don-modal" tabindex="-1" aria-labelledby="tao-don-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tao-don-modal-label">Tạo đơn nghỉ phép</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Mã nhân viên</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-don-ma-nv" type="text" value="<?= $_SESSION['user']['manhanvien'] ?>" readonly>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Họ và tên</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-don-ho-ten" type="text" value="<?= $_SESSION['user']['hoten'] ?>" readonly>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Số ngày muốn nghỉ</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-don-ngay-nghi" type="number">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Lí do nghỉ</div>
                    <div class="col-7">
                        <textarea class="form-control" id="tao-don-li-do" cols="30" rows=3"></textarea>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">File đính kèm</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-don-file" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="tao-don">Tạo đơn</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warning-tao-don-modal" tabindex="-1" aria-labelledby="warning-tao-don-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warning-tao-don-modal-label">Tạo đơn nghỉ phép</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <p id="warning-tao-don-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
</div>