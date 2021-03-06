@extends('vcms.main')

@section('content')
<div class="single-widget-container error-page">
    <section class="widget transparent widget-404">
        <div class="body">
            <div class="row">
                <div class="col-md-5">
                    <h1 class="text-align-center">404</h1>
                </div>
                <div class="col-md-7">
                    <div class="description">
                        <h3>Opps, it seems that this page does not exist here.</h3>
                        <p>If you are sure it should, search for it.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="widget widget-404-search">
        <div class="body no-margin">
            <form class="form-inline form-search no-margin text-align-center" method="get" action="special_search.html"
                  role="form">
                <div class="input-group">
                    <input type="search" class="form-control"
                           placeholder="Pages: Posts, Tags">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            &nbsp; Search &nbsp;
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </section>
</div>
@stop