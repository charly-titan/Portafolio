    <!-- BEGIN: TITULO -->
        <div class="iu-texto">
            <div class="terminos-condiciones">
            	@if (!isset($promo_info))
                <h2 class="title">{{isset($questionAll->questionText)?$questionAll->questionText:''}}</h2>
                <h4 class="resumen_login">{{isset($info->properties['descriptionContest'])?$info->properties['descriptionContest']:''}}</h4>
                @else
                <h2 class="title">{{isset($info->properties['titleThanks'])?$info->properties['titleThanks']:''}}</h2>
                <h4 class="resumen_login">{{isset($contentText->textThanks)?$contentText->textThanks:''}}</h4>
                @endif
            </div>
        </div>
    <!-- END: TITULO -->
