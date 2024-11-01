"use strict";
function openRank(type) {
  var i;
  var x = document.getElementsByClassName("type");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(type).style.display = "block";
}
