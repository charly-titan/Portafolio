@extends('vcms.main')
@section('content')

<div style=""></div>

<div class="row">
    
    <div class="col-md-9 col-md-offset-2">
        
        <section class="widget" style="position: absolute; top: 80px; width: 100%; ">
            <header>
                <h5>
                    <i class="fa fa-magic"></i>
                    Drop Zone
                </h5>
            </header>
            
            <div class="body">
                <div class="modal" style="position: relative; top: auto; right: auto; left: 5%; bottom: auto; z-index: 1; display: block; overflow: hidden; width: 90%">
                    <div class="modal-dialog" style="width: auto; padding: 0;">
                        <div class="modal-content">
                            
                            <div class="modal-header">

                                <h4 class="modal-title">Tools Drop Files</h4>
                                
                            </div>
                            
                            <div class="modal-body">
                                
                                    {{Form::open(array('method'=>'POST','url'=>'/folder_fotos','files'=>true,'class'=>'dropzone','id'=>'my-dropzone'))}}

                                    {{Form::close()}}
                            </div>
                            
                            <div class="modal-footer">

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
            
        </section>
        
    </div>

</div> 







         
      









<!--<!doctype html>

<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <title>dropzone</title>
        <link href="css/dropzone.css" rel="stylesheet">
        <script src="js/dropzone.js"></script>
    </head>
    
    <body>
        
        <form action="file-upload.php" method="post" enctype="multipart/form-data"  class="dropzone"></form>

    </body>
</html>-->














