<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h1 class="ms-5 mt-4 mb-3">DANH SÁCH PHÒNG BAN</h1>
                <button class="btn btn-primary btn-them mx-5 mb-3 mt-4" style="max-width: 200px;" data-bs-toggle="modal" data-bs-target="#tao-pb-modal">
                    <span>Tạo phòng ban</span>
                </button>
            </div>
            <div class="card mx-5" id="phong-ban-list">
                <div class="row thead">
                    <div class="col-3 col-sm-6-m">
                        Tên phòng ban
                    </div>
                    <div class="col-2 none">
                        Số phòng
                    </div>
                    <div class="col-4 none">
                        Mô tả
                    </div>
                    <div class="col-3 col-sm-6-m">
                        Bổ nhiệm trưởng phòng
                    </div>
                </div>
                <?php
                foreach ($data['phongban'] as $d) {
                ?>
                    <div class="row row-hover row-click-edit" id="<?= $d['maphongban'] ?>" data-bs-toggle="modal" data-bs-target="#chinh-sua-pb-modal">
                        <div class="col-3 col-sm-6-m pb-ten">
                            <?= $d['tenphongban'] ?>
                        </div>
                        <div class="col-2 none pb-sophong">
                            <?= $d['sophong'] ?>
                        </div>
                        <div class="col-4 none pb-mota">
                            <?= $d['mota'] ?>
                        </div>
                        <input class="form-control pb-truongphong" type="hidden" value="<?= $d['truongphong'] ?>">
                        <div class="col-3 col-sm-6-m">
                            <button class="btn btn-success btn-bo-nhiem" data-bs-toggle="modal" data-bs-target="#bo-nhiem-modal">Bổ nhiệm</button>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Chinh sua phong ban Modal -->
<div class="modal fade" id="chinh-sua-pb-modal" tabindex="-1" aria-labelledby="chinh-sua-pb-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chinh-sua-pb-modal-label">Chỉnh sửa phòng ban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input id="chinh-sua-pb-id" type="hidden">
                <div class="row mx-3 my-2">
                    <div class="col-5">Trưởng phòng</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-pb-truong-phong" type="text" readonly>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Tên phòng ban</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-pb-ten" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Số phòng</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-pb-so-phong" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <textarea class="form-control" id="chinh-sua-pb-mo-ta" cols="30" rows=3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="chinh-sua-pb" class="btn btn-success" data-bs-dismiss="modal">Thay đổi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tao PB Modal -->
<div class="modal fade" id="tao-pb-modal" tabindex="-1" aria-labelledby="tao-pb-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tao-pb-modal-label">Tạo phòng ban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Tên phòng ban</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-pb-ten" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Số phòng</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-pb-so-phong" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <textarea class="form-control" id="tao-pb-mo-ta" cols="30" rows=3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="tao-pb">Tạo phòng ban</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bo nhiem Modal -->
<div class="modal fade" id="bo-nhiem-modal" tabindex="-1" aria-labelledby="bo-nhiem-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bo-nhiem-modal-label">Bổ nhiệm trưởng phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 mb-2">
                    <div class="col-4">Nhân viên</div>
                    <div class="col-8 pb-list-nv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="phong-ban-bo-nhiem" type="button" class="btn btn-success" data-bs-dismiss="modal">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warning-pb-modal" tabindex="-1" aria-labelledby="warning-pb-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warning-pb-modal-label">Bổ nhiệm trưởng phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <p id="warning-pb-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
</div>