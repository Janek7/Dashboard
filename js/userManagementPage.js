'use strict';

$(".verifiedLabel").click(function () {
    var _this = this;
    this.setAttribute("data-selected", "true");
    $("#verifyModalTitle").html("Verify Infos zu " + _this.dataset['user']);
    //document.getElementById("verifyModalTitle").innerHTML = "Verify Infos zu " + this.dataset['user'];
    document.getElementById("verifyModalCheckBox").checked = this.dataset['verified'] == "1";
    if (this.dataset['verified'] == "1") {
        $("#verifier").html(this.dataset['verifier']);
        $("#verifyDate").html(this.dataset['verifydate']);
    } else {
        $("#verifierDiv").css("display", "None");
        $("#verifyDateDiv").css("display", "None");
    }
    $("#verifyModal").css("display", "block");
});

$("#closeVerifyModal").click(function (ev) {
    $("#verifyModal").fadeOut();
    getSelectedLabel().setAttribute("data-selected", "false");
});

$("#closeVerifyModalButton").click(function (ev) {

    var label = getSelectedLabel();
    var verify = document.getElementById("verifyModalCheckBox").checked;
    var phpcall = "functions/verify.php?verify=" + (verify ? "1" : "0") + "&userid=" + label.dataset['userid'];
    $.get(phpcall, function (data, status) {
        var json = JSON.parse(data);
        alert(json.length);
        for (var jsonKey in json) {
            label.setAttribute(jsonKey, json[jsonKey]);
        }
        label.setAttribute("class", "label verifiedLabel " + (verify ? "label-success" : "label-danger"));
        label.innerHTML = verify ? "Verfiziert" : "Unverfiziert";
        $("#verifyModal").fadeOut();
    });

});

function getSelectedLabel() {
    const verifiedLabels = document.getElementsByClassName("verifiedLabel");
    for (var labelIndex in verifiedLabels) {
        if (labelIndex == "length") {
            break;
        }
        if (verifiedLabels[labelIndex].dataset['selected'] == "true") {
            return verifiedLabels[labelIndex];
        }
    }
}



/*
var contentWithoutModals = document.querySelectorAll(":not(.modal-dialog *)");
for (var contentIndex in contentWithoutModals) {
    contentWithoutModals[contentIndex].addEventListener("click", function (ev) {
        var modals = document.getElementsByClassName("model-dialog");
        for (var modalIndex in modals) {
            alert("hi");
            //modals[modalIndex].style.display = "None";
        }

    });
}*/
