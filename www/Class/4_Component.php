<?php
/** 4 **
 * This class holds string components to be used in other php files
 * Prevents hairy code
 */

include_once( "3_Tool.php" );

class Component
{
    static $html_wrapper = <<<'HTML'
<!DOCTYPE html>
<html lang="en"><head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="en-us" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="description" content="Hostel Management System - Second Home Hostel">
    <meta name="keywords" content="hostel, management, system, reception" />
    <meta name="author" content="Mahmut Akkuş">
    <meta name="copyright" content="&copy; Mahmut Akkuş 2014" />
    <meta name="robot" content="noindex, nofollow" />

    <title>Reception - Second Home Hostel</title>

    <link rel="shortcut icon" href="Image/favicon.png" />

    <link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Css/main.css" rel="stylesheet">
    <link href="Css/prelogin.css" rel="stylesheet">
    <link href="Css/navbar.css" rel="stylesheet">
    <link href="Css/summary.css" rel="stylesheet">
    <link href="Css/reservations.css" rel="stylesheet">
    <link href="Css/people.css" rel="stylesheet">
    <link href="Css/finance.css" rel="stylesheet">
    <link href="Css/statistics.css" rel="stylesheet">
    <link href="Css/settings.css" rel="stylesheet">

    <script type="text/javascript" src="Javascript/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="Javascript/jquery.json-2.4.js"></script>
    <script type="text/javascript" src="Javascript/jquery.cookie.js"></script>
    <script type="text/javascript" src="Javascript/jstorage.js"></script>

    <script type="text/javascript" src="Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>

    <script type="text/javascript" src="Javascript/HMS.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Tool.js"></script>
    <script type="text/javascript" src="Javascript/HMS_System.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Data.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Component.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Maker.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Designer.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Action.js"></script>
    <script type="text/javascript" src="Javascript/HMS_Control.js"></script>

</head>
<body id="prelogin" >replace_me</body></html>
HTML;

    static $script_wrapper = <<<'HTML'
<script>
    $(document).ready(function(e){replace_me});
</script>
HTML;

    static $dberrormail_body = "<html><head><title>-- RECEPTION ERROR --</title></head><body><b>There have been some errors at Second Home Hostel Reception.</b><br/><br/>replace_me</body></html>";
    static $dberrormail_head = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nTo: Mahmut Akkuş <yepisyenilmis@gmail.com>\r\nFrom: Second Home Hostel Reception <noreply@secondhomehostel.com>\r\n";

    static $set_cookey = <<<'JS'
HMS.System.SetCookie( "cookey", "replace_me", 365 );
JS;

    static $msg_login_successful = <<<'JS'
HMS.Designer.Login_Alert( "success", "Login succesfull!" );
setTimeout( function(){ HMS.System.Reload(); }, 500 );
JS;
    static $msg_login_incorrect = <<<'JS'
HMS.Designer.Login_Alert( "danger", "Username or password is incorrect!" );
Recaptcha.reload();
JS;
    static $msg_login_invalidcaptcha = <<<'JS'
HMS.Designer.Login_Alert( "danger", "Invalid captcha!" );
Recaptcha.reload();
JS;

    // PAGES
    static $page_load = <<<'HTML'
<br/><br/><br/>
<img src="Image/logo.png"/>
<br/>
<div class="load-holder">Loading &nbsp; &nbsp; <img src="Image/ajaxloading.gif"/></div>
<script type="text/javascript">
    $("html").css( "cursor", "wait" );
    HMS.Component.Flush();
    HMS.System.DeleteCookie();
    var success = HMS.Component.LoadAllComponents();
    if( success )
    {
        HMS.Component.Set( "loaded", "1" );
        HMS.System.SetCookie( "loaded", "1", 365 );
        //alert( "DEBUG: Loading has completed. Will not redirect..." )
        // Redirect when not in debug.
        HMS.System.GotoPage( "" );
    }
    else alert( "ERROR" );
</script>
HTML;

    static $page_login = <<<'JS'
HMS.Designer.SetPage_Login();
JS;

    static $common_data = <<<'JS'
HMS.Data.username = "x1x";
HMS.Data.usertype = "x2x";
HMS.Data.USD = x3x;
HMS.Data.EUR = x4x;
HMS.Data.GBP = x5x;
HMS.Data.page = "x6x";
HMS.Data.server_date = new Date( x7x * 1000 );
HMS.Data.list_room = x8x;
HMS.Data.list_source = x9x;
HMS.Data.list_fee = x10x;
HMS.Data.list_payment = x11x;
HMS.Data.order_room = x12x;
HMS.Data.order_source = x13x;
HMS.Data.order_fee = x14x;
HMS.Data.order_payment = x15x;
HMS.Data.option = x16x;
JS;

    static $page_summary = <<<'JS'
HMS.Designer.SetPage_Summary();
JS;
    static $page_reservations = <<<'JS'
HMS.Designer.SetPage_Reservations();
JS;
    static $page_people = <<<'JS'
HMS.Designer.SetPage_People();
JS;
    static $page_finance = <<<'JS'
HMS.Designer.SetPage_Finance();
JS;
    static $page_statistics = <<<'JS'
HMS.Designer.SetPage_Statistics();
JS;
    static $page_settings = <<<'JS'
HMS.Designer.SetPage_Settings();
HMS.Designer.Settings_Users();
JS;




}