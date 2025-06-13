$(document).ready(function () {
    setTimeout(function () {
        $(".popup-question").fadeIn();
        console.log(this);
    }, 15000);

    $(document).on("click", ".contact-popup-button", function () {
        $(".popup-question").css('display', 'none');
    });

    $(document).on("click", ".popup-question", function () {
        $(".contact-popup-button").trigger("click");
        $(".popup-question").css('display', 'none');
    });
});


function copyFromInput(input) {
	let link_input = $("#"+input);
	link_input.removeClass('hidden');
	link_input.select();
	document.execCommand("copy");
	link_input.addClass('hidden');

   $('.success_copied').css('opacity',1)
   setTimeout(function(){
	   $('.success_copied').css('opacity',0)
   }, 3000)
}

function closeContact(){

    document.querySelector('.contact-popup').classList.remove('active');
    document.querySelector('.contact-popup-items').classList.remove('active');
    document.querySelector('.contact-popup-items').classList.remove('up');
    document.querySelector('.contact-popup-items').classList.remove('up');
    document.querySelector('.contact-popup-bg').style.opacity = 0
    setTimeout(function(){
        document.querySelector('.contact-popup-bg').classList.remove('active');
    },300);

}

function openContact(){

    document.querySelector('.contact-popup').classList.add('active');
    document.querySelector('.contact-popup-items').classList.add('active');
    setTimeout(function(){
        document.querySelector('.contact-popup-items').classList.add('up');
    },25);

    document.querySelector('.contact-popup-bg').classList.add('active');
    setTimeout(function(){
        document.querySelector('.contact-popup-bg').style.opacity = 1
    },25);
}


document.querySelector('.contact-popup-button').onclick  = function(){
    if( document.querySelector('.contact-popup-items').classList.contains('active') ){
        closeContact();
    }else{
        openContact();
    }
};


document.querySelector('.contact-popup-bg').onclick = function(){
    closeContact()
}

document.onkeydown = function(e){
    if(e.code == 'Escape'){
        closeContact();
    }
}