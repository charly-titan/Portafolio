 $(".left").on('click',function(){
        var leftWeek = $(this).attr('id'),
            location = window.location.origin;
            console.log(location+leftWeek)

        $( "#tableFeedsRes" ).load(location+leftWeek);
    });

    $(".right").on('click',function(){

        var rightWeek = $(this).attr('id'),
            location = window.location.origin;

        $( "#tableFeedsRes" ).load(location+rightWeek);
    });

    var lang = $("#language-combo").val(),

        meses = Array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
        months = Array('','January','February','March','April','May','June','July','August','September','October','November','December'),
        month =$("#month").val(),
        monthAct = '';


    (lang == 'es') ? monthAct = meses : monthAct = months;

        $.each(monthAct,function(key,val){
            if(key == month){$("#weekR").text(val);}
        });
    
    $(".glyEdit").mouseover(function(){
        $(this).css("opacity",2);
    }).mouseout(function(){

        $(this).css("opacity",.2);
    });

    $(".update").on('click',function(){

        var $this = $(this),
            id = $this.attr("id"),
            parm = id.split("@"),
            idFeed = parm[0],
            dateFeed = parm[1],
            location = window.location.origin;

        $this.empty('a');
        $this.prepend($('<span>').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin')));

            $.ajax({
                url: location+'/escaletas/updatefeed/'+idFeed+'/'+dateFeed,
                type: 'POST',
                data: {idFeed:idFeed,dateFeed:dateFeed},
                dataType: 'JSON',
                success: function(data) { 

                    window.location.href = location+"/adminFeeds/tableFeedsRes";
                }//fin success
            })//fin ajax
    })
