// MAIN

HMS.Control.OpenModal = function( title, body, buttons )
{
    $("body").append( HMS.Component.Get( "modal" ) );
    $("#modal #title").html( title );
    $("#modal #body").html( body );

    // Buttons: cancel confirm addnow
    var i;
    var loop = buttons.length;
    for( i=0; i<loop; ++i ) $("#modal #btnbar").append( HMS.Component.Get( "modal_btn_" + buttons[i] ) );
    $("#modal").on("hidden.bs.modal", function(e){
        $("#modal").remove();
    });

    $("#modal .close, #modal #cancel").mousedown( function(e){ if( e.which == 1 ){
        HMS.Control.CloseModal();
    }});

    $("#modal").modal( { show: true, backdrop: 'static' } );

};

HMS.Control.CloseModal = function()
{
    $("#modal").on("hidden.bs.modal", function(e){
        $("#modal").remove();
    });
    $("#modal").modal( "hide" );
};

HMS.Control.DisableModal = function()
{
    $("#modal #body #modal-alert").remove();
    $("#modal #save, #modal #confirm, #modal #addnow").removeClass("btn-success").addClass("btn-primary");
    $("#modal #save, #modal #confirm, #modal #addnow").html( HMS.Component.Get( "loading" ) );
    $("#modal *").attr( "disabled", "disabled" );
    $("#modal, #modal *").off();
};


HMS.Control.Modal_Confirm = function( title, body )
{
    HMS.Control.OpenModal( title, body, ["cancel","confirm"] );
};

HMS.Control.Modal_Addnow = function( title, body )
{
    HMS.Control.OpenModal( title, body, ["cancel","addnow"] );
};

HMS.Control.Modal_Save = function( title, body )
{
    HMS.Control.OpenModal( title, body, ["cancel","save"] );
};

HMS.Control.Modalert = function( msg )
{
    $("#modal #body #modal-alert").remove();
    $("#modal #body").append( HMS.Component.Get( "summary_modal_alert" ) );
    $("#modal #body #modal-alert").append( msg );
};


// NOTES

HMS.Control.Note_Edit = function( index )
{
    HMS.Control.Modal_Save(
        "Edit Note",
        HMS.Component.Get( "summary_modal_note_edit" )
    );
    $("#modal #edit-note").val( HMS.Data.summary_notes[index]["note"] )
    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        if( $("#modal #edit-note").val().isValidNote() )
        {
            HMS.Control.DisableModal();
            HMS.Action.Note_Edit( HMS.Data.summary_notes[ index ]["id"], $("#modal #edit-note").val() );
        }
        else
            HMS.Control.Modalert( "Note should be lesser than 3000 characters, and can not be empty." );
    }});
};

HMS.Control.Note_Delete = function( index )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to permanently delete this note:<br/><br/><b>"
            + HMS.Data.summary_notes[ index ]["note"] + "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        HMS.Control.DisableModal();
        HMS.Action.Note_Delete( HMS.Data.summary_notes[ index ]["id"] );
    }});
};

HMS.Control.Note_Add = function( )
{
    HMS.Control.Modal_Addnow(
        "Add New Note",
        HMS.Component.Get( "summary_modal_noteadd" )
    );
    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        if( $("#modal #new-note").val().isValidNote() )
        {
            HMS.Control.DisableModal();
            HMS.Action.Note_Add( $("#modal #new-note").val() );
        }
        else
            HMS.Control.Modalert( "Note should be lesser than 3000 characters, and can not be empty." );
    }});
};


// USER

HMS.Control.User_Edit = function( id )
{
    HMS.Control.Modal_Save(
        "Edit User",
        HMS.Component.Get( "settings_modal_user_edit" )
    );
    $("#modal #username").val( HMS.Data.settings_users_byid[ id ]["username"] );
    $("#modal #type").val( HMS.Data.settings_users_byid[ id ]["type"] );

    $("#modal #changepass").change( function(){
        if( this.checked )
            $("#modal #password-wrap").css( "display", "inline-block" );
        else
            $("#modal #password-wrap").css( "display", "none" );
    });

    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        var correct = false;
        var username = $("#modal #username").val() ;
        var type = $("#modal #type").val();
        var changepass = $("#modal #changepass").is(":checked");
        var password = $("#modal #password").val()

        if( username.isUsernameExists() && ( HMS.Data.settings_users_byid[id]["username"] != username) )
            HMS.Control.Modalert( "Username already exists!" );
        else if( !username.isValidUsername() )
            HMS.Control.Modalert( "Username length must be between 1-32 letters!" );
        else if( changepass && !password.isValidPassword() )
            HMS.Control.Modalert( "Password length must be between 1-32 letters!" );
        else if( id == 1 )
        {
            if( HMS.Data.username == "root" )
            {
                if( username != "root" )
                    HMS.Control.Modalert( "\"root\" username can not be changed!" );
                else if( type != "Manager" )
                    HMS.Control.Modalert( "\"root\" is always manager, can not be changed into employee!" );
                else
                    correct = true;
            }
            else
                HMS.Control.Modalert( "\"root\" superuser can not be modified!" );
        }
        else if( HMS.Data.username == HMS.Data.settings_users_byid[id]["username"] )
        {
            if( username != HMS.Data.username )
                HMS.Control.Modalert( "You can not change your own username!" );
            else if( type != "Manager" )
                HMS.Control.Modalert( "You can not change yourself into an employee!" );
            else
                correct = true;
        }
        else
            correct = true;

        if( correct )
        {
            HMS.Control.DisableModal();
            HMS.Action.User_Edit( id, username, type, changepass, password );
        }
    }});
};

