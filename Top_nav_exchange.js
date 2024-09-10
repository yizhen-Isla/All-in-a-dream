
$(document).ready(function() {
    let TopHeader = $('.TopHeader');   // 要隱藏或顯示的物件
    let header_searchBar = $('#header_searchBar')  // 位移到的地方
    let sticky = header_searchBar.offset().top;

    $(window).on('scroll', function() {
        if ($(this).scrollTop() >= sticky) {
            TopHeader.addClass('sticky').removeClass('x');
        } else {
            TopHeader.removeClass('sticky').addClass('x');
        }
    });
});