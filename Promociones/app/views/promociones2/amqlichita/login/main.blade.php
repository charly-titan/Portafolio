<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Login Form</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- Bootstrap 3 CSS -->
    <link href="/amqlichita/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Eternity Login , Registration & Forgot Password Forms CSS -->
    <link href="/amqlichita/css/forms.css" rel="stylesheet" />
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <!-- Modenizer -->
    <script src="/amqlichita/js/modernizr.js"></script>

    <!-- Animations CSS -->
    <link href="/amqlichita/css/animate.min.css" rel="stylesheet" />

    <!-- Font Icons -->
    <link href="/amqlichita/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Google Web Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

<style type="text/css">
    .jp-contenedor {
        width: 100%;
    }

    .jp-wrapper {
        margin: 0 auto;
        position: relative;
        width: 100%;
    }

    .jp-wrapper:before, .jp-wrapper:after {
        content: " ";
        display: table;
    }

    .jp-wrapper:after {
        clear: both;
    }

    .lc-page .jp-wrapper {
        height: 100%;
    }



@media all {
    .header-menu #tooltip {
        max-width: 309px;
        max-height: 54px;
    }

    .FixMov {
        top: 45px !important;
    }

    .FixDesk {
        top: 37px !important;
    }

    #nav_header_televisa div.topnav a.logo.big {
        box-shadow: none !important;
        z-index: 99 !important;
    }

    .noTop {
        top: 0 !important;
    }

    .mm-opened .noTransform {
        transform: none !important;
        -webkit-transform: none !important;
    }

    div.header-menu {
        line-height: 16px !important;
        font-size: 12px !important;
        width: 100%;
        z-index: 3;

    }

    div.backheader {
        z-index: 999;
    }

    #menu > ul {
        display: none;
    }

    .corporativo .color-bg-main {
        background: #F3F3F5;
    }

    .fixed {
        position: fixed;
        top: 0;
        margin: 0 auto;
    }

    .no-icon:after {
        display: none !important;
    }

    header.common-header div.sub-header {
        height: 71px;
        border-width: 0;
        border-top-style: solid;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        box-sizing: border-box;
        border: none;
    }

    div.header-menu div.sub-header {
        height: 71px;
        border-width: 0;
        border-top-style: solid;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        box-sizing: border-box;
        border: none;
    }

    .header-menu span img {
        display: none;
    }

    nav#menu .mm-menu, nav#menu .dl-menu {
        display: none;
        font-family: 'Oswald' Sans-serif;
        text-transform: uppercase;
    }

    div.header-menu div.title strong a {
        color: #fff;
    }

    .center-logo {
        position: relative;
        width: 100px;
        transform: translateX(-50%);
        -webkit-transform: translateX(-50%);
        left: 50%;
        z-index: 1;
    }

    .logo-capa1, .logo-capa2, .logo-capa3 {
        display: block;
        /* background: url(../img/amql_logo_top.png) no-repeat 0 0; */
        background: url(/amqlichita/img/sprite_amqlichita.png) no-repeat -10px 0px;
        background-size: 297px auto;
        width: 100px;
        height: 65px;
        position: relative;
        top: 5px;
        left: 0;
    }

    .caja-centrado {
        display: block;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        -webkit-transform: translateX(-50%);
    }

    .logo-capa1 {
        background-position: -13px -10px;
        top: 0;
        height: 18px;
        width: 25px;
    }

    .logo-capa2 {
        background-position: -84px 3px;
        width: 65px;
        top: 0;
    }

    .logo-capa3 {
        background-position: -36px -3px;
        width: 54px;
        top: 0;
    }

    .fixed .logo-capa1, .fixed .logo-capa2, .fixed .logo-capa3 {
        top: 0;
    }
}

@media screen and (max-width: 647px) {
    .logo-capa1, .logo-capa2, .logo-capa3 {
        max-height: 45px;
    }

    div.backheader {
        z-index: 101;
    }

    header.common-header div.sub-header {
        height: 45px;
    }

    div.header-menu div.title {
        background: #F3F3F5;
        height: 45px;
        width: 98px;
    }

    div.header-menu div.title strong {
        color: #fff;
        font-size: 24px;
        font-weight: bold;
        display: block;
        letter-spacing: -0.05em;
        line-height: 43px;
        height: 43px;
        padding-left: 10px;
        left: 184px;
        text-align: center;
        width: calc(100% - 41px);
    }

    .logo-capa2 {
        top: -2px;
    }
}

/*Tablet*/
@media screen and (min-width: 648px) {
    div.backheader {
        background: #F3F3F5;
        width: 100%;
        height: 71px;
    }

    div.header-menu {
        line-height: 16px !important;
        font-size: 12px !important;
        width: 100%;
    }

    div.header-menu div.title {
        background: #F3F3F5;
        height: 65px;
        border-width: 0;
        border-top-style: solid;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        box-sizing: border-box;
        border: none;
        text-align: center;
    }

    div.header-menu div.title strong {
        color: #fff;
        font-size: 29px;
        position: relative;
    }

    div.header-menu div.inner {
        width: 624px;
        position: relative;
        margin: auto;
    }

    .logo-capa1, .logo-capa2, .logo-capa3 {
        background-size: 495px;
    }

    .logo-capa1 {
        background-position: -21px -29px;
        width: 35px;
        top: 3px;
    }

    .logo-capa2 {
        background-position: -137px -8px;
        width: 100px;
    }

    .logo-capa3 {
        background-position: -58px -16px;
        width: 80px;
    }
}

