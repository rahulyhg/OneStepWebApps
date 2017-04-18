$('.toggle').on('click', function() {
  $('.container').stop().addClass('active');
  var ht = $('.fusion-image-wrapper').height();
  ht += 330;
  $("#containerclass").css({'height':ht+'px'});
});

$('.close').on('click', function() {
  $('.container').stop().removeClass('active');
  $("#containerclass").css({'height':'auto'});
});