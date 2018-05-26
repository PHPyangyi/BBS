window.onload=function (ev) {
    var img=document.getElementsByTagName('img');
    for (var i=0; i<img.length; i++) {
        img[i].onclick=function (ev2) {
             _opener(this.alt);
        }
    }
}

function _opener(src) {
            opener.document.getElementById('faceimg').src = src;
            opener.document.register.face.value = src;
            window.close();
}
