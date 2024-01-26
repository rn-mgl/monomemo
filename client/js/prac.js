const func = () => {
    const $sideNav = $("#sidenav");
    const currWidth = $sideNav.width();

    if (currWidth == "80") {
        $sideNav.width("465")
    } else {
        $sideNav.width("80")

    }
}