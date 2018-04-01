'use strict';

var timeDisplay = document.getElementById("time");
setInterval(function () {
    timeDisplay.innerHTML = new Date().toLocaleString("DE");
},0 , 1000);