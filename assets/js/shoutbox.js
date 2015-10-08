/*
// show/hide Smileys box
function showSmileys() {
    var a = document.getElementById("smileys");
    var b = document.getElementById("showSmileys");
    if (a.style.display == "block") {
        a.style.display = "none";
        b.innerHTML = "<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAwRJREFUeNp8U0tPE1EYPTOdKTCUltJpC0gkCjWKtgmIjxglGIgxGl3o3oXRxKU/QGIMP0A3GuPSlStNTHShLsREQQRBeWlrJeWZgaJIZ6a1czvX7/LwsXGSM3fm3nPO/b7vfleauQ9IEqAo66Mmy+gGcJrQRPAT1ghpwhPXxQvOYTMGJB8CY49Ihz9PjBZ7Fb29tXLn2ajia9Rkb5XiFnOMmZl26+vjzp/G0AjxegipLdGWQcyVKu5Wxy8ktGibDpdmOKFoQeZQvVo04E1cDtjG/prVsfthIH9ly0R2HGgUUm+g5VxCqwrq3F4Ed0xwZv470rxYFzzBn+/H+RIwpJRK6C4P727TfH7dzRtk6YPksakgqvAnUDjcAS/lwV0T5V6fPv082r2aM9qJdU2hCE77G/ZF+NosiSgj2QIXYvENaSMXztZNzPkfeHtrHMYMC1bHkdQ1PBAGTV5V1Xj+O/HFjvnNUf6rvi4W+pcxeCeJssoQlDqPFDuxUlDKiFUswu/hTOHkxIs/N0HhFu3fWBgwMHj7M+K7u7BoZnH8agKuBB9podBrrWhZTGFMXQ9Zcjd2F81B/8aqjOEZD+J7utE3+RzHLm0HVYsJ3fopFApI5759tzlzqUhA35sFOI6HlsqwmnUwnPbi5I1XeBaYwtGLjdjZ5ofgCx0BsmniSWosvQSZEuIq6uuCmEqtIJdXMfp+BrGaCO5d70JHVy2aDlALEE/whc6yAM+ZOGa/Za2DlX5/bbCmRguGImBQ8W40g7GJNAZfT6PjcAPqa6vgUi/PZpazkx+m31Av3KQ0HMW2YVML9/T3TYVLJW+ieW9Ib9gegj+8A22HjsBD5VAlRi1bQCY5lx0Z+PSROeihEtnYPGjsigCnWhCLhdHb0FjXum//3mgoGtHKK8qVQr7AVowle3x4wpjLLI6kltHzdBKp5NLGAQsDUbEQQdd9CHQ2o/VgIw5rKrbRLlUUXc52MD+YwcDLLxjOmhDSZYK5ZSA6poKgEVT8/xFXjGoPS1w1MfFLgAEAqDZlqsFSMiIAAAAASUVORK5CYII=' title='Show Smileys'>"
    } else {
        a.style.display = "block";
        b.innerHTML = "<img src='data:image/png;base64,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' title='Hide Smileys'>"
    }
}
*/

// insert emoticons by clicking on the emoticon images
function insertSmiley(smiley) {
    var currentText = document.getElementById("shout");
    if (currentText.value == "Message") {
        currentText.value = "";
    }
    var smileyWithPadding = " " + smiley + " ";
    currentText.value += smileyWithPadding;
}

// mention user by clicking on their nicknames
function insertNickname(nickname) {
    var currentText = document.getElementById("shout");
    if (currentText.value == "Message") {
        currentText.value = "";
    }
    var nicknameWithPadding = "" + nickname + " ";
    currentText.value += nicknameWithPadding;
}

// show/hide the help info box
function help() {
    var ele1 = document.getElementById("helpbox");
    var text1 = document.getElementById("helpswitch");
    if (ele1.style.display == "block") {
        ele1.style.display = "none";
        text1.innerHTML = "[?]";
    } else {
        ele1.style.display = "block";
        text1.innerHTML = "[X]";
    }
}

// show/hide the more box
function more() {
    var ele1 = document.getElementById("morebox");
    var text1 = document.getElementById("moreswitch");
    if (ele1.style.display == "block") {
        ele1.style.display = "none";
        text1.innerHTML = "More?";
    } else {
        ele1.style.display = "block";
        text1.innerHTML = "X";
    }
}

// hide element by clicking on [X]
function hide(obj) {
    var el = document.getElementById(obj);
    el.style.display = 'none';
}

// popup the windows for administrating
function popupwindow(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2);
    //var top = (screen.height/2)-(h/2);
    var top = 100;
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

// close popup and refresh page
function refreshParent() {
    window.opener.location.href = window.opener.location.href;
      if (window.opener.progressWindow){
        window.opener.progressWindow.close()
      }
    window.close();
}