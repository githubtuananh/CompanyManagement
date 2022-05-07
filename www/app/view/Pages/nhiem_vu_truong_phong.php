<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <?php if (empty($data['param'])) { ?>
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="ms-5 mt-4 mb-3 title-long">DANH SÁCH NHIỆM VỤ</h1>
                    <button class="btn btn-primary btn-them mx-5 mb-3 mt-4" style="max-width: 200px;" data-bs-toggle="modal" data-bs-target="#tao-task-modal">
                        <span>Tạo nhiệm vụ</span>
                    </button>
                </div>
                <div class="card mx-5" id="phong-ban-list">
                    <div class="row thead">
                        <div class="col-4 col-sm-7-m">
                            Tên nhiệm vụ
                        </div>
                        <div class="col-2 none">
                            Tên nhân viên
                        </div>
                        <div class="col-2 none">
                            Deadline
                        </div>
                        <div class="col-2 col-sm-5-m">
                            Trạng thái
                        </div>
                        <div class="col-2 none">
                            Đánh giá
                        </div>
                    </div>
                    <div id="list-task">
                        <?php
                        foreach ($data['nhiemvu'] as $d) {
                        ?>
                            <div class="row row-hover row-href">
                                <input class="task-id" type="hidden" value="<?= $d['manhiemvu'] ?>">
                                <div class="col-4 col-sm-7-m tieude">
                                    <?= $d['tieude'] ?>
                                </div>
                                <div class="col-2 none manhanvien">
                                    <?= $d['manhanvien'] ?>
                                </div>
                                <div class="col-2 none hanchot">
                                    <?= $d['hanchot'] ?>
                                </div>
                                <div class="col-2 col-sm-5-m status">
                                    <?= $d['trangthai'] ?>
                                </div>
                                <div class="col-2 none">
                                    <?= $d['danhgia'] ?>
                                </div>
                                <input type="hidden" class="task-mota" value="<?= $d['mota'] ?>">
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="container">
                    <div class="d-flex flex-row flex-column-m justify-content-center">
                        <div class="card card-body mt-4 me-3 p-5 col-6 col-sm-11-m margin-task">
                            <h1>Tiêu đề : <?= $data['nhiemvuchitiet'][0]['tieude'] ?></h1>
                            <h5 class="mt-2">Người làm : <?= $data['nhiemvuchitiet'][0]['manhanvien'] ?></h5>
                            <h5 class="mt-1 d-none">Người gửi : <span id="nguoi-gui"><?= $data['nhiemvu'][0]['matruongphong'] ?></span></h5>
                            <h5 class="mt-1">Deadline: <span id="deadline"><?= $data['nhiemvuchitiet'][0]['hanchot'] ?></span></h5>
                            <h5 class="mt-1">File : <a class="file-download" ref="<?= $data['nhiemvuchitiet'][0]['taptin'] ?>"><?= $data['nhiemvuchitiet'][0]['taptin'] ?></a></h5>
                            <h5 class="mt-1">Trạng thái : <strong style="color: red;" id="chi-tiet-trang-thai"><?= $data['nhiemvuchitiet'][0]['trangthai'] ?></strong></h5>
                            <h5 class="mt-1">Đánh giá : <strong id="danh-gia" style="color: blueviolet;"><?php echo $data['nhiemvuchitiet'][0]['danhgia'] ? $data['nhiemvuchitiet'][0]['danhgia'] : "Chưa đánh giá" ?></strong></h5>
                        </div>
                        <div class="card card-body mt-4 ms-3 p-5 col-6 col-sm-11-m margin-task">
                            <h1>Mô tả chi tiết :</h1>
                            <h5><?= $data['nhiemvuchitiet'][0]['mota'] ?></h5>
                        </div>
                    </div>
                    <div class="card card-body mt-4 p-5 mx-2-m">
                        <div class="row flex-column-m">
                            <div class="col-9">
                                <h1 class="mb-3" style="text-align: left;">Quá trình thực hiện</h1>
                            </div>
                            <div class="col-3 col-sm-12-m row">
                                <?php $trangthai = $data['nhiemvuchitiet'][0]['trangthai'] ?>
                                <div class="col-6">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#task-complete-modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?> id="btn-task-complete" <?php if ($trangthai != "Waiting") echo 'disabled' ?>>Hoàn tất</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#task-reject-modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?> id="btn-task-reject" <?php if ($trangthai != "Waiting") echo 'disabled' ?>>Từ chối</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="row thead">
                                <div class="col-4 col-sm-6-m">
                                    Người gửi
                                </div>
                                <div class="col-6 col-sm-6-m">
                                    Ghi chú
                                </div>
                                <div class="col-2 none">
                                    Ngày gửi
                                </div>
                            </div>
                            <div id="task-history">
                                <?php
                                foreach ($data['lichsu'] as $d) {
                                ?>
                                    <div class="row row-hover row-history" data-bs-toggle="modal" data-bs-target="#lich-su-modal">
                                        <div class="col-4 col-sm-6-m history-nguoi-gui">
                                            <?= $d['manhanvien'] ?>
                                        </div>
                                        <div class="col-6 col-sm-6-m history-mo-ta">
                                            <?= $d['mota'] ?>
                                        </div>
                                        <div class="col-2 none history-ngay-gui">
                                            <?= $d['ngaygui'] ?>
                                        </div>
                                        <input type="hidden" value="<?= $d['taptin'] ?>"></input>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Tao Task Modal -->
<div class="modal fade" id="tao-task-modal" tabindex="-1" aria-labelledby="tao-task-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tao-task-modal-label">Tạo nhiệm vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Tiêu đề</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-task-tieu-de" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <textarea class="form-control" id="tao-task-mo-ta" cols="30" rows=3></textarea>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Deadline</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-task-deadline" type="date"></input>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">File</div>
                    <div class="col-7">
                        <input class="form-control" id="tao-task-file" type="file"></input>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Chọn nhân viên</div>
                    <div class="col-7" id="tao-task-nhan-vien">
                        <select class="form-control">
                            <?php foreach ($data['nhanvien'] as $d) { ?>
                                <option><?= $d['manhanvien'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="tao-task" truongphong=<?= $_SESSION['user']['manhanvien'] ?>>Tạo nhiệm vụ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chinh sua Task Modal -->
<div class="modal fade" id="chinh-sua-task-modal" tabindex="-1" aria-labelledby="chinh-sua-task-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chinh-sua-task-modal-label">Chỉnh sửa nhiệm vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Tiêu đề</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-task-tieu-de" type="text">
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <textarea class="form-control" id="chinh-sua-task-mo-ta" cols="30" rows=3"></textarea>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">Deadline</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-task-deadline" type="date"></input>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">File</div>
                    <div class="col-7">
                        <input class="form-control" id="chinh-sua-task-file" type="file"></input>
                    </div>
                </div>
                <input id="chinh-sua-task-id" type="hidden"></input>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="chinh-sua-task">Chỉnh sửa</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="huy-task">Huỷ nhiệm vụ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hoan tat Modal -->
<div class="modal fade" id="task-complete-modal" tabindex="-1" aria-labelledby="task-complete-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="task-complete-modal-label">Hoàn tất nhiệm vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-4">Mức độ</div>
                    <div class="col-8 task-danhgia">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-danh-gia" data-bs-dismiss="modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?>>Xong</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tu choi Modal -->
<div class="modal fade" id="task-reject-modal" tabindex="-1" aria-labelledby="task-reject-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="task-reject-modal-label">Chưa hoàn tất nhiệm vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="row mx-3 my-2">
                        <div class="col-5">Mô tả</div>
                        <div class="col-7">
                            <textarea class="form-control" id="tuchoi-task-mo-ta" cols="30" rows=3"></textarea>
                        </div>
                    </div>
                    <div class="row mx-3 my-2">
                        <div class="col-5">Deadline</div>
                        <div class="col-7">
                            <input class="form-control" id="tuchoi-task-deadline" type="date"></input>
                        </div>
                    </div>
                    <div class="row mx-3 my-2">
                        <div class="col-5">File</div>
                        <div class="col-7">
                            <input class="form-control" id="tuchoi-task-file" type="file"></input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btn-chua-hoan-tat" data-bs-dismiss="modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?>>Gửi</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lich su Task Modal -->
<div class="modal fade" id="lich-su-modal" tabindex="-1" aria-labelledby="lich-su-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lich-su-modal-label">Lịch sử nộp bài</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <p class="form-control" id="lich-su-mo-ta"></textarea>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">File</div>
                    <div class="col-7">
                        <p class="form-control" id="lich-su-file"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warning-nhiem-vu-modal" tabindex="-1" aria-labelledby="warning-nhiem-vu-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warning-nhiem-vu-modal-label">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <p id="warning-nhiem-vu-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
</div>