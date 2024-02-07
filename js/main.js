function changeLanguage(language) {
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 7);
    var expires = expirationDate.toUTCString();
    document.cookie = "lang=" + language + "; expires=" + expires + "; path=/";

    location.assign(window.location.href);
}