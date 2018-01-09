<?php
error_reporting(-1);
ini_set("display_errors", 1);
date_default_timezone_set('UTC');

include_once( "Class/11_Control.php" );

Control::ConnectDatabase();

Control::InitialiseSystem();

$repeat = $_GET["repeat"];

// 150 total
$names = array(
    "Mahmut", "Jones", "Jim", "Moriarty", "Yakup", "Salih", "Ayşe", "Sherlock", "Holmes", "Mehmet",
    "Yggrit", "Sharon", "Abdul", "Kerim", "Can", "Albert", "Arzu", "Nalan", "Fatma", "Emre",
    "Guillarme", "Tony", "Buket", "Beşar", "Mustafa", "Kemal", "Bill", "Gates", "Burak", "Jensen",

    "Lee", "Bruce", "Kim", "Kardashian", "Mary", "Patricia", "Linda", "Elizabeth", "Henry", "Donna",
    "Carol", "Ruth", "Betty", "Anna", "Amy", "Debra", "Amanda", "Alice", "Kelly", "Nicola",
    "Tesla", "Newton", "Isaac", "Lois", "Charlotte", "Veronica", "Annette", "Raymond", "Andrew", "Henry",

    "Carl", "Arthur", "Alexander", "Jonathan", "Johan", "Hegg", "Samuel", "Eugene", "Jeremy", "Sean",
    "Bean", "Bush", "Tayyip", "Emine", "Gül", "Jacob", "Adolph", "Hitler", "Zhou", "Kohan",
    "Khalesi", "Joffrey", "Arya", "Jon", "Benjen", "Aya", "Ayako", "Haruki", "Kazuma", "Yoshi",

    "Luigi", "Mario", "Gordon", "Morgan", "Freeman", "Kasumi", "Katushi", "Yamaro", "Mei", "Yao",
    "Michio", "Mizuki", "Naomi", "Abdullah", "Omar", "Hassan", "Mahmoud", "Mohammad", "Adam", "Marko",
    "Brahma", "Pushkar", "Shankar", "Rotshcild", "Chandra", "Khali", "Ludwig", "Harshad", "Marauder", "Ogre",

    "Mukesh", "Safiyah", "Lut", "Baqir", "Brutus", "Shaun", "Sami", "Olga", "Anastasia", "Katrina",
    "Natasha", "Natalya", "Tatyanna", "Yulia", "Augustus", "Rasmussen", "Stalin", "Nixon", "Kennedy", "Jesus",
    "Descartes", "Roman", "Samsung", "Redbull", "Zeus", "Moses", "Athene", "Thor", "Amon", "Zul",

    "Renault", "Toyota", "Mercedes", "Hyundai", "Nissan", "Ferrari", "Jaguar", "Jeep"
);

for( $i=0; $i<$repeat; ++$i )
{
    ++System::$count_reservation;

    $days = array();
    $day_count = mt_rand( 1, 10 );
    $day_first = mktime(0, 0, 0, 1, 1, 2018) + ( 60 * 60 * 24 * mt_rand( 1, 340 ) );
    $days = Tool::GenerateConsecutiveDays( $day_first, $day_count );
    Datamng::Table_AddReservation( $days, System::$count_reservation );


    $people = array();
    $people_ids = array();
    $person_count = mt_rand( 1, 7 );
    for( $j=0; $j<$person_count; ++$j )
    {
        $people[$j]["id"] = ++System::$count_people;
        $people[$j]["name"] = $names[ mt_rand( 0, 150 ) ] . " " . $names[ mt_rand( 0, 150 ) ];
        $people[$j]["passport"] = Encrypt::GenerateCookey( 12 );
        $people[$j]["country"] = mt_rand( 1, 207 );
        $people[$j]["birth"] = Tool::MakeDbTimeStr( mt_rand( 1900, 2013 ), mt_rand( 1, 12 ), mt_rand( 1 , 31 ) );
        $people[$j]["reservation"] = System::$count_reservation;
        $people[$j]["checkin"] = $days[0];
        $people[$j]["checkout"] = $days[ $day_count-1 ];

        $people_ids[$j] = System::$count_people;
    }
    Database::People_Insert( $people );

    $currency = array( "TL", "$", "€", "£" );
    $finance = array();
    $finance_ids = array();
    $finance_count = mt_rand( 1, 5 );
    $alldone = mt_rand( 0, 1 );
    for( $j=0; $j<$finance_count; ++$j )
    {
        $finance[$j]["id"] = ++System::$count_finance;
        $finance[$j]["class"] = 0;
        $finance[$j]["type"] = mt_rand( 1, 10 );
        $finance[$j]["description"] = Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ." ". Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ." ". Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ;
        $finance[$j]["date"] = $days[ $day_count-1 ];
        $finance[$j]["reservation"] = System::$count_reservation;
        $finance[$j]["amount"] = mt_rand( 5, 2000 );
        $finance[$j]["currency"] = $currency[ mt_rand( 0, 3 ) ];
        $finance[$j]["done"] = ( ($alldone == 1) ? 1 : 0 );

        $finance_ids[$j] = System::$count_finance;
    }
    Database::Finance_Insert( $finance );

    $reservation = array();
    $room = mt_rand( 1, 20 );
    $stay = array();
    $reservation[0]["id"] = System::$count_reservation;
    $reservation[0]["description"] = Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ." ". Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ." ". Encrypt::GenerateCookey( mt_rand( 3, 10 ) ) ;
    for( $j=0; $j<$day_count; ++$j )
    {
        $stay[$j] = $days[$j] . "." . $room;
    }
    $reservation[0]["stay"] = implode( ":", $stay );
    $reservation[0]["people"] = implode( ":", $people_ids );
    $reservation[0]["fee"] = implode( ":", $finance_ids );
    $reservation[0]["source"] = mt_rand( 1, 10 );
    $reservation[0]["status"] = mt_rand( 0, 3 );
    $reservation[0]["allfeepaid"] = $alldone;
    Database::Reservation_Insert( $reservation );

    if( $reservation[0]["status"] == 0 || $reservation[0]["status"] == 1 )
    {
        Database::Room_AddActive( $room, 1 );
    }

    //echo "#" . $i . "#Done!!!";
    if( !Database::$is_robust ) echo "AAAAAAAAAAAAAA";
}

Datamng::Main_Update();

Database::MailError();


Control::Conclude();