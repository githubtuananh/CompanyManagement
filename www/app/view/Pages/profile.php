<div class="d-flex flex-row h-100">
    <?php require_once(__DIR__ . "/../layout/dashboard.php") ?>
    <div class="d-flex flex-column w-100">
        <?php require_once(__DIR__ . "/../layout/navbar.php") ?>
        <div class="content d-flex flex-column">
            <div class="profile card mt-5 p-3">
                <h1 class="ms-3 mb-3 mt-2">Ảnh đại diện</h1>
                <div class="d-flex justify-content-center mb-2">
                    <img class="img-avatar" src="/avatar/<?= $data['anhdaidien'] ?>" alt="avatar" style="width: 150px; height: 150px">
                </div>
                <form action="/Profile/ChangeAvatar/" enctype="multipart/form-data" method="POST">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control" type="file" name="anhdaidien">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary" type="submit" name="submit">Lưu</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="content d-flex flex-column">
            <div class="profile card m-5 p-3">
                <h1 class="ms-3 mb-3 mt-2">Thông tin</h1>
                <div class="row no-border">
                    <div class="col-6 col-lg-4 col-sm-12-m ps-5"><span style="font-weight: bold">Mã nhân viên</span></div>
                    <div class="col-6 col-lg-8 col-sm-12-m ps-5"><?= $data['manhanvien'] ?></div>
                </div>
                <div class="row no-border">
                    <div class="col-6 col-lg-4 col-sm-12-m ps-5"><span style="font-weight: bold">Họ và tên</span></div>
                    <div class="col-6 col-lg-8 col-sm-12-m ps-5"><?= $data['hoten'] ?></div>
                </div>
                <div class="row no-border">
                    <div class="col-6 col-lg-4 col-sm-12-m ps-5"><span style="font-weight: bold">Tên tài khoản</span></div>
                    <div class="col-6 col-lg-8 col-sm-12-m ps-5"><?= $data['taikhoan'] ?></div>
                </div>
                <div class="row no-border">
                    <div class="col-6 col-lg-4 col-sm-12-m ps-5"><span style="font-weight: bold">Chức vụ</span></div>
                    <div class="col-6 col-lg-8 col-sm-12-m ps-5"><?= $data['chucvu'] ?></div>
                </div>
                <div class="row no-border">
                    <div class="col-6 col-lg-4 col-sm-12-m ps-5"><span style="font-weight: bold">Tên phòng ban</span></div>
                    <div class="col-6 col-lg-8 col-sm-12-m ps-5"><?= $data['phongban'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>