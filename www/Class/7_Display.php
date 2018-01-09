<?php
/** 7 **
 * This class handles all the output that php echos
 */

include_once( "6_Encrypt.php" );

class Display
{
    /**
     * Holds final output
     * @var string
     */
    static private $output = "";

    /**
     * Holds script output
     * @var string
     */
    static private $script = "";

    /**
     * Adds given script to the script output
     * @param string
     */
    static function AddScript( $_script )
    {
        self::$script .= $_script;
    }

    /**
     * Adds given html to the output
     * @param string
     */
    static function AddHtml( $_html )
    {
        self::$output .= $_html;
    }

    /**
     * Adds given json to the output
     * Be careful, there has to be no other output
     * @param string
     */
    static function AddJson( $_json )
    {
        self::$output .= json_encode( $_json );
    }

    /**
     * Prepares the output by adding scripts
     */
    static function PrepareOutput()
    {
        if( self::$script != "" )
            self::$output .= str_replace( "replace_me", self::$script, Component::$script_wrapper  );
    }

    /**
     * Makes the output a full html page
     * Places output string in the body
     */
    static function MakeFullPage()
    {
        self::$output = str_replace( "replace_me", self::$output, Component::$html_wrapper );
    }

    /**
     * Print the output
     */
    static function PrintOutput()
    {
        echo self::$output;
    }
}