HMS.Control.User_Delete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to permanently delete this user:<br/><br/><b>"
            + HMS.Data.settings_users_byid[ id ]["username"] + "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        if( id == 1 )
            HMS.Control.Modalert( "\"root\" can not be deleted!" );
        else if( HMS.Data.username == HMS.Data.settings_users_byid[ id ]["username"] )
            HMS.Control.Modalert( "You can not delete yourself!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.User_Delete( id );
        }
    }});
};

HMS.Control.User_Add = function()
{
    HMS.Control.Modal_Addnow(
        "Add New User",
        HMS.Component.Get( "settings_modal_user_add" )
    );

    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        var username = $("#modal #username").val() ;
        var type = $("#modal #type").val();
        var password = $("#modal #password").val();

        if( username.isUsernameExists() )
            HMS.Control.Modalert( "Username already exists!" );
        else if( !username.isValidUsername() )
            HMS.Control.Modalert( "Username length must be between 1-32 letters!" );
        else if( !password.isValidPassword() )
            HMS.Control.Modalert( "Password length must be between 1-32 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.User_Add( username, type, password );
        }
    }});
};

// ROOMS

HMS.Control.Room_Add = function()
{
    HMS.Control.Modal_Addnow(
        "Add New Room",
        HMS.Component.Get( "settings_modal_room_add").replace( "{option_number_1_100}", HMS.Component.Get( "option_number_1_100" ) )
    );

    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;
        var type = $("#modal #type").val();
        var bed = $("#modal #bed").val();

        if( !name.isValidRoomname() )
            HMS.Control.Modalert( "Room name length must be between 1-48 letters!" );
        else if( !type.isValidRoomtype() )
            HMS.Control.Modalert( "Room type length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Room_Add( name, type, bed );
        }
    }});
};

HMS.Control.Room_Delete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to remove this room:<br/><br/><b>"
            + HMS.Data.settings_rooms_byid[ id ]["name"] + " - "
            + HMS.Data.settings_rooms_byid[ id ]["type"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        if( HMS.Data.order_room.length < 2 )
            HMS.Control.Modalert( "There has to be at least 1 room in the list!" );
        else if( Number(HMS.Data.settings_rooms_byid[ id ]["active"]) > 0 )
            HMS.Control.Modalert( "There are active reservations in this room. Make sure that all the reservations made to this room are either cancelled or checked out!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Room_Delete( id );
        }
    }});
};

HMS.Control.Room_Undelete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to undelete this room:<br/><br/><b>"
            + HMS.Data.settings_rooms_byid[ id ]["name"] + " - "
            + HMS.Data.settings_rooms_byid[ id ]["type"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
            HMS.Control.DisableModal();
            HMS.Action.Room_Undelete( id );
    }});
};

HMS.Control.Room_Edit = function( id )
{
    HMS.Control.Modal_Save(
        "Edit Room",
        HMS.Component.Get( "settings_modal_room_add").replace( "{option_number_1_100}", HMS.Component.Get( "option_number_1_100" ) )
    );
    $("#modal #name").val( HMS.Data.settings_rooms_byid[ id ]["name"] );
    $("#modal #type").val( HMS.Data.settings_rooms_byid[ id ]["type"] );
    $("#modal #bed").val( HMS.Data.settings_rooms_byid[ id ]["bed"] );

    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;
        var type = $("#modal #type").val();
        var bed = $("#modal #bed").val();

        if( !name.isValidRoomname() )
            HMS.Control.Modalert( "Room name length must be between 1-48 letters!" );
        else if( !type.isValidRoomtype() )
            HMS.Control.Modalert( "Room type length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Room_Edit( id, name, type, bed );
        }
    }});
};

