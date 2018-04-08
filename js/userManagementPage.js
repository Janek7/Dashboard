'use strict';

const verifiedLabels = document.getElementsByClassName("verifiedLabel");
for (var index in verifiedLabels) {
    if (index == "length") break;
    const label = verifiedLabels[index];
    label.addEventListener("click", function(ev) {
        label.setAttribute("data-selected", "true");

        document.getElementById("verifyModalTitle").innerHTML = "Verify Infos zu " + label.dataset['user'];
        document.getElementById("verifyModalCheckBox").checked = label.dataset['verified'] == "1";
        if (label.dataset['verified'] == "1") {
            document.getElementById("verifier").innerHTML = label.dataset['verifier'];
            document.getElementById("verifyDate").innerHTML = label.dataset['verifydate'];
        } else {
            document.getElementById("verifierDiv").style.display = "None";
            document.getElementById("verifyDateDiv").style.display = "None";
        }
        document.getElementById("verifyModal").style.display = "block";
    });
}

document.getElementById("closeVerifyModal").addEventListener("click", function (ev) {
    document.getElementById("verifyModal").style.display = "None";
    getSelectedLabel().setAttribute("data-selected", "false");
});

function getSelectedLabel() {
    for (var labelIndex in verifiedLabels) {
        if (labelIndex == "length") {
            break;
        }
        if (verifiedLabels[labelIndex].dataset['selected'] == "true") {
            return verifiedLabels[labelIndex];
        }
    }
}


document.getElementById("closeVerifyModalButton").addEventListener("click", function (ev) {

    var updatePage = function modifyPage(req, label, verify) {
        document.getElementById("verifyModal").style.display = "None";
        /*var response = eval('(' + req.responseText+ ')');
        alert(response);*/
        //TODO: Label data attribute mit Infos aus JSON Rückgabe ändern
        label.setAttribute("class","label verifiedLabel " + (verify ? "label-success" : "label-danger"));
        label.innerHTML = verify ? "Verfiziert" : "Unverfiziert";
    };

    var req = getXmlHttpRequestObject();
    if((req.readyState == 4 || req.readyState == 0)) {
        var l = getSelectedLabel();
        var verify = document.getElementById("verifyModalCheckBox").checked;
        var phpcall = "functions/verify.php?verify=" + verify + "&userid=" + l.dataset['userid'];
        req.open('GET', phpcall, true);
        req.onreadystatechange = updatePage(req, l, verify);
        req.send();
    }

});

function getXmlHttpRequestObject() {
    if(window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        alert('Ajax funktioniert bei Ihnen nicht!');
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
