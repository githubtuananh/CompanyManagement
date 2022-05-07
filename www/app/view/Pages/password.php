<section class="reset-password-section">
    <div class="reset-password-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="reset-password-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Đổi mật khẩu</h3>
                    <form action="/password" method="post" class="reset-password-form">
                        <?php
                        if (!$data['first-use']) {
                        ?>
                            <div class="mb-3">
                                <input name="pass-old" type="password" class="form-control" placeholder="Mật khẩu cũ" required />
                            </div>
                        <?php
                        }
                        ?>
                        <div class="mb-3">
                            <input name="pass-new-1" type="password" class="form-control" placeholder="Mật khẩu mới" required />
                        </div>
                        <div class="mb-3">
                            <input name="pass-new-2" type="password" class="form-control" placeholder="Nhập lại mật khẩu" required />
                        </div>
                        <?php
                        if ($data['first-use']) {
                        ?>
                            <div class="text-end">
                                <a href="/logout">Đăng xuất</a>
                            </div>
                        <?php
                        }
                        if (!empty($data['error'])) {
                            echo $data['error'];
                        }
                        ?>
                        <div class="mb-3 reset-password-button">
                            <button type="submit" class="btn btn-primary submit p-3 px-5">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>