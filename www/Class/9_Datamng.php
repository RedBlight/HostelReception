<?php
/** 9 **
 * This class manages the raw data taken from database and formalizes it
 */

include_once( "8_Database.php" );

Class Datamng
{
    const RV_DAY = 0;
    const RV_ROOM = 1;

    const YESTERDAY = 0;
    const TODAY = 1;
    const TOMORROW = 2;

    static function GetMainData()
    {
        $data = Database::GetMainData();
        $arr = Database::Fetch( $data );
        $arr["option"] = explode( ":", $arr["option"] );
        $arr["forex"] = explode( ":", $arr["forex"] );
        $arr["ordroom"] = explode( ":", $arr["ordroom"] );
        $arr["ordsource"] = explode( ":", $arr["ordsource"] );
        $arr["ordfee"] = explode( ":", $arr["ordfee"] );
        $arr["ordpayment"] = explode( ":", $arr["ordpayment"] );
        return $arr;
    }

    static function GetNameList_Room()
    {
        $data = Database::GetNameList_Room();
        $data_arr = array();
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr["name"];
        }
        return $data_arr;
    }

    static function GetNameList_Source()
    {
        $data = Database::GetNameList_Source();
        $data_arr = array();
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr["name"];
        }
        return $data_arr;
    }

    static function GetNameList_Fee()
    {
        $data = Database::GetNameList_Fee();
        $data_arr = array();
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr["name"];
        }
        return $data_arr;
    }

    static function GetNameList_Payment()
    {
        $data = Database::GetNameList_Payment();
        $data_arr = array();
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr["name"];
        }
        return $data_arr;
    }

    static function Main_Update()
    {
        $data["id"] = 1;
        $data["option"] = implode( ":", System::$option );
        $data["forex"] = implode( ":", System::$forex );
        $data["ordroom"] = implode( ":", System::$order_room );
        $data["ordsource"] = implode( ":", System::$order_source );
        $data["ordfee"] = implode( ":", System::$order_fee );
        $data["ordpayment"] = implode( ":", System::$order_payment );
        $data["cuser"] = System::$count_user;
        $data["croom"] = System::$count_room;
        $data["creservation"] = System::$count_reservation;
        $data["cpeople"] = System::$count_people;
        $data["csource"] = System::$count_source;
        $data["cfee"] = System::$count_fee;
        $data["cpayment"] = System::$count_payment;
        $data["cfinance"] = System::$count_finance;
        Database::Main_Update( $data );
    }

    static function GetUserDataById( $id )
    {
        $data = Database::GetUserDataById( $id );
        $arr = Database::Fetch( $data );
        return $arr;
    }

    static function GetUserDataByUsername( $username )
    {
        $data = Database::GetUserDataByUsername( $username );
        $arr = Database::Fetch( $data );
        return $arr;
    }

    static function Room_GetRow( $id )
    {
        $data = Database::Room_GetRow( $id );
        $arr = Database::Fetch( $data );
        return $arr;
    }

    static function Table_AddReservation( $days, $reservation_id )
    {
        Database::Table_AddTime( $days );
        $data = Database::Table_GetData( $days );
        $new_data = array();
        $count = count( $days );
        for( $i=0; $i<$count; ++$i )
        {
            $arr = Database::Fetch( $data );
            $reservations = explode( ":", $arr["data"] );
            if( $reservations[0] == 0 )
                $reservations[0] = $reservation_id;
            else
                $reservations[] = $reservation_id;
            sort( $reservations, SORT_NUMERIC );
            $new_data[$i]["time"] = $arr["time"];
            $new_data[$i]["data"] = implode( ":", $reservations );
        }
        Database::Table_Insert( $new_data );
    }

	static function Table_DeleteReservation( $days, $reservation_id )
	{
		Database::Table_AddTime( $days );
		$data = Database::Table_GetData( $days );
		$new_data = array();
		$count = count( $days );
		for( $i=0; $i<$count; ++$i )
		{
			$arr = Database::Fetch( $data );
			$reservations = explode( ":", $arr["data"] );
			$key = array_search( $reservation_id, $reservations );
			if( $key !== false  )
				unset( $reservations[ $key ] );
			$reservations = array_values( $reservations );
			if( count( $reservations ) < 1 )
				$reservations[0] = 0;
			sort( $reservations, SORT_NUMERIC );
			$new_data[$i]["time"] = $arr["time"];
			$new_data[$i]["data"] = implode( ":", $reservations );
		}
		Database::Table_Insert( $new_data );
	}

    static function Table_GetData( $days )
    {
        $data = Database::Table_GetData( $days );
        $data_arr = array();
        $count = count( $days );
        for( $i=0; $i<$count; ++$i )
        {
            $data_arr[ $days[ $i ] ] = array();
        }
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["time"] ] = explode( ":", $arr["data"] );
        }
        return $data_arr;
    }

    static function People_GetData( $ids )
    {
        $data = Database::People_GetData( $ids );
        $data_arr = array();

        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr;
        }
        return $data_arr;
    }

	static function People_GetData_index( $ids )
	{
		$data = Database::People_GetData( $ids );
		$data_arr = array();

		$i = 0;
		while( $arr = Database::Fetch( $data ) )
		{
			$data_arr[ $i++ ] = $arr;
		}
		return $data_arr;
	}

    static function Reservation_GetData( $ids )
    {
        $data = Database::Reservation_GetData( $ids );
        $data_arr = array();

        while( $arr = Database::Fetch( $data ) )
        {
            $arr["people"] = explode( ":", $arr["people"] );
            $arr["fee"] = explode( ":", $arr["fee"] );
            $arr["stay"] = explode( ":", $arr["stay"] );
            $count = count( $arr["stay"] );
            for( $i=0; $i<$count; ++$i )
            {
                $arr["stay"][$i] = explode( ".", $arr["stay"][$i] );
            }
            $data_arr[ $arr["id"] ] = $arr;

        }
        return $data_arr;
    }

	static function Reservation_GetData_index( $ids )
	{
		$data = Database::Reservation_GetData( $ids );
		$data_arr = array();

		$j = 0;
		while( $arr = Database::Fetch( $data ) )
		{
			$arr["people"] = explode( ":", $arr["people"] );
			$arr["fee"] = explode( ":", $arr["fee"] );
			$arr["stay"] = explode( ":", $arr["stay"] );
			$count = count( $arr["stay"] );
			for( $i=0; $i<$count; ++$i )
			{
				$arr["stay"][$i] = explode( ".", $arr["stay"][$i] );
			}
			$data_arr[ $j++ ] = $arr;
		}
		return $data_arr;
	}

    static function Reservation_GetData_allfeepaid_0( $ids )
    {
        $data = Database::Reservation_GetData_allfeepaid_0( $ids );
        $data_arr = array();

        while( $arr = Database::Fetch( $data ) )
        {
            $arr["people"] = explode( ":", $arr["people"] );
            $arr["fee"] = explode( ":", $arr["fee"] );
            $arr["stay"] = explode( ":", $arr["stay"] );
            $count = count( $arr["stay"] );
            for( $i=0; $i<$count; ++$i )
            {
                $arr["stay"][$i] = explode( ".", $arr["stay"][$i] );
            }
            $data_arr[ $arr["id"] ] = $arr;

        }
        return $data_arr;
    }

    static function Finance_GetFee( $ids )
    {
        $data = Database::Finance_GetFee( $ids );
        $data_arr = array();

        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $arr["id"] ] = $arr;
        }
        return $data_arr;
    }

	static function Finance_GetFee_index( $ids )
	{
		$data = Database::Finance_GetFee( $ids );
		$data_arr = array();

		$i = 0;
		while( $arr = Database::Fetch( $data ) )
		{
			$data_arr[ $i++ ] = $arr;
		}
		return $data_arr;
	}

    static function Note_GetData()
    {
        $data = Database::Note_GetData();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }

    // ABSTRACTIONS

    static function Summary_GetArriving()
    {
        $days[0] = Tool::MakeDbTimeStr_ts( System::$today_timestamp - (2*60*60*24) );
        $days[1] = Tool::MakeDbTimeStr_ts( System::$today_timestamp - (60*60*24) );
        $days[2] = System::$today_dbtime;
        $days[3] =  Tool::MakeDbTimeStr_ts( System::$today_timestamp + (60*60*24) );
        $table = self::Table_GetData( $days );
        $checkin_ids[0] = Tool::GetUniques( $table[ $days[0] ], $table[ $days[1] ] );
	    $checkin_ids[0] = Tool::RemoveVal( $checkin_ids[0], 0 );
        $checkin_ids[1] = Tool::GetUniques( $table[ $days[1] ], $table[ $days[2] ] );
	    $checkin_ids[1] = Tool::RemoveVal( $checkin_ids[1], 0 );
	    $checkin_ids[2] = Tool::GetUniques( $table[ $days[2] ], $table[ $days[3] ] );
	    $checkin_ids[2] = Tool::RemoveVal( $checkin_ids[2], 0 );
	    $all_checkin_ids = Tool::Merge( Tool::Merge( $checkin_ids[0], $checkin_ids[1] ), $checkin_ids[2] );
        $reservations = self::Reservation_GetData( $all_checkin_ids );

        $name_ids = array();
        $count = count( $all_checkin_ids );
        for( $i=0; $i<$count; ++$i )
        {
            $id = $all_checkin_ids[$i];
            $name_ids[ $i ] = $reservations[ $id ][ "people" ][0];
        }
        $names = self::People_GetData( $name_ids );


        //Yesterday
        $data[0] = array();
        $count = count( $checkin_ids[0] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkin_ids[0][$i];
            if( $reservations[ $id ]["status"] == "0"  )
            {
                $data[0][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[0][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[0][$j]["source"] = $reservations[ $id ]["source"];
                $data[0][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }

        //Today
        $data[1] = array();
        $count = count( $checkin_ids[1] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkin_ids[1][$i];
            if( $reservations[ $id ]["status"] == "0"  )
            {
                $data[1][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[1][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[1][$j]["source"] = $reservations[ $id ]["source"];
                $data[1][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }

        //Tomorrow
        $data[2] = array();
        $count = count( $checkin_ids[2] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkin_ids[2][$i];
            if( $reservations[ $id ]["status"] == "0"  )
            {
                $data[2][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[2][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[2][$j]["source"] = $reservations[ $id ]["source"];
                $data[2][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }

        return $data;
    }

    static function Summary_GetLeaving()
    {
        $days[0] = Tool::MakeDbTimeStr_ts( System::$today_timestamp - (60*60*24) );
        $days[1] = System::$today_dbtime;
        $days[2] = Tool::MakeDbTimeStr_ts( System::$today_timestamp + (60*60*24) );
        $days[3] =  Tool::MakeDbTimeStr_ts( System::$today_timestamp + (2*60*60*24) );
        $table = self::Table_GetData( $days );
        $checkout_ids[0] = Tool::GetUniques( $table[ $days[1] ], $table[ $days[0] ] );
	    $checkout_ids[0] = Tool::RemoveVal( $checkout_ids[0], 0 );
        $checkout_ids[1] = Tool::GetUniques( $table[ $days[2] ], $table[ $days[1] ] );
	    $checkout_ids[1] = Tool::RemoveVal( $checkout_ids[1], 0 );
        $checkout_ids[2] = Tool::GetUniques( $table[ $days[3] ], $table[ $days[2] ] );
	    $checkout_ids[2] = Tool::RemoveVal( $checkout_ids[2], 0 );
        $all_checkout_ids = Tool::Merge( Tool::Merge( $checkout_ids[0], $checkout_ids[1] ), $checkout_ids[2] );
        $reservations = self::Reservation_GetData( $all_checkout_ids );

        $name_ids = array();
        $count = count( $all_checkout_ids );
        for( $i=0; $i<$count; ++$i )
        {
            $id = $all_checkout_ids[$i];
            $name_ids[ $i ] = $reservations[ $id ][ "people" ][0];
        }
        $names = self::People_GetData( $name_ids );

        //Yesterday
        $data[0] = array();
        $count = count( $checkout_ids[0] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkout_ids[0][$i];
            if( $reservations[ $id ]["status"] == "1"  )
            {
                $data[0][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[0][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[0][$j]["source"] = $reservations[ $id ]["source"];
                $data[0][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }


        //Today
        $data[1] = array();
        $count = count( $checkout_ids[1] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkout_ids[1][$i];
            if( $reservations[ $id ]["status"] == "1"  )
            {
                $data[1][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[1][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[1][$j]["source"] = $reservations[ $id ]["source"];
                $data[1][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }

        //Tomorrow
        $data[2] = array();
        $count = count( $checkout_ids[2] );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $checkout_ids[2][$i];
            if( $reservations[ $id ]["status"] == "1"  )
            {
                $data[2][$j]["room"] = $reservations[ $id ]["stay"][0][ self::RV_ROOM ];
                $data[2][$j]["name"] = $names[ $reservations[ $id ]["people"][0] ][ "name" ];
                $data[2][$j]["source"] = $reservations[ $id ]["source"];
                $data[2][$j]["person"] = count( $reservations[ $id ]["people"] );
                ++$j;
            }
        }

        return $data;
    }

    static function Summary_GetFees()
    {
        $days[0] = Tool::MakeDbTimeStr_ts( System::$today_timestamp - (60*60*24) );
        $days[1] = System::$today_dbtime;
        $days[2] = Tool::MakeDbTimeStr_ts( System::$today_timestamp + (60*60*24) );
        $days[3] =  Tool::MakeDbTimeStr_ts( System::$today_timestamp + (2*60*60*24) );
        $table = self::Table_GetData( $days );
        $reservation_ids[0] = Tool::GetUniques( $table[ $days[3] ], $table[ $days[0] ] );
	    $reservation_ids[0] = Tool::RemoveVal( $reservation_ids[0], 0 );
        $reservation_ids[1] = Tool::GetUniques( $table[ $days[3] ], $table[ $days[1] ] );
	    $reservation_ids[1] = Tool::RemoveVal( $reservation_ids[1], 0 );
        $reservation_ids[2] = Tool::GetUniques( $table[ $days[3] ], $table[ $days[2] ] );
	    $reservation_ids[2] = Tool::RemoveVal( $reservation_ids[2], 0 );
        $all_reservation_ids = Tool::Merge( Tool::Merge( $reservation_ids[0], $reservation_ids[1] ), $reservation_ids[2] );
        $reservations = self::Reservation_GetData_allfeepaid_0( $all_reservation_ids );
        $reservation_ids = array_keys( $reservations );

        $name_ids = array();
        $count = count( $reservations );
        for( $i=0; $i<$count; ++$i )
        {
            $id = $reservation_ids[$i];
            $name_ids[ $i ] = $reservations[ $id ][ "people" ][0];
        }
        $names = self::People_GetData( $name_ids );

        $fee_ids = array();
        $count = count( $reservations );
        for( $i=0; $i<$count; ++$i )
        {
            $reserv_id = $reservation_ids[$i];
            $count_fee = count( $reservations[ $reserv_id ]["fee"] );
            for( $j=0; $j<$count_fee; ++$j )
            {
                $fee_ids[] = $reservations[ $reserv_id ]["fee"][$j];
            }
        }
        $fees = self::Finance_GetFee( $fee_ids );

        $data = array();
        $count = count( $fees );
        $j = 0;
        for( $i=0; $i<$count; ++$i )
        {
            $id = $fee_ids[$i];
            if( $fees[ $id ]["done"] == "0"  )
            {
                $data[$j]["room"] = $reservations[ $fees[ $id ]["reservation"] ]["stay"][0][ self::RV_ROOM ];
                $data[$j]["name"] = $names[ $reservations[ $fees[$id]["reservation"] ]["people"][0] ][ "name" ];
                $data[$j]["type"] = $fees[ $id ]["type"];
                $data[$j]["amount"] = $fees[ $id ]["amount"] . " " . $fees[ $id ]["currency"];
                ++$j;
            }
        }

        return $data;
    }

    // SETTINGS

    static function Settings_GetUsers()
    {
        $data = Database::Settings_GetUsers();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }

    static function Settings_GetRooms()
    {
        $data = Database::Settings_GetRooms();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }

    static function Settings_GetSources()
    {
        $data = Database::Settings_GetSources();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }

    static function Settings_GetFees()
    {
        $data = Database::Settings_GetFees();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }

    static function Settings_GetPayments()
    {
        $data = Database::Settings_GetPayments();
        $data_arr = array();

        $i = 0;
        while( $arr = Database::Fetch( $data ) )
        {
            $data_arr[ $i++ ] = $arr;
        }
        return $data_arr;
    }


}