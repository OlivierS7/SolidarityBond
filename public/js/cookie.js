function oft_setCookie(cname) {
    let d = new Date();
    d.setTime(d.getTime() + 30660000000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=y; " + expires;
}

function oft_getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1);
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
}

function oft_checkCookie() {
    let check = oft_getCookie("oft_cookieConsent");
    if (check === "y") {
        $('#oft_cookieConsent').hide();
    } else {
        $('#oft_cookieConsent').show();
    }
}

function oft_cookieConsent() {
    $("body").append('<div id="oft_cookieConsent" style="position:fixed;bottom:0;right:0;width:100%;background-color:#343A40;padding:20px;color:#e0e0e0;">' +
        '<div style="display:inline-block;padding-right:20px;">\n' +
        'Nous utilisons les cookies afin de fournir les services et fonctionnalités proposés sur notre site et afin d’améliorer l’expérience de nos utilisateurs.\n' +
        '<a class="text-warning" href="/conditions-generales-d-utilisation">Plus d\'information</a></div>' +
        '<div class="text-center"><button id="oft_cookieConsent_valid" class="btn btn-warning" style="width:125px;margin-top: 20px;">J\'accepte !</button></div>');
    oft_checkCookie();
    $('#oft_cookieConsent_valid').on('click', function(){
        oft_setCookie("oft_cookieConsent");
        $('#oft_cookieConsent').hide();
    });
}
oft_cookieConsent();