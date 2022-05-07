<nav class="navbar d-flex flex-row justify-content-between p-2 bg-light">
    <a id="download" style="display: none" href="" download></a>
    <div>
        <button id="menu-bar"><i class="fas fa-bars"></i></button>
    </div>
    <div class="d-flex flex-row">
        <div class="d-flex align-items-center me-2"><?= $_SESSION['user']['hoten'] ?></div>
        <div class="dropdown">
            <button class="" type="button" id="avatar" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/avatar/<?= $_SESSION['user']['anhdaidien'] ?>" alt="avatar">
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="avatar">
                <li><a class="dropdown-item" href="/profile"><i class="fas fa-user"></i>Tài khoản</a></li>
                <li><a class="dropdown-item" href="/password"><i class="fas fa-key"></i>Đổi mật khẩu</a></li>
                <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</nav>