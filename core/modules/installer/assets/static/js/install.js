$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        var sideBar = $('#sidebar');
        var width_side = sideBar.width();
        if(sideBar.hasClass('tw_hidden')) {
            sideBar.removeClass('tw_hidden');
            $(this).removeClass('tw_hidden');
            sideBar.css('margin-left',0);
        } else {
            sideBar.addClass('tw_hidden');
            $(this).addClass('tw_hidden');
            sideBar.css('margin-left',width_side * (-1));
        }
    });
});