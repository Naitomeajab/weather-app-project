function changeLanguage(language) {
    document.cookie = "lang=" + language;
    location.assign(window.location.href);
    console.log("IT WENT THROUGH! THE LANGUAGE IS" + language)
}