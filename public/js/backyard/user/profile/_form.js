/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************************!*\
  !*** ./resources/js/backyard/user/profile/_form.js ***!
  \*****************************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }
document.addEventListener('DOMContentLoaded', function (event) {
  methods.initPreviewImage();
});
var methods = {
  initPreviewImage: function initPreviewImage() {
    var elImageForm = document.getElementsByName('photo_raw')[0];
    var elTruePhoto = document.getElementById('true_photo');
    var elPreviews = document.getElementsByClassName('preview');
    elImageForm.addEventListener('change', function (e) {
      if (e.target.files) {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          var img = document.createElement("img");
          img.onload = function (e) {
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");
            canvas.width = 300;
            canvas.height = 300;
            var MAX_WIDTH = 300;
            var MAX_HEIGHT = 300;
            var width = img.width;
            var height = img.height;
            if (width > height) {
              if (width > MAX_WIDTH) {
                height = height * (MAX_WIDTH / width);
                width = MAX_WIDTH;
              }
            } else {
              if (height > MAX_HEIGHT) {
                width = width * (MAX_HEIGHT / height);
                height = MAX_HEIGHT;
              }
            }
            ctx.drawImage(img, 0, 0, 300, 300);
            var dataUrl = canvas.toDataURL(file.type);
            elTruePhoto.value = dataUrl;
            var _iterator = _createForOfIteratorHelper(elPreviews),
              _step;
            try {
              for (_iterator.s(); !(_step = _iterator.n()).done;) {
                var _elPreview = _step.value;
                _elPreview.src = dataUrl;
                _elPreview.style.display = "block";
              }
            } catch (err) {
              _iterator.e(err);
            } finally {
              _iterator.f();
            }
          };
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        elPreview.style.display = "none";
      }
    });
  }
};
/******/ })()
;