// ======== MENU BURGER ========

const burger = document.getElementById("burger");
const navMobile = document.getElementById("nav-mobile");

if (burger && navMobile) {
    burger.addEventListener("click", () => {
        navMobile.classList.toggle("open");
    });
}