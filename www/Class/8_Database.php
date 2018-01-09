<?php
/** 8 **
 * This class handles database operations
 */

include_once( "7_Display.php" );

class Database
{
    //////////////////// VARIABLES ////////////////////
    /**
     * Database Connection
     * @var object
     */
    static $con;

    /**
     * Database Connection
     * @var object
     */
    static $connected = false;

    /**
     * Error Count
     * @var int
     */
    static $error_count = 0;

    /**
     * Array of error messages
     * @var array
     */
    static $error_messages = array("Error Messages");

    /**
     * False if there is error
     * @var object
     */
    static $is_robust = true;

    //////////////////// FUNDAMENTAL FUNCTIONS ////////////////////

    /**
     * Commits database actions if there is no error
     */
    static function Commit()
    {
        if( self::$connected )
        {
            if( self::$is_robust )
                self::$con->commit();
            else
                self::$con->rollback();
        }
    }

    /**
     * Sends error messages to the admin.
     * !!! In debug, prints it
     */
    static function MailError()
    {
        if( !self::$is_robust )
        {
            $err_html = "";
            for( $i=1; $i<=self::$error_count; ++$i )
                $err_html .= "<b>" . $i . " -> </b>" . self::$error_messages[$i] . "<br/>";
            $message = str_replace( "replace_me", $err_html, Component::$dberrormail_body );
            mail("", "-- RECEPTION ERROR --", $message, Component::$dberrormail_head);
            //echo $message;
        }
    }

    /**
     * Adds an error
     * @param string
     */
    static function ThrowError( $err_str )
    {
        self::$error_messages[ ++self::$error_count ] = $err_str;
    }

    /**
     * Checks if there was an error in last query, throws error if so
     * @param string
     */
    static function CheckError( $query )
    {
	    $err = self::$con->error;
        if( $err != "" )
        {
            self::ThrowError( $err . " ::Query( " . $query . ");" );
            self::$con->rollback();
            self::$is_robust = false;
        }
    }

    /**
     * Connects to the database with given values
     * @param string
     * @param string
     * @param string
     * @param string
     * @return bool true if successful
     */
    static function Connect( $server, $user, $pass, $name )
    {
        self::$con =  new mysqli( $server, $user, $pass, $name );
        if( self::$con->connect_errno )
        {
            self::ThrowError( "@ Connect(): " . self::$con->connect_error );
            return false;
        }
        self::$con->autocommit( false );
        self::$con->set_charset( "utf8" );
        self::$connected = true;
        return true;
    }

    /**
     * Disconnects from database
     */
    static function Disconnect()
    {
        if( self::$connected ) self::$con->close();
    }

    /**
     * escapes given string
     * @param string
     * @return string
     */
    static function Escape( $str )
    {
        return self::$con->real_escape_string( $str );
    }

    /**
     * Executes given mysql query
     * Returns result object
     * @param string
     * @return bool|object
     */
    static function Query( $query )
    {
	    //var_dump( $query ); echo (self::$is_robust) ? 'true' : 'false';
        if( self::$is_robust )
        {
            $obj_result = self::$con->query( $query );
            self::CheckError( $query );
            if( !$obj_result )
                return false;
            else
                return $obj_result;
        }
    }

    /**
     * Returns first row of result obj as assoc array
     * @param object
     * @return bool|array
     */
    static function Fetch($obj_result)
    {
        if($obj_result instanceof mysqli_result) return $obj_result->fetch_assoc();
        else return false;
    }

    //////////////////// HELPER FUNCTIONS ////////////////////

    /**
     * Checks whether a row exists by given data
     * Returns true if row exists
     * @param string
     * @param string
     * @param string
     * @return bool
     */
    static function RowExists( $table, $colname, $colval )
    {
        $table = self::Escape( $table );
        $colname = self::Escape( $colname );
        $colval = self::Escape( $colval );
        $query = " SELECT EXISTS(SELECT * FROM `x1` WHERE `x2`='x3' LIMIT 1) ";
        $query = str_replace( "x1", $table, $query );
        $query = str_replace( "x2", $colname, $query );
        $query = str_replace( "x3", $colval, $query );
        $data = self::Query( $query );
        $data_arr = array_values( self::Fetch( $data ) );
        return $data_arr[0];
    }