@-webkit-keyframes tooltip {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
        display: none;
    }
}

@keyframes tooltip {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
        display: none;
    }
}

/*Desktop*/
@media screen and (min-width: 948px) {
    .center-logo {
        position: relative;
        width: 121px;
    }

    .logo-capa1, .logo-capa2, .logo-capa3 {
        background-size: auto;
    }

    .logo-capa1 {
        background-position: -30px -36px;
        margin-top: 0;
        height: 18px;
        width: 37px;
        top: -1px;
    }

    .logo-capa2 {
        width: 121px;
        margin-top: 0;
        background-position: -168px -18px;
    }

    .logo-capa3 {
        width: 105px;
        margin-top: 0;
        background-position: -69px -28px;
    }

    .fixed-logo {
        width: 121px;
        height: 65px;
        margin: 0 auto;
        display: inline-block;
        vertical-align: top;
        visibility: hidden;
        position: relative;
        transition: width 0.3s;
        -moz-transition: width 0.3s;
        -webkit-transition: width 0.3s;
    }

    .fixed .fixed-logo {
        visibility: visible;
        width: 121px;
    }

    .fixed-logo .logo-img-fx {
        width: 100%;
        height: 100%;
        margin: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    div.header-menu div.title strong {
        left: 40px;
        top: 32px;
        letter-spacing: -0.5px;
        width: auto;
        display: inline-block;
        vertical-align: top;
        width: 210px;
    }

    div.header-menu.fixed div.title strong {
        left: 0;
    }

    div.header-menu div.title span {
        width: 309px;
        height: 54px;
        display: inline-block;
        vertical-align: top;
        margin-left: 195px;
        margin-top: 15px;
    }

    div.header-menu {
        max-width: 1165px;
    }

    div.backheader {
        margin: 0 0 0;
        height: 70px;
    }

    div.backheader.fixed {
        box-shadow: 1px 2px 2px 0px #999999;
    }

    div.backheader * {
        z-index: 3;
    }

    #tooltip {
        float: none;
        display: block;
        margin: 0;
        width: 309px;
    }

    #tooltip {
        opacity: 1;
        -webkit-animation: tooltip 2s linear 7s 1 forwards;
        animation: tooltip 2s linear 7s 1 forwards;
    }

    #menu {
        display: none;
    }

    header.common-header {
        width: 100%;
        z-index: 1;
    }

    div.header-menu div.inner {
        width: auto;
        position: relative;
        margin: 0 auto;
        display: inline-block;
        vertical-align: top;
        margin-left: -44px;
    }

    .fixed div.header-menu div.inner {
        margin-left: 0;
    }
}

.fixed-logo {
    background: url(../img/logo.png);
    visibility: visible;
    background-position: 0;
    background-size: 60%;
    background-repeat: no-repeat;
}

.fixed .fixed-logo {
    background-size: 100%;
}

.dl-menuwrapper {
    width: 100%;
    max-width: 300px;
    float: right;
    font-family: 'Raleway';
    position: relative;
    -webkit-perspective: 1000px;
    perspective: 1000px;
    -webkit-perspective-origin: 50% 200%;
    perspective-origin: 50% 200%;
    margin-top: -60px;
    margin-right: 0;
    z-index: 100;
    font-weight: bold;
}

.dl-menuwrapper ul {
    border-top: none;
    overflow-y: hidden;
}

.dl-menuwrapper ul:not(.dl-subview):not(.dl-submenu),
.dl-subviewopen {
    background: rgba(0, 0, 0, 0.6);
}

.dl-menuwrapper button {
    background: #7EEEFF;
    border: none;
    width: 62px;
    height: 62px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    outline: none;
    margin-left: 200px;
    color: #000;
    border: 4px solid #000 !important;
    border-radius: 6px;
    line-height: 31px;
    padding: 0px !important;
}

.dl-menuwrapper button span {
    display: none;
}

.dl-menuwrapper button i {
    font-size: 38px;
    display: block;
    margin: 0;
}

@-moz-document url-prefix() {
    .dl-menuwrapper button i {
        display: block;
        padding-bottom: 0px;
    }

    .dl-menuwrapper button span {
        margin-top: -3px;
    }
}

.dl-menuwrapper ul li ul {
    border: none;
}

