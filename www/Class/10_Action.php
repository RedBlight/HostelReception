<?php
/** 10 **
 * This class does the requested action by ajax, and then generates response
 */

include_once( "9_Datamng.php" );

class Action
{
	// DATA MAKERS
	static function MakeCommonData()
	{
		$find = array( "x1x", "x2x", "x3x", "x4x", "x5x", "x6x", "x7x", "x8x", "x9x", "x10x", "x11x", "x12x", "x13x", "x14x", "x15x", "x16x" );
		$replace = array(
			System::$username,
			System::$type,
			System::$forex[0],
			System::$forex[1],
			System::$forex[2],
			System::$page,
			System::$today_timestamp,
			json_encode( System::$list_room ),
			json_encode( System::$list_source ),
			json_encode( System::$list_fee ),
			json_encode( System::$list_payment ),
			json_encode( System::$order_room ),
			json_encode( System::$order_source ),
			json_encode( System::$order_fee ),
			json_encode( System::$order_payment ),
			json_encode( System::$option )
		);
		return str_replace( $find, $replace, Component::$common_data );
	}

	static function MakeSummaryData()
	{
		return "HMS.Data.summary_arriving = " . json_encode( Datamng::Summary_GetArriving() ) . ";"
		. "HMS.Data.summary_leaving = " . json_encode( Datamng::Summary_GetLeaving() ) . ";"
		. "HMS.Data.summary_notes = " . json_encode( Datamng::Note_GetData() ) . ";"
		. "HMS.Data.summary_fees = " . json_encode( Datamng::Summary_GetFees() ) . ";"
		;
	}

	static function MakeReservationsData()
	{
		$script = "";
		if( Tool::_request( "date" ) != NULL )
			$table_dbtime = Tool::_request( "date" );
		else
			$table_dbtime = System::$today_dbtime;

		$table_timestamp = Tool::TsToDb( $table_dbtime );
		$days = Tool::GenerateWeek( $table_timestamp );

		$table_data = Datamng::Table_GetData( $days );

		$reservation_ids = array();
		for( $i=0; $i<7; ++$i )
			$reservation_ids = Tool::Merge( $reservation_ids, $table_data[ $days[$i] ] ) ;

		$reservations = Datamng::Reservation_GetData_index( $reservation_ids );

		$people_ids = array();
		$count = count( $reservations );
		for( $i=0; $i<$count; ++$i )
		{
			$people_ids = Tool::Merge( $people_ids, $reservations[$i]["people"] );
		}

		$people = Datamng::People_GetData_index( $people_ids );

		$script .= "HMS.Data.table_dbtime = " . $table_dbtime . ";";
		$script .= "HMS.Data.table_timestamp = " . $table_timestamp . ";";
		$script .= "HMS.Data.table_rooms = " . json_encode( Datamng::Settings_GetRooms() )  . ";";
		$script .= "HMS.Data.table_reservations = " . json_encode( $reservations )  . ";";
		$script .= "HMS.Data.table_people = " . json_encode( $people )  . ";";

		return $script;
	}

	static function MakeSettingsUsersData()
	{
		return "HMS.Data.settings_users = " . json_encode( Datamng::Settings_GetUsers() ) . ";"
		;
	}

	static function MakeSettingsRoomsData()
	{
		return "HMS.Data.settings_rooms = " . json_encode( Datamng::Settings_GetRooms() ) . ";"
		;
	}

	static function MakeSettingsSourcesData()
	{
		return "HMS.Data.settings_sources = " . json_encode( Datamng::Settings_GetSources() ) . ";"
		;
	}

	static function MakeSettingsFeesData()
	{
		return "HMS.Data.settings_fees = " . json_encode( Datamng::Settings_GetFees() ) . ";"
		;
	}

	static function MakeSettingsPaymentsData()
	{
		return "HMS.Data.settings_payments = " . json_encode( Datamng::Settings_GetPayments() ) . ";"
		;
	}

	// PAGE
	static function Page_Load()
	{
		Display::AddHtml( Component::$page_load );
	}

	static function Page_Login()
	{
		Display::AddScript( Component::$page_login );
	}

