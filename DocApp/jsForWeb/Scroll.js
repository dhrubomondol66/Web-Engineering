let prevScrollPos = window.pageYOffset;
const navbar = document.querySelector(".navbar");

window.onscroll = function () {
    let currentScrollPos = window.pageYOffset;

    if (prevScrollPos > currentScrollPos) {
    navbar.style.top = "0"; // show navbar
    } else {
    navbar.style.top = "-100px"; // hide navbar (adjust if your navbar is taller)
    }

    prevScrollPos = currentScrollPos;
};