.dl-menuwrapper ul {
    padding: 0;
    list-style: none;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.dl-menuwrapper li {
    position: relative;
    border-bottom: 1px solid rgba(134, 134, 134, 0.8);
}

.dl-menuwrapper li.dl-subviewopen {
    border-bottom: none;
}

.dl-menuwrapper li a {
    display: block;
    position: relative;
    padding: 8px 10px 8px 12px;
    font-size: 18px;
    text-transform: uppercase;
    line-height: 20px;
    color: #FFF;
    outline: none;
    text-decoration: none;
    text-shadow: 0px 0px 3px #000;
}

.dl-menuwrapper ul li.redes {
    height: 50px;
    /*display: inline-block;*/
    padding: 0 12px;
    height: 31px;
    margin-top: 5px;
    font-size: 12px;
    font-weight: bold;
    border: none;
}

li.redes span {
    display: inline-block;
    width: 27px;
    height: 27px;
    text-align: center;
    margin-right: -2px;
    opacity: 0.4;
}

li.redes span a:link {
    color: #fff;
}

.dl-menuwrapper li.redes span {
    background: none;
    border-radius: 15px;
}

.dl-menuwrapper li.redes span a {
    padding: 1px 1px 0px 0px;
    font-size: 12px;
    text-shadow: none;
}

li.redes span i {
    font-size: 26px;
    color: #FFF;
    line-height: inherit;
    display: block;
}

.dl-menuwrapper li > a:hover {
    background: #76F1FF;
    color: #000000 !important;
    text-shadow: none;
}

.dl-menuwrapper li.redes span {
    opacity: 1;
}

.dl-menuwrapper li.redes span:hover {
    opacity: 0.5;
}

.dl-menuwrapper li.redes a:hover {
    /* background: inherit; */
}

.dl-menuwrapper li:hover > a:after {
    color: #000;
}

.dl-menuwrapper li.dl-back > a {
    padding-left: 48px;
    background: #16D5E8;
    color: #000;
    text-shadow: none;
}

.dl-menuwrapper li.dl-back > a:before {
    position: absolute;
    top: 0;
    line-height: 36px;
    font-family: 'amqlichita';
    font-size: 14px;
    speak: none;
    -webkit-font-smoothing: antialiased;
    content: "h";
    left: 25px;
    text-transform: lowercase;
}

.dl-menuwrapper li.dl-back:after, .dl-menuwrapper li > a:not(:only-child):after {
    position: absolute;
    top: 0;
    line-height: 36px;
    font-family: 'amqlichita';
    font-size: 14px;
    speak: none;
    -webkit-font-smoothing: antialiased;
    content: "g";
    text-transform: lowercase;
    text-shadow: 0px 0px 1px #000;
}

.dl-menuwrapper li.dl-back:after, .dl-menuwrapper li:hover > a:not(:only-child):after {
    text-shadow: none;
}

.dl-menuwrapper li.dl-back:after {
    left: 10px;
    color: rgba(212, 204, 198, 0.3);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}

.dl-menuwrapper li > a:after {
    right: 15px;
    color: white;
}

.dl-menuwrapper .dl-menu {
    margin: 0;
    position: absolute;
    width: 100%;
    opacity: 0;
    -webkit-transform: translateY(10px);
    transform: translateY(10px);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    display: none;
    /* height: 100vh */
}

/* .dl-menuwrapper .dl-menu.dl-menu-toggle {
    transition: all 0.3s ease;
}  */
.dl-menuwrapper .dl-menu.dl-menuopen {
    opacity: 1;
    pointer-events: auto;
    -webkit-transform: translateY(0px);
    transform: translateY(0px);
    margin-top: 3px;
}

.fixed .dl-menuwrapper .dl-menu.dl-menuopen {
    margin-top: 2px;
}

.dl-menuwrapper ul {
    /* min-height: 100vh; */
}

.dl-menuwrapper > ul.dl-menuopen {
    /* overflow-y: scroll; */
}

.dl-menuwrapper li .dl-submenu {
    display: none;
    top: 62px;
}

.dl-menu.dl-subview li, .dl-menu.dl-subview li.dl-subviewopen > a,
.dl-menu.dl-subview li.dl-subview > a {
    display: none;
}

.dl-menu.dl-subview li.dl-subview, .dl-menu.dl-subview li.dl-subview .dl-submenu,
.dl-menu.dl-subview li.dl-subviewopen, .dl-menu.dl-subview li.dl-subviewopen > .dl-submenu,
.dl-menu.dl-subview li.dl-subviewopen > .dl-submenu > li {
    display: block;
}

.dl-menuwrapper > .dl-submenu {
    position: absolute;
    width: 100%;
    top: 62px;
    left: 0;
    margin: 0;
    opacity: 0;
}

.dl-menu.dl-animate-out-2 li {
    -webkit-animation: MenuAnimOut2 0.3s linear;
    -moz-animation: MenuAnimOut2 0.3s linear;
    animation: MenuAnimOut2 0.3s linear;
}

@-webkit-keyframes MenuAnimOut2 {
    0% {}

    100% {
        -webkit-transform: translateX(-30%);
        opacity: 0;
    }
}

@keyframes MenuAnimOut2 {
    0% {}

    100% {
        -webkit-transform: translateX(-30%);
        transform: translateX(-30%);
        opacity: 0;
    }
}

.dl-menu.dl-animate-in-2 li {
    -webkit-animation: MenuAnimIn2 0.2s linear;
    -moz-animation: MenuAnimIn2 0.2s linear;
    animation: MenuAnimIn2 0.2s linear;
}

@-webkit-keyframes MenuAnimIn2 {
    0% {
        -webkit-transform: translateX(-30%);
        opacity: 0;
    }

    100% {
        -webkit-transform: translateX(0px);
        opacity: 1;
    }
}

@keyframes MenuAnimIn2 {
    0% {
        -webkit-transform: translateX(-30%);
        transform: translateX(-30%);
        opacity: 0;
    }

    100% {
        -webkit-transform: translateX(0px);
        transform: translateX(0px);
        opacity: 1;
    }
}

.dl-menuwrapper > .dl-submenu.dl-animate-in-2 li {
    -webkit-animation: SubMenuAnimIn2 0.2s linear;
    -moz-animation: SubMenuAnimIn2 0.2s linear;
    animation: SubMenuAnimIn2 0.2s linear;
}

@-webkit-keyframes SubMenuAnimIn2 {
    0% {
        -webkit-transform: translateX(30%);
        opacity: 0;
    }

    100% {
        -webkit-transform: translateX(0px);
        opacity: 1;
    }
}

@keyframes SubMenuAnimIn2 {
    0% {
        -webkit-transform: translateX(30%);
        transform: translateX(30%);
        opacity: 0;
    }

    100% {
        -webkit-transform: translateX(0px);
        transform: translateX(0px);
        opacity: 1;
    }
}

.dl-menuwrapper > .dl-submenu.dl-animate-out-2 li {
    -webkit-animation: SubMenuAnimOut2 0.3s linear;
    -moz-animation: SubMenuAnimOut2 0.3s linear;
    animation: SubMenuAnimOut2 0.3s linear;
}

@-webkit-keyframes SubMenuAnimOut2 {
    0% {
        -webkit-transform: translateX(0%);
        opacity: 1;
    }

    100% {
        -webkit-transform: translateX(30%);
        opacity: 0;
    }
}

@keyframes SubMenuAnimOut2 {
    0% {
        -webkit-transform: translateX(0%);
        transform: translateX(0%);
        opacity: 1;
    }

    100% {
        -webkit-transform: translateX(30%);
        transform: translateX(30%);
        opacity: 0;
    }
}

.no-js .dl-menuwrapper .dl-menu {
    position: relative;
    opacity: 1;
    -webkit-transform: none;
    transform: none;
}

.no-js .dl-menuwrapper li .dl-submenu {
    display: block;
}

.no-js .dl-menuwrapper li.dl-back {
    display: none;
}

.no-js .dl-menuwrapper li > a:not(:only-child) {
    background: rgba(0, 0, 0, 0.1);
}

.no-js .dl-menuwrapper li > a:not(:only-child):after {
    content: '';
}

@media screen and (max-width: 647px) {
    .dl-menuwrapper {
        width: 100%;
        max-width: 300px;
        float: right;
        position: relative;
        -webkit-perspective: 1000px;
        perspective: 1000px;
        -webkit-perspective-origin: 50% 200%;
        perspective-origin: 50% 200%;
        margin-top: -42px;
    }

    .dl-menu.dl-menuopen {
        display: none;
    }

    #menu > span {
        display: none;
    }

    .mm-opened #menu > span {
        display: block;
    }

    .mm-menu > span {
        background: #16D5E8;
        color: #fff;
        font-family: 'Montserrat';
        font-weight: 400;
        font-size: 20px;
        height: 40px;
        display: block;
        line-height: 40px;
        text-align: center;
    }

    .mm-list > li:first-child:after {
        display: none;
    }

    .mm-menu.mm-right {
        left: auto;
        right: 0;
        z-index: 0;
        top: 49px;
    }

    .dl-menuwrapper button {
        margin-bottom: 0;
    }

    .dl-menuwrapper button i {
        margin-top: 0px;
    }
}

