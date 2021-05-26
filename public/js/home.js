$(document).ready(function () {

    // Open and close menu
    $('.js--open-menu').click(function() {
        $('.nav').addClass('nav-small')
    })

    $('.js--close-menu').click(function() {
        $('.nav').removeClass('nav-small')
    })

    $('#menucontainer').click(function() {
        $('.nav').removeClass('nav-small')
    })
});