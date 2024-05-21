$(document).ready(function () {
  if (document.getElementById("selectState")) {
    var tags = document.getElementById("selectState");
    new Choices(tags, { shouldSort: false });
  }
  if (document.getElementById("selectStatus")) {
    var tags = document.getElementById("selectStatus");
    new Choices(tags, { shouldSort: false });
  }
  hSearch();
});

function hSearch() {
  var url = "";
  url = get_base_url(
    `drivers/search?state=${$("#selectState").val()}&status=${$(
      "#cmbStatus"
    ).val()}&search=${$("#txtSearch").val()}`
  );

  console.log(url);
  $("#divTableProducts").html(
    '<div style="width:180px;height:180px;">please wait...</div>'
  );
  getData2(url, "divTableDrivers", enableVTable);
}

function showActive(name) {
  $(".nav-link").removeClass("active");
  $(".tab-pane").removeClass("show active");
  $(`#btn-${name}`).addClass("active");
  $(`#${name}`).addClass("show active");
}

function showModal(id) {
  try {
    var driver = JSON.parse($.trim($("#driver_profile_" + id).html()));
    var badge = "";
    if (driver.approval_status == "Approved") {
      badge = '<span class="badge badge-success">Approved</span>';
    } else if (driver.approval_status == "Pending") {
      badge = '<span class="badge badge-warning">Pending</span>';
    } else {
      badge = '<span class="badge badge-danger">Denied</span>';
    }
    $("#btnDenyDriver").click(function () {
      $("#modelDriver").modal("hide");
      denyDriver(driver.id);
    });
    $("#btnApproveDriver").click(function () {
      $("#modelDriver").modal("hide");
      approveDriver(driver.id);
    });
    $("#h5DriverName").html(`${driver.user.firstname} ${driver.user.lastname} ${badge}`);
    $("#txtFirstname").val(driver.user.firstname);
    $("#txtLastname").val(driver.user.lastname);
    $("#txtEmail").val(driver.user.email);
    $("#txtPhoneNumber").val(driver.user.phone_number);
    $("#txtCity").val(driver.user.city);
    $("#txtState").val(driver.user.state);
    $("#txtAddress").val(driver.user.business_address);
    $("#imgDriver").attr("src", get_base_url(`images/${driver.user.photo}`));
    if (driver.driver_licence) {
      $("#txtLicenseNumber").val(driver.driver_licence.number);
      $("#txtLicenseExpiry").val(Date(driver.driver_licence.expiry_date));
      $("#frontLicense").attr(
        "src",
        get_base_url(`${driver.driver_licence.front}`)
      );
      $("#backLicense").attr(
        "src",
        get_base_url(`${driver.driver_licence.back}`)
      );
      $("#carLicenseFront").attr(
        "href",
        get_base_url(`${driver.driver_licence.front}`)
      );
      $("#carLicenseBack").attr(
        "href",
        get_base_url(`${driver.driver_licence.back}`)
      );
      $("#carLicenseBack").attr("target", "_blank");
      $("#carLicenseFront").attr("target", "_blank");
    } else {
      $("#txtLicenseNumber").val("");
      $("#txtLicenseExpiry").val("");
      $("#frontLicense").attr("src", "");
      $("#backLicense").attr("src", "");
      $("#carLicenseFront").attr("href", "");
      $("#carLicenseBack").attr("href", "");
      $("#carLicenseBack").attr("target", "");
      $("#carLicenseFront").attr("target", "");
    }
    if (driver.car_reg_details) {
      $("#txtCarColor").val(driver.car_reg_details.color);
      $("#txtCarYear").val(driver.car_reg_details.year);
      $("#txtCarModelType").val(driver.car_reg_details.model_type);
      $("#txtCarModel").val(driver.car_reg_details.model);
      $("#txtCarRegNumber").val(driver.car_reg_details.registration_number);
      $("#carImage").attr(
        "src",
        get_base_url(`${driver.car_reg_details.image}`)
      );
      $("#carFrontReg").attr(
        "src",
        get_base_url(`${driver.car_reg_details.front}`)
      );
      $("#carBackReg").attr(
        "src",
        get_base_url(`${driver.car_reg_details.back}`)
      );
      $("#carImgImage").attr(
        "href",
        get_base_url(`${driver.car_reg_details.image}`)
      );
      $("#carImgFront").attr(
        "href",
        get_base_url(`${driver.car_reg_details.front}`)
      );
      $("#carImgBack").attr(
        "href",
        get_base_url(`${driver.car_reg_details.back}`)
      );
      $("#carImgImage").attr("target", "_blank");
      $("#carImgFront").attr("target", "_blank");
      $("#carImgBack").attr("target", "_blank");
    }else{
      $("#txtCarColor").val("");
      $("#txtCarYear").val("");
      $("#txtCarModelType").val("");
      $("#txtCarModel").val("");
      $("#txtCarRegNumber").val("");
      $("#carImage").attr(
        "src",
        ""
      );
      $("#carFrontReg").attr(
        "src",
        ""
      );
      $("#carBackReg").attr(
        "src",
        ""
      );
      $("#carImgImage").attr(
        "href",
        ""
      );
      $("#carImgFront").attr(
        "href",
        ""
      );
      $("#carImgBack").attr(
        "href",
        ""
      );
      $("#carImgImage").attr("target", "");
      $("#carImgFront").attr("target", "");
      $("#carImgBack").attr("target", "");
    }
    if(driver.bank_details){
      $("#txtBankBeneficiary").val(driver.bank_details.beneficiary_name);
      $("#txtBankName").val(driver.bank_details.bank_name);
      $("#txtBankAccountNumber").val(driver.bank_details.account_number);
      $("#txtBankSwiftCode").val(driver.bank_details.swift_code);
    }else{
      $("#txtBankBeneficiary").val("");
      $("#txtBankName").val("");
      $("#txtBankAccountNumber").val("");
      $("#txtBankSwiftCode").val("");
    }
    $("#modelDriver").modal("show");
  } catch (e) {
    console.log(e);
  }
}

function enableVTable() {
  if (document.getElementById("drivers-list")) {
    const dataTableSearch = new DataTable("#drivers-list", {
      searchable: true,
      fixedHeight: false,
      perPage: 25
    });
  }
}