/*Only Tablet*/
@media screen and (min-width: 648px) and (max-width: 947px) {
    .mm-menu {
        font-family: 'Oswald';
    }

    .mm-menu, .mm-menu > .mm-panel {
        display: block;
    }

    .mm-menu.mm-right {
        left: auto;
        right: 0;
        z-index: 0;
        top: 37px;
    }

    .mm-menu > span {
        text-align: center;
        background: #7EEEFF;
        color: #fff;
        font-weight: 400;
        font-size: 20px;
        height: 71px;
        display: block;
        line-height: 71px;
    }

    .dl-menuwrapper button {
        margin: 0px 12px 0 0;
        height: 71px;
        background: #7eeeff none repeat scroll 0 0;
        border: 3px solid #000 !important;
        border-radius: 6px;
    }

    div.header-menu {
        width: 100%;
        top: 0;
        padding: 0;
        margin: 0;
        display: block;
    }

    .dl-menuwrapper {
        max-width: inherit;
        height: 71px;
        vertical-align: middle;
        display: table-cell;
        margin-top: 0;
        width: auto;
    }

    .dl-menuwrapper button {
        margin-top: 6px !important;
        width: 55px !important;
        height: 55px !important;
    }

    @-moz-document url-prefix() {
        div.header-menu div.title strong {
            padding-left: 240px;
        }
}

    div.header-menu div.title strong {
        left: 240px;
        top: 0;
        height: 71px;
        vertical-align: middle;
        display: table-cell;
    }

    @-moz-document url-prefix() {
        div.header-menu.fixed div.title strong {
            padding-left: 0px;
        }
}

    div.header-menu.fixed div.title strong {
        left: 15px;
    }

    @-moz-document url-prefix() {
        .dl-menuwrapper button {
            margin-top: 0px;
        }
}

    .dl-menuwrapper button i {
        margin-top: 0px;
        padding-bottom: 0;
    }

    #dl-menu.dl-menuwrapper {
        position: absolute;
        right: 15px;
        top: 0;
    }

    li.redes span i {
        font-size: 22px;
        color: #fff;
        display: block;
        line-height: inherit;
        position: relative;
        margin: 4px 0px 0 -5px;
    }
}

