function gtag_add_to_cart(){
    // gtag("event", "add_to_cart");
    // console.log('add_to_cart')
}

function gtag_begin_checkout(){
    gtag("event", "begin_checkout");
    console.log('begin_checkout')
}

function gtag_cart_open(){
    gtag("event", "cart_open");
    console.log('cart_open')
}
function gtag_checkout_finished(){
    gtag("event", "checkout_finished");
    console.log('checkout_finished')
}
function gtag_phone_click(){
    gtag("event", "phone_click");
    console.log('phone_click')
}
function gtag_product_view(){
    gtag("event", "product_view");
    console.log('product_view')
}

function gtag_tedee_catalog_click(){
    gtag("event", "tedee_catalog_click");
    console.log('tedee_catalog_click')
}


// form_sent - catalog/view/theme/journal3/js/journal.js


// Детальна карточка товару, купити
$(document).on('click','#product-product #button-cart', function(){
    gtag_add_to_cart();
});

// Детальна карточка товару, в 1 клік
$(document).on('click','#product-product .extra-group .btn-extra-46', function(){
    gtag_add_to_cart();

});

// Список товарів, купити
$(document).on('click','.product-thumb .cart-group .btn-cart', function(){
    gtag_add_to_cart();
});

// Телефон в шапці
$(document).on('click','#main-menu-2 .main-menu-item-1 a', function(){
    gtag_phone_click();
});

// Телефон на сторінці контактів
$(document).on('click','.module-info_blocks.module-info_blocks-194 .module-body .module-item-2', function(){
    gtag_phone_click();
});



if (window.location.pathname === "/tedee-ua") {
    console.log('tedee2')


    $(document).on('click','a[href="https://smobile.ua/rozumnyj-zamok-tedee_ua"]', function(e){
        e.preventDefault()
        gtag_tedee_catalog_click();

        setTimeout(function (){
            window.location = 'https://smobile.ua/rozumnyj-zamok-tedee_ua'
        }, 550)

    });

    $(document).on('click','a[href="/rozumnyj-zamok-tedee_ua"]', function(e){
        e.preventDefault()
        gtag_tedee_catalog_click();

        setTimeout(function (){
            window.location = 'https://smobile.ua/rozumnyj-zamok-tedee_ua'
        }, 550)

    });

    $(document).on('click','.tedee_color a', function(e){
        e.preventDefault()
        gtag_tedee_catalog_click();

        setTimeout(function (){
            window.location = 'https://smobile.ua/rozumnyj-zamok-tedee_ua'
        }, 550)

    });
}


