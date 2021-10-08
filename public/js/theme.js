const body = document.body;
const darkModeToggle = document.getElementById('dark-mode-toggle');

document.addEventListener("DOMContentLoaded", ()=> {
    if (localStorage.getItem("theme-white")) {
        setTheme(JSON.parse(localStorage.getItem("theme-white")));
    } else {
        setTheme(body.classList.contains("theme-white") ? true : false);
    }
})

darkModeToggle.addEventListener('click', ()=> {
    setTheme(body.classList.contains("theme-white") ? false : true);
})

function setTheme(white) {

    localStorage.setItem('theme-white', white);
    if (white) {
        body.classList.add('theme-white');
    }
    else {
        body.classList.remove('theme-white');
    }
    document.querySelector('link[href$="theme-dark.css"]').disabled = white;

}