/*Only Mobile*/
@media screen and (max-width: 647px) {
    .mm-menu {
        font-family: 'Oswald';
    }

    .dl-menuwrapper button span {
        display: none;
    }

    @-moz-document url-prefix() {
        .dl-menuwrapper button i {
            margin-top: -5px;
        }
}

    .dl-menu.dl-menuopen {
        display: none;
    }

    .dl-menuwrapper ul li span.redes {
        height: 50px;
        display: inline-block;
        padding: 0 12px;
        height: 36px;
        margin-top: 12px;
        font-size: 12px;
        font-weight: bold;
        border: none;
    }

    span.redes span {
        display: inline-block;
        width: 22px;
        height: 22px;
        text-align: center;
        margin-right: 24px;
    }

    span.redes span i {
        font-size: 24px;
        color: #fff;
        line-height: 24px;
    }

    span.redes span a:link {
        color: #fff;
    }

    span.redes span.twitter {
        background: #00aced;
    }

    span.redes span.facebook {
        background: #3b5998;
        color: #fff;
    }

    span.redes span.gplus {
        background: #d34836;
    }

    .dl-menuwrapper ul.redes li a {
        padding: 6px;
        font-size: 12px;
    }

    ul.redes li i {
        font-size: 24px;
        color: #fff;
        line-height: inherit;
    }

    .dl-menuwrapper button {
        height: 41px !important;
    }
}

/*Desktop*/
@media screen and (min-width: 948px) {
    .dl-menuwrapper {
        margin-top: -63px;
    }

    nav#menu .mm-menu {
        display: none;
    }

    .mm-menu, .mm-menu > .mm-panel {
        display: none;
    }

    div.header-menu.mm-fixed-top {
        -webkit-transform: translateY(0px) !important;
        transform: translateY(0px) !important;
    }

    .dl-menu.dl-subview > li.redes:last-child {
        display: none;
    }

    .dl-menuwrapper button.dl-active, .no-touch .dl-menuwrapper button:hover {
        background: #000;
        border: 4px solid #16D5E8 !important;
        color: #16D5E8;
    }

    .dl-menuwrapper button span {
        display: block;
        font-family: 'Trebuchet MS';
        font-size: 11px;
        text-transform: uppercase;
        line-height: 1px;
    }
}