	static function Page_Summary()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSummaryData() );
		Display::AddScript( Component::$page_summary );
	}

	static function Page_Reservations()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeReservationsData() );
		Display::AddScript( Component::$page_reservations );
	}

	static function Page_People()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( Component::$page_people );
	}

	static function Page_Finance()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( Component::$page_finance );
	}

	static function Page_Statistics()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( Component::$page_statistics );
	}

	static function Page_Settings()
	{
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsUsersData() );
		Display::AddScript( Component::$page_settings );
	}


	// AJAX

	static function GetComponents()
	{
		Display::AddJson( ComponentC::$comp );
	}

	static function Login()
	{
		$rcp_control = recaptcha_check_answer( recaptcha_get_privatekey(), Tool::_server("REMOTE_ADDR"), Tool::_request("recaptcha_challenge_field"), Tool::_request("recaptcha_response_field") );
		if( $rcp_control->is_valid )
		{
			$username = Tool::_request( "username" );
			$password = Tool::_request( "password" );
			$userdata = Datamng::GetUserDataByUsername( $username );
			if( $userdata != false && Tool::CheckLoginInput( $username ) && Tool::CheckLoginInput( $password ) && Encrypt::Validate( $password, $userdata["passwordhash"] ) )
			{
				$new_cookey = Encrypt::GenerateCookey(32);
				$new_cookey_hash = Encrypt::Hash( $new_cookey, 1024 );
				$scrambled = Encrypt::ScrambleCookey( $userdata["id"], $new_cookey );
				$script = str_replace( "replace_me", $scrambled, Component::$set_cookey );
				Database::UpdateCookey( $userdata["id"], $new_cookey_hash );
				Display::AddScript( $script );
				Display::AddScript( Component::$msg_login_successful );
			}
			else Display::AddScript( Component::$msg_login_incorrect );
		}
		else Display::AddScript( Component::$msg_login_invalidcaptcha );
	}

	static function Note_Edit()
	{
		$note = Tool::_request( "note" );
		$length = mb_strlen($note);
		if( $length > 0 && $length < 3000  )
			Database::Note_Edit( Tool::_request( "note_id" ), $note );
		Display::AddScript( 'HMS.System.GotoPage("summary");' );
	}

	static function Note_Delete()
	{
		Database::Note_Delete( Tool::_request( "note_id" ) );
		Display::AddScript( 'HMS.System.GotoPage("summary");' );
	}

	static function Note_Add()
	{
		$note = Tool::_request( "note" );
		$length = mb_strlen($note);
		if( $length > 0 && $length < 3000  )
			Database::Note_Add( Tool::_request( "note" ) );
		Display::AddScript( 'HMS.System.GotoPage("summary");' );
	}


	// RESERVATIONS

	static function Options_Edit()
	{
		$opt0 = Tool::_request( "opt0" );
		$opt1 = Tool::_request( "opt1" );
		$opt2 = Tool::_request( "opt2" );
		if( ($opt0 == 1 || $opt0 == 0) && ($opt1 == 1 || $opt1 == 0) && ($opt2 == 1 || $opt2 == 0)  )
			System::$option = array( $opt0, $opt1, $opt2 );
		Display::AddScript( 'HMS.System.Reload();' );
	}

	static function Reservation_Add()
	{
		$add_main = json_decode( Tool::_request( "add_main" ), true );
		$add_people = json_decode( Tool::_request( "add_people" ), true );
		$add_stay = json_decode( Tool::_request( "add_stay" ), true );
		$add_fees = json_decode( Tool::_request( "add_fees" ), true );

		$control = true;
		if( mb_strlen( $add_main["description"] ) > 3000 )
			$control = false;
		if( $control && count($add_people) < 1 )
			$control = false;
		if( $control ){ $length = count($add_people); for( $i=0; $i<$length; ++$i )
		{
			if( $control && ( mb_strlen( $add_people[$i]["name"] ) > 64 || mb_strlen( $add_people[$i]["name"] ) < 1 ) )
			{
				$control = false; $i = $length;
			}
			if( $control && ( mb_strlen( $add_people[$i]["passport"] ) > 64 || mb_strlen( $add_people[$i]["passport"] ) < 1 ) )
			{
				$control = false; $i = $length;
			}
		}}
		if( $control && count($add_stay) < 1 )
			$control = false;
		if( $control ){ $length = count($add_fees); for( $i=0; $i<$length; ++$i )
		{
			if( $control && ( !is_numeric( $add_fees[$i]["amount"] ) || ( $add_fees[$i]["amount"] % 1 !== 0 )  ) )
			{
				$control = false; $i = $length;
			}
			if( $control && ( mb_strlen( $add_fees[$i]["description"] ) > 1000 ) )
			{
				$control = false; $i = $length;
			}
		}}

		if( $control )
		{
			$reservation_id = ++System::$count_reservation;

			$days = array();
			$rooms = array();
			$day_count = count($add_stay);
			for( $i=0; $i<$day_count; ++$i )
			{
				$days[$i] = $add_stay[$i][0];
				$rooms[$i] = $add_stay[$i][1];
			}
			Datamng::Table_AddReservation( $days, $reservation_id );

			$people = array();
			$people_ids = array();
			$person_count = count( $add_people );
			for( $i=0; $i<$person_count; ++$i )
			{
				$people[$i]["id"] = ++System::$count_people;
				$people[$i]["name"] = $add_people[$i]["name"];
				$people[$i]["passport"] = $add_people[$i]["passport"];
				$people[$i]["country"] = $add_people[$i]["country"];
				$people[$i]["birth"] = $add_people[$i]["birth"];
				$people[$i]["reservation"] = $reservation_id;
				$people[$i]["checkin"] = $days[0];
				$people[$i]["checkout"] = $days[ $day_count-1 ];

				$people_ids[$i] = System::$count_people;
			}
			Database::People_Insert( $people );

			$finance = array();
			$finance_ids = array();
			$finance_count = count( $add_fees );
			$allfeepaid = "1";
			for( $i=0; $i<$finance_count; ++$i )
			{
				$finance[$i]["id"] = ++System::$count_finance;
				$finance[$i]["class"] = 0;
				$finance[$i]["type"] = $add_fees[$i]["type"];
				$finance[$i]["description"] = $add_fees[$i]["description"];
				$finance[$i]["date"] = $days[ $day_count-1 ];
				$finance[$i]["reservation"] = $reservation_id;
				$finance[$i]["amount"] = $add_fees[$i]["amount"];
				$finance[$i]["currency"] = $add_fees[$i]["currency"];
				$finance[$i]["done"] = $add_fees[$i]["done"];

				if( $finance[$i]["done"] == "0" ) $allfeepaid = "0";

				$finance_ids[$i] = System::$count_finance;
			}
			Database::Finance_Insert( $finance );

			$reservation = array();
			$stay = array();
			$reservation[0]["id"] = $reservation_id;
			$reservation[0]["description"] = $add_main["description"];
			for( $i=0; $i<$day_count; ++$i )
				$stay[$i] = $add_stay[$i][0] . "." . $add_stay[$i][1];
			$reservation[0]["stay"] = implode( ":", $stay );
			$reservation[0]["people"] = implode( ":", $people_ids );
			$reservation[0]["fee"] = implode( ":", $finance_ids );
			$reservation[0]["source"] = $add_main["source"];
			$reservation[0]["status"] = $add_main["status"];
			$reservation[0]["allfeepaid"] = $allfeepaid;
			Database::Reservation_Insert( $reservation );

			if( $reservation[0]["status"] == 0 || $reservation[0]["status"] == 1 )
			{
				Database::Room_AddActiveArray( array_unique($rooms), 1 );
			}

			Display::AddScript( 'HMS.System.GotoPage("reservations?date=' . $days[0] . '");' );
		}

	}

	static function Reservation_Get()
	{
		$reservation_id = Tool::_request("reservation_id");
		$reservation_data = Datamng::Reservation_GetData_index( array( $reservation_id ) );

		$people_ids = $reservation_data[0]["people"];
		$people_data = Datamng::People_GetData_index( $people_ids );

		$stay_data = $reservation_data[0]["stay"];

		$arr_stay = array();
		$arr_stay_days = array();
		$length = count( $stay_data );
		for( $i=0; $i<$length; ++$i )
		{
			$arr_stay[] = $stay_data[ $i ][0] . "-" . $stay_data[ $i ][1];
			$arr_stay_days[] = $stay_data[ $i ][0];
		}

		$fees_ids = $reservation_data[0]["fee"];
		$fees_data = Datamng::Finance_GetFee_index( $fees_ids );

		$script = "HMS.Data.reservedit[0] = " . json_encode( $reservation_data[0] ) . ";"
			. "HMS.Data.reservedit[1] = " . json_encode( $people_data ) . ";"
			. "HMS.Data.reservedit[2] = " . json_encode( $stay_data ) . ";"
			. "HMS.Data.reservedit[3] = " . json_encode( $fees_data ) . ";"
			. "HMS.Data.reservadd_stay = " . json_encode( $arr_stay ) . ";"
			. "HMS.Data.reservadd_stay_days = " . json_encode( $arr_stay_days ) . ";"
			. "HMS.Control.Reservation_Edit_Make();" ;

		Display::AddScript( $script );
	}

	static function Reservation_Edit()
	{
		$add_main = json_decode( Tool::_request( "add_main" ), true );
		$add_people = json_decode( Tool::_request( "add_people" ), true );
		$add_stay = json_decode( Tool::_request( "add_stay" ), true );
		$add_fees = json_decode( Tool::_request( "add_fees" ), true );

		$control = true;
		if( mb_strlen( $add_main["description"] ) > 3000 )
			$control = false;
		if( $control && count($add_people) < 1 )
			$control = false;
		if( $control ){ $length = count($add_people); for( $i=0; $i<$length; ++$i )
		{
			if( $control && ( mb_strlen( $add_people[$i]["name"] ) > 64 || mb_strlen( $add_people[$i]["name"] ) < 1 ) )
			{
				$control = false; $i = $length;
			}
			if( $control && ( mb_strlen( $add_people[$i]["passport"] ) > 64 || mb_strlen( $add_people[$i]["passport"] ) < 1 ) )
			{
				$control = false; $i = $length;
			}
		}}
		if( $control && count($add_stay) < 1 )
			$control = false;
		if( $control ){ $length = count($add_fees); for( $i=0; $i<$length; ++$i )
		{
			if( $control && ( !is_numeric( $add_fees[$i]["amount"] ) || ( $add_fees[$i]["amount"] % 1 !== 0 )  ) )
			{
				$control = false; $i = $length;
			}
			if( $control && ( mb_strlen( $add_fees[$i]["description"] ) > 1000 ) )
			{
				$control = false; $i = $length;
			}
		}}

		if( $control )
		{
			$reservation_id = $add_main["id"];

			$reservation_data = Datamng::Reservation_GetData_index( array( $reservation_id ) );

			$old_days = array();
			$old_rooms = array();
			$old_day_count = count( $reservation_data[0]["stay"] );
			for( $i=0; $i<$old_day_count; ++$i )
			{
				$old_days[$i] = $reservation_data[0]["stay"][$i][0];
				$old_rooms[$i] = $reservation_data[0]["stay"][$i][1];
			}
			Datamng::Table_DeleteReservation( $old_days, $reservation_id );

			$days = array();
			$rooms = array();
			$day_count = count($add_stay);
			for( $i=0; $i<$day_count; ++$i )
			{
				$days[$i] = $add_stay[$i][0];
				$rooms[$i] = $add_stay[$i][1];
			}
			Datamng::Table_AddReservation( $days, $reservation_id );


			$old_people = $reservation_data[0]["people"];
			Database::People_Delete( $old_people );

			$people = array();
			$people_ids = array();
			$person_count = count( $add_people );
			for( $i=0; $i<$person_count; ++$i )
			{
				if( $add_people[$i]["id"] == "0" )
					$people[$i]["id"] = ++System::$count_people;
				else
					$people[$i]["id"] = $add_people[$i]["id"];
				$people[$i]["name"] = $add_people[$i]["name"];
				$people[$i]["passport"] = $add_people[$i]["passport"];
				$people[$i]["country"] = $add_people[$i]["country"];
				$people[$i]["birth"] = $add_people[$i]["birth"];
				$people[$i]["reservation"] = $reservation_id;
				$people[$i]["checkin"] = $days[0];
				$people[$i]["checkout"] = $days[ $day_count-1 ];

				$people_ids[$i] = $people[$i]["id"];
			}
			Database::People_Insert( $people );


			$old_finance = $reservation_data[0]["fee"];
			Database::Finance_Delete( $old_finance );

			$finance = array();
			$finance_ids = array();
			$finance_count = count( $add_fees );
			$allfeepaid = "1";
			for( $i=0; $i<$finance_count; ++$i )
			{
				if( $add_fees[$i]["id"] == "0" )
					$finance[$i]["id"] = ++System::$count_people;
				else
					$finance[$i]["id"] = $add_fees[$i]["id"];
				$finance[$i]["class"] = 0;
				$finance[$i]["type"] = $add_fees[$i]["type"];
				$finance[$i]["description"] = $add_fees[$i]["description"];
				$finance[$i]["date"] = $days[ $day_count-1 ];
				$finance[$i]["reservation"] = $reservation_id;
				$finance[$i]["amount"] = $add_fees[$i]["amount"];
				$finance[$i]["currency"] = $add_fees[$i]["currency"];
				$finance[$i]["done"] = $add_fees[$i]["done"];

				if( $finance[$i]["done"] == "0" ) $allfeepaid = "0";

				$finance_ids[$i] = $finance[$i]["id"];
			}
			Database::Finance_Insert( $finance );


			Database::Reservation_Delete( array($reservation_id) );

			$reservation = array();
			$stay = array();
			$reservation[0]["id"] = $reservation_id;
			$reservation[0]["description"] = $add_main["description"];
			for( $i=0; $i<$day_count; ++$i )
				$stay[$i] = $add_stay[$i][0] . "." . $add_stay[$i][1];
			$reservation[0]["stay"] = implode( ":", $stay );
			$reservation[0]["people"] = implode( ":", $people_ids );
			$reservation[0]["fee"] = implode( ":", $finance_ids );
			$reservation[0]["source"] = $add_main["source"];
			$reservation[0]["status"] = $add_main["status"];
			$reservation[0]["allfeepaid"] = $allfeepaid;
			Database::Reservation_Insert( $reservation );


			if( ($reservation_data[0]["status"] === "0") || ($reservation_data[0]["status"] === "1") )
			{
				Database::Room_AddActiveArray( array_unique( $old_rooms ), -1 );
			}

			if( ($reservation[0]["status"] === "0") || ($reservation[0]["status"] === "1") )
			{
				Database::Room_AddActiveArray( array_unique($rooms), 1 );
			}

			Display::AddScript( 'HMS.System.GotoPage("reservations?date=' . $days[0] . '");' );
		}
	}


	// SETTINGS

	static function GetSettingUsers()
	{
		Display::AddScript( self::MakeSettingsUsersData() );
		Display::AddScript( 'HMS.Designer.Settings_Users();' );
	}

	static function GetSettingRooms()
	{
		Display::AddScript( self::MakeSettingsRoomsData() );
		Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
	}

	static function GetSettingSources()
	{
		Display::AddScript( self::MakeSettingsSourcesData() );
		Display::AddScript( 'HMS.Designer.Settings_Sources();' );
	}

	static function GetSettingFees()
	{
		Display::AddScript( self::MakeSettingsFeesData() );
		Display::AddScript( 'HMS.Designer.Settings_Fees();' );
	}

	static function GetSettingPayments()
	{
		Display::AddScript( self::MakeSettingsPaymentsData() );
		Display::AddScript( 'HMS.Designer.Settings_Payments();' );
	}

	static function User_Edit()
	{
		$id = Tool::_request( "s_id" );
		$username = Tool::_request( "s_username" );
		$type = Tool::_request( "s_type" );
		$changepass = ( Tool::_request( "s_changepass" ) == "true" ) ? true : false ;
		$password = Tool::_request( "s_password" );

		$userdata = Datamng::GetUserDataById( $id);

		if( !(
			( Database::RowExists( "user", "username", $username ) && ( $userdata["username"] != $username ) )
			|| !Tool::CheckLoginInput( $username )
			|| ( $changepass && !Tool::CheckLoginInput( $password ) )
			|| ( ( $type != "Manager" ) && ( $type != "Employee" ) )
			|| ( ($id == 1) && (
				( System::$userid != 1 )
				|| ( ( System::$userid == 1 ) && (
					( $username != "root" )
					|| ( $type != "Manager" )
					)
				)
			) )
			|| ( ( System::$userid == $id ) && ( ( $username != System::$username ) || ( $type != "Manager"  ) ) )
		) )
		{
			Database::User_Edit( $id, $username, $type, $changepass, $password  );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsUsersData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Users();' );
		}
	}

	static function User_Delete()
	{
		$id = Tool::_request( "s_id" );

		if( !(
			( $id == 1 )
			|| ( $id == System::$userid )
		) )
		{
			Database::User_Delete( $id );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsUsersData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Users();' );
		}
	}

	static function User_Add()
	{
		$username = Tool::_request( "s_username" );
		$type = Tool::_request( "s_type" );
		$password = Tool::_request( "s_password" );

		if( !(
			!Tool::CheckLoginInput( $username )
			|| !Tool::CheckLoginInput( $password )
			|| Database::RowExists( "user", "username", $username )
		) )
		{
			$id = ++System::$count_user;
			Database::User_Add( $id, $username, $type, $password );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsUsersData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Users();' );
		}
	}

	// ROOMS

	static function Room_Edit()
	{
		$id = Tool::_request( "s_id" );
		$name = Tool::_request( "s_name" );
		$type = Tool::_request( "s_type" );
		$bed = Tool::_request( "s_bed" );

		if( !(
			!Tool::CheckRoomInput( $name )
			|| !Tool::CheckRoomInput( $type )
			|| !Tool::CheckRoomBed( $bed )
		) )
		{
			Database::Room_Edit( $id, $name, $type, $bed  );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsRoomsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
		}
	}

	static function Room_Add()
	{
		$name = Tool::_request( "s_name" );
		$type = Tool::_request( "s_type" );
		$bed = Tool::_request( "s_bed" );

		if( !(
			!Tool::CheckRoomInput( $name )
			|| !Tool::CheckRoomInput( $type )
			|| !Tool::CheckRoomBed( $bed )
		) )
		{
			$id = ++System::$count_room;
			System::$order_room[] = (string)System::$count_room; // adding without string cast causes bizzare errors
			Database::Room_Add( $id, $name, $type, $bed );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsRoomsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
		}
	}

	static function Room_Delete()
	{
		$id = Tool::_request( "s_id" );
		$roomdata = Datamng::Room_GetRow( $id );

		if( !(
			( count( System::$order_room ) < 2 )
			|| ( (int)$roomdata["active"] > 0 )
		) )
		{
			System::$order_room = Tool::RemoveVal( System::$order_room, $id );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsRoomsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
		}
	}

	static function Room_Up()
	{
		$id = Tool::_request( "s_id" );
		System::$order_room = Tool::OneUp( System::$order_room, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsRoomsData() );
		Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
	}

	static function Room_Down()
	{
		$id = Tool::_request( "s_id" );
		System::$order_room = Tool::OneDown( System::$order_room, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsRoomsData() );
		Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
	}

	static function Room_Undelete()
	{
		$id = Tool::_request( "s_id" );
		if( Database::RowExists( "room", "id", $id ) )
		{
			System::$order_room[] = (string)$id;
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsRoomsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Rooms();' );
		}
	}

	// SOURCES

	static function Source_Edit()
	{
		$id = Tool::_request( "s_id" );
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			Database::Source_Edit( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsSourcesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Sources();' );
		}
	}

	static function Source_Add()
	{
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			$id = ++System::$count_source;
			System::$order_source[] = (string)System::$count_source; // adding without string cast causes bizzare errors
			Database::Source_Add( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsSourcesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Sources();' );
		}
	}

	static function Source_Delete()
	{
		$id = Tool::_request( "s_id" );

		if( !(
		( count( System::$order_source ) < 2 )
		) )
		{
			System::$order_source = Tool::RemoveVal( System::$order_source, $id );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsSourcesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Sources();' );
		}
	}

	static function Source_Up()
	{
		$id = Tool::_request( "s_id" );
		System::$order_source = Tool::OneUp( System::$order_source, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsSourcesData() );
		Display::AddScript( 'HMS.Designer.Settings_Sources();' );
	}

	static function Source_Down()
	{
		$id = Tool::_request( "s_id" );
		System::$order_source = Tool::OneDown( System::$order_source, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsSourcesData() );
		Display::AddScript( 'HMS.Designer.Settings_Sources();' );
	}

	static function Source_Undelete()
	{
		$id = Tool::_request( "s_id" );
		if( Database::RowExists( "source", "id", $id ) )
		{
			System::$order_source[] = (string)$id;
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsSourcesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Sources();' );
		}
	}

	// FES

	static function Fee_Edit()
	{
		$id = Tool::_request( "s_id" );
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			Database::Fee_Edit( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsFeesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Fees();' );
		}
	}

	static function Fee_Add()
	{
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			$id = ++System::$count_fee;
			System::$order_fee[] = (string)System::$count_fee; // adding without string cast causes bizzare errors
			Database::Fee_Add( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsFeesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Fees();' );
		}
	}

	static function Fee_Delete()
	{
		$id = Tool::_request( "s_id" );

		if( !(
		( count( System::$order_fee ) < 2 )
		) )
		{
			System::$order_fee = Tool::RemoveVal( System::$order_fee, $id );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsFeesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Fees();' );
		}
	}

	static function Fee_Up()
	{
		$id = Tool::_request( "s_id" );
		System::$order_fee = Tool::OneUp( System::$order_fee, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsFeesData() );
		Display::AddScript( 'HMS.Designer.Settings_Fees();' );
	}

	static function Fee_Down()
	{
		$id = Tool::_request( "s_id" );
		System::$order_fee = Tool::OneDown( System::$order_fee, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsFeesData() );
		Display::AddScript( 'HMS.Designer.Settings_Fees();' );
	}

	static function Fee_Undelete()
	{
		$id = Tool::_request( "s_id" );
		if( Database::RowExists( "fee", "id", $id ) )
		{
			System::$order_fee[] = (string)$id;
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsFeesData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Fees();' );
		}
	}

	// PAYMENTS

	static function Payment_Edit()
	{
		$id = Tool::_request( "s_id" );
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			Database::Payment_Edit( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsPaymentsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Payments();' );
		}
	}

	static function Payment_Add()
	{
		$name = Tool::_request( "s_name" );

		if( !(
		!Tool::CheckRoomInput( $name )
		) )
		{
			$id = ++System::$count_payment;
			System::$order_payment[] = (string)System::$count_payment; // adding without string cast causes bizzare errors
			Database::Payment_Add( $id, $name );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsPaymentsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Payments();' );
		}
	}

	static function Payment_Delete()
	{
		$id = Tool::_request( "s_id" );

		if( !(
		( count( System::$order_payment ) < 2 )
		) )
		{
			System::$order_payment = Tool::RemoveVal( System::$order_payment, $id );
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsPaymentsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Payments();' );
		}
	}

	static function Payment_Up()
	{
		$id = Tool::_request( "s_id" );
		System::$order_payment = Tool::OneUp( System::$order_payment, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsPaymentsData() );
		Display::AddScript( 'HMS.Designer.Settings_Payments();' );
	}

	static function Payment_Down()
	{
		$id = Tool::_request( "s_id" );
		System::$order_payment = Tool::OneDown( System::$order_payment, $id );
		Display::AddScript( self::MakeCommonData() );
		Display::AddScript( self::MakeSettingsPaymentsData() );
		Display::AddScript( 'HMS.Designer.Settings_Payments();' );
	}

	static function Payment_Undelete()
	{
		$id = Tool::_request( "s_id" );
		if( Database::RowExists( "payment", "id", $id ) )
		{
			System::$order_payment[] = (string)$id;
			Display::AddScript( self::MakeCommonData() );
			Display::AddScript( self::MakeSettingsPaymentsData() );
			Display::AddScript( 'HMS.Control.CloseModal();' );
			Display::AddScript( 'HMS.Designer.Settings_Payments();' );
		}
	}
}