// SOURCES

HMS.Control.Source_Add = function()
{
    HMS.Control.Modal_Addnow(
        "Add New Source",
        HMS.Component.Get( "settings_modal_source_add" )
    );

    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidSourcename() )
            HMS.Control.Modalert( "Source name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Source_Add( name );
        }
    }});
};

HMS.Control.Source_Delete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to remove this source:<br/><br/><b>"
            + HMS.Data.settings_sources_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        if( HMS.Data.order_source.length < 2 )
            HMS.Control.Modalert( "There has to be at least 1 source in the list!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Source_Delete( id );
        }
    }});
};

HMS.Control.Source_Undelete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to undelete this source:<br/><br/><b>"
            + HMS.Data.settings_sources_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        HMS.Control.DisableModal();
        HMS.Action.Source_Undelete( id );
    }});
};

HMS.Control.Source_Edit = function( id )
{
    HMS.Control.Modal_Save(
        "Edit Source",
        HMS.Component.Get( "settings_modal_source_add" )
    );
    $("#modal #name").val( HMS.Data.settings_sources_byid[ id ]["name"] );

    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidSourcename() )
            HMS.Control.Modalert( "Source name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Source_Edit( id, name );
        }
    }});
};

// FEES

HMS.Control.Fee_Add = function()
{
    HMS.Control.Modal_Addnow(
        "Add New Fee",
        HMS.Component.Get( "settings_modal_fee_add" )
    );

    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidFeename() )
            HMS.Control.Modalert( "Fee name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Fee_Add( name );
        }
    }});
};

HMS.Control.Fee_Delete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to remove this fee:<br/><br/><b>"
            + HMS.Data.settings_fees_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        if( HMS.Data.order_fee.length < 2 )
            HMS.Control.Modalert( "There has to be at least 1 fee in the list!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Fee_Delete( id );
        }
    }});
};

HMS.Control.Fee_Undelete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to undelete this fee:<br/><br/><b>"
            + HMS.Data.settings_fees_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        HMS.Control.DisableModal();
        HMS.Action.Fee_Undelete( id );
    }});
};

HMS.Control.Fee_Edit = function( id )
{
    HMS.Control.Modal_Save(
        "Edit Fee",
        HMS.Component.Get( "settings_modal_fee_add" )
    );
    $("#modal #name").val( HMS.Data.settings_fees_byid[ id ]["name"] );

    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidFeename() )
            HMS.Control.Modalert( "Fee name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Fee_Edit( id, name );
        }
    }});
};

// PAYMENTS

HMS.Control.Payment_Add = function()
{
    HMS.Control.Modal_Addnow(
        "Add New Payment",
        HMS.Component.Get( "settings_modal_payment_add" )
    );

    $("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidPaymentname() )
            HMS.Control.Modalert( "Payment name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Payment_Add( name );
        }
    }});
};

HMS.Control.Payment_Delete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to remove this payment:<br/><br/><b>"
            + HMS.Data.settings_payments_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        if( HMS.Data.order_payment.length < 2 )
            HMS.Control.Modalert( "There has to be at least 1 payment in the list!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Payment_Delete( id );
        }
    }});
};

HMS.Control.Payment_Undelete = function( id )
{
    HMS.Control.Modal_Confirm(
        "Are you sure?",
        "Do you really want to undelete this payment:<br/><br/><b>"
            + HMS.Data.settings_payments_byid[ id ]["name"] +  "</b>"
    );
    $("#modal #confirm").mousedown( function(e){ if( e.which == 1 ){
        HMS.Control.DisableModal();
        HMS.Action.Payment_Undelete( id );
    }});
};

HMS.Control.Payment_Edit = function( id )
{
    HMS.Control.Modal_Save(
        "Edit Payment",
        HMS.Component.Get( "settings_modal_payment_add" )
    );
    $("#modal #name").val( HMS.Data.settings_payments_byid[ id ]["name"] );

    $("#modal #save").mousedown( function(e){ if( e.which == 1 ){
        var name = $("#modal #name").val() ;

        if( !name.isValidPaymentname() )
            HMS.Control.Modalert( "Payment name length must be between 1-48 letters!" );
        else
        {
            HMS.Control.DisableModal();
            HMS.Action.Payment_Edit( id, name );
        }
    }});
};



// RESERVATIONS

