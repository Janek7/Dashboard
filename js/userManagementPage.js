var verifiedLabels = document.getElementsByClassName("verifiedLabel");
for (var index in verifiedLabels) {
    verifiedLabels[index].addEventListener("click", function (ev) {
        alert("hi");
    });
}
