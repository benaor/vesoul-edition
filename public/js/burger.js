//burger menu
$(document).ready(function () {

    $("#openBurger").click(function () {
        $('#menu-burger').animate({ height: '100vh' }, 1000);
    });

    $("#closeBurger").click(function () {
        $('#menu-burger').animate({ height: '0vh' }, 1000);
    });
    
    $(".lien-burger").click(function () {
        $('#menu-burger').animate({ height: '0vh' }, 1000);
    });

});