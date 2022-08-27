/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/custom-js.js ***!
  \***********************************/
$('#image').on('change', function () {
  //get the file name
  var fileName = $(this).val(); //replace the "Choose a file" label

  $(this).next('.custom-file-label').html(fileName);
});
/******/ })()
;