/*Only Mobile*/
@media screen and (max-width: 947px) {
    div.header-menu {
        width: 100%;
        background: #F3F3F5;
    }

    .dl-menuwrapper {
        margin-bottom: 0px;
    }

    .dl-menuwrapper .dl-menu {
        display: none !important;
    }

    .dl-menuwrapper button {
        /*background: #F3F3F5;
                border: none;*/
        /*width: 41px;*/
        /*height: 65px;*/
        width: 65px;
        height: 61px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        outline: none;
        /*      margin-bottom: 0 !important;*/
        margin-top: 2px;
        color: #000;
        /*      padding: 0;*/
        float: right;
        right: 12px;
    }

    .dl-menuwrapper button i {
        font-size: 30px;
        display: block;
        margin-top: 4px;
    }

    .mm-menu {
        font-family: 'Oswald', Sans-serif;
    }

    .mm-menu ul.mm-list li.redes {
        border-bottom: none;
        margin-left: 20px;
    }

    .mm-menu ul.mm-list li.redes span {
        display: inline-block;
        padding: 0px;
        height: 45px;
        width: 45px;
        font-size: 12px;
        font-weight: bold;
        border: none;
    }

    .mm-menu ul.mm-list li.redes span a {
        display: block;
        height: 45px;
        position: relative;
        text-align: center;
        top: 0;
        width: 45px;
        padding: 11px;
    }

    li.redes span i {
        font-size: 32px;
        color: #16D5E8;
        display: block;
        line-height: inherit;
        position: relative;
        margin: 0;
        background: none;
        width: 22px;
        height: 22px;
        letter-spacing: -1px;
        border-radius: 10px;
    }

    li.redes span a:link {
        color: #fff;
    }

    li.redes span {
        background: none;
        border-radius: 15px;
    }

    /* li.redes span.twitter i {
                background: #00aced;
        }
        li.redes span.facebook i {
                background: #3b5998;
                color: #fff;
        }
        li.redes span.gplus i {
                background: #d34836;
        } */
    .dl-menuwrapper li.redes span a {
        padding: 6px;
        font-size: 12px;
    }

    .mm-menu.mm-horizontal > .mm-panel {
        -webkit-transition: -webkit-transform 0.4s ease;
        transition: transform 0.4s ease;
    }

    .mm-menu .mm-hidden {
        display: none;
    }

    .mm-wrapper {
        overflow-x: hidden;
        position: relative;
    }

    .mm-menu, .mm-menu > .mm-panel {
        width: 100%;
        height: 100%;
        position: absolute;
        right: 0;
        z-index: 0;
    }

    .mm-menu {
        background: inherit;
        display: block;
        overflow: hidden;
        padding: 0;
    }

    .mm-menu > .mm-panel {
        background: inherit;
        background: #FFF;
        -webkit-overflow-scrolling: touch;
        overflow: scroll;
        overflow-x: hidden;
        overflow-y: auto;
        box-sizing: border-box;
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
    }

    .mm-menu > .mm-panel.mm-opened {
        -webkit-transform: translateX(0%);
        transform: translateX(0%);
        height: 100vh;
    }

    .mm-menu > .mm-panel.mm-subopened {
        -webkit-transform: translateX(-30%);
        transform: translateX(-30%);
    }

    .mm-menu > .mm-panel.mm-highest {
        z-index: 1;
    }

    .mm-panel > .mm-list {
        margin-left: -20px;
        margin-right: -20px;
    }

    .mm-panel > .mm-list:first-child {
        padding-top: 0;
    }

    .mm-list, .mm-list > li {
        list-style: none;
        display: block;
        padding: 0;
        margin: 0;
    }

    .mm-list {
        font: inherit;
        font-size: 14px;
    }

    .mm-list a, .mm-list a:hover {
        text-decoration: none;
    }

    .mm-list > li {
        position: relative;
        border-bottom: 1px solid #d6d6d6;
    }

    ul.mm-list.opened > ul.mm-list li:first-child {
        text-align: center;
        font-weight: 400;
        font-size: 20px;
    }

    .mm-list > li > a,
    .mm-list > li > span {
        color: #000000;
        font-family: 'Raleway';
        font-size: 16px;
        font-weight: 400;
        text-overflow: ellipsis;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
        line-height: 22px;
        display: block;
        padding: 7px 10px 7px 12px;
        margin: 0;
    }

    .mm-list > li:not(.mm-subtitle):not(.mm-label):not(.mm-search):not(.mm-noresults):after {
        width: auto;
        margin-left: 20px;
        position: relative;
        left: auto;
    }

    .mm-list a.mm-subopen {
        width: 100%;
        height: 100%;
        padding: 0;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 2;
    }

    .mm-list a.mm-subopen.mm-fullsubopen {
        width: 100%;
    }

    .mm-list a.mm-subopen.mm-fullsubopen:before {
        border-left: none;
    }

    .mm-list a.mm-subopen + a, .mm-list a.mm-subopen + span {
        padding-right: 5px;
        margin-right: 0px;
    }

    .mm-list > li.mm-selected > a.mm-subopen {
        background: transparent;
    }

    .mm-list > li.mm-selected > a.mm-fullsubopen + a, .mm-list > li.mm-selected > a.mm-fullsubopen + span {
        padding-right: 45px;
        margin-right: 0;
    }

    .mm-list a.mm-subclose {
        text-indent: 20px;
    }

    .mm-list > li.mm-label {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        font-size: 10px;
        text-transform: uppercase;
        text-indent: 20px;
        line-height: 25px;
        padding-right: 5px;
    }

    .mm-list > li.mm-spacer {
        padding-top: 40px;
    }

    .mm-list > li.mm-spacer.mm-label {
        padding-top: 25px;
    }

    .mm-list a.mm-subopen:after {
        content: "g";
        font-family: 'amqlichita';
        width: 7px;
        height: 7px;
        position: absolute;
        line-height: 35px;
        text-transform: lowercase;
    }

    .mm-list a.mm-subclose:before {
        content: "h";
        font-family: 'amqlichita';
        width: 7px;
        height: 7px;
        position: absolute;
        line-height: 15px;
        text-transform: lowercase;
    }

    .mm-list a.mm-subopen:after {
        border-top: none;
        border-left: none;
        right: 12px;
    }

    .mm-list a.mm-subclose:before {
        border-right: none;
        border-bottom: none;
        left: -10px;
        line-height: 22px;
    }

    .mm-menu.mm-vertical .mm-list .mm-panel {
        display: none;
        padding: 10px 0 10px 10px;
    }

    .mm-menu.mm-vertical .mm-list .mm-panel li:last-child:after {
        border-color: transparent;
    }

    .mm-menu.mm-vertical .mm-list li.mm-opened > .mm-panel {
        display: block;
    }

    .mm-menu.mm-vertical .mm-list > li.mm-opened > a.mm-subopen {
        height: 40px;
    }

    .mm-menu.mm-vertical .mm-list > li.mm-opened > a.mm-subopen:after {
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
        top: 16px;
        right: 16px;
    }

    .mm-menu.mm-vertical .mm-list > li.mm-opened.mm-label > a.mm-subopen {
        height: 25px;
    }

    html.mm-opened .mm-page {
        z-index: -2 !important;
    }

    .mm-menu {
        background: #FFFFFF;
        color: rgba(255, 255, 255, 0.6);
    }

    .mm-menu .mm-list > li > a.mm-subclose {
        background: #16d5e8;
        color: #232323;
    }

    .mm-menu .mm-list > li > a.mm-subopen:after, .mm-menu .mm-list > li > a.mm-subclose:before {
        border-color: #232323;
    }

    .mm-menu .mm-list > li > a.mm-subopen:before {
        border-color: rgba(0, 0, 0, 0.15);
    }

    .mm-menu .mm-list > li.mm-selected > a:not(.mm-subopen), .mm-menu .mm-list > li.mm-selected > span {
        background: rgba(0, 0, 0, 0.1);
        color: #232323;
        font-weight: bold;
    }

    .mm-menu .mm-list > li.mm-label {
        background: rgba(255, 255, 255, 0.05);
    }

    .mm-menu.mm-vertical .mm-list li.mm-opened > a.mm-subopen, .mm-menu.mm-vertical .mm-list li.mm-opened > ul {
        background: rgba(255, 255, 255, 0.05);
    }

    .mm-page {
        -webkit-transition: -webkit-transform 0.4s ease;
        transition: transform 0.4s ease;
    }

    html.mm-opened .mm-page {
        box-sizing: border-box;
        position: relative;
    }

    html.mm-background .mm-page {
        background: inherit;
    }

    #mm-blocker {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        right: 0;
        z-index: 999999;
        display: none;
    }

    html.mm-opened #mm-blocker, html.mm-blocking #mm-blocker {
        display: block;
        box-shadow: inset -15px 0 15px -15px #000, 0px 0 0px 0px #000;
    }

    .mm-menu.mm-offcanvas {
        display: none;
        position: fixed;
    }

    .mm-menu.mm-current {
        display: block;
        overflow-x: hidden;
        height: 100%;
    }

    .mm-menu {
        width: 276px;
        min-width: 140px;
        max-width: 276px;
    }

    html.mm-opening .mm-page, html.mm-opening #mm-blocker {
        -webkit-transform: translate(-276px, 0);
        transform: translate(-276px, 0);
    }

    html.mm-opened.mm-dragging .mm-menu, html.mm-opened.mm-dragging .mm-page,
    html.mm-opened.mm-dragging .mm-fixed-top, html.mm-opened.mm-dragging .mm-fixed-bottom,
    html.mm-opened.mm-dragging #mm-blocker {
        -webkit-transition-duration: 0s;
        transition-duration: 0s;
    }
}

