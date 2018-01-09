<?php
/** 3 **
 * This class holds some fundamental operations to be used in other codes
 */

include_once( "2_System.php" );

class Tool
{
    // THERE 3 FUNCTIONS WILL TAKE PHP _XXX[] VARS WITHOUT ERROR
    static function _cookie( $label )
    {
        if( isset($_COOKIE[$label]) )
            return $_COOKIE[$label];
        return NULL;
    }
    static function _request( $label )
    {
        if( isset($_GET[$label]) )
            return $_GET[$label];
        else if( isset($_POST[$label]) )
            return $_POST[$label];
        return NULL;
    }
    static function _server( $label )
    {
        if( isset($_SERVER[$label]) )
            return $_SERVER[$label];
        return NULL;
    }


    static function GetReqPage()
    {
        $raw_url = explode( "/", Tool::_server("REQUEST_URI")."/" );
        $u1 = explode( "?", $raw_url[1] );
        $u2 = explode( "#", $u1[0] );
        return $u2[0];
    }

    static function CheckLoginInput( $str )
    {
        if( mb_strlen( $str ) > 0 && mb_strlen( $str ) < 33 ) return true;
        return false;
    }

    static function CheckRoomInput( $str )
    {
        if( mb_strlen( $str ) > 0 && mb_strlen( $str ) < 49 ) return true;
        return false;
    }

    static function CheckRoomBed( $int )
    {
        if( $int > 0 && $int < 101 ) return true;
        return false;
    }

    static function AddZero($_var)
    {
        if((int)$_var < 10)
        {
            return "0".(string)$_var;
        }
        return (string)$_var;
    }

    static function MakeDbTimeStr( $year, $month, $day )
    {
        return (int)( (string)$year . Tool::AddZero( $month ) . Tool::AddZero( $day ) );
    }

    static function MakeDbTimeStr_ts( $timestamp )
    {
        return (int)( (string)date( "Y", $timestamp ) . Tool::AddZero( date( "n", $timestamp ) ) . Tool::AddZero( date( "j", $timestamp ) ) );
    }

	static function TsToDb( $dbtime )
	{
		$year = (int)substr( $dbtime, 0, 4 );
		$month = (int)substr( $dbtime, 4, 2 );
		$day = (int)substr( $dbtime, 6, 2 );
		return mktime(0, 0, 0, $month, $day, $year);
	}

    static function GenerateConsecutiveDays( $firstday, $count )
    {
        $days = array();
        for( $i=0; $i<$count; ++$i )
        {
            $days[$i] = date( "Ymd", $firstday + (60 * 60 * 24 * $i) );
        }
        return $days;
    }

	static function GenerateWeek( $day )
	{
		$offset = (int)date("N", $day) - 1;
		$day -=  $offset * 60 * 60 * 24;
		$days = array();
		for( $i=0; $i<7; ++$i )
		{
			$days[$i] = date( "Ymd", $day + (60 * 60 * 24 * $i) );
		}
		return $days;
	}

    static function GetUniques( $haystack, $needle )
    {
        $unique = array();
        $count = count( $needle );
        for( $i=0; $i<$count; ++$i )
        {
            if( !in_array( $needle[$i], $haystack ) )
            {
                $unique[] = $needle[$i];
            }
        }
        return $unique;
    }

    static function Merge( $arr1, $arr2 )
    {
        $count = count( $arr2 );

        for( $i=0; $i<$count; ++$i )
        {
            if( !in_array( $arr2[$i], $arr1 ) )
            {
                $arr1[] = $arr2[$i];
            }
        }
        sort( $arr1, SORT_NUMERIC );
        return $arr1;
    }

    static function RemoveVal( $arr, $val )
    {
        if( ( $key = array_search( $val, $arr ) ) !== false )
            unset( $arr[ $key ] );
        return array_values( $arr );
    }

    static function OneUp( $arr, $val )
    {
        if( $arr[ 0 ] != $val )
        {
            if( ( $key = array_search( $val, $arr ) ) !== false )
            {
                $temp = $arr[ $key - 1 ];
                $arr[ $key - 1 ] = $arr[ $key ];
                $arr[ $key ] = $temp;

            }
        }
        return $arr;
    }

    static function OneDown( $arr, $val )
    {
        if( $arr[ count($arr) - 1 ] != $val )
        {
            if( ( $key = array_search( $val, $arr ) ) !== false )
            {
                $temp = $arr[ $key + 1 ];
                $arr[ $key + 1 ] = $arr[ $key ];
                $arr[ $key ] = $temp;

            }
        }
        return $arr;
    }

}