HMS.Control.Options_Edit = function()
{
	HMS.Control.Modal_Save(
		"Options",
		HMS.Component.Get( "reserv_modal_options" )
	);
	//$("#modal #name").val( HMS.Data.settings_payments_byid[ id ]["name"] );
	//$('.myCheckbox').prop('checked', true);

	$("#modal #opt-0").prop( "checked", true );
	$("#modal #opt-1").prop( "checked", true );
	$("#modal #opt-2").prop( "checked", true );

	if( HMS.Data.option[0] == 0 )
		$("#modal #opt-0").prop( "checked", false );
	if( HMS.Data.option[1] == 0 )
		$("#modal #opt-1").prop( "checked", false );
	if( HMS.Data.option[2] == 0 )
		$("#modal #opt-2").prop( "checked", false );

	$("#modal #save").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.DisableModal();
		HMS.Action.Options_Edit( $("#modal #opt-0").prop( "checked" ), $("#modal #opt-1").prop( "checked" ), $("#modal #opt-2").prop( "checked" )  );
	}});
};

HMS.Control.Reservation_PersonFillRow = function()
{
	$("#r-tab-people").append( HMS.Component.Get( "reserv_modal_add_people_row" ) );
	$("#r-tab-people tr:last #p-i-country").append( HMS.Component.Get( "option_country" ) );
	$("#r-tab-people tr:last #p-i-bday").append( HMS.Component.Get( "option_day" ) );
	$("#r-tab-people tr:last #p-i-bmon").append( HMS.Component.Get( "option_smonth" ) );
	$("#r-tab-people tr:last #p-i-byea").append( HMS.Component.Get( "option_lyear" ) );
	$("#r-tab-people tr:last #p-i-byea").val("1990");
	$("#r-tab-people tr:last #p-i-del").mousedown( function(e){ if( e.which == 1 ){
		if( $("#r-tab-people tr").length > 2 )
		{
			$(this).parent().parent().remove();
		}
	}});
};

HMS.Control.Reservation_FeeFillRow = function()
{
	$("#r-tab-fees").append( HMS.Component.Get( "reserv_modal_add_fees_row" ) );
	$("#r-tab-fees tr:last #f-i-type").append( HMS.Tool.MakeOptionFee() );
	$("#r-tab-fees tr:last #f-i-del").mousedown( function(e){ if( e.which == 1 ){
		if( $("#r-tab-fees tr").length > 2 )
		{
			$(this).parent().parent().remove();
		}
	}});
};

HMS.Control.Reservation_MakeStay = function()
{
	var i;
	var j;
	var room_id;
	var data;
	var month = $("#r-date-stay #s-date-month").val();
	var year = $("#r-date-stay #s-date-year").val();
	var mon_length = new Date( year, month, 0).getDate() + 1;

	var matrix_body = '<tr><td class="matrix-h">R/D</td>';
	for( i=1; i<mon_length; ++i ) matrix_body += '<td class="matrix-h">' + i.toString().addZero(2) + '</td>';
	matrix_body += '</tr>';


	var room_count = HMS.Data.order_room.length;
	for( i=0; i<room_count; ++i )
	{
		room_id = HMS.Data.order_room[i];
		matrix_body += '<tr><td class="matrix-h">' + HMS.Data.list_room[ room_id ] + '</td>';
		for( j=1; j<mon_length; ++j )
		{
			data = year+month+(j).toString().addZero(2) + "-" + room_id;
			matrix_body += '<td class="matrix-d d' + data + '" data="' + data + '"></td>';
		}
		matrix_body += '</tr>';
	}

	$("#r-matrix-stay #s-matrix").html( matrix_body );

	var length = HMS.Data.reservadd_stay.length;
	var table_body = '<tr><th id="s-ind">#</th><th id="s-date">Date</th><th id="s-room">Room</th><th id="s-del">Delete</th></tr>';
	for( i=0; i<length; ++i )
	{
		var ddat = HMS.Data.reservadd_stay[i];
		$("#r-matrix-stay #s-matrix .d" + ddat ).css( "background-color", "#DFD" );
		table_body += '<tr><td id="s-ind">' + (i+1) + '</td><td id="s-date">' + ddat.slice(0,8).dbdateToDatestr() + '</td><td id="s-room">' + HMS.Data.list_room[ ddat.slice(9) ] + '</td><td id="s-del" data="' + ddat + '"><span class="glyphicon glyphicon-remove" id="s-i-del"></span></td></tr>'

	}

	$("#r-tab-stay").html( table_body );

	$("#s-matrix .matrix-d").mousedown( function(e){ if( e.which == 1 ){
		var ddat = $(this).attr("data");
		var dday = ddat.slice(0,8);
		var droom = ddat.slice(9);
		var ind = HMS.Data.reservadd_stay_days.indexOf( dday );
		if( ind === -1 )
		{
			HMS.Data.reservadd_stay.push( ddat );
			HMS.Data.reservadd_stay_days.push( dday );
		}
		else if( HMS.Data.reservadd_stay[ind] != ddat )
		{
			HMS.Data.reservadd_stay.splice( ind, 1 );
			HMS.Data.reservadd_stay_days.splice( ind, 1 );
			HMS.Data.reservadd_stay.push( ddat );
			HMS.Data.reservadd_stay_days.push( dday );
		}
		else if( HMS.Data.reservadd_stay[ind] == ddat )
		{
			HMS.Data.reservadd_stay.splice( ind, 1 );
			HMS.Data.reservadd_stay_days.splice( ind, 1 );
		}
		HMS.Data.reservadd_stay.sort();
		HMS.Data.reservadd_stay_days.sort();
		HMS.Control.Reservation_MakeStay();
	}});

	$("#r-tab-stay #s-i-del").mousedown( function(e){ if( e.which == 1 ){
		var ddat = $(this).parent().attr("data");
		var dday = ddat.slice(0,8);
		var droom = ddat.slice(9);
		var ind = HMS.Data.reservadd_stay_days.indexOf( dday );
		HMS.Data.reservadd_stay.splice( ind, 1 );
		HMS.Data.reservadd_stay_days.splice( ind, 1 );
		HMS.Data.reservadd_stay.sort();
		HMS.Data.reservadd_stay_days.sort();
		HMS.Control.Reservation_MakeStay();
	}});
};