/*Only smartphone*/
@media all and (max-width: 647px) {
    html.mm-right.mm-opening .mm-page, html.mm-right.mm-opening #mm-blocker {
        -webkit-transform: translate(-276px, 0);
        transform: translate(-276px, 0);
    }

    #dl-menu {
        width: 50px;
    }

    .dl-menuwrapper button {
        margin-top: 0;
        width: 48px;
    }

    .dl-menuwrapper button i {
        font-size: 24px;
        display: block;
        margin-top: 6px;
    }

    .dl-menuwrapper button {
        border: 2px solid #000 !important;
    }
}

nav.mm-menu {
    /*display: none !important*/
}

.no-back {
    position: relative;
    background: #F3F3F5;
}

/*Only devices*/
@media all and (max-width: 947px) {
    div.header-menu.fixed {
        box-shadow: 2px 2px 10px #999;
        z-index: 100;
    }

    .real-opened nav.mm-menu {
        display: block !important;
        z-index: 100;
    }

    .real-opened .mm-page {
        min-height: 100vh;
        max-height: 100vh;
        overflow: hidden;
    }

    .real-opened footer {
        display: none;
    }

    .real-opened .header-menu {
        transform: none !important;
    }

    html.real-opened, html.real-opened > body {
        overflow: hidden;
        min-height: 100vh;
        position: fixed;
    }

    html.real-opened .mm-menu {
        z-index: 999;
    }

    html.mm-opened #nav_footer_televisa {
        z-index: 0;
    }

    div.backheader {
        height: auto;
    }

    .no-back {
        width: 100px;
        height: 65px;
    }
}

/*Only Phablet*/
@media all and (min-width: 645px) and (max-width: 680px) {
    div.header-menu div.inner {
        width: 590px;
    }
}

