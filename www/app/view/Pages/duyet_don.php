<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <h1 class="ms-5 mt-4 mb-3 title-long">DANH SÁCH ĐƠN NGHỈ PHÉP</h1>
            <div class="card mx-5">
                <div class="row thead">
                    <div class="col-1 col-sm-6-m">
                        Mã đơn
                    </div>
                    <div class="col-2 none">
                        Mã nhân viên
                    </div>
                    <div class="col-1 none">
                        Số ngày
                    </div>
                    <div class="col-2 none">
                        Lí do
                    </div>
                    <div class="col-2 none">
                        Ngày lập
                    </div>
                    <div class="col-2 none">
                        File
                    </div>
                    <div class="col-2 col-sm-6-m">
                        Tình trạng
                    </div>
                </div>
                <?php
                foreach ($data as $d) {
                ?>
                    <div class="row row-hover row-click" id="<?= $d['madon'] ?>" data-bs-toggle="modal" data-bs-target="#xem-don-modal">
                        <div class="col-1 col-sm-6-m">
                            <?= $d['madon'] ?>
                        </div>
                        <div class="col-2 none">
                            <?= $d['manhanvien'] ?>
                        </div>
                        <div class="col-1 none">
                            <?= $d['songaymuonnghi'] ?>
                        </div>
                        <div class="col-2 none">
                            <?= $d['noidung'] ?>
                        </div>
                        <div class="col-2 none">
                            <?= $d['ngaylap'] ?>
                        </div>
                        <div class="col-2 none">
                            <a class="file-download" ref="<?= $d['taptin'] ?>" download><?= $d['taptin'] ?></a>
                        </div>
                        <div class="col-2 col-sm-6-m status <?= $d['madon'] ?>">
                            <?= $d['trangthai'] ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Xem Don Modal -->
<div class="modal fade" id="xem-don-modal" tabindex="-1" aria-labelledby="tao-don-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tao-don-modal-label">Xem đơn nghỉ phép</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 mb-2">
                    Chọn hành động duyệt đơn nghỉ phép
                </div>
                <div class="modal-footer">
                    <button id="xem-don-dong-y" type="button" class="btn btn-success" data-bs-dismiss="modal">Chấp nhận</button>
                    <button id="xem-don-tu-choi" type="button" class="btn btn-danger" data-bs-dismiss="modal">Từ chối</button>
                </div>
            </div>
        </div>
    </div>
</div>