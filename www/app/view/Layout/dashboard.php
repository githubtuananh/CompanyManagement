<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <h3>DASHBOARD</h3>
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <?php
            $chucvu = $_SESSION['user']['chucvu'];
            switch ($chucvu) {
                case "Giám đốc":
            ?>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/TaiKhoan" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col-10">Quản lý tài khoản</div>
                                </a>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/PhongBan" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-door-closed"></i>
                                    </div>
                                    <div class="col-10">Quản lý phòng ban</div>
                                </a>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/NghiPhep/DuyetDon" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-calendar-week"></i>
                                    </div>
                                    <div class="col-10">Quản lý nghỉ phép</div>
                                </a>
                            </div>
                        </button>
                    </li>
                <?php
                    break;
                case "Trưởng phòng":
                ?>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/NhiemVu/TruongPhong" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div class="col-10">Quản lý nhiệm vụ</div>
                                </a>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task" data-bs-toggle="collapse" data-bs-target="#collapseDayOff" aria-expanded="false" aria-controls="collapseDayOff">
                            <div class="function">
                                <div class="col-2 me-2 d-flex justify-content-center">
                                    <i class="fas fa-calendar-week"></i>
                                </div>
                                <div class="col-10">Quản lý nghỉ phép</div>
                            </div>
                        </button>
                        <div class="collapse" id="collapseDayOff">
                            <div class="card">
                                <a href="/NghiPhep/DuyetDon">Duyệt đơn</a>
                            </div>
                            <div class="card">
                                <a href="/NghiPhep/TaoDon">Tạo đơn</a>
                            </div>
                        </div>
                    </li>
                <?php
                    break;
                default:
                ?>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/NhiemVu/NhanVien" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div class="col-10">Quản lý nhiệm vụ</div>
                                </a>
                            </div>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="dashboard-btn button-task">
                            <div class="function">
                                <a href="/NghiPhep/TaoDon" class="d-flex align-items-center">
                                    <div class="col-2 me-2 d-flex justify-content-center">
                                        <i class="fas fa-calendar-week"></i>
                                    </div>
                                    <div class="col-10">Quản lý nghỉ phép</div>
                                </a>
                            </div>
                        </button>
                    </li>
            <?php
                    break;
            }
            ?>
        </ul>
    </div>
</nav>