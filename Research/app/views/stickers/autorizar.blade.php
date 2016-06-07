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
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="change">
                        <h1>Mias</h1>
                        <div class="cc-selector" id="form-two">
                            @foreach ($sticker_one as $sticker)
                            <div class="col-sm-6" >
                                <div class="thumbnail-container">
                                    <div class="thumbnail-body">
                                            <img class="thumbnail-img" src="{{'//promociones.sinpk2.com/img/albums/tdbook/sticker'.$sticker.'.jpg'}}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="change">
                        <h1>Amigo</h1>
                        <div class="cc-selector" id="form-one">
                            @foreach ($sticker_two as $sticker)
                            <div class="col-sm-6" >
                                <div class="thumbnail-container">
                                    <div class="thumbnail-body">
                                            <img class="thumbnail-img" src="{{'//promociones.sinpk2.com/img/albums/tdbook/sticker'.$sticker.'.jpg'}}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
