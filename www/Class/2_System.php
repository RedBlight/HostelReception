<?php
/** 2 **
 * This class handles server and client variables, like cookies, user id, room order, forex data, etc...
 */

include_once( "1_Recaptcha.php" );

class System
{
    // CONSTANTS
	const OPT_RE_SHOW_PERSON_COUNT   = 0;
    const OPT_RE_SHOW_COMPANIONS     = 1;
    const OPT_RE_SHOW_CANCELLED      = 2;

    const FX_USD = 0;
    const FX_EUR = 1;
    const FX_GBP = 2;

    // SYSTEM VARS
    static public $option   = array();
    static public $forex    = array();

    static public $order_room = array();
    static public $order_source = array();
    static public $order_fee = array();
    static public $order_payment = array();

    static public $list_room = array();
    static public $list_source = array();
    static public $list_fee = array();
    static public $list_payment = array();

    static public $count_user = 0;
    static public $count_room = 0;
    static public $count_reservation = 0;
    static public $count_people = 0;
    static public $count_source = 0;
    static public $count_fee = 0;
    static public $count_payment = 0;
    static public $count_finance = 0;

    // CLIENT VARS
    static public $is_cmp_loaded = false;
    static public $cookey = "x";
    static public $is_ajax = false;
    static public $page = "";
    static public $action = "";

    // USER VARS
    static public $auth = false;
    static public $userid = 0;
    static public $username = "x";
    static public $type= "x";

    // IF DONE, DONT DO NEXT STEPS OF CONTROL
    static public $finished = false;

    // EXECUTION VARS
    static public $today_timestamp = 0;
    static public $today_dbtime = 0;
}