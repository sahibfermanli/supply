$(document).ready(function () {
  var s_width = screen.width;
  if (s_width < 992) {
    $('.message-mobile').css('display', 'none');
    $('.cats-mobile').css('display', 'block');
  }
  else {
    $('.cats-mobile').css('display', 'none');
    $('.message-mobile').css('display', 'block');
  }

  $(window).resize(function(){
    var s_width = screen.width;
    if (s_width < 992) {
      $('.message-mobile').css('display', 'none');
      $('.cats-mobile').css('display', 'block');
    }
    else {
      $('.cats-mobile').css('display', 'none');
      $('.message-mobile').css('display', 'block');
    }
  });
});

$('.cat-li-mobile').click(function() {
  $('.tables-mobile').css('display', 'block');
  $('.cats-mobile').css('display', 'none');
  $('.btn-mobile').css('display', 'inline-block');
});

$('.btn-mobile').click(function() {
  $('.tables-mobile').css('display', 'none');
  $('.cats-mobile').css('display', 'block');
  $('.btn-mobile').css('display', 'none');
});
