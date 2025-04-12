function toggleSideMenu() {
    const sideMenu = document.getElementById("sideMenu");
    const overlay = document.getElementById("overlay");

    sideMenu.classList.toggle("show");
    overlay.classList.toggle("show");

    if (sideMenu.classList.contains('show')) {
        menuButton.classList.add('hide');
    } else {
        menuButton.classList.remove('hide');
    }
}
