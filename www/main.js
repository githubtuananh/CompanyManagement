// Logout
$("#login").click(function (e) {
  e.preventDefault();
  window.location.replace("http://localhost:8080/login");
});
let n = 9;

let interval;
function CountDown() {
  if (n >= 0) {
    $("#count-down").html(n);
    n--;
  } else {
    clearInterval(interval);
    window.location.replace("http://localhost:8080/login");
  }
}
if (window.location.pathname === "/logout") {
  interval = setInterval(CountDown, 1000);
}

// Xem don
$(".status:contains('Approved')").parent().removeAttr("data-bs-toggle");
$(".status:contains('Refused')").parent().removeAttr("data-bs-toggle");

let idXemDon;
$(".row-click").click(function (e) {
  e.preventDefault();
  idXemDon = $(this).attr("id");
});

// Duyet don - dong y
$("#xem-don-dong-y").click(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/NghiPhep/DuyetDonNghiPhep",
    data: { trangthai: "Approved", madon: idXemDon },
    dataType: "json",
    success: function (response) {
      $(`.status.${idXemDon}`).html(response.tinhtrang);
      $(".status:contains('Approved')").parent().removeAttr("data-bs-toggle");
      $(".status:contains('Refused')").parent().removeAttr("data-bs-toggle");
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Duyet don - tu choi
$("#xem-don-tu-choi").click(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/NghiPhep/DuyetDonNghiPhep",
    data: { trangthai: "Refused", madon: idXemDon },
    dataType: "json",
    success: function (response) {
      $(`.status.${idXemDon}`).html(response.tinhtrang);
      $(".status:contains('Approved')").parent().removeAttr("data-bs-toggle");
      $(".status:contains('Refused')").parent().removeAttr("data-bs-toggle");
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Tao don
$("#tao-don").click(function (e) {
  e.preventDefault();
  data = {
    manhanvien: $("#tao-don-ma-nv").val(),
    hoten: $("#tao-don-ho-ten").val(),
    songaymuonnghi: $("#tao-don-ngay-nghi").val(),
    noidung: $("#tao-don-li-do").val(),
    ngaylap: new Date().toJSON().slice(0, 10).replace(/-/g, "-"),
    file: $("#tao-don-file")[0].files[0],
  };
  if (data.songaymuonnghi == "" || data.noidung == "") {
    $("#warning-tao-don-modal").modal("show");
    $("#warning-tao-don-text").html("Chưa nhập đủ thông tin");
  } else if (data.file && data.file.size > 1 * 1024 ** 2) {
    $("#warning-tao-don-modal").modal("show");
    $("#warning-tao-don-text").html("Tập tin quá lớn, tối đa 1 MB");
  } else {
    $("#tao-don-ngay-nghi").val("");
    $("#tao-don-li-do").val("");
    $("#tao-don-file").val("");
    const formData = new FormData();
    for (let i = 0; i < Object.keys(data).length; i++) {
      formData.append(Object.keys(data)[i], Object.values(data)[i]);
    }
    $.ajax({
      type: "POST",
      url: "/NghiPhep/TaoDonMoi",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.code === 1) {
          $("#warning-tao-don-modal").modal("show");
          $("#warning-tao-don-text").html(response.message);
        } else {
          str = `
        <div class="row row-hover">
          <div class="col-2 col-sm-6-m">
            ${response.data.madon}
          </div>
          <div class="col-2 none">
            ${response.data.songaymuonnghi}
          </div>
          <div class="col-2 none">
            ${response.data.noidung}
          </div>
          <div class="col-2 none">
            ${response.data.ngaylap}
          </div>
          <div class="col-2 none">
            <a class="file-download" ref='${response.data.file}'>${response.data.file}</a>
          </div>
          <div class="col-2 col-sm-6-m">
            ${response.data.trangthai}
          </div>
        </div>
        `;
          $("#tao-don-list").append(str);
          ReloadFuntion();
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Xem tai khoan
$(".row-click").click(function (e) {
  e.preventDefault();

  data = {
    manv: $(this).children("div.tk-manv").html(),
    hoten: $(this).children("div.tk-hoten").html(),
    phongban: $(this).children("div.tk-phongban").html(),
    chucvu: $(this).children("input.tk-chucvu").val(),
  };
  $("#tk-manv").html(data.manv);
  $("#tk-hoten").html(data.hoten);
  $("#tk-phongban").html(data.phongban);
  $("#tk-chucvu").html(data.chucvu);
});

// Chinh sua phong ban
$(".row-click-edit").click(function (e) {
  e.preventDefault();
  data = {
    maphongban: $(this).attr("id"),
    truongphong: $(this).children("input.pb-truongphong").val(),
    tenphongban: $(this).children("div.pb-ten").html().trim(),
    sophong: $(this).children("div.pb-sophong").html().trim(),
    mota: $(this).children("div.pb-mota").html().trim(),
  };
  $("#chinh-sua-pb-id").val(data.maphongban);
  $("#chinh-sua-pb-truong-phong").val(
    data.truongphong ? data.truongphong : "Chưa bổ nhiệm"
  );
  $("#chinh-sua-pb-ten").val(data.tenphongban);
  $("#chinh-sua-pb-so-phong").val(data.sophong);
  $("#chinh-sua-pb-mo-ta").val(data.mota);
});

// Tao tai khoan
$("#tao-tk").click(function (e) {
  e.preventDefault();
  data = {
    hoten: $("#tao-tk-ho-ten").val(),
    taikhoan: $("#tao-tk-tai-khoan").val(),
    phongban: $("#tao-tk-phong-ban option:selected").html(),
    chucvu: $("#tao-tk-chuc-vu").val(),
  };
  if (data.hoten == "" || data.taikhoan == "") {
    $("#warning-tk-modal").modal("show");
    $("#warning-tk-text").html("Chưa nhập đủ thông tin");
  } else {
    $.ajax({
      type: "POST",
      url: "/TaiKhoan/TaoTaiKhoan",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.code === 1) {
          $("#warning-tk-modal").modal("show");
          $("#warning-tk-text").html(response.message);
        } else {
          str = `
        <div class="row row-hover row-click" data-bs-toggle="modal" data-bs-target="#xem-tai-khoan-modal">
          <div class="col-3 col-sm-7-m tk-manv">
            ${response.data.manv}
          </div>
          <div class="col-4 none tk-hoten">
            ${response.data.hoten}
          </div>
          <div class="col-3 none tk-phongban">
            ${response.data.phongban}
          </div>
          <input class="form-control tk-chucvu" type="hidden" class="tk-chucvu" value='${response.data.chucvu}'>
          <div class="col-2 col-sm-5-m">
            <button class="btn btn-danger btn-reset" data-bs-toggle="modal" data-bs-target="#reset-password-modal">Reset</button>
          </div>
        </div>
        `;
          $("#tai-khoan-list").append(str);
        }
        $("#tao-tk-ho-ten").val("");
        $("#tao-tk-tai-khoan").val("");
        // Reload funtion Xem tai khoan nhan vien
        ReloadFuntion();
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Reset Password
let manhanvien;
$(".btn-reset").click(function (e) {
  e.preventDefault();
  manhanvien = $(this).parent().parent().children("div.tk-manv").html();
});
$("#tai-khoan-reset-password").click(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "/TaiKhoan/ResetPassword",
    data: { manv: manhanvien.trim() },
    dataType: "json",
    success: function (response) {
      console.log(response.message);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Tao phong ban
$("#tao-pb").click(function (e) {
  e.preventDefault();
  data = {
    tenphongban: $("#tao-pb-ten").val(),
    mota: $("#tao-pb-mo-ta").val(),
    sophong: $("#tao-pb-so-phong").val(),
  };
  if (data.tenphongban == "" || data.mota == "" || data.sophong == "") {
    $("#warning-pb-modal").modal("show");
    $("#warning-pb-text").html("Chưa nhập đủ thông tin");
  } else {
    $.ajax({
      type: "POST",
      url: "/PhongBan/TaoPhongBan",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.code === 1) {
          $("#warning-pb-modal").modal("show");
          $("#warning-pb-text").html(response.message);
        } else {
          str = `
        <div class="row row-hover row-click-edit" id="${response.data.maphongban[0].maphongban}" data-bs-toggle="modal" data-bs-target="#chinh-sua-pb-modal">
          <div class="col-3 col-sm-6-m pb-ten">
            ${response.data.tenphongban}
          </div>
          <div class="col-2 none pb-sophong">
            ${response.data.sophong}
          </div>
          <div class="col-4 none pb-mota">
            ${response.data.mota}
          </div>
          <input class="pb-truongphong" type="hidden" value='${response.data.truongphong}'>
          <div class="col-3 col-sm-6-m">
            <button class="btn btn-success btn-bo-nhiem" data-bs-toggle="modal" data-bs-target="#bo-nhiem-modal">Bổ nhiệm</button>
          </div>
        </div>
        `;
          $("#phong-ban-list").append(str);
        }
        $("#tao-pb-ten").val("");
        $("#tao-pb-mo-ta").val("");
        $("#tao-pb-so-phong").val("");
        // Reload funtion Tao phong ban
        ReloadFuntion();
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Chinh sua phong ban
$("#chinh-sua-pb").click(function (e) {
  e.preventDefault();
  id = $("#chinh-sua-pb-id").val();
  data = {
    id: $("#chinh-sua-pb-id").val(),
    tenphongban: $("#chinh-sua-pb-ten").val(),
    mota: $("#chinh-sua-pb-mo-ta").val(),
    sophong: $("#chinh-sua-pb-so-phong").val(),
  };
  $.ajax({
    type: "POST",
    url: "/PhongBan/ChinhSuaPhongBan",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.code === 0) {
        $(`#${id} .pb-ten`).html(data.tenphongban);
        $(`#${id} .pb-mota`).html(data.mota);
        $(`#${id} .pb-sophong`).html(data.sophong);
      } else {
        $("#warning-pb-modal").modal("show");
        $("#warning-pb-text").html(response.message);
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Xem danh sach nhan vien phong ban
$(".btn-bo-nhiem").click(function (e) {
  e.preventDefault();
  id = $(this).parent().parent().attr("id");
  $.ajax({
    type: "POST",
    url: "PhongBan/DanhSachNhanVien",
    data: { maphongban: id },
    dataType: "json",
    success: function (response) {
      if (response.code === 0) {
        $(".pb-list-nv").empty();
        $(".pb-list-nv").append(
          `<input id=${id} type='hidden'></input><select class="form-select" id="pb-nhanvien" aria-label="Default select"></select>`
        );
        response.data.forEach((e) => {
          $("#pb-nhanvien").append(`<option>${e.hoten}</option>`);
        });
      } else {
        $(".pb-list-nv").empty();
        $(".pb-list-nv").append(
          `<input id=${id} type='hidden'></input><p>${response.message}</p>`
        );
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Bo nhiem truong phong
$("#phong-ban-bo-nhiem").click(function (e) {
  e.preventDefault();
  data = {
    maphongban: $(".pb-list-nv input").attr("id"),
    truongphong: $(".pb-list-nv option:selected").html()
      ? $(".pb-list-nv option:selected").html()
      : "",
  };
  $.ajax({
    type: "POST",
    url: "PhongBan/BoNhiem",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.code === 0) {
        $(`.row-click-edit#${data.maphongban} .pb-truongphong`).val(
          response.data
        );
      } else {
        $("#warning-pb-modal").modal("show");
        $("#warning-pb-text").html(response.message);
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Di den trang chi tiet nhiem vu
$(".row-href").click(function (e) {
  e.preventDefault();
  let status = $(this).children(".status").html();
  if (status.trim() == "New" && location.pathname.includes("TruongPhong")) {
    $("#chinh-sua-task-modal").modal("show");

    $("#chinh-sua-task-id").val($(this).children("input.task-id").val());
    $("#chinh-sua-task-tieu-de").val(
      $(this).children("div.tieude").html().trim()
    );
    $("#chinh-sua-task-mo-ta").val($(this).children("input.task-mota").val());
    $("#chinh-sua-task-deadline").val(
      $(this).children("div.hanchot").html().trim()
    );
  } else {
    location.href =
      location.pathname + "/" + $(this).children(".task-id").val();
  }
});

// Switch modal start || submit
$("#btn-nop-bai").click(function (e) {
  e.preventDefault();
  let trangthai = $("#chi-tiet-trang-thai").html();
  if (trangthai.trim() === "New") {
    $("#warning-task-modal").modal("show");
    $("#warning-task-text").html("Bắt đầu nhiệm vụ trước khi nộp bài");
  } else {
    $("#nop-task-modal").modal("show");
  }
});

// Request Start
$("#btn-task-bat-dau").click(function (e) {
  e.preventDefault();
  data = {
    id: $(this).attr("manhiemvu"),
    status: "In progress",
  };
  $.ajax({
    type: "POST",
    url: "/NhiemVu/BatDau",
    data: data,
    dataType: "json",
    success: function (response) {
      $("#chi-tiet-trang-thai").html(response.data);
      $("#btn-nop-bai").html("Nộp bài");
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Request Submit
$("#nop-task").click(function (e) {
  e.preventDefault();
  data = {
    manhiemvu: $(this).attr("manhiemvu"),
    manhanvien: $("#nguoi-lam").html(),
    mota: $("#nop-task-mo-ta").val(),
    file: $("#nop-task-file")[0].files[0],
    ngaygui: new Date().toJSON().slice(0, 10).replace(/-/g, "-"),
  };
  if (data.mota == "" || data.taptin == "") {
    $("#warning-task-modal").modal("show");
    $("#warning-task-text").html("Chưa nhập đủ thông tin");
  } else if (data.file && data.file.size > 1 * 1024 ** 2) {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Tập tin quá lớn, tối đa 1 MB");
  } else {
    const formData = new FormData();
    for (let i = 0; i < Object.keys(data).length; i++) {
      formData.append(Object.keys(data)[i], Object.values(data)[i]);
    }
    $.ajax({
      type: "POST",
      url: "/NhiemVu/Submit",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.code === 0) {
          $("#task-history").prepend(
            `<div class="row row-hover row-history" data-bs-toggle="modal" data-bs-target="#lich-su-modal">
            <div class="col-4 col-sm-6-m history-nguoi-gui">
              ${response.data.manhanvien}
            </div>
            <div class="col-6 col-sm-6-m history-mo-ta">
            ${response.data.mota}
            </div>
            <div class="col-2 none history-ngay-gui">
            ${data.ngaygui}
            </div>
            <input type="hidden" value='${response.data.taptin}'></input>
          </div>`
          );
          $("#chi-tiet-trang-thai").html("Waiting");
          $("#btn-nop-bai").prop("disabled", true);
          ReloadFuntion();
        } else {
          $("#warning-nhiem-vu-modal").modal("show");
          $("#warning-nhiem-vu-text").html(response.message);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Xem chi tiet submit
$(".row-history").click(function (e) {
  e.preventDefault();
  data = {
    mota: $(this).children(".history-mo-ta").html().trim(),
    taptin: $(this).children("input").val(),
  };
  $("#lich-su-mo-ta").html(data.mota);
  $("#lich-su-file").html(
    data.taptin
      ? `<a class="file-download" href="/files/${data.taptin}" download>${data.taptin}</a>`
      : "Không có file đính kèm"
  );
});

// Tao task
$("#tao-task").click(function (e) {
  e.preventDefault();
  data = {
    tieude: $("#tao-task-tieu-de").val(),
    mota: $("#tao-task-mo-ta").val(),
    hanchot: $("#tao-task-deadline").val(),
    file: $("#tao-task-file")[0].files[0],
    nhanvien: $("#tao-task-nhan-vien option:selected").html(),
    truongphong: $(this).attr("truongphong"),
  };
  if (data.tieude == "" || data.mota == "" || data.deadline == "") {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Chưa nhập đủ thông tin");
  } else if (data.file && data.file.size > 1 * 1024 ** 2) {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Tập tin quá lớn, tối đa 1 MB");
  } else {
    const formData = new FormData();
    for (let i = 0; i < Object.keys(data).length; i++) {
      formData.append(Object.keys(data)[i], Object.values(data)[i]);
    }
    $.ajax({
      type: "POST",
      url: "/NhiemVu/TaoTask",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.code == 0) {
          $("#list-task").prepend(
            `<div class="row row-hover row-href">
            <input class="task-id" type="hidden" value='${response.data.manhiemvu}'>
            <div class="col-4 col-sm-7-m tieude">
              ${response.data.tieude}
            </div>
            <div class="col-2 none tennhanvien">
              ${response.data.tennhanvien}
            </div>
            <div class="col-2 none hanchot">
              ${response.data.deadline}
            </div>
            <div class="col-2 col-sm-5-m status">
              ${response.data.trangthai}
            </div>
            <div class="col-2 none">
            </div>
            <input type="hidden" class="task-mota" value='${response.data.mota}'>
          </div>`
          );
          ReloadFuntion();
        } else {
          console.log(response.message);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Huy task
$("#huy-task").click(function (e) {
  e.preventDefault();
  data = {
    id: $(this).parent().parent().children("#chinh-sua-task-id").val(),
  };
  $.ajax({
    type: "POST",
    url: "/NhiemVu/HuyTask",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.code === 0) {
        $(`input[value=${data.id}]`).siblings("div.status").html("Canceled");
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Chinh sua task
$("#chinh-sua-task").click(function (e) {
  e.preventDefault();
  data = {
    id: $("#chinh-sua-task-id").val(),
    tieude: $("#chinh-sua-task-tieu-de").val(),
    mota: $("#chinh-sua-task-mo-ta").val(),
    hanchot: $("#chinh-sua-task-deadline").val(),
    file: $("#chinh-sua-task-file")[0].files[0],
  };
  if (data.file && data.file.size > 1 * 1024 ** 2) {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Tập tin quá lớn, tối đa 1 MB");
  } else {
    const formData = new FormData();
    for (let i = 0; i < Object.keys(data).length; i++) {
      formData.append(Object.keys(data)[i], Object.values(data)[i]);
    }
    console.log(data.mota);
    $.ajax({
      type: "POST",
      url: "/NhiemVu/ChinhSuaTask",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.code === 0) {
          $(`input[value=${data.id}]`)
            .siblings("div.tieude")
            .html(response.data.tieude);
          $(`input[value=${data.id}]`)
            .siblings("div.hanchot")
            .html(response.data.deadline);
          $(`input[value=${data.id}]`)
            .siblings("input.task-mota")
            .val(response.data.mota);
        } else {
          $("#warning-nhiem-vu-modal").modal("show");
          $("#warning-nhiem-vu-text").html(response.message);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Hoan thanh task -> danh gia
$("#btn-task-complete").click(function (e) {
  e.preventDefault();
  data = {
    id: $(this).attr("manhiemvu"),
    ngaygui: $("#task-history div:first-child")
      .children("div.history-ngay-gui")
      .html()
      .trim(),
  };
  $.ajax({
    type: "POST",
    url: "/NhiemVu/HoanTat",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.code === 0) {
        $(".task-danhgia").empty();
        $(".task-danhgia").append(
          `<select class="form-control">
            <option>Good</option>
            <option>OK</option>
            <option>Bad</option>
           </select>`
        );
      } else {
        $(".task-danhgia").empty();
        $(".task-danhgia").append(
          `<select class="form-control">
            <option>OK</option>
            <option>Bad</option>
           </select>`
        );
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Danh gia task
$("#btn-danh-gia").click(function (e) {
  e.preventDefault();
  data = {
    id: $(this).attr("manhiemvu"),
    mucdo: $(".task-danhgia option:selected").html(),
  };
  $.ajax({
    type: "post",
    url: "/NhiemVu/DanhGia",
    data: data,
    dataType: "json",
    success: function (response) {
      $("#chi-tiet-trang-thai").html(response.data);
      $("#btn-task-complete").prop("disabled", true);
      $("#btn-task-reject").prop("disabled", true);
      $("#danh-gia").html(data.mucdo);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Chua hoan tat
$("#btn-chua-hoan-tat").click(function (e) {
  e.preventDefault();
  data = {
    id: $(this).attr("manhiemvu"),
    nguoigui: $("#nguoi-gui").html(),
    mota: $("#tuchoi-task-mo-ta").val(),
    hanchot: $("#tuchoi-task-deadline").val(),
    file: $("#tuchoi-task-file")[0].files[0],
    ngaygui: new Date().toJSON().slice(0, 10).replace(/-/g, "-"),
  };
  if (data.mota == "") {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Chưa nhập đủ thông tin");
  } else if (data.file && data.file.size > 1 * 1024 ** 2) {
    $("#warning-nhiem-vu-modal").modal("show");
    $("#warning-nhiem-vu-text").html("Tập tin quá lớn, tối đa 1 MB");
  } else {
    const formData = new FormData();
    for (let i = 0; i < Object.keys(data).length; i++) {
      formData.append(Object.keys(data)[i], Object.values(data)[i]);
    }
    $.ajax({
      type: "post",
      url: "/NhiemVu/TuChoi",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.code === 0) {
          $("#task-history").prepend(
            `<div class="row row-hover row-history" data-bs-toggle="modal" data-bs-target="#lich-su-modal">
            <div class="col-4 col-sm-6-m history-nguoi-gui">
              ${response.data.manhanvien}
            </div>
            <div class="col-6 col-sm-6-m history-mo-ta">
            ${response.data.mota}
            </div>
            <div class="col-2 none history-ngay-gui">
            ${data.ngaygui}
            </div>
            <input type="hidden" value='${response.data.taptin}'></input>
          </div>`
          );
          $("#chi-tiet-trang-thai").html("Rejected");
          $("#deadline").html(response.data.hanchot);
          $("#btn-task-complete").prop("disabled", true);
          $("#btn-task-reject").prop("disabled", true);
          ReloadFuntion();
        } else {
          $("#warning-nhiem-vu-modal").modal("show");
          $("#warning-nhiem-vu-text").html(response.message);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  }
});

// Download
$(".file-download").click(function (e) {
  e.preventDefault();
  $("#download").attr("href", "/files/" + $(this).attr("ref"));
  document.getElementById("download").click();
});

// Reload Function
function ReloadFuntion() {
  // Relaod click -> Xem tai khoan
  $(".row-click").click(function (e) {
    e.preventDefault();

    data = {
      manv: $(this).children("div.tk-manv").html(),
      hoten: $(this).children("div.tk-hoten").html(),
      phongban: $(this).children("div.tk-phongban").html(),
      chucvu: $(this).children("input.tk-chucvu").val(),
    };
    $("#tk-manv").html(data.manv);
    $("#tk-hoten").html(data.hoten);
    $("#tk-phongban").html(data.phongban);
    $("#tk-chucvu").html(data.chucvu);
  });

  // Reload click -> Chinh sua phong ban
  $(".row-click-edit").click(function (e) {
    e.preventDefault();
    data = {
      maphongban: $(this).attr("id"),
      truongphong: $(this).children("input.pb-truongphong").val(),
      tenphongban: $(this).children("div.pb-ten").html().trim(),
      sophong: $(this).children("div.pb-sophong").html().trim(),
      mota: $(this).children("div.pb-mota").html().trim(),
    };
    $("#chinh-sua-pb-id").val(data.maphongban);
    $("#chinh-sua-pb-truong-phong").val(
      data.truongphong ? data.truongphong : "Chưa bổ nhiệm"
    );
    $("#chinh-sua-pb-ten").val(data.tenphongban);
    $("#chinh-sua-pb-so-phong").val(data.sophong);
    $("#chinh-sua-pb-mo-ta").val(data.mota);
  });

  // Reload click -> reset password
  let manhanvien;
  $(".btn-reset").click(function (e) {
    e.preventDefault();
    manhanvien = $(this).parent().parent().children("div.tk-manv").html();
  });
  $("#tai-khoan-reset-password").click(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "/TaiKhoan/ResetPassword",
      data: { manv: manhanvien.trim() },
      dataType: "json",
      success: function (response) {
        console.log(response.message);
      },
      error: function (e) {
        console.log(e);
      },
    });
  });

  // Reload click -> list nhan vien phong ban
  $(".btn-bo-nhiem").click(function (e) {
    e.preventDefault();
    id = $(this).parent().parent().attr("id");
    $.ajax({
      type: "POST",
      url: "PhongBan/DanhSachNhanVien",
      data: { maphongban: id },
      dataType: "json",
      success: function (response) {
        if (response.code === 0) {
          $(".pb-list-nv").empty();
          $(".pb-list-nv").append(
            `<input id=${id} type='hidden'></input><select class="form-select" id="pb-nhanvien" aria-label="Default select"></select>`
          );
          response.data.forEach((e) => {
            $("#pb-nhanvien").append(`<option>${e.hoten}</option>`);
          });
        } else {
          $(".pb-list-nv").empty();
          $(".pb-list-nv").append(
            `<input id=${id} type='hidden'></input><p>${response.message}</p>`
          );
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });

  // Reload click -> bo nhiem truong phong
  $("#phong-ban-bo-nhiem").click(function (e) {
    e.preventDefault();
    data = {
      maphongban: $(".pb-list-nv input").attr("id"),
      truongphong: $(".pb-list-nv option:selected").html()
        ? $(".pb-list-nv option:selected").html()
        : "",
    };
    $.ajax({
      type: "POST",
      url: "PhongBan/BoNhiem",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.code === 0) {
          $(`.row-click#${maphongban} .pb-truongphng`).val(response.data);
        } else {
          $("#warning-pb-modal").modal("show");
          $("#warning-pb-text").html(response.message);
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });

  // Reload click -> history
  $(".row-history").click(function (e) {
    e.preventDefault();
    data = {
      mota: $(this).children(".history-mo-ta").html().trim(),
      taptin: $(this).children("input").val(),
    };
    $("#lich-su-mo-ta").html(data.mota);
    $("#lich-su-file").html(
      `<a class="file-download" href="/files/${data.taptin}" download>${data.taptin}</a>`
    );
  });

  // Reload click -> chi tiet task
  $(".row-href").click(function (e) {
    e.preventDefault();
    let status = $(this).children(".status").html();
    if (status.trim() == "New" && location.pathname.includes("TruongPhong")) {
      $("#chinh-sua-task-modal").modal("show");

      $("#chinh-sua-task-id").val($(this).children("input.task-id").val());
      $("#chinh-sua-task-tieu-de").val(
        $(this).children("div.tieude").html().trim()
      );
      $("#chinh-sua-task-mo-ta").val($(this).children("input.task-mota").val());
      $("#chinh-sua-task-deadline").val(
        $(this).children("div.hanchot").html().trim()
      );
    } else {
      location.href =
        location.pathname + "/" + $(this).children(".task-id").val();
    }
  });

  // Reload click -> Download
  $(".file-download").click(function (e) {
    e.preventDefault();
    $("#download").attr("href", "/files/" + $(this).attr("ref"));
    document.getElementById("download").click();
  });
}

// Responsive
$("#menu-bar").click(function (e) {
  e.preventDefault();
  $("#sidebarMenu").attr(
    "style",
    "display: block; position: fixed; top: 0; bottom: 0; min-width: 225px"
  );
});

$(".container").click(function (e) {
  e.preventDefault();
  $("#sidebarMenu").attr("style", "display: none;");
});
