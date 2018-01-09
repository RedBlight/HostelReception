HMS.Action.codeport = "#codeport";
HMS.Action.in_request = false;



HMS.Action.Ajax = function( data ){ if( !HMS.Action.in_request )
{
    HMS.Action.in_request = true;
    data.is_ajax = "true";
    data.type = 'POST';
    $(HMS.Action.codeport).html("");
    $(HMS.Action.codeport).load( "index.php", data, function(){
        HMS.Action.in_request = false;
    });
}};

HMS.Action.Login_Login = function()
{
    // Check errors
    // Light up errors if there is one
    // if non, send them to php, light up loadin
    // wait for it, response will come in php, place it to body
    // it will do the rest

    var username = $("#username").val();
    var password = $("#password").val();

    if( !HMS.Tool.CheckLoginInput( username ) )
    {
        HMS.Designer.Login_Alert( "danger", "Invalid username!" );
    }
    else if( !HMS.Tool.CheckLoginInput( password ) )
    {
        HMS.Designer.Login_Alert( "danger", "Invalid password!" );
    }
    else
    {
        HMS.Designer.Login_Alert( "info", HMS.Component.Get( "loading" ) );
        var data = {};
        data.username = username;
        data.password = password;
        data.recaptcha_challenge_field = $("input#recaptcha_challenge_field").val();
        data.recaptcha_response_field = $("input#recaptcha_response_field").val();
        data.action = "login";
        HMS.Action.Ajax( data );
    }
};


// NOTE

HMS.Action.Note_Edit = function( id, note )
{
    var data = {};
    data.note_id = id;
    data.note = note;
    data.action = "note_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.Note_Delete = function( id )
{
    var data = {};
    data.note_id = id;
    data.action = "note_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.Note_Add = function( note )
{
    var data = {};
    data.note = note;
    data.action = "note_add";
    HMS.Action.Ajax( data );
};

// SETTINGS

HMS.Action.GetSetting = function( setting )
{
    var data = {};
    data.action = "get_setting_"+setting;
    HMS.Action.Ajax( data );
};

// USER

HMS.Action.User_Edit = function( id, username, type, changepass, password )
{
    var data = {};
    data.s_id = id;
    data.s_username = username;
    data.s_type = type;
    data.s_changepass = changepass;
    data.s_password = password;
    data.action = "user_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.User_Delete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "user_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.User_Add = function( username, type, password )
{
    var data = {};
    data.s_username = username;
    data.s_type = type;
    data.s_password = password;
    data.action = "user_add";
    HMS.Action.Ajax( data );
};

// ROOM

HMS.Action.Room_Edit = function( id, name, type, bed )
{
    var data = {};
    data.s_id = id;
    data.s_name = name;
    data.s_type = type;
    data.s_bed = bed;
    data.action = "room_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.Room_Add = function( name, type, bed )
{
    var data = {};
    data.s_name = name;
    data.s_type = type;
    data.s_bed = bed;
    data.action = "room_add";
    HMS.Action.Ajax( data );
};

HMS.Action.Room_Delete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "room_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.Room_Undelete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "room_undelete";
    HMS.Action.Ajax( data );
};

HMS.Action.Room_Up = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "room_up";
    HMS.Action.Ajax( data );
};

HMS.Action.Room_Down = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "room_down";
    HMS.Action.Ajax( data );
};

// SOURCE

HMS.Action.Source_Edit = function( id, name )
{
    var data = {};
    data.s_id = id;
    data.s_name = name;
    data.action = "source_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.Source_Add = function( name )
{
    var data = {};
    data.s_name = name;
    data.action = "source_add";
    HMS.Action.Ajax( data );
};

HMS.Action.Source_Delete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "source_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.Source_Undelete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "source_undelete";
    HMS.Action.Ajax( data );
};

HMS.Action.Source_Up = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "source_up";
    HMS.Action.Ajax( data );
};

HMS.Action.Source_Down = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "source_down";
    HMS.Action.Ajax( data );
};

// FEE

HMS.Action.Fee_Edit = function( id, name )
{
    var data = {};
    data.s_id = id;
    data.s_name = name;
    data.action = "fee_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.Fee_Add = function( name )
{
    var data = {};
    data.s_name = name;
    data.action = "fee_add";
    HMS.Action.Ajax( data );
};

HMS.Action.Fee_Delete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "fee_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.Fee_Undelete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "fee_undelete";
    HMS.Action.Ajax( data );
};

HMS.Action.Fee_Up = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "fee_up";
    HMS.Action.Ajax( data );
};

HMS.Action.Fee_Down = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "fee_down";
    HMS.Action.Ajax( data );
};

// PAYMENT

HMS.Action.Payment_Edit = function( id, name )
{
    var data = {};
    data.s_id = id;
    data.s_name = name;
    data.action = "payment_edit";
    HMS.Action.Ajax( data );
};

HMS.Action.Payment_Add = function( name )
{
    var data = {};
    data.s_name = name;
    data.action = "payment_add";
    HMS.Action.Ajax( data );
};

HMS.Action.Payment_Delete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "payment_delete";
    HMS.Action.Ajax( data );
};

HMS.Action.Payment_Undelete = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "payment_undelete";
    HMS.Action.Ajax( data );
};

HMS.Action.Payment_Up = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "payment_up";
    HMS.Action.Ajax( data );
};

HMS.Action.Payment_Down = function( id )
{
    var data = {};
    data.s_id = id;
    data.action = "payment_down";
    HMS.Action.Ajax( data );
};

HMS.Action.Options_Edit = function( opt0, opt1, opt2 )
{
	var data = {};
	data.opt0 = ( opt0 == true ) ? "1" : "0";
	data.opt1 = ( opt1 == true ) ? "1" : "0";
	data.opt2 = ( opt2 == true ) ? "1" : "0";
	data.action = "options_edit";
	HMS.Action.Ajax( data );
};

HMS.Action.Reservation_Add = function()
{
	var data = {};
	data.add_main = JSON.stringify( HMS.Data.reservadd[0] );
	data.add_people = JSON.stringify( HMS.Data.reservadd[1] );
	data.add_stay = JSON.stringify( HMS.Data.reservadd[2] );
	data.add_fees = JSON.stringify( HMS.Data.reservadd[3] );
	data.action = "reservation_add";
	HMS.Action.Ajax( data );
};

HMS.Action.Reservation_Get = function( bid )
{
	var data = {};
	data.reservation_id = bid;
	data.action = "reservation_get";
	HMS.Action.Ajax( data );
};

HMS.Action.Reservation_Edit = function()
{
	var data = {};
	data.add_main = JSON.stringify( HMS.Data.reservadd[0] );
	data.add_people = JSON.stringify( HMS.Data.reservadd[1] );
	data.add_stay = JSON.stringify( HMS.Data.reservadd[2] );
	data.add_fees = JSON.stringify( HMS.Data.reservadd[3] );
	data.action = "reservation_edit";
	HMS.Action.Ajax( data );
};