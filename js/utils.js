function getXmlHttpRequestObject() {
    alert("ajax methode");
    if(window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        alert('Ajax funktioniert bei Ihnen nicht!');
    }
}