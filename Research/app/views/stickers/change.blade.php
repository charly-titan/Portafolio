<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="{{ asset('/css/stickers.css')}}">
    </head>
    <?php    $user_id = (Session::get('user.id'));    if ($user_id) {    $user_id = $user_id;    }    ?>
    <body>
        <div class="container">
            <div class="row">
                {{ Form::open(array('url' => 'tdbook/change', 'id' => 'formulario')) }}
                <div class="col-sm-2">
                    <label></label>
                    <div class="change">
                        <h1>faltan mias</h1>
                        <div class="cc-selector">
                            @foreach ($faltan_one as $sticker)
                            <div class="col-sm-12" >
                                <div class="thumbnail-container">
                                    <div class="thumbnail-body">
                                        <img class="thumbnail-img transparente" id="{{'faltan-two-'.$sticker}}" src="{{'//promociones.sinpk2.com/img/albums/tdbook/sticker'.$sticker.'.jpg'}}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>
                        <select class="form-control" id="selector" onchange="getchange()">
                            <option disable="">Amigo</option>
                            @foreach ($amigos as $amigo)
                            <option value="{{$amigo}}">{{$amigo}}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="change">
                        <h1>Quiero-Amigo</h1>
                        <div class="cc-selector" id="form-two">
                            <div id="deaqui"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label><?php echo 'mi nombre'; ?></label>
                    <div class="change">
                        <h1>Doy-Mias</h1>
                        <div class="cc-selector" id="form-one">
                            @foreach ($one as $sticker)
                            <div class="col-sm-6" >
                                <div class="thumbnail-container">
                                    <div class="thumbnail-body">
                                        <input type="checkbox" id="{{'one-'.$sticker}}" value="{{$sticker}}" name="sticker_one[]">
                                        <label class="drinkcard-cc" for="{{'one-'.$sticker}}" value="{{$sticker}}">
                                        <img class="thumbnail-img" src="{{'//promociones.sinpk2.com/img/albums/tdbook/sticker'.$sticker.'.jpg'}}">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label></label>
                    <div class="change">
                        <h1>faltan a el</h1>
                        <div class="cc-selector">
                            <div id="dealla"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button class="btn btn-primary" id="solicitar" type="button" disabled="">Solicitar</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="{{asset('/js/bootstrap/bootstrap.min.js')}}"></script>
        <script>
            function getchange() {
                selected = $( "#selector option:selected" ).text();
                $.ajax({
                    url: '/tdbook/change',
                    type: 'post',
                    data: {'selected':selected},
                    success: function(data) {
                //console.log(data);
                $( "#deaqui" ).empty();
                $( "#dealla" ).empty();
                $('input:checkbox').removeAttr('checked');
                $('.thumbnail-img').css("border", "");
                if (data != 0){
                    $.each(data.sueltos, function(i, val) {
                        $("#deaqui").append('<div class="col-sm-6" ><div class="thumbnail-container"><div class="thumbnail-body"><input type="checkbox" id="two-'+val+'" value="'+val+'" name="sticker_two[]"><label class="drinkcard-cc" for="two-'+val+'"><img class="thumbnail-img" src="//promociones.sinpk2.com/img/albums/tdbook/sticker'+val+'.jpg"></label></div></div></div>');
                    });
                    $.each(data.faltan, function(i, val) {
                        $("#dealla").append('<div class="col-sm-12" ><div class="thumbnail-container"><div class="thumbnail-body"><img class="thumbnail-img transparente" id="faltan-one-'+val+'" src="//promociones.sinpk2.com/img/albums/tdbook/sticker'+val+'.jpg"}}"></div></div></div>');
                    });
                }
                $("#form-one").change(function(data){
                    elemento= data.target;
                    find_one = '#faltan-'+elemento.id;
                    checkbox_one = 'one-'+data.target.defaultValue;
                    if ($('#'+checkbox_one).is(':checked')) {
                        $(find_one).css( "border", "3px solid blue" );
                        console.log('bordo');
                    } else {
                        $(find_one).css( "border", "" );
                        console.log('no bordo');
                    }
                });
                $("#form-two").change(function(data){
                    elemento= data.target;
                    find_two = '#faltan-'+elemento.id;
                    checkbox_two = 'two-'+data.target.defaultValue;
                    if ($('#'+checkbox_two).is(':checked')) {
                        $(find_two).css( "border", "3px solid red" );
                        console.log('bordo');
                    } else {
                        $(find_two).css( "border", "" );
                        console.log('no bordo');
                    }
                });
                $('input:checkbox').change(function() {
                    totalCheckboxes_one = $('input[name="sticker_one[]"]:checked').length;
                    totalCheckboxes_two = $('input[name="sticker_two[]"]:checked').length;
                    if (totalCheckboxes_one == totalCheckboxes_two){
                        console.log('coincide');
                        $('#solicitar').prop('disabled', false);
                    } else{
                        console.log('no coincide');
                        $('#solicitar').prop('disabled', true);
                    }
                });
            },
            error: function(data) {
                console.log('error');
                console.log(data);
            }
            });
            }
            $( "#solicitar" ).click(function() {
            $( "#formulario" ).submit();
            });
        </script>
    </body>
</html>
