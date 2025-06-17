$('.ocf-filter-header').click(function(){

    let wrapper = $(this).closest('.ocf-filter-km');



    $(wrapper).toggleClass('collapsed-wrapper')

    $(wrapper).find('.custom-list-wrapper').slideToggle();

});

function openRecentlyViewd(){
    scSidebar('Меню', 'menu');
    setTimeout(function (){
        $('#oct_sidebar_viewed_toggle').click()
    },100)
}


$(function () {
    $('.breadcrumb-item').last().on('click', function () {
        $('.breadcrumb').addClass('show-all');
    });
});
