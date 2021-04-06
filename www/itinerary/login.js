function init() {
    gapi.load('auth2', function() {
    });
}

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();

    var email = profile.getEmail();
    var first = profile.getGivenName();
    var last = profile.getFamilyName();

    gapi.auth2.getAuthInstance().disconnect();

    
    window.location.replace("objects/ProcessLogin.php?google=true&password=&email=" + email + "&first=" + first + "&last=" + last);
  }