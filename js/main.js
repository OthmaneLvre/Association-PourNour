// ======== MENU BURGER ========

const burger = document.getElementById("burger");
const navMobile = document.getElementById("nav-mobile");

burger.addEventListener("click", () => {
    navMobile.classList.toggle("active");
});