    /**
     * Gets main table
     * @return object
     */
    static function GetMainData()
    {
        $query = " SELECT * FROM `main` WHERE `id`='1' LIMIT 1 ";
        $data = self::Query( $query );
        return $data;
    }

    static function Main_Update( $data )
    {
        $data["id"] = self::Escape( $data["id"] );
        $data["option"] = self::Escape( $data["option"] );
        $data["forex"] = self::Escape( $data["forex"] );
        $data["ordroom"] = self::Escape( $data["ordroom"] );
        $data["ordsource"] = self::Escape( $data["ordsource"] );
        $data["ordfee"] = self::Escape( $data["ordfee"] );
        $data["ordpayment"] = self::Escape( $data["ordpayment"] );
        $data["cuser"] = self::Escape( $data["cuser"] );
        $data["croom"] = self::Escape( $data["croom"] );
        $data["creservation"] = self::Escape( $data["creservation"] );
        $data["cpeople"] = self::Escape( $data["cpeople"] );
        $data["csource"] = self::Escape( $data["csource"] );
        $data["cfee"] = self::Escape( $data["cfee"] );
        $data["cpayment"] = self::Escape( $data["cpayment"] );
        $data["cfinance"] = self::Escape( $data["cfinance"] );

        $query = " UPDATE `main` SET `id`='x1',`option`='x2',`forex`='x3',`ordroom`='x4',`ordsource`='x5',`ordfee`='x6',`ordpayment`='x7',`cuser`='x8',`croom`='x9',`creservation`='x10',`cpeople`='x11',`csource`='x12',`cfee`='x13',`cpayment`='x14',`cfinance`='x15' WHERE `id`='1' LIMIT 1 ";

        // Reverse order for 9+
        $query = str_replace( "x15", $data["cfinance"], $query );
        $query = str_replace( "x14", $data["cpayment"], $query );
        $query = str_replace( "x13", $data["cfee"], $query );
        $query = str_replace( "x12", $data["csource"], $query );
        $query = str_replace( "x11", $data["cpeople"], $query );
        $query = str_replace( "x10", $data["creservation"], $query );
        $query = str_replace( "x9", $data["croom"], $query );
        $query = str_replace( "x8", $data["cuser"], $query );
        $query = str_replace( "x7", $data["ordpayment"], $query );
        $query = str_replace( "x6", $data["ordfee"], $query );
        $query = str_replace( "x5", $data["ordsource"], $query );
        $query = str_replace( "x4", $data["ordroom"], $query );
        $query = str_replace( "x3", $data["forex"], $query );
        $query = str_replace( "x2", $data["option"], $query );
        $query = str_replace( "x1", $data["id"], $query );
        self::Query( $query );
    }

