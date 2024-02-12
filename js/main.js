document.getElementById("main").scrollIntoView({behavior: 'smooth', block: 'start'});
function changeLanguage(language) {
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 7);
    var expires = expirationDate.toUTCString();
    document.cookie = "lang=" + language + "; expires=" + expires + "; path=/";

    location.assign(window.location.href);
}
//redirects to desired page in the same folder, keeping the GET value.
function redirect(Page) {
    var GET = window.location.search;
    var Url = Page + GET;
    window.location.href = Url;
}
//Hide or display the forecast for each entry for a certain day
function expandList(listId) {
    var fullClassName = "forecast-block-"+listId;
    var elements = document.getElementsByClassName(fullClassName);
    var buttonIcon = document.getElementById("forecast-list-icon-"+listId);

    for (let i = 0; i < elements.length; i++) {
        var element = elements[i];
        var computedStyle = window.getComputedStyle(element);

        if (computedStyle.display === 'none') {
            element.style.display = "flex";
            buttonIcon.innerHTML = '<i class="bi bi-caret-down-fill"></i>';
        } else {
            element.style.display = "none";
            buttonIcon.innerHTML = '<i class="bi bi-caret-right-fill"></i>';
        }
    }
}