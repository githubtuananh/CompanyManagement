<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="container">
            <?php if (empty($data['param'])) { ?>
                <div class="d-flex flex-row justify-content-between">
                    <h1 class="ms-5 mt-4 mb-3 title-long">DANH SÁCH NHIỆM VỤ</h1>
                </div>
                <div class="card mx-5" id="phong-ban-list">
                    <div class="row thead">
                        <div class="col-6 col-sm-7-m">
                            Tên nhiệm vụ
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
                    <?php
                    foreach ($data['nhiemvu'] as $d) {
                    ?>
                        <div class="row row-hover row-href" data-bs-toggle="modal" data-bs-target="#chinh-sua-pb-modal">
                            <input class="task-id" type="hidden" value="<?= $d['manhiemvu'] ?>">
                            <div class="col-6 col-sm-7-m">
                                <?= $d['tieude'] ?>
                            </div>
                            <div class="col-2 none">
                                <?= $d['hanchot'] ?>
                            </div>
                            <div class="col-2 col-sm-5-m status">
                                <?= $d['trangthai'] ?>
                            </div>
                            <div class="col-2 none">
                                <?= $d['danhgia'] ?>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            <?php } else { ?>
                <div class="container">
                    <div class="d-flex flex-row flex-column-m justify-content-center">
                        <div class="card card-body mt-4 me-3 p-5 col-6 col-sm-11-m margin-task">
                            <h1>Tiêu đề : <?= $data['nhiemvuchitiet'][0]['tieude'] ?></h1>
                            <h5 class="mt-2 d-none">Người làm : <span id="nguoi-lam"><?= $data['nhiemvuchitiet'][0]['manhanvien'] ?></span>
                            </h5>
                            <h5 class="mt-1">Người gửi : <span id="nguoi-gui"><?= $data['nhiemvu'][0]['matruongphong'] ?></span></h5>
                            <h5 class="mt-1">Deadline : <?= $data['nhiemvuchitiet'][0]['hanchot'] ?></h5>
                            <h5 class="mt-1">File : <a class="file-download" ref="<?= $data['nhiemvuchitiet'][0]['taptin'] ?>"><?= $data['nhiemvuchitiet'][0]['taptin'] ?></a></h5>
                            <h5 class="mt-1">Trạng thái : <strong id="chi-tiet-trang-thai" style="color: red;"><?= $data['nhiemvuchitiet'][0]['trangthai'] ?></strong></h5>
                            <h5 class="mt-1">Đánh giá : <strong id="danh-gia" style="color: blueviolet;"><?php echo $data['nhiemvuchitiet'][0]['danhgia'] ? $data['nhiemvuchitiet'][0]['danhgia'] : "Chưa đánh giá" ?></strong></h5>
                        </div>
                        <div class="card card-body mt-4 ms-3 p-5 col-6 col-sm-11-m margin-task">
                            <h1>Mô tả chi tiết :</h1>
                            <h5><?= $data['nhiemvuchitiet'][0]['mota'] ?></h5>
                        </div>
                    </div>
                    <div class="card card-body mt-4 p-5">
                        <div class="row">
                            <h1 class="mb-3 col-11" style="text-align: left;">Quá trình thực hiện</h1>
                            <?php $trangthai = $data['nhiemvuchitiet'][0]['trangthai'] ?>
                            <button class="btn btn-primary col-1 col-sm-5-m mx-auto" id="btn-nop-bai" <?php if ($trangthai !== "In progress" && $trangthai !== "Rejected" && $trangthai !== "New") echo "disabled" ?>><?php echo $trangthai === "New" ? "Bắt đầu" : "Nộp bài" ?></button>
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

<!-- Nop Task Modal -->
<div class="modal fade" id="nop-task-modal" tabindex="-1" aria-labelledby="nop-task-modal-label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nop-task-modal-label">Nộp bài</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <div class="col-5">Mô tả</div>
                    <div class="col-7">
                        <textarea class="form-control" id="nop-task-mo-ta" cols="30" rows=3"></textarea>
                    </div>
                </div>
                <div class="row mx-3 my-2">
                    <div class="col-5">File</div>
                    <div class="col-7">
                        <input class="form-control" id="nop-task-file" type="file"></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?> id="nop-task">Nộp bài</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
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
<div class="modal fade" id="warning-task-modal" tabindex="-1" aria-labelledby="warning-task-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warning-pb-modal-label">Nhiệm vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mx-3 my-2">
                    <p id="warning-task-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" manhiemvu=<?= $data['nhiemvuchitiet'][0]['manhiemvu'] ?> id="btn-task-bat-dau">Bắt đầu</button>
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