HMS.Control.Reservation_Add = function()
{
	HMS.Data.reservadd = {};
	HMS.Data.reservadd[0] = {};
	HMS.Data.reservadd[1] = {};
	HMS.Data.reservadd[2] = {};
	HMS.Data.reservadd[3] = {};
	HMS.Data.reservadd_stay = [];
	HMS.Data.reservadd_stay_days = [];

	HMS.Control.Modal_Addnow(
		"Add New Reservation",
		HMS.Component.Get( "reserv_modal_add" )
	);

	$(".modal-dialog").addClass("modal-lg");
	$("#modal #body").css( "padding", "19px" );


	$("#r-segment-main").append( HMS.Component.Get( "reserv_modal_add_main" ) );
	$("#m-source").append( HMS.Tool.MakeOptionSource() );


	$("#r-segment-people").append( HMS.Component.Get( "reserv_modal_add_people" ) );
	HMS.Control.Reservation_PersonFillRow();
	$("#p-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_PersonFillRow();
	}});

	$("#r-segment-stay").append( HMS.Component.Get( "reserv_modal_add_stay" ) );
	$("#r-date-stay #s-date-month").append( HMS.Component.Get( "option_month" )).val( (HMS.Data.table_date.getMonth()+1).toString().addZero(2) );
	$("#r-date-stay #s-date-year").append( HMS.Component.Get( "option_year" ) ).val( HMS.Data.table_date.getFullYear() );
	HMS.Control.Reservation_MakeStay();
	$("#r-date-stay #s-date-month, #r-date-stay #s-date-year").change( function(){
		HMS.Control.Reservation_MakeStay();
	});

	$("#r-segment-fees").append( HMS.Component.Get( "reserv_modal_add_fees" ) );
	HMS.Control.Reservation_FeeFillRow();
	$("#f-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_FeeFillRow();
	}});

	$(".btno").mousedown( function(e){ if( e.which == 1 ){
		$("#reservadd-segment #r-navbar .btni").addClass("btno").removeClass("btni");
		$(this).addClass("btni").removeClass("btno");

		$(".r-segment").css( "display", "none" );
		$( "#r-segment-" + $(this).attr("id") ).css( "display", "inline-block" );
	}});

	$("#reservadd-segment #r-navbar .btno#main").addClass("btni").removeClass("btno");
	$(".r-segment").css( "display", "none" );
	$("#r-segment-main").css( "display", "inline-block" );




	$("#modal #addnow").mousedown( function(e){ if( e.which == 1 ){
		var i;
		var nth;
		var length;
		var control;
		var amount;

		HMS.Data.reservadd[0]["status"] = $("#m-status").val();
		HMS.Data.reservadd[0]["source"] = $("#m-source").val();
		HMS.Data.reservadd[0]["description"] = $("#m-description").val();

		length = $("#r-tab-people tr").length - 1;
		for( i=0; i<length; ++i )
		{
			nth = i+2;
			HMS.Data.reservadd[1][i] = {};
			HMS.Data.reservadd[1][i]["name"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-name").val();
			HMS.Data.reservadd[1][i]["passport"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-passport").val();
			HMS.Data.reservadd[1][i]["country"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-country").val();
			HMS.Data.reservadd[1][i]["birth"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-byea").val() + $("#r-tab-people tr:nth-child(" + nth + ") #p-i-bmon").val() + $("#r-tab-people tr:nth-child(" + nth + ") #p-i-bday").val();
		}

		length = HMS.Data.reservadd_stay.length;
		for( i=0; i<length; ++i )
		{
			HMS.Data.reservadd[2][i] = {};
			HMS.Data.reservadd[2][i][0] = HMS.Data.reservadd_stay[i].slice(0,8);
			HMS.Data.reservadd[2][i][1] = HMS.Data.reservadd_stay[i].slice(9);
		}

		length = $("#r-tab-fees tr").length - 1;
		for( i=0; i<length; ++i )
		{
			nth = i+2;
			HMS.Data.reservadd[3][i] = {};
			HMS.Data.reservadd[3][i]["type"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-type").val();
			HMS.Data.reservadd[3][i]["description"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-description").val();
			amount = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-amount").val()
			HMS.Data.reservadd[3][i]["amount"] = ( amount === "" || ( Number( amount ) === NaN ) || ( ( Number( amount ) % 1 ) !== 0 ) ) ? NaN : Number( amount );
			HMS.Data.reservadd[3][i]["currency"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-currency").val();
			HMS.Data.reservadd[3][i]["done"] = ( $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-paid").prop("checked") ) ? "1" : "0";
		}

		control = true;
		if( HMS.Data.reservadd[0]["description"].length > 3000 )
		{
			HMS.Control.Modalert( "Additional notes can not be larger than 3000 chars." );
			control = false;
		}
		if( control && Object.keys( HMS.Data.reservadd[1] ).length < 1 )
		{
			HMS.Control.Modalert( "There has to be at least 1 person in the reservation." );
			control = false;
		}
		if( control ) { length = Object.keys( HMS.Data.reservadd[1] ).length; for( i=0; i<length; ++i )
		{
			if( control && ( HMS.Data.reservadd[1][i]["name"].length > 64 || HMS.Data.reservadd[1][i]["name"].length < 1 ) )
			{
				HMS.Control.Modalert( "Person-" + (i+1) + " name length has to be between 1-64 chars."  );
				control = false; i = length;
			}
			if( control && ( HMS.Data.reservadd[1][i]["passport"].length > 64 || HMS.Data.reservadd[1][i]["passport"].length < 1 ) )
			{
				HMS.Control.Modalert( "Person-" + (i+1) + " passport number length has to be between 1-64 chars."  );
				control = false; i = length;
			}
		}}
		if( control && Object.keys( HMS.Data.reservadd[2] ).length < 1 )
		{
			HMS.Control.Modalert( "Reservation has to be made on at least 1 day." );
			control = false;
		}
		if( control ) { length = Object.keys( HMS.Data.reservadd[3] ).length; for( i=0; i<length; ++i )
		{
			if( control && isNaN( HMS.Data.reservadd[3][i]["amount"] ) )
			{
				HMS.Control.Modalert( "Fee-" + (i+1) + " amount has to be an integer value. "  );
				control = false; i = length;
			}
			if( control && HMS.Data.reservadd[3][i]["description"].length > 1000 )
			{
				HMS.Control.Modalert( "Fee-" + (i+1) + " description can not be larger that 1000 chars. "  );
				control = false; i = length;
			}
		}}
		if( control )
		{
			HMS.Control.DisableModal();
			HMS.Action.Reservation_Add();
		}
	}});
};

HMS.Control.Reservation_Edit = function( bid )
{
	HMS.Data.reservedit = {};
	HMS.Data.reservedit[0] = {};
	HMS.Data.reservedit[1] = {};
	HMS.Data.reservedit[2] = {};
	HMS.Data.reservedit[3] = {};
	HMS.Data.reservadd_stay = [];
	HMS.Data.reservadd_stay_days = [];

	HMS.Data.reservadd = {};
	HMS.Data.reservadd[0] = {};
	HMS.Data.reservadd[1] = {};
	HMS.Data.reservadd[2] = {};
	HMS.Data.reservadd[3] = {};

	HMS.Control.Modal_Save(
		"Reservation #" + bid,
		HMS.Component.Get( "loading" )
	);

	$(".modal-footer #save").css( "display", "none" );

	$(".modal-dialog").addClass("modal-lg");
	$("#modal #body").css( "padding", "19px" );

	HMS.Action.Reservation_Get( bid );
};

HMS.Control.Reservation_Edit_Make = function()
{
	var i;
	var count;

	$("#modal #body").html( HMS.Component.Get( "reserv_modal_add" ) );
	$(".modal-footer #save").css( "display", "inline-block" );

	$("#r-segment-main").append( HMS.Component.Get( "reserv_modal_add_main" ) );
	$("#m-status").val( HMS.Data.reservedit[0]["status"] );
	$("#m-source").append( HMS.Tool.MakeOptionSource() );
	if( HMS.Data.order_source.indexOf( HMS.Data.reservedit[0]["source"] ) === -1 )
		$("#m-source").prepend( '<option value="' + HMS.Data.reservedit[0]["source"] + '">' + HMS.Data.list_source[ HMS.Data.reservedit[0]["source"] ] + '</option>' );
	$("#m-source").val( HMS.Data.reservedit[0]["source"] );
	$("#m-description").val( HMS.Data.reservedit[0]["description"] );

	$("#r-segment-people").append( HMS.Component.Get( "reserv_modal_add_people" ) );
	count = HMS.Data.reservedit[1].length;
	for( i=0; i<count; ++i )
	{
		HMS.Control.Reservation_PersonFillRow();
		$("#r-tab-people tr:last").attr( "dbid", HMS.Data.reservedit[1][i]["id"] );
		$("#r-tab-people tr:last #p-i-name").val( HMS.Data.reservedit[1][i]["name"] );
		$("#r-tab-people tr:last #p-i-passport").val( HMS.Data.reservedit[1][i]["passport"] );
		$("#r-tab-people tr:last #p-i-country").val( HMS.Data.reservedit[1][i]["country"] );
		$("#r-tab-people tr:last #p-i-bday").val( HMS.Data.reservedit[1][i]["birth"].slice(6,8) );
		$("#r-tab-people tr:last #p-i-bmon").val( HMS.Data.reservedit[1][i]["birth"].slice(4,6) );
		$("#r-tab-people tr:last #p-i-byea").val( HMS.Data.reservedit[1][i]["birth"].slice(0,4) );
	}
	$("#p-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_PersonFillRow();
	}});

	$("#r-segment-stay").append( HMS.Component.Get( "reserv_modal_add_stay" ) );
	$("#r-date-stay #s-date-month").append( HMS.Component.Get( "option_month" )).val( HMS.Data.reservedit[2][0][0].slice(4,6) );
	$("#r-date-stay #s-date-year").append( HMS.Component.Get( "option_year" ) ).val( HMS.Data.reservedit[2][0][0].slice(0,4) );
	HMS.Control.Reservation_MakeStay();
	$("#r-date-stay #s-date-month, #r-date-stay #s-date-year").change( function(){
		HMS.Control.Reservation_MakeStay();
	});

	$("#r-segment-fees").append( HMS.Component.Get( "reserv_modal_add_fees" ) );
	count = HMS.Data.reservedit[3].length;
	for( i=0; i<count; ++i )
	{
		HMS.Control.Reservation_FeeFillRow();
		$("#r-tab-fees tr:last").attr( "dbid", HMS.Data.reservedit[3][i]["id"] );
		if( HMS.Data.order_fee.indexOf( HMS.Data.reservedit[3][i]["type"] ) === -1 )
			$("#r-tab-fees tr:last #f-i-type").prepend( '<option value="' + HMS.Data.reservedit[3][i]["type"] + '">' + HMS.Data.list_fee[ HMS.Data.reservedit[3][i]["type"] ] + '</option>' );
		$("#r-tab-fees tr:last #f-i-type").val( HMS.Data.reservedit[3][i]["type"] );
		$("#r-tab-fees tr:last #f-i-description").val( HMS.Data.reservedit[3][i]["description"] );
		$("#r-tab-fees tr:last #f-i-amount").val( HMS.Data.reservedit[3][i]["amount"] );
		$("#r-tab-fees tr:last #f-i-currency").val( HMS.Data.reservedit[3][i]["currency"] );
		$("#r-tab-fees tr:last #f-i-paid").prop( "checked", (HMS.Data.reservedit[3][i]["done"] == "1" ) );
	}
	$("#f-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_FeeFillRow();
	}});

	$(".btno").mousedown( function(e){ if( e.which == 1 ){
		$("#reservadd-segment #r-navbar .btni").addClass("btno").removeClass("btni");
		$(this).addClass("btni").removeClass("btno");

		$(".r-segment").css( "display", "none" );
		$( "#r-segment-" + $(this).attr("id") ).css( "display", "inline-block" );
	}});

	$("#reservadd-segment #r-navbar .btno#main").addClass("btni").removeClass("btno");
	$(".r-segment").css( "display", "none" );
	$("#r-segment-main").css( "display", "inline-block" );

	$("#modal #save").mousedown( function(e){ if( e.which == 1 ){
		var i;
		var nth;
		var length;
		var control;
		var amount;

		HMS.Data.reservadd[0]["id"] = HMS.Data.reservedit[0]["id"];
		HMS.Data.reservadd[0]["status"] = $("#m-status").val();
		HMS.Data.reservadd[0]["source"] = $("#m-source").val();
		HMS.Data.reservadd[0]["description"] = $("#m-description").val();

		length = $("#r-tab-people tr").length - 1;
		for( i=0; i<length; ++i )
		{
			nth = i+2;
			HMS.Data.reservadd[1][i] = {};
			HMS.Data.reservadd[1][i]["id"] = $("#r-tab-people tr:nth-child(" + nth + ")").attr("dbid");
			HMS.Data.reservadd[1][i]["name"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-name").val();
			HMS.Data.reservadd[1][i]["passport"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-passport").val();
			HMS.Data.reservadd[1][i]["country"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-country").val();
			HMS.Data.reservadd[1][i]["birth"] = $("#r-tab-people tr:nth-child(" + nth + ") #p-i-byea").val() + $("#r-tab-people tr:nth-child(" + nth + ") #p-i-bmon").val() + $("#r-tab-people tr:nth-child(" + nth + ") #p-i-bday").val();
		}

		length = HMS.Data.reservadd_stay.length;
		for( i=0; i<length; ++i )
		{
			HMS.Data.reservadd[2][i] = {};
			HMS.Data.reservadd[2][i][0] = HMS.Data.reservadd_stay[i].slice(0,8);
			HMS.Data.reservadd[2][i][1] = HMS.Data.reservadd_stay[i].slice(9);
		}

		length = $("#r-tab-fees tr").length - 1;
		for( i=0; i<length; ++i )
		{
			nth = i+2;
			HMS.Data.reservadd[3][i] = {};
			HMS.Data.reservadd[3][i]["id"] = $("#r-tab-fees tr:nth-child(" + nth + ")").attr("dbid");
			HMS.Data.reservadd[3][i]["type"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-type").val();
			HMS.Data.reservadd[3][i]["description"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-description").val();
			amount = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-amount").val()
			HMS.Data.reservadd[3][i]["amount"] = ( amount === "" || ( Number( amount ) === NaN ) || ( ( Number( amount ) % 1 ) !== 0 ) ) ? NaN : Number( amount );
			HMS.Data.reservadd[3][i]["currency"] = $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-currency").val();
			HMS.Data.reservadd[3][i]["done"] = ( $("#r-tab-fees tr:nth-child(" + nth + ") #f-i-paid").prop("checked") ) ? "1" : "0";
		}

		control = true;
		if( HMS.Data.reservadd[0]["description"].length > 3000 )
		{
			HMS.Control.Modalert( "Additional notes can not be larger than 3000 chars." );
			control = false;
		}
		if( control && Object.keys( HMS.Data.reservadd[1] ).length < 1 )
		{
			HMS.Control.Modalert( "There has to be at least 1 person in the reservation." );
			control = false;
		}
		if( control ) { length = Object.keys( HMS.Data.reservadd[1] ).length; for( i=0; i<length; ++i )
		{
			if( control && ( HMS.Data.reservadd[1][i]["name"].length > 64 || HMS.Data.reservadd[1][i]["name"].length < 1 ) )
			{
				HMS.Control.Modalert( "Person-" + (i+1) + " name length has to be between 1-64 chars."  );
				control = false; i = length;
			}
			if( control && ( HMS.Data.reservadd[1][i]["passport"].length > 64 || HMS.Data.reservadd[1][i]["passport"].length < 1 ) )
			{
				HMS.Control.Modalert( "Person-" + (i+1) + " passport number length has to be between 1-64 chars."  );
				control = false; i = length;
			}
		}}
		if( control && Object.keys( HMS.Data.reservadd[2] ).length < 1 )
		{
			HMS.Control.Modalert( "Reservation has to be made on at least 1 day." );
			control = false;
		}
		if( control ) { length = Object.keys( HMS.Data.reservadd[3] ).length; for( i=0; i<length; ++i )
		{
			if( control && isNaN( HMS.Data.reservadd[3][i]["amount"] ) )
			{
				HMS.Control.Modalert( "Fee-" + (i+1) + " amount has to be an integer value. "  );
				control = false; i = length;
			}
			if( control && HMS.Data.reservadd[3][i]["description"].length > 1000 )
			{
				HMS.Control.Modalert( "Fee-" + (i+1) + " description can not be larger that 1000 chars. "  );
				control = false; i = length;
			}
		}}
		if( control )
		{
			HMS.Control.DisableModal();
			HMS.Action.Reservation_Edit();
		}
	}});

};






