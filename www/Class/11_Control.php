<?php
/** 11 **
 * This class controls all the other classes
 * Very useful if one class needs to use an higher class method
 */

include_once( "10_Action.php" );


class Control
{

    const C_USERID = 0;
    const C_KEY = 1;

    const DB_SERVER = "localhost";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "";
    const DB_DATABASE = "mahmutak_reception";

    static function ConnectDatabase()
    {
        $success = Database::Connect( self::DB_SERVER, self::DB_USERNAME, self::DB_PASSWORD, self::DB_DATABASE );
        if( !$success )
        {
            Display::AddScript( 'alert( "Fatal Error! #0001" );' );
            System::$finished = true;
        }
    }

    static function InitialiseSystem()
    {
        if( !System::$finished )
        {
            $maindata = Datamng::GetMainData();
            if( $maindata === false )
            {
                Display::AddScript( 'alert( "Fatal Error! #0002" );' );
                System::$finished = true;
            }
            else
            {
                System::$option = $maindata["option"];
                System::$forex = $maindata["forex"];

                System::$order_room = $maindata["ordroom"];
                System::$order_source = $maindata["ordsource"];
                System::$order_fee = $maindata["ordfee"];
                System::$order_payment = $maindata["ordpayment"];

                System::$list_room = Datamng::GetNameList_Room();
                System::$list_source = Datamng::GetNameList_Source();
                System::$list_fee = Datamng::GetNameList_Fee();
                System::$list_payment = Datamng::GetNameList_Payment();

                System::$count_user = $maindata["cuser"];
                System::$count_room = $maindata["croom"];
                System::$count_reservation = $maindata["creservation"];
                System::$count_people = $maindata["cpeople"];
                System::$count_source = $maindata["csource"];
                System::$count_fee = $maindata["cfee"];
                System::$count_payment = $maindata["cpayment"];
                System::$count_finance = $maindata["cfinance"];

                if( Tool::_cookie( "loaded" ) == 1 )
                    System::$is_cmp_loaded = true;
                if( Tool::_cookie( "cookey" ) )
                    System::$cookey = Tool::_cookie( "cookey" );
                if( Tool::_request( "is_ajax" ) == true )
                    System::$is_ajax = true;
                if( Tool::_request( "action" ) )
                    System::$action = Tool::_request( "action" );
                System::$page = Tool::GetReqPage();

                System::$today_timestamp = time();
                System::$today_dbtime = Tool::MakeDbTimeStr_ts( System::$today_timestamp );
            }
        }

    }

    static function HandleClientComponents()
    {
        if( !System::$finished && !System::$is_cmp_loaded && System::$page != "load"  )
        {
            $script = <<<JS
HMS.System.GotoPage("load");
JS;
            Display::AddScript( $script );
            System::$finished = true;
        }
    }

    static function AuthorizeClient()
    {
        if( !System::$finished )
        {
            $pcookey = Encrypt::ParseCookey( System::$cookey );
            if( $pcookey !== false )
            {
                $userdata = Datamng::GetUserDataById( $pcookey[self::C_USERID] );
                if( $userdata != false && Encrypt::Validate( $pcookey[self::C_KEY], $userdata["cookeyhash"] ) )
                {
                    System::$auth = true;
                    System::$userid = $userdata["id"];
                    System::$username = $userdata["username"];
                    System::$type = $userdata["type"];
                    //==========================================================//
                    //=== FOR EASY USER TYPE CONT OVER PAGE AND AJAX HANDLES ===//
                    //==========================================================//
                    define( "M", (System::$type == "Manager")  );
                    define( "E", (System::$type == "Employee")  );
                    //==========================================================//
                }
            }
        }
    }

