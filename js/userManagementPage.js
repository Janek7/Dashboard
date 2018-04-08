'use strict';

//VERIFY MODAL
$(".verifiedLabel").click(function () {
    var _this = this;
    this.setAttribute("data-selected", "true");
    $("#verifyModalTitle").html("Verify Infos zu " + _this.dataset['user']);
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

$("#closeVerifyModal").click(function () {
    closeVerifyModal();
});

$("#closeVerifyModalButton").click(function () {

    var label = getSelectedVerifyLabel();
    var verify = document.getElementById("verifyModalCheckBox").checked;
    var phpcall = "functions/verify.php?verify=" + (verify ? "1" : "0") + "&userid=" + label.dataset['userid'];
    $.get(phpcall, function (data, status) {
        var json = JSON.parse(data);
        for (var jsonKey in json) {
            label.setAttribute(jsonKey, json[jsonKey]);
        }
        label.setAttribute("class", "label verifiedLabel " + (verify ? "label-success" : "label-danger"));
        label.innerHTML = verify ? "Verfiziert" : "Unverfiziert";
        closeVerifyModal();
        $("#successAlertText").html("Der Verify Status von " + label.dataset['user'] + " wurde erfolgreich bearbeitet");
        $('#successAlertBox').css("display", "Block");
    });

});

function closeVerifyModal() {
    window.location.href = '#';
    $("#verifyModal").fadeOut();
    getSelectedVerifyLabel().setAttribute("data-selected", "false");
}

function getSelectedVerifyLabel() {
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



//PERMISSION MODAL
$(".permLabel").click(function () {
    $("#permModalTitle").html("Permission Infos zu " + /*_this.dataset['user']*/ " hier was einfügen");
    $("#permModal").css("display", "block");
});

$("#closePermModal").click(function () {
    closePermModal();
});

$("#closePermModalButton").click(function () {
    closePermModal();
});

function closePermModal() {
    window.location.href = '#';
    $("#permModal").fadeOut();
}