    /**
     * Gets user data of given id
     * @param string
     * @return object
     */
    static function GetUserDataById( $id )
    {
        $id = self::Escape( $id );
        $query = " SELECT * FROM `user` WHERE `id`='x1' LIMIT 1 ";
        $query = str_replace( "x1", $id, $query );
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Gets user data of given username
     * @param string
     * @return object
     */
    static function GetUserDataByUsername( $username )
    {
        $username = self::Escape( $username );
        $query = " SELECT * FROM `user` WHERE `username`='x1' LIMIT 1 ";
        $query = str_replace( "x1", $username, $query );
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Updates cookie hash of given user
     * @param string|number
     * @param string
     */
    static function UpdateCookey( $id, $cookey )
    {
        $id = self::Escape( $id );
        $cookey = self::Escape( $cookey );
        $query = " UPDATE `user` SET `cookeyhash`='x1' WHERE `id`='x2' LIMIT 1 ";
        $query = str_replace( "x1", $cookey, $query );
        $query = str_replace( "x2", $id, $query );
        self::Query( $query );
    }

    /**
     * Returns room name list
     * @return object
     */
    static function GetNameList_Room()
    {
        $query = " SELECT `id`,`name` FROM `room` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns source name list
     * @return object
     */
    static function GetNameList_Source()
    {
        $query = " SELECT `id`,`name` FROM `source` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns fee name list
     * @return object
     */
    static function GetNameList_Fee()
    {
        $query = " SELECT `id`,`name` FROM `fee` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns payment name list
     * @return object
     */
    static function GetNameList_Payment()
    {
        $query = " SELECT `id`,`name` FROM `payment` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Gets data of given days from table
     * @param array
     * @return object
     */
    static function Table_GetData( $days )
    {
        $query = " SELECT * FROM `table` WHERE `time` IN('0',";
        $count = count( $days );
        for( $i=0; $i<$count; ++$i )
        {
            $query .= "'" . self::Escape( $days[$i] ) . "',";
        }
        $query = rtrim( $query, "," ) . ")";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Adds given times to the table if they don't exist
     * @param array
     */
    static function Table_AddTime( $times )
    {
        $amount = count( $times );
        $query = " INSERT INTO `table` (`time`, `data`) VALUES ";
        $do_query = false;
        for( $i=0; $i<$amount; ++$i )
        {
            if( !self::RowExists( "table", "time", $times[$i] ) )
            {
                $query .= "('" . self::Escape( $times[$i] ) . "','0'),";
                $do_query = true;
            }
        }
        if( $do_query )
        {
            $query = rtrim( $query, "," );
            self::Query( $query );
        }
    }

    /**
     * Inserts given data to 'table'
     * @param array
     */
    static function Table_Insert( $data )
    {
        $amount = count( $data );
        $query = " UPDATE `table` SET `data`='x1' WHERE `time`='x2' LIMIT 1 ";
        for( $i=0; $i<$amount; ++$i )
        {
            $queryi = str_replace( "x1", self::Escape( $data[$i]["data"] ), $query );
            $queryi = str_replace( "x2", self::Escape( $data[$i]["time"] ), $queryi );
            self::Query( $queryi );
        }
    }

    /**
     * Inserts given data to 'people'
     * @param array
     */
    static function People_Insert( $data )
    {
        $amount = count( $data );
        $query = " INSERT INTO `people` (`id`,`name`,`passport`,`country`,`birth`,`reservation`,`checkin`,`checkout`) VALUES ";
        $do_query = false;
        for( $i=0; $i<$amount; ++$i )
        {
            $query .= "('" . self::Escape( $data[$i]["id"] ) . "','" . self::Escape( $data[$i]["name"] ) . "','" . self::Escape( $data[$i]["passport"] ) . "','"
                . self::Escape( $data[$i]["country"] ) . "','" . self::Escape( $data[$i]["birth"] ) . "','" . self::Escape( $data[$i]["reservation"] ) . "','"
                . self::Escape( $data[$i]["checkin"] ). "','" . self::Escape( $data[$i]["checkout"] )
                . "'),";
            $do_query = true;
        }
        if( $do_query )
        {
            $query = rtrim( $query, "," );
            self::Query( $query );
        }
    }

	/**
	 * Removes given id's from people table
	 * @param array
	 */
	static function People_Delete( $ids )
	{
		$amount = count( $ids );
		$query = " DELETE FROM `people` WHERE `id` IN('0',";
		$do_query = false;
		for( $i=0; $i<$amount; ++$i )
		{
			$query .= "'" . self::Escape( $ids[$i] ) . "',";
			$do_query = true;
		}
		if( $do_query )
		{
			$query = rtrim( $query, "," ) . ")";
			self::Query( $query );
		}
	}

    /**
     * Inserts given data to 'finance'
     * @param array
     */
    static function Finance_Insert( $data )
    {
        $amount = count( $data );
        $query = " INSERT INTO `finance` (`id`,`class`,`type`,`description`,`date`,`reservation`,`amount`,`currency`,`done`) VALUES ";
        $do_query = false;
        for( $i=0; $i<$amount; ++$i )
        {
            $query .= "('" . self::Escape( $data[$i]["id"] ) . "','" . self::Escape( $data[$i]["class"] ) . "','" . self::Escape( $data[$i]["type"] ) . "','"
                . self::Escape( $data[$i]["description"] ) . "','" . self::Escape( $data[$i]["date"] ) . "','" . self::Escape( $data[$i]["reservation"] ) . "','"
                . self::Escape( $data[$i]["amount"] ) . "','" . self::Escape( $data[$i]["currency"] ) . "','" . self::Escape( $data[$i]["done"] )
                . "'),";
            $do_query = true;
        }
        if( $do_query )
        {
            $query = rtrim( $query, "," );
            self::Query( $query );
        }
    }

	/**
	 * Removes given id's from finance table
	 * @param array
	 */
	static function Finance_Delete( $ids )
	{
		$amount = count( $ids );
		$query = " DELETE FROM `finance` WHERE `id` IN('0',";
		$do_query = false;
		for( $i=0; $i<$amount; ++$i )
		{
			$query .= "'" . self::Escape( $ids[$i] ) . "',";
			$do_query = true;
		}
		if( $do_query )
		{
			$query = rtrim( $query, "," ) . ")";
			self::Query( $query );
		}
	}

    /**
     * Returns data of given ids from 'reservation'
     * @param array
     * @return object
     */
    static function People_GetData( $ids )
    {
        $query = " SELECT * FROM `people` WHERE `id` IN('0',";
        $count = count( $ids );
        for( $i=0; $i<$count; ++$i )
        {
            $query .= "'" . self::Escape( $ids[$i] ) . "',";
        }
        $query = rtrim( $query, "," ) . ")";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns data of given ids from 'reservation'
     * @param array
     * @return object
     */
    static function Reservation_GetData( $ids )
    {
        $query = " SELECT * FROM `reservation` WHERE `id` IN('0',";
        $count = count( $ids );
        for( $i=0; $i<$count; ++$i )
        {
            $query .= "'" . self::Escape( $ids[$i] ) . "',";
        }
        $query = rtrim( $query, "," ) . ")";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns data of given ids from 'reservation', where allfeepaid=0
     * @param array
     * @return object
     */
    static function Reservation_GetData_allfeepaid_0( $ids )
    {
        $query = " SELECT * FROM `reservation` WHERE `allfeepaid`='0' AND `id` IN('0',";
        $count = count( $ids );
        for( $i=0; $i<$count; ++$i )
        {
            $query .= "'" . self::Escape( $ids[$i] ) . "',";
        }
        $query = rtrim( $query, "," ) . ")";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Inserts given data to 'reservation'
     * @param array
     */
    static function Reservation_Insert( $data )
    {
        $amount = count( $data );
        $query = " INSERT INTO `reservation` (`id`,`description`,`stay`,`people`,`fee`,`source`,`status`,`allfeepaid`) VALUES ";
        $do_query = false;
        for( $i=0; $i<$amount; ++$i )
        {
            $query .= "('" . self::Escape( $data[$i]["id"] ) . "','" . self::Escape( $data[$i]["description"] ) . "','" . self::Escape( $data[$i]["stay"] ) . "','"
                . self::Escape( $data[$i]["people"] ) . "','" . self::Escape( $data[$i]["fee"] ) . "','" . self::Escape( $data[$i]["source"] ) . "','"
                . self::Escape( $data[$i]["status"] ) . "','" . self::Escape( $data[$i]["allfeepaid"] )
                . "'),";
            $do_query = true;
        }
        if( $do_query )
        {
            $query = rtrim( $query, "," );
            self::Query( $query );
        }
    }

	/**
	 * Removes given id's from reservation table
	 * @param array
	 */
	static function Reservation_Delete( $ids )
	{
		$amount = count( $ids );
		$query = " DELETE FROM `reservation` WHERE `id` IN('0',";
		$do_query = false;
		for( $i=0; $i<$amount; ++$i )
		{
			$query .= "'" . self::Escape( $ids[$i] ) . "',";
			$do_query = true;
		}
		if( $do_query )
		{
			$query = rtrim( $query, "," ) . ")";
			self::Query( $query );
		}
	}

    /**
     * Returns data of given ids from 'reservation'
     * @param array
     * @return object
     */

    static function Finance_GetFee( $ids )
    {
        $query = " SELECT * FROM `finance` WHERE `class`='0' AND `id` IN('0',";
        $count = count( $ids );
        for( $i=0; $i<$count; ++$i )
        {
            $query .= "'" . self::Escape( $ids[$i] ) . "',";
        }
        $query = rtrim( $query, "," ) . ")";
        $data = self::Query( $query );
        return $data;
    }

    /**
 * Increases given room's active by given value add
 * @param int
 * @param int
 */
	static function Room_AddActive( $id, $add )
	{
		$id = self::Escape( $id );
		$add = self::Escape( $add );
		$query = " UPDATE `room` SET `active`=`active`+(x1) WHERE `id`='x2' ";
		$query = str_replace( "x1", $add, $query );
		$query = str_replace( "x2", $id, $query );
		self::Query( $query );
	}

	/**
	 * Increases given room's active by given value add
	 * @param array
	 * @param int
	 */
	static function Room_AddActiveArray( $ids, $add )
	{
		$query = " UPDATE `room` SET `active`=`active`+(x1) WHERE `id` IN('0',";
		$query = str_replace( "x1", $add, $query );
		$count = count( $ids );
		for( $i=0; $i<$count; ++$i )
			$query .= "'" . self::Escape( $ids[$i] ) . "',";
		$query = rtrim( $query, "," ) . ")";
		self::Query( $query );
	}

    /**
     * Returns all notes
     * @return object
     */
    static function Note_GetData()
    {
        $query = " SELECT * FROM `note` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Changes given id's note
     * @param int
     * @param string
     */
    static function Note_Edit( $id, $note )
    {
        $id = self::Escape( $id );
        $note = self::Escape( $note );
        $query = " UPDATE `note` SET `note`='x1x' WHERE `id`='x2x' ";
        $query = str_replace( "x1x", $note, $query );
        $query = str_replace( "x2x", $id, $query );
        self::Query( $query );
    }

    /**
     * Deletes the note of given id
     * @param int
     */
    static function Note_Add( $note )
    {
        $note = self::Escape( $note );
        $query = " INSERT INTO `note` (`note`) VALUES ('x1x') ";
        $query = str_replace( "x1x", $note, $query );
        self::Query( $query );
    }

    /**
     * Deletes the note of given id
     * @param int
     */
    static function Note_Delete( $id )
    {
        $id = self::Escape( $id );
        $query = " DELETE FROM `note` WHERE `id` = 'x1x' ";
        $query = str_replace( "x1x", $id, $query );
        self::Query( $query );
    }

    /**
     * Returns all users
     * @return object
     */
    static function Settings_GetUsers()
    {
        $query = " SELECT `id`,`type`,`username` FROM `user` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns all rooms
     * @return object
     */
    static function Settings_GetRooms()
    {
        $query = " SELECT * FROM `room` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns all sources
     * @return object
     */
    static function Settings_GetSources()
    {
        $query = " SELECT * FROM `source` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns all fees
     * @return object
     */
    static function Settings_GetFees()
    {
        $query = " SELECT * FROM `fee` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Returns all payments
     * @return object
     */
    static function Settings_GetPayments()
    {
        $query = " SELECT * FROM `payment` WHERE 1 ";
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Changes user with given values
     * @param int
     * @param string
     * @param string
     * @param bool
     * @param string
     */
    static function User_Edit( $id, $username, $type, $changepass, $password )
    {
        $id = self::Escape( $id );
        $username = self::Escape( $username );
        $type = self::Escape( $type );
        if( $changepass )
        {
            $passwordhash = Encrypt::Hash( $password, 4096 );
            $query = " UPDATE `user` SET `type`='x1x', `username`='x2x', `passwordhash`='x4x' WHERE `id`='x3x' ";
            $query = str_replace( "x4x", $passwordhash, $query );
        }
        else
            $query = " UPDATE `user` SET `type`='x1x', `username`='x2x' WHERE `id`='x3x' ";
        $query = str_replace( "x1x", $type, $query );
        $query = str_replace( "x2x", $username, $query );
        $query = str_replace( "x3x", $id, $query );
        self::Query( $query );
    }

    /**
     * Deletes given user
     * @param int
     */
    static function User_Delete( $id )
    {
        $id = self::Escape( $id );
        $query = " DELETE FROM `user` WHERE `id` = 'x1x' ";
        $query = str_replace( "x1x", $id, $query );
        self::Query( $query );
    }

    /**
     * Creates an user with given data
     * @param int
     * @param string
     * @param string
     * @param string
     */
    static function User_Add( $id, $username, $type, $password )
    {
        $id = self::Escape( $id );
        $username = self::Escape( $username );
        $type = self::Escape( $type );
        $passwordhash = Encrypt::Hash( $password, 4096 );
        $query = " INSERT INTO `user` (`id`,`type`,`username`,`passwordhash`,`cookeyhash`) VALUES ('x1x','x2x','x3x','x4x','xxx')";
        $query = str_replace( "x1x", $id, $query );
        $query = str_replace( "x2x", $type, $query );
        $query = str_replace( "x3x", $username, $query );
        $query = str_replace( "x4x", $passwordhash, $query );
        self::Query( $query );
    }

    /**
     * Gets the data of given room
     * @param int
     * @return object
     */
    static function Room_GetRow( $id )
    {
        $id = self::Escape( $id );
        $query = " SELECT * FROM `room` WHERE `id`='x1x' LIMIT 1 ";
        $query = str_replace( "x1x", $id, $query );
        $data = self::Query( $query );
        return $data;
    }

    /**
     * Creates a room with given data
     * @param int
     * @param string
     * @param string
     * @param string
     */
    static function Room_Add( $id, $name, $type, $bed )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $type = self::Escape( $type );
        $bed = self::Escape( $bed );
        $query = " INSERT INTO `room` (`id`,`name`,`type`,`bed`,`active`) VALUES ('x1x','x2x','x3x','x4x','0')";
        $query = str_replace( "x1x", $id, $query );
        $query = str_replace( "x2x", $name, $query );
        $query = str_replace( "x3x", $type, $query );
        $query = str_replace( "x4x", $bed, $query );
        self::Query( $query );
    }

    /**
     * Changes room with given values
     * @param int
     * @param string
     * @param string
     * @param int
     */
    static function Room_Edit( $id, $name, $type, $bed )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $type = self::Escape( $type );
        $bed = self::Escape( $bed );
        $query = " UPDATE `room` SET `name`='x1x', `type`='x2x', `bed`='x3x' WHERE `id`='x4x' ";
        $query = str_replace( "x1x", $name, $query );
        $query = str_replace( "x2x", $type, $query );
        $query = str_replace( "x3x", $bed, $query );
        $query = str_replace( "x4x", $id, $query );
        self::Query( $query );
    }

    /**
     * Creates a source with given data
     * @param int
     * @param string
     */
    static function Source_Add( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " INSERT INTO `source` (`id`,`name`) VALUES ('x1x','x2x')";
        $query = str_replace( "x1x", $id, $query );
        $query = str_replace( "x2x", $name, $query );
        self::Query( $query );
    }

    /**
     * Changes source with given values
     * @param int
     * @param string
     */
    static function Source_Edit( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " UPDATE `source` SET `name`='x1x' WHERE `id`='x2x' ";
        $query = str_replace( "x1x", $name, $query );
        $query = str_replace( "x2x", $id, $query );
        self::Query( $query );
    }

    /**
     * Creates a fee with given data
     * @param int
     * @param string
     */
    static function Fee_Add( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " INSERT INTO `fee` (`id`,`name`) VALUES ('x1x','x2x')";
        $query = str_replace( "x1x", $id, $query );
        $query = str_replace( "x2x", $name, $query );
        self::Query( $query );
    }

    /**
     * Changes fee with given values
     * @param int
     * @param string
     */
    static function Fee_Edit( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " UPDATE `fee` SET `name`='x1x' WHERE `id`='x2x' ";
        $query = str_replace( "x1x", $name, $query );
        $query = str_replace( "x2x", $id, $query );
        self::Query( $query );
    }

    /**
     * Creates a payment with given data
     * @param int
     * @param string
     */
    static function Payment_Add( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " INSERT INTO `payment` (`id`,`name`) VALUES ('x1x','x2x')";
        $query = str_replace( "x1x", $id, $query );
        $query = str_replace( "x2x", $name, $query );
        self::Query( $query );
    }

    /**
     * Changes payment with given values
     * @param int
     * @param string
     */
    static function Payment_Edit( $id, $name )
    {
        $id = self::Escape( $id );
        $name = self::Escape( $name );
        $query = " UPDATE `payment` SET `name`='x1x' WHERE `id`='x2x' ";
        $query = str_replace( "x1x", $name, $query );
        $query = str_replace( "x2x", $id, $query );
        self::Query( $query );
    }



}