/*Desktop*/
@media all and (min-width: 948px) {
    .addFixed {
        padding-bottom: 93px !important;
    }

    .mm-page {
        width: 100% !important;
    }

    div.header-menu div.title {
        margin-top: 3px;
    }
}

/*Only Tablet*/
@media all and (min-width: 648px) and (max-width: 947px) {
    .addFixed {
        padding-bottom: 70px !important;
    }

    .no-back {
        background: none;
    }
}

/*Only smartphone*/
@media all and (max-width: 647px) {
    .addFixed {
        padding-bottom: 38px !important;
    }

    .fixed-logo {
        background-position: -5px 5px;
        background-size: 110%;
        height: 45px;
        left: 5px;
        padding: 0 18px;
        position: absolute;
        top: 0;
        visibility: visible;
        width: 62px;
        z-index: 1;
    }
}


</style>
</head>


<body style="background-color: #16d5e8">
      <!--
            BEGIN: MENU HAMBURGUER;
            -->
            <div class="jp-contenedor backheader" id="">
                <div class="jp-wrapper">
                    <div class="header-menu mm-fixed-top">
                        <div class="center-logo title color-bg-main color-border-top-lighten color-border-bottom-darken">
                            <div class="fixed-logo no-back">
                                <div class="caja-centrado">
                                    <div class="logo-capa1 tossing"></div>
                                </div>
                                <div class="caja-centrado">
                                    <div class="logo-capa2 "></div>
                                </div>
                                <div class="caja-centrado">
                                    <div class="logo-capa3 pulse"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <!--
            END: MENU HAMBURGUER;
            -->
    <br />
    <br />
    <br />
    <div class="container eternity-form">
        <div class="login-form-section">
            <div class="login-content animated bounceIn">
                <form>
                    <div class="section-title">
                        <h3>{{Lang::get("users.login_instructions")}}</h3>
                    </div>
                    <!--div class="textbox-wrap">
                        Selecciona una de las opciones para iniciar sesión
                    </div-->
                    <!--div class="textbox-wrap">
                        <div class="input-group">
                            <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                            <input type="password" required="required" class="form-control " placeholder="Password" />
                        </div>
                    </div>
                    <div class="login-form-action clearfix">
                        <div class="checkbox pull-left">
                            <div class="custom-checkbox">
                                <input type="checkbox" checked name="iCheck">
                            </div>
                            <span class="checkbox-text pull-left">&nbsp;Remember Me</span>
                        </div>
                        <button type="submit" class="btn btn-success pull-right green-btn">LogIn &nbsp; <i class="icon-chevron-right"></i></button>
                    </div-->
            <div class="section-title">
            
            <a href="/social/Facebook">
                <div class="login-form-links link1 animated fadeInLeftBig bg-blue">
                    <h4 class="white"><i class="fa fa-facebook"></i> Facebook</h4>
                    <!--span>No worry</span>
                    <a href="#" class="blue">Click Here</a>
                    <span></span-->
                </div>
            </a>
            <a href="/social/Twitter">
                <div class="login-form-links link2 animated fadeInRightBig bg-lblue">
                    <h4 class="white"><i class="fa fa-twitter"></i> Twitter</h4>
                    <!--span>Dont worry</span>
                    <a href="#" class="green">Click Here</a>
                    <span>to Get New One</span-->
                </div>
            </a>
            <a href="/social/Google">
                <div class="login-form-links link1 animated fadeInLeftBig bg-orange">
                    <h4 class="white"><i class="fa fa-google-plus"></i> Google</h4>
                    <!--span>No worry</span>
                    <a href="#" class="blue">Click Here</a>
                    <span>to Register</span-->
                </div>
            </a>
</div>



                </form>
            </div>
            
        </div>
    </div>
    <br />
    <br />
    <br />

    <!-- Jquery   -->
    <script src="/amqlichita/js/jquery-1.9.1.min.js"></script>

    <!-- PlaceHolder For Older Browsers -->
    <script src="/amqlichita/js/placeholders.min.js"></script>

    <!-- Custom Checkbox PLugin -->
    <script src="/amqlichita/js/jquery.icheck.js"></script>

    <!-- Media Query Support For Older Browsers [Ie 8 & lower] -->
    <script src="/amqlichita/js/respond.min.js"></script>


    <!-- For Initializing Checkbox And Focus Event For Textbox -->
    <script type="text/javascript">
        $(function () {

            //Custom Checkbox For Light Theme
            $("input").iCheck({
                checkboxClass: 'icheckbox_square-blue',
                increaseArea: '20%'
            });


            //Custom Checkbox For Dark Theme
            $(".dark input").iCheck({
                checkboxClass: 'icheckbox_polaris',
                increaseArea: '20%'
            });


            //TextBox Focus Event
            $(".form-control").focus(function () {
                $(this).closest(".textbox-wrap").addClass("focused");
            }).blur(function () {
                $(this).closest(".textbox-wrap").removeClass("focused");
            });

        });
    </script>
</body>
</html>