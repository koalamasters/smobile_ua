let isMonoCheckoutBtnOnProductPage = false;

function mono_checkout_init() {
    let cartSingleAdd = false;

    $(document).on('click', '#mono_checkout_cart_page', function() {
        isMonoCheckoutBtnOnProductPage = false;
        addOrder();
    })
    $(document).on('click', '#mono_checkout_cart_modal', function() {
        isMonoCheckoutBtnOnProductPage = false;
        addOrder();
    })
    $(document).on('click', '#mono_checkout_product_page', async function (e) {
        e.preventDefault()
        await fetch('index.php?route=extension/module/mono_checkout/prepareForItem')
        cartSingleAdd = true
        isMonoCheckoutBtnOnProductPage = true;

        if ($('#button-cart').hasClass('added_to_cart_in_product_page')) {
            ajaxAfterButtonCartClick(); // ця функція знаходиться в файлі product/product.twig
        } else {
            $('#button-cart').click();
        }
    })

    $(document).on("ajaxComplete", function (event, xhr, settings) {
        if (settings.url === 'index.php?route=checkout/cart/add' && !xhr.responseJSON.error && cartSingleAdd) {
            cartSingleAdd = false
            setTimeout(addOrder, 300)
        }
    });
}

async function addOrder() {
    $(this).attr('disabled', true)
    const response = await fetch('index.php?route=extension/module/mono_checkout/addOrder')
    const data = await response.json()
    $(this).attr('disabled', false)

    if (!data.result) {
        new Noty({
            text: data.message,
            type: 'warning',
            layout: 'topRight',
            theme: 'mint',
            closeWith: ['click', 'button'],
            timeout: 3500
        }).show();
    }

    if(data.result && data.result.redirect_url) {
        if (
            isMonoCheckoutBtnOnProductPage
        ) {
            // Якщо клік по кнопці "Mono Checkout" на сторінці товару
            let price = $('#mono_checkout_product_page').data('order-price');
            fbq('track', 'mono_checkout', {
                currency: "UAH",
                value: Number(price)
            });
        }
        location = data.result.redirect_url;
    }
}

$(document).ready(function () {
    mono_checkout_init()
})