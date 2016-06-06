var idFeedActive = $('#pestActiva').val(),
    locations = location.origin,
    urlPestanaFeed = $("." + idFeedActive).attr('id'),
    url = locations + urlPestanaFeed;

$( "#" + idFeedActive ).prepend($('<span>').css('padding-left','500px').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin fa-3x')));
$( "#" + idFeedActive ).removeClass('clearfix').addClass('active');
$( "#" + idFeedActive ).load( url );
 

$(".pestanaFeed a").on('click',function(){
    
    var id = $(this).attr('href'),
        href = $(this).attr('id');

    $( id ).empty().prepend($('<span>').css('padding-left','500px').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin fa-3x')));
    $( id ).load( locations + href );
    
});



