$(document).ready(function(){
    $('.list-share li').on('click', function() {
        $('.list-share li').removeClass('active-share');
        $(this).addClass('active-share');
        $('#sh').val($(this).text());
    });
});