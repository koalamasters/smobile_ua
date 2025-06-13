$(document).ready(function () {
  $('input[type="tel"]:not(input[type="tel"]#customer_telephone)').mask("+38 (000) 000 00-00");
  // $('input[type="tel"]').attr("autocomplete", "off");

  // $(document).on("click", ".register-form button[type='submit']", function (event) {
  //   if ($(('.register-form input[type="tel"]').val().length != 19)) {
  //     event.preventDefault();
  //   }
  // });

  $("form :input").keyup(function () {
    const phoneInput = $('form input[type="tel"]');
    if(phoneInput.val() != undefined) {
        if (phoneInput.val().length !== 19) {
            $($("form").find("button[type='submit']")).prop("disabled", true);
        } else {
            $($("form").find("button[type='submit']")).prop("disabled", false);
        }
    }

  });

  $("#checkout-cart .cart-table").change(function () {
    $(this).find(".btn-update").trigger("click");
  });
});

// $(".register-form").change(function () {
//   $('input[type="tel"]').mask("+38 (000) 000 00-00");
//   $('input[type="tel"]').attr("autocomplete", "off");

//   console.log("change");

//   if ($('input[type="tel"]').length !== 19) {
//     $(this).find('button[type="submit"]').prop("disabled", true);
//     console.log("change+");
//   } else {
//     $(this).find('button[type="submit"]').prop("disabled", false);
//     console.log("change-");
//   }

//   $('input[type="tel"]').keyup(function () {
//     if ($(this).val().length !== 19) {
//       $(this).find('button[type="submit"]').prop("disabled", true);
//       console.log("change++");
//     } else {
//       $(this).find('button[type="submit"]').prop("disabled", false);
//       console.log("change--");
//     }
//   });
// });

// $('input[type="tel"]').on("change", function () {

//   $('input[type="tel"]').mask("+38 (000) 000 00-00");
//   $('input[type="tel"]').attr("autocomplete", "off");

//   if ($("#billing_phone").val().length !== 19) {
//     $("#billing_phone").addClass("err-border");
//   } else {
//     $("#billing_phone").removeClass("err-border");
//   }
// });

$(".menu-item.flyout-menu-item.multi-level.dropdown").on("mouseenter", function () {
  const parent = $(this);
  const children = parent.find(".dropdown-menu.j-dropdown .j-menu:first");
  const childCount = parent.find(".dropdown-menu.j-dropdown .j-menu:first").children().length;

  console.log("parent", parent);
  console.log("children", children);
  console.log("childCount", childCount);

  if (childCount > 5) {
    children.addClass("scrollable");
    console.log("+++");
  }
});
