<?php
/** 6 **
 * This class handles all the cryptological operations
 */

include_once( "5_ComponentC.php" );

class Encrypt
{
    static private $chars = "0123456789abcdefghijklmnopqrstuvwxyzQWERTYUIOPASDFGHJKLZXCVBNMxxxx";
    const PBKDF2_HASH_ALGORITHM = 'sha256';
    const PBKDF2_SALT_BYTES = 24;
    const PBKDF2_HASH_BYTES = 24;
    const HASH_SECTIONS = 4;
    const HASH_ALGORITHM_INDEX = 0;
    const HASH_ITERATION_INDEX = 1;
    const HASH_SALT_INDEX = 2;
    const HASH_PBKDF2_INDEX = 3;

    /**
     * Hashes given password with iterations
     * @param string
     * @param int
     * @return string
     */
    static function Hash( $password, $iterations )
    {
        $salt = base64_encode(mcrypt_create_iv(self::PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM));
        return self::PBKDF2_HASH_ALGORITHM.":".$iterations.":".$salt.":"
        .base64_encode(
            self::KeyDerive(
                self::PBKDF2_HASH_ALGORITHM,
                $password,
                $salt,
                $iterations,
                self::PBKDF2_HASH_BYTES,
                true
            )
        );
    }

    /**
     * Compares a password with hash
     * @param string
     * @param string
     * @return bool
     */
    static function Validate( $password, $hash )
    {
        $params = explode(":", $hash);
        if(count($params) < self::HASH_SECTIONS) { return false; }
        $PBKDF2 = base64_decode( $params[self::HASH_PBKDF2_INDEX] );
        return self::SlowEquals($PBKDF2,
            self::KeyDerive(
                $params[self::HASH_ALGORITHM_INDEX],
                $password,
                $params[self::HASH_SALT_INDEX],
                (int)$params[self::HASH_ITERATION_INDEX],
                strlen($PBKDF2),
                true
            )
        );
    }

    // PBKDF2
    static function SlowEquals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
        {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    // PBKDF2
    static function KeyDerive($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if(!in_array($algorithm, hash_algos(), true)) { die('KeyDerive ERROR: Invalid hash algorithm.'); }
        if($count <= 0 || $key_length <= 0) { die('KeyDerive ERROR: Invalid parameters.'); }
        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);
        $output = "";
        for($i = 1; $i <= $block_count; $i++)
        {
            $last = $salt.pack("N", $i);
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            for($j = 1; $j < $count; $j++)
            {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }
        if($raw_output) { return substr($output, 0, $key_length); }
        else { return bin2hex(substr($output, 0, $key_length)); }
    }

    /**
     * Generates a random string with given length
     * @param int
     * @return string
     */
    static function GenerateCookey( $length )
    {
        $key = "";
        for($i=0; $i<$length; $i++) { $key .= self::$chars[mt_rand(0, 62)]; }
        return $key;
    }

    /**
     * Scrambles given id with cookey
     * @param int
     * @param string
     * @return string
     */
    static function ScrambleCookey( $id, $c )
    {
        //made for 32 char cookeys
        //base 36
        //i c c c c    m c c c c    a c c i c    c m c c c    c
        //i c c c c    m c c c c    a c c i c    c m c c c    c
        //last 1 or 3 i
        $mulrand			= mt_rand(46646, 1679615);
        $m					= base_convert( $mulrand, 10, 36 );
        $addrand			= mt_rand(36, 1295);
        $a					= base_convert( $addrand, 10, 36 );
        $i					= base_convert( $mulrand * ($id + $addrand), 10, 36 );
        $cckey = $i[0] . $c[0] . $c[1] . $c[2] . $c[3] . $m[0] . $c[4] . $c[5] . $c[6] . $c[7]
            .$a[0] . $c[8] . $c[9] . $i[1] . $c[10]. $c[11]. $m[1] . $c[12]. $c[13]. $c[14]. $c[15]
            .$i[2] . $c[16]. $c[17]. $c[18]. $c[19]. $m[2] . $c[20]. $c[21]. $c[22]. $c[23]
            .$a[1] . $c[24]. $c[25]. $i[3] . $c[26]. $c[27]. $m[3] . $c[28]. $c[29]. $c[30]. $c[31]
            .$i[4];
        if(isset($i[5])) $cckey.= $i[5];
        if(isset($i[6])) $cckey.= $i[6];
        return $cckey;
    }

    /**
     * Solves scrambled cookie key
     * @param string
     * @return array|bool
     */
    static function ParseCookey( $c )
    {
        $size = strlen($c);
        if( ctype_alnum($c) && $size<46 && $size>42 )
        {
            $mulrand	= (int)base_convert( $c[5].$c[16].$c[26].$c[37], 36, 10 );
            $addrand	= (int)base_convert( $c[10].$c[31], 36, 10 );
            $i			= $c[0].$c[13].$c[21].$c[34].$c[42]; if(isset($c[43]))$i.=$c[43]; if(isset($c[44]))$i.=$c[44];
            $id			= ( ((int)base_convert($i, 36, 10)) / $mulrand ) - $addrand;
            $cookey		= $c[1].$c[2].$c[3].$c[4]	  .$c[6].$c[7].$c[8].$c[9]	   .$c[11].$c[12].$c[14] .$c[15].$c[17].$c[18].$c[19].$c[20]
                .$c[22].$c[23].$c[24].$c[25] .$c[27].$c[28].$c[29].$c[30] .$c[32].$c[33].$c[35] .$c[36].$c[38].$c[39].$c[40].$c[41];
            return array($id, $cookey);
        }
        return false;
    }
}