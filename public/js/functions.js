function getData(url, id1) {
  //alert(url);
  $.get(url, function (data) {
    $("#" + id1).html(data);
  });
  //is_processing = false;
}

function getData2(url, id1, func, arg) {
  //alert(url);
  $.get(url, function (data) {
    $("#" + id1).html(data);
    if (typeof arg === "undefined") {
      func();
    } else {
      func(arg);
    }
  });
  //is_processing = false;
}
function generateRamdomKey(count) {
  var result = "";
  var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for (var i = count; i > 0; --i)
    result += chars[Math.floor(Math.random() * chars.length)];
  return result;
}


function toDataURL(src, callback, outputFormat, args) {
  var img = new Image();
  img.crossOrigin = "Anonymous";
  img.onload = function () {
    var canvas = document.createElement("CANVAS");
    var ctx = canvas.getContext("2d");
    var dataURL;
    canvas.height = this.naturalHeight;
    canvas.width = this.naturalWidth;
    ctx.drawImage(this, 0, 0);
    dataURL = canvas.toDataURL(outputFormat);
    delete canvas;
    delete ctx;
    callback(dataURL, args);
  };
  img.src = src;
}