    static function HandleAjaxRequests()
    {
        if( !System::$finished && System::$is_ajax )
        {
            if( System::$auth )
            {
                switch( System::$action )
                {
                    case "get_components":          if(M||E){Action::GetComponents();        break;}
                    case "note_edit":               if(M||E){Action::Note_Edit();            break;}
                    case "note_delete":             if(M||E){Action::Note_Delete();          break;}
                    case "note_add":                if(M||E){Action::Note_Add();             break;}
	                case "options_edit":            if(M||E){Action::Options_Edit();         break;}
	                case "reservation_add":         if(M||E){Action::Reservation_Add();      break;}
	                case "reservation_get":         if(M||E){Action::Reservation_Get();      break;}
	                case "reservation_edit":        if(M||E){Action::Reservation_Edit();     break;}


                    case "get_setting_users":       if(M){Action::GetSettingUsers();         break;}
                    case "get_setting_rooms":       if(M){Action::GetSettingRooms();         break;}
                    case "get_setting_sources":     if(M){Action::GetSettingSources();       break;}
                    case "get_setting_fees":        if(M){Action::GetSettingFees();          break;}
                    case "get_setting_payments":    if(M){Action::GetSettingPayments();      break;}
                    case "user_edit":               if(M){Action::User_Edit();               break;}
                    case "user_delete":             if(M){Action::User_Delete();             break;}
                    case "user_add":                if(M){Action::User_Add();                break;}
                    case "room_edit":               if(M){Action::Room_Edit();               break;}
                    case "room_up":                 if(M){Action::Room_Up();                 break;}
                    case "room_down":               if(M){Action::Room_Down();               break;}
                    case "room_delete":             if(M){Action::Room_Delete();             break;}
                    case "room_add":                if(M){Action::Room_Add();                break;}
                    case "room_undelete":           if(M){Action::Room_Undelete();           break;}
                    case "source_edit":             if(M){Action::Source_Edit();             break;}
                    case "source_up":               if(M){Action::Source_Up();               break;}
                    case "source_down":             if(M){Action::Source_Down();             break;}
                    case "source_delete":           if(M){Action::Source_Delete();           break;}
                    case "source_add":              if(M){Action::Source_Add();              break;}
                    case "source_undelete":         if(M){Action::Source_Undelete();         break;}
                    case "fee_edit":                if(M){Action::Fee_Edit();                break;}
                    case "fee_up":                  if(M){Action::Fee_Up();                  break;}
                    case "fee_down":                if(M){Action::Fee_Down();                break;}
                    case "fee_delete":              if(M){Action::Fee_Delete();              break;}
                    case "fee_add":                 if(M){Action::Fee_Add();                 break;}
                    case "fee_undelete":            if(M){Action::Fee_Undelete();            break;}
                    case "payment_edit":            if(M){Action::Payment_Edit();            break;}
                    case "payment_up":              if(M){Action::Payment_Up();              break;}
                    case "payment_down":            if(M){Action::Payment_Down();            break;}
                    case "payment_delete":          if(M){Action::Payment_Delete();          break;}
                    case "payment_add":             if(M){Action::Payment_Add();             break;}
                    case "payment_undelete":        if(M){Action::Payment_Undelete();        break;}
                }
            }
            else
            {
                switch( System::$action )
                {
                    case "get_components":          Action::GetComponents();        break;
                    case "login":                   Action::Login();                break;
                }
            }
        }
    }

    static function HandlePageRequests()
    {
        if( !System::$finished && !System::$is_ajax )
        {
            if( System::$auth )
            {
                switch( System::$page )
                {
                    case "load":            if(M||E){Action::Page_Load();            break;}
                    case "summary":         if(M||E){Action::Page_Summary();         break;}
                    case "reservations":    if(M||E){Action::Page_Reservations();    break;}
                    case "people":          if(M||E){Action::Page_People();          break;}
                    case "finance":         if(M||E){Action::Page_Finance();         break;}
                    case "statistics":      if(M||E){Action::Page_Statistics();      break;}

                    case "settings":        if(M){Action::Page_Settings();        break;}

                    default:
                        System::$page = "summary";
                        Action::Page_Summary();
                    break;
                }
            }
            else
            {
                switch( System::$page )
                {
                    case "load":            Action::Page_Load();            break;
                    default:
                        System::$page = "summary";
                        Action::Page_Login();
                    break;
                }
            }
        }
    }

    static function Conclude()
    {
        Datamng::Main_Update();
        Database::Commit();
        Database::Disconnect();
	    Database::MailError();
    }

    static function SendOutput()
    {
        Display::PrepareOutput();
        if( !System::$is_ajax )
        {
            Display::MakeFullPage();
        }
        Display::PrintOutput();
    }


}