// Time Zone Responsive
window.onload = function () {
  jam();
};

function jam() {
  let e = document.getElementById("jam"),
    d = new Date(),
    h,
    m,
    s;
  h = d.getHours();
  m = set(d.getMinutes());
  s = set(d.getSeconds());

  e.innerHTML = h + ":" + m + ":" + s;

  setTimeout("jam()", 1000);
}

function set(e) {
  e = e < 10 ? "0" + e : e;
  return e;
}

// Active Page Highlight On Click
$(document).ready(function () {
  let nav = $("a[href='" + window.location.href + "']");
  nav.parent().addClass("active");
});

// Preview Images
function previewImgUser() {
  const imgUser = document.querySelector("#imgUser");
  const imgUserLabel = document.querySelector(".custom-file-label");
  const imgUserPreview = document.querySelector(".img-preview");

  imgUserLabel.textContent = imgUser.files[0].name;

  const fileImgUser = new FileReader();
  fileImgUser.readAsDataURL(imgUser.files[0]);

  fileImgUser.onload = function (e) {
    imgUserPreview.src = e.target.result;
  };
}

function previewImgRapma() {
  const imgRapma = document.querySelector("#imgRapma");
  const imgRapmaLabel = document.querySelector(".custom-file-label");
  const imgRapmaPreview = document.querySelector(".img-preview");

  imgRapmaLabel.textContent = imgRapma.files[0].name;

  const fileImgRapma = new FileReader();
  fileImgRapma.readAsDataURL(imgRapma.files[0]);

  fileImgRapma.onload = function (e) {
    imgRapmaPreview.src = e.target.result;
  };
}
