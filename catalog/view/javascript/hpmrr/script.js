    $(document).ready(function() 
    {
        init_hpmrr_event();
    });

    function card_prd(new_url, title)
    {
        $.ajax({
            type: "GET",
            url: new_url,
            //data: {'kjajax': 1 },
            success: function(response) {
                if(hpmrr_prd_config.change_url)
                {
                    window.history.pushState({}, title, new_url);
                }
                $('.tooltip').remove();
                success_ajax_product_cart(response);
            }
        });
    }

    function cat_prd(id, $hpm_block)
    {
        $.ajax({
            type: "GET",
            url: 'index.php?route=extension/module/hpmrr/product_json&pid=' + id,
            success: function(json) 
            {
                if (json['success']) 
                {
                    hpmrr_cat_config.replace_piece_cat(json['success'], $hpm_block);
                }
                $('.tooltip').remove();
            }
        });
    }

    function init_hpmrr_event() 
    {
        if ($("#product").length) 
        {
            //product card 
            window.onpopstate = function(event) {
               location.reload();
            }
        }

        if(typeof hpmrr_prd_config !=='undefined')
        {
            if(hpmrr_prd_config.refresh_price)
            {
                $(document).on('change', hpmrr_prd_config.pr_opts, function() {
                    $.ajax({
                      url: 'index.php?route=extension/module/hpmrr/get_price',
                      type: 'post',
                      data: $(hpmrr_prd_config.pr_opts),
                      success: function(json) {
                        hpmrr_prd_config.refresh_price_func(json);
                      }
                    });
                });
            }
                
            if(!hpmrr_prd_config.redirect)
            {
                $(document).on("click", ".hpm-block-prd a", function(e) {
                    e.preventDefault();
                 
                    let $target = $(this).find(".hpmcircle").length ? $(this).find(".hpmcircle") : $(this);
                    $target.addClass("text-center").height($(this).height()).css('line-height', $(this).height()+"px").width($(this).width()).html('<i class="fa fa-spinner fa-spin"></i>');
                    $(this).removeClass("disabled").addClass("active").siblings().removeClass("active");
                    card_prd($(this).attr("href"), $(this).attr("title"));
                    return false;
                });

                $(document).on("change", ".hpm-block-prd select", function(e) {
                    card_prd(this.value, $(this).find("option:selected").data('title'));
                });

                $('.dropdown-select').on( 'click', '.dropdown-menu li a', function(e) { 
                    card_prd($(this).attr("href"), $(this).attr('title'));
                    return false;
                });
            }
            else
            {
                $(document).on("change", ".hpm-block-prd select", function(e) {
                    window.location = this.value;
                });
            }
        }
        
        //category
        if(typeof hpmrr_cat_config !=='undefined')
        {
            if(!hpmrr_cat_config.redirect)
            {
                $(document).on("click", ".hpm-block-cat a", function(e) {
                    e.preventDefault();
                    
                    let $target = $(this).find(".hpmcircle").length ? $(this).find(".hpmcircle") : $(this);
                    $target.addClass("text-center").height($(this).height()).css('line-height', $(this).height()+"px").width($(this).width()).html('<i class="fa fa-spinner fa-spin"></i>');
                        $(this).removeClass("disabled").addClass("active").siblings().removeClass("active");
                    cat_prd($(this).data("pid"), $(this).parents(".hpm-block-cat"));
                    return false;
                })

                $(document).on("change", ".hpm-block-cat select", function(e) {
                    cat_prd(this.value, $(this).parents(".hpm-block-cat"));
                });

                $('.dropdown-select').on( 'click', '.dropdown-menu li a', function(e) { 
                    cat_prd($(this).data("pid"), $(this).parents(".hpm-block-cat"));
                    return false;
                });
            }
            else
            {
                $(document).on("change", ".hpm-block-cat select", function(e) {
                    window.location = $(this).find("option:selected").attr("data-link");
                });
            }
        }
    }

    function success_ajax_product_cart(data)
    {
        var $wrap_html =  $('<div>').html(data);

        hpmrr_prd_config.before_ajax($wrap_html);
        $.each(hpmrr_prd_config.ajax_replace, function(index, val) 
        {
            if ($wrap_html.find(val).length) 
            {
                $(val).html($wrap_html.find(val).html());
            } else {
                $(val).html('');
            }
        });
        $(".hpm-block-prd").remove();

        $("body").append($wrap_html.find(".hpm-block-prd")[0].outerHTML);
        hpmrr_setpos();
        hpmrr_prd_config.after_ajax($wrap_html);
    }