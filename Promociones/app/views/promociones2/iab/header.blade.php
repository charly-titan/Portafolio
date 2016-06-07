@section('header')
<style type="text/css">
	.navbar-brand{ position: relative;}
	.navbar-brand img{ position: absolute; top: 15px; }
	#mainHeader{
	    margin-bottom: 0px!important;
	    min-height: 88px;
	}
	div.styleSwitcher{ display: none;}
</style>
<!-- header -->
<header id="mainHeader" class="navbar-fixed-top" role="banner">
<div class="container">
	<nav class="navbar navbar-default scrollMenu" role="navigation">
    	<div class="navbar-header">
        	<a class="navbar-brand" href="#">{{ HTML::image('/aib/files/images/loguito-1.png') }}</a> 
    	</div>
    </nav>
</div>
</header>
<!-- header -->
@show