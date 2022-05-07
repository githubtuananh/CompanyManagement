<section class="login-section">
    <div class="login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Đăng nhập</h3>
                    <form action="/login" class="login-form" method="post">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required />
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required />
                        </div>
                        <div class="mb-3 login-button">
                            <?php
                            if (!empty($data['error'])) {
                                echo $data['error'];
                            }
                            ?>
                            <button type="submit" class="btn btn-primary submit p-3 px-5">
                                Đăng nhập
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>