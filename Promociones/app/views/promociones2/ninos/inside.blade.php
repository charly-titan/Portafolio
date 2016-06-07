@section('inside')

    <div class="hidden-smartphone" style="display: inline-flex;width: 100%;text-align: initial;">

        <div class="box-top5" >
            <div class="top5">
                <h2 class="titulo-top">{{(isset($info->properties['TxtNinosOpt1']))?$info->properties['TxtNinosOpt1']:''}}</h2>
                <a href="{{(isset($info->properties['UrlNinosOpt1']))?$info->properties['UrlNinosOpt1']:''}}"><img src="{{(isset($info->properties['ImgNinosOpt1']))?$info->properties['ImgNinosOpt1']:''}}" height="300" width="300"></a>
             
            </div>
        </div>
        <div class="box-top5" >
            <div class="top5">
                <h2 class="titulo-top">{{(isset($info->properties['TxtNinosOpt2']))?$info->properties['TxtNinosOpt2']:''}}</h2>
                <a href="{{(isset($info->properties['UrlNinosOpt2']))?$info->properties['UrlNinosOpt2']:''}}"><img src="{{(isset($info->properties['ImgNinosOpt2']))?$info->properties['ImgNinosOpt2']:''}}" height="300" width="300"></a>   
            </div>
        </div>
        <div class="box-top5" >
            <div class="top5">
                <h2 class="titulo-top" style="margin-bottom: 10%;margin-top: 11%;">{{(isset($info->properties['TxtNinosOpt3']))?$info->properties['TxtNinosOpt3']:''}}</h2>
                <a href="{{(isset($info->properties['UrlNinosOpt3']))?$info->properties['UrlNinosOpt3']:''}}"><img src="{{(isset($info->properties['ImgNinosOpt3']))?$info->properties['ImgNinosOpt3']:''}}" height="300" width="300"></a>   
            </div>
        </div>
    </div>

    <div class="vs-sec-ganaste hidden-desktop" >

    </div>
                        
                        
        
@show