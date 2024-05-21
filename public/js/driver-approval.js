async function approveDriver(id, source) {
  const apiUrl = get_base_url("driver/approve");
  const response = await fetch(apiUrl, {
    method: "POST",
    body: JSON.stringify({
      _token: $('[name="_token"]').val(),
      id: id
    }),
    headers: {
      "Content-type": "application/json; charset=UTF-8"
    }
  });
  console.log(response);
  if (!response.ok) {
    Swal.fire({
      title: "Something Went Wrong",
      text: response.statusText,
      icon: "error"
    });
  } else {
    var resp = await response.json();
    Swal.fire({
      title: `Result`,
      icon: "success",
      text: resp.message,
      timer: 1000,
      willClose: () => {
        if (source == "driver_view") {
          window.location.reload();
        } else {
          hSearch();
        }
      }
    });
  }
}

async function denyDriver(id, source) {
  Swal.fire({
    title: "Are you sure?",
    text: "Are you sure you want to deny the driver?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes Deny Driver!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Please enter your reason for denying this driver",
        input: "textarea",
        inputLabel: "Denial Reason",
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Deny Driver",
        showLoaderOnConfirm: true,
        preConfirm: async (reason) => {
          try {
            const apiUrl = get_base_url("driver/deny");
            const response = await fetch(apiUrl, {
              method: "POST",
              body: JSON.stringify({
                _token: $('[name="_token"]').val(),
                id: id,
                img: reason
              }),
              headers: {
                "Content-type": "application/json; charset=UTF-8"
              }
            });
            if (!response.ok) {
              return Swal.showValidationMessage(`
          ${JSON.stringify(await response.json())}
        `);
            }
            return response.json();
          } catch (error) {
            Swal.showValidationMessage(`
        Request failed: ${error}
      `);
          }
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed) {
          if (result.value.status) {
            Swal.fire({
              title: `Result`,
              icon: "success",
              timer: 1000,
              willClose: () => {
                if (source == "driver_view") {
                  window.location.reload();
                } else {
                  hSearch();
                }
              }
            });
          } else {
            Swal.fire({
              text: result.value.message,
              title: `Something Went Wrong`,
              icon: "error"
            });
          }
        }
      });
    }
  });
}
