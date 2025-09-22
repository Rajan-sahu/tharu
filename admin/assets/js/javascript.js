// ✅ Success: ✅

// ❌ Error: ❌

// ⚠️ Warning: ⚠️

// ℹ️ Info: ℹ️

//admin login 


function show_delete(del_id, this_btn, table_name) {
  swal({
    title: "Confirm Deletion",
    text: "This action cannot be undone. Are you sure you want to delete this data?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        url: './config/request/del.php',
        type: "POST",
        data: { del_id: del_id, table_name: table_name },
        success: function (res) {

          try {
            let json = JSON.parse(res);
            if (json.status === 200) {
              setTimeout(() => window.location.reload(), 1000);
              Toastify({
                text: "✅" + json.message,
                duration: 3000,
                style: {
                  background: "#ffffff", // white background
                  color: " #28a745", // red text
                  zIndex: 9999,
                  border: "1px solid #28a745",
                  fontWeight: "bold",
                  fontSize: "16px",
                  pdding: "10px 20px",
                },
              }).showToast();
            } else {
              json.key && $(`.${json.key}`).text();
              Toastify({
                text: "❌" + json.message,
                duration: 3000,
                style: {
                  background: "#ffffff", // white background
                  color: " #FA5252", // red text
                  zIndex: 9999,
                  border: "1px solid #FF0000",
                  fontWeight: "bold",
                },
              }).showToast();
            }
          } catch {
            Toastify({
              text: "❌ An error occurred. Please try again.",
              duration: 3000,
              style: {
                background: "#ffffff", // white background
                color: "#FA5252", // red text
                zIndex: 9999,
                border: "1px solid #FF0000",
                fontWeight: "bold",
              },
            }).showToast();
          }
        },
        error: function (jqXHR) {
          $("#sub_btn").prop("disabled", false);
          // formStop();
          try {
            let json = JSON.parse(jqXHR.responseText);
            console.log(json);
            if ([400, 401, 500].includes(json.status)) {
              Toastify({
                text: "❌ " + json.message,
                duration: 3000,
                style: {
                  background: "#ffffff", // white background
                  color: "#FA5252", // red text
                  zIndex: 9999,
                  fontWeight: "bold",
                },
              }).showToast();
            }
          } catch {
            Toastify({
              text: "❌" + "An error occurred while submitting the form. Please try again later.",
              duration: 3000,
              style: {
                background: "#ffffff", // white background
                color: "#FA5252", // red text
                zIndex: 9999,
                fontWeight: "bold",
              },
            }).showToast();
          }
        },
      });
    }
  });
}

function delete_table(button_class, table_name_tb) {
  $(document).on("click", button_class, function (e) {
    e.preventDefault();
    let this_btn = $(this);
    let del_id = $(this).data("del_id");
    let table_name = table_name_tb;
    // alert(del_id);
    show_delete(del_id, this_btn, table_name);
  });
}





$(document).on("submit", "#login_form", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/login.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200) {
          setTimeout(() => window.location.assign("./index.php"), 500);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});



$(document).on("submit", "#station_add", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/station_add.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200 || json.status === 201) {
          setTimeout(() => window.location.reload(), 1000);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});


$(document).on("submit", "#department_add", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/department_add.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200 || json.status === 201) {
          setTimeout(() => window.location.reload(), 1000);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});

delete_table(".delete-department", 1);
delete_table(".delete-designation", 2);
delete_table(".delete-employee", 3);
delete_table(".delete-shift", 4);
delete_table(".delete-station", 5);

$(document).on("submit", "#designation_add", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/designation_add.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200 || json.status === 201) {
          setTimeout(() => window.location.reload(), 1000);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});

$(document).on("submit", "#shift_add", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/shift_add.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200 || json.status === 201) {
          setTimeout(() => window.location.reload(), 1000);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});

$(document).on("submit", "#employee_add", function (e) {
  e.preventDefault();
  $("#sub_btn").prop("disabled", true);
  $(".error-span").text("");
  const formData = new FormData(this);
  $.ajax({
    url: "./config/request/employee_add.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (res) {
      console.log(res);

      $("#sub_btn").prop("disabled", false);
      try {
        let json = JSON.parse(res);
        if (json.status === 200 || json.status === 201) {
          setTimeout(() => window.location.reload(), 1000);
          Toastify({
            text: "✅" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #28a745", // red text
              zIndex: 9999,
              border: "1px solid #28a745",
              fontWeight: "bold",
              fontSize: "16px",
              pdding: "10px 20px",
            },
          }).showToast();
        } else {
          json.key && $(`.${json.key}`).text();
          Toastify({
            text: "❌" + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: " #FA5252", // red text
              zIndex: 9999,
              border: "1px solid #FF0000",
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌ An error occurred. Please try again.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            border: "1px solid #FF0000",
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
    error: function (jqXHR) {
      $("#sub_btn").prop("disabled", false);
      // formStop();
      try {
        let json = JSON.parse(jqXHR.responseText);
        console.log(json);
        if ([400, 401, 500].includes(json.status)) {
          Toastify({
            text: "❌ " + json.message,
            duration: 3000,
            style: {
              background: "#ffffff", // white background
              color: "#FA5252", // red text
              zIndex: 9999,
              fontWeight: "bold",
            },
          }).showToast();
        }
      } catch {
        Toastify({
          text: "❌" + "An error occurred while submitting the form. Please try again later.",
          duration: 3000,
          style: {
            background: "#ffffff", // white background
            color: "#FA5252", // red text
            zIndex: 9999,
            fontWeight: "bold",
          },
        }).showToast();
      }
    },
  });
});






