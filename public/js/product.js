var product_images = [];

$(document).ready(function () {
  ClassicEditor.create(document.querySelector("#editor"))
    .then((newEditor) => {
      quill = newEditor;
    })
    .catch((error) => {
      console.error(error);
    });

  variationSearch();
  getInitImages();
});



function getInitImages() {
  product_images = [];
  try {
    dat = JSON.parse($.trim($("#divImages").html()));
    dat.forEach(function (n) {
      var v = generateRamdomKey(6);
      product_images.push({
        id: v,
        image: `${base_url}/images/${n}`
      });
      toDataURL(
        `${base_url}/images/${n}`,
        function (dataUrl, arg) {
          var i = product_images.findIndex(function (p) {
            return p.id === arg;
          });
          if (i !== -1) {
            product_images[i].image = dataUrl;
          }
        },
        "image/png",
        v
      );
    });
    redrawImages();
  } catch (e) {
    console.log(e);
  }
}

function redrawImages() {
  $("#divProductImages").html("");
  product_images.forEach(function (e) {
    r =
      '<div class="avatar avatar-xxl position-relative mt-4 ml-2 me-2" id="av_pi_' +
      e.id +
      '" style="height: 25% !important;width: 25% !important;">' +
      '<img src="' +
      e.image +
      '" class="border-radius-md" alt="team-2" style="width:100%"/>' +
      "</div>";
    $("#divProductImages").html($("#divProductImages").html() + r);
  });
}

function variationSearch() {
  enableVTable();
}
function enableVTable() {
  if (document.getElementById("variation-list")) {
    const dataTableSearch = new DataTable("#variation-list", {
      searchable: true,
      fixedHeight: false,
      perPage: 20
    });
  }
  try {
    product_variant = [];
    dat = JSON.parse($.trim($("#divVariantData").html()));
    dat.forEach(function (n) {
      d = n;
      if (n.status === "0" || n.status === "false") {
        d.status = "false";
      } else {
        d.status = "true";
      }
      if (n.on_sale === "0" || n.on_sale === "false") {
        d.on_sale = "false";
      } else {
        d.on_sale = "true";
      }
      product_variant.push(d);
    });
  } catch (e) {
    console.log(e);
  }
}