HMS.Designer.SetAsCaptcha = function( elem_id )
{
	Recaptcha.create( "6LfGMt8SAAAAAG3l5rmgDChrtDwCyKA8CF2cifZn", elem_id, { theme: "white", lang: "en" } );
};

HMS.Designer.AddCodeport = function()
{
	$("body").append( HMS.Component.Get( "codeport" ) );
};

HMS.Designer.SetPage_Login = function()
{
	HMS.Component.IntegrityCheck();

	var html = HMS.Component.Get( "page_login" );
	$("body").html( html );
	HMS.Designer.AddCodeport();

	// add login functionality for button here
	HMS.Designer.SetAsCaptcha( "captcha" );
	$("#login-btn").mousedown(function() {
		HMS.Action.Login_Login();
	});
	$("#username").keydown(function( event ) {
		if( event.which == 13 )
		{
			event.preventDefault();
			HMS.Action.Login_Login();
		}
	});
	$("#password").keydown(function( event ) {
		if( event.which == 13 )
		{
			event.preventDefault();
			HMS.Action.Login_Login();
		}
	});

	$("body").on( "keydown", "#recaptcha_response_field", function( event ){
		if( event.which == 13 )
		{
			event.preventDefault();
			HMS.Action.Login_Login();
		}
	});
	/*
	 $("#recaptcha_response_field").keydown(function( event ) {
	 if( event.which == 13 )
	 {
	 event.preventDefault();
	 HMS.Action.Login_Login();
	 }
	 });
	 */
};

// Type success info warning danger
HMS.Designer.Login_Alert = function( type, message )
{
	$("#login-alert").css( "display", "none" );
	$("#login-alert").html( "" );
	$("#login-alert").removeClass( "alert-success" );
	$("#login-alert").removeClass( "alert-info" );
	$("#login-alert").removeClass( "alert-warning" );
	$("#login-alert").removeClass( "alert-danger" );

	$("#login-alert").addClass( "alert-" + type );
	switch( type )
	{
		case "success":
			$("#login-alert").append( '<span class="glyphicon glyphicon-ok"></span>' );
			break;
		case "info":
			$("#login-alert").append( '<span class="glyphicon glyphicon-info-sign"></span>' );
			break;
		case "warning":
			$("#login-alert").append( '<span class="glyphicon glyphicon-exclamation-sign"></span>' );
			break;
		case "danger":
			$("#login-alert").append( '<span class="glyphicon glyphicon-warning-sign"></span>' );
			break;
	}
	$("#login-alert").append( message );
	$("#login-alert").css( "display", "inline-block" );
};

HMS.Designer.SetNavbarButton = function( page )
{
	$("#navbar .btni").addClass("btno").removeClass("btni");
	$("#navbar #"+page).addClass("btni").removeClass("btno");
};

HMS.Designer.UpdateDate = function()
{
	HMS.Data.local_date = new Date();
	HMS.Data.system_date = new Date( HMS.Data.local_date.getTime() + HMS.Data.date_diff );
	$("#navbar #time").html( HMS.Data.system_date.getNavbarDate() );
};

HMS.Designer.SetContent_Loading = function()
{
	$("#content").html( HMS.Component.Get( "loading" ) );
};

HMS.Designer.PreparePage = function()
{
	HMS.Component.IntegrityCheck();
	$("body").attr( "id", "afterlogin" );
	if( HMS.Data.usertype == "Manager" )
		$("body").html( HMS.Component.Get( "layout_manager" ) );
	else if( HMS.Data.usertype == "Employee" )
		$("body").html( HMS.Component.Get( "layout_employee" ) );

	$("#navbar #usd").html( HMS.Data.USD );
	$("#navbar #eur").html( HMS.Data.EUR );
	$("#navbar #gbp").html( HMS.Data.GBP );
	$("#navbar #username").text( HMS.Data.username );
	HMS.Designer.SetNavbarButton( HMS.Data.page );

	HMS.Data.local_date = new Date();
	HMS.Data.date_diff = HMS.Data.server_date.getTime() - HMS.Data.local_date.getTime();
	HMS.Designer.UpdateDate();
	setInterval( function(){ HMS.Designer.UpdateDate(); }, 1000 );

	HMS.Maker.NavbarLink( "summary" );
	HMS.Maker.NavbarLink( "reservations" );
	HMS.Maker.NavbarLink( "people" );
	HMS.Maker.NavbarLink( "finance" );
	HMS.Maker.NavbarLink( "statistics" );
	HMS.Maker.NavbarLink( "settings" );
	$("#navbar #exit").mousedown( function(e){ if( e.which == 1 ){
		HMS.System.DeleteCookie( "cookey" );
		HMS.System.GotoPage( "" );
	}});

	$("#logo").mousedown( function(e){ if( e.which == 1 ){
		HMS.System.GotoPage( "load" );
	}});
};

HMS.Designer.SetPage_Summary = function()
{
	var length;
	var i;
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_summary" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
	$(".sum-segment .sum-date#yesterday").html( HMS.Data.server_date.getSummaryDate( "yesterday" ) );
	$(".sum-segment .sum-date#today").html( HMS.Data.server_date.getSummaryDate( "today" ) );
	$(".sum-segment .sum-date#tomorrow").html( HMS.Data.server_date.getSummaryDate( "tomorrow" ) );

	// ARRIVING
	length = HMS.Data.summary_arriving[0].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#arriving table#yesterday").append( HMS.Component.Get( "summary_row_arriving" ) );
			$(".sum-segment#arriving table#yesterday .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_arriving[0][i]["room"] ] );
			$(".sum-segment#arriving table#yesterday .col-name:last").text( HMS.Data.summary_arriving[0][i]["name"] );
			$(".sum-segment#arriving table#yesterday .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_arriving[0][i]["source"] ] );
			$(".sum-segment#arriving table#yesterday .col-person:last").text( HMS.Data.summary_arriving[0][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#arriving table#yesterday").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	length = HMS.Data.summary_arriving[1].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#arriving table#today").append( HMS.Component.Get( "summary_row_arriving" ) );
			$(".sum-segment#arriving table#today .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_arriving[1][i]["room"] ] );
			$(".sum-segment#arriving table#today .col-name:last").text( HMS.Data.summary_arriving[1][i]["name"] );
			$(".sum-segment#arriving table#today .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_arriving[1][i]["source"] ] );
			$(".sum-segment#arriving table#today .col-person:last").text( HMS.Data.summary_arriving[1][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#arriving table#today").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	length = HMS.Data.summary_arriving[2].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#arriving table#tomorrow").append( HMS.Component.Get( "summary_row_arriving" ) );
		    $(".sum-segment#arriving table#tomorrow .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_arriving[2][i]["room"] ] );
			$(".sum-segment#arriving table#tomorrow .col-name:last").text( HMS.Data.summary_arriving[2][i]["name"] );
			$(".sum-segment#arriving table#tomorrow .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_arriving[2][i]["source"] ] );
			$(".sum-segment#arriving table#tomorrow .col-person:last").text( HMS.Data.summary_arriving[2][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#arriving table#tomorrow").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	//LEAVING
	length = HMS.Data.summary_leaving[0].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#leaving table#yesterday").append( HMS.Component.Get( "summary_row_leaving" ) );
			$(".sum-segment#leaving table#yesterday .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_leaving[0][i]["room"] ] );
			$(".sum-segment#leaving table#yesterday .col-name:last").text( HMS.Data.summary_leaving[0][i]["name"] );
			$(".sum-segment#leaving table#yesterday .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_leaving[0][i]["source"] ] );
			$(".sum-segment#leaving table#yesterday .col-person:last").text( HMS.Data.summary_leaving[0][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#leaving table#yesterday").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	length = HMS.Data.summary_leaving[1].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#leaving table#today").append( HMS.Component.Get( "summary_row_leaving" ) );
			$(".sum-segment#leaving table#today .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_leaving[1][i]["room"] ] );
			$(".sum-segment#leaving table#today .col-name:last").text( HMS.Data.summary_leaving[1][i]["name"] );
			$(".sum-segment#leaving table#today .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_leaving[1][i]["source"] ] );
			$(".sum-segment#leaving table#today .col-person:last").text( HMS.Data.summary_leaving[1][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#leaving table#today").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	length = HMS.Data.summary_leaving[2].length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#leaving table#tomorrow").append( HMS.Component.Get( "summary_row_leaving" ) );
			$(".sum-segment#leaving table#tomorrow .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_leaving[2][i]["room"] ] );
			$(".sum-segment#leaving table#tomorrow .col-name:last").text( HMS.Data.summary_leaving[2][i]["name"] );
			$(".sum-segment#leaving table#tomorrow .col-source:last").text( HMS.Data.list_source[ HMS.Data.summary_leaving[2][i]["source"] ] );
			$(".sum-segment#leaving table#tomorrow .col-person:last").text( HMS.Data.summary_leaving[2][i]["person"] );
		}
	}
	else
	{
		$(".sum-segment#leaving table#tomorrow").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	// FEES
	length = HMS.Data.summary_fees.length;
	if( length > 0 )
	{
		for( i=0; i<length; ++i )
		{
			$(".sum-segment#fees table#fees").append( HMS.Component.Get( "summary_row_fee" ) );
			$(".sum-segment#fees table#fees .col-room:last").text( HMS.Data.list_room[ HMS.Data.summary_fees[i]["room"] ] );
			$(".sum-segment#fees table#fees .col-name:last").text( HMS.Data.summary_fees[i]["name"] );
			$(".sum-segment#fees table#fees .col-type:last").text( HMS.Data.list_fee[ HMS.Data.summary_fees[i]["type"] ] );
			$(".sum-segment#fees table#fees .col-amount:last").text( HMS.Data.summary_fees[i]["amount"] );
		}
	}
	else
	{
		$(".sum-segment#fees table#fees").append( HMS.Component.Get( "summary_row_alldone" ) );
	}

	//NOTES
	length = HMS.Data.summary_notes.length;
	for( i=0; i<length; ++i )
	{
		$(".sum-segment#notes").append( HMS.Component.Get( "summary_row_note" ) );
		$(".sum-segment#notes table#notes .col-note:last").text( HMS.Data.summary_notes[i]["note"] );
		$(".sum-segment#notes table#notes .col-action:last").attr( "index", i );
	}

	$(".sum-segment#notes").append( HMS.Component.Get( "summary_row_noteadd" ) );

	$(".sum-segment#notes #note-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Note_Edit( $(this).parent().attr("index") );
	}});
	$(".sum-segment#notes #note-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Note_Delete( $(this).parent().attr("index") );
	}});

	$(".sum-segment#notes #note-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Note_Add( );
	}});
};

































HMS.Designer.SetPage_Reservations = function()
{
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_reservations" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
	HMS.Data.table_date = new Date( HMS.Data.table_timestamp*1000 );
	HMS.Data.days_date = HMS.Data.table_date.makeWeekDate();
	HMS.Data.table_rooms_byid = HMS.Data.table_rooms.arrangeById();
	HMS.Data.table_reservations_byid = HMS.Data.table_reservations.arrangeById();
	HMS.Data.table_people_byid = HMS.Data.table_people.arrangeById();

    $("#content").append( HMS.Component.Get( "reserv_table_head" ) );
    $(".res-head #h1").html( HMS.Data.days_date[0].reservTableStr() );
	$(".res-head #h2").html( HMS.Data.days_date[1].reservTableStr() );
	$(".res-head #h3").html( HMS.Data.days_date[2].reservTableStr() );
	$(".res-head #h4").html( HMS.Data.days_date[3].reservTableStr() );
	$(".res-head #h5").html( HMS.Data.days_date[4].reservTableStr() );
	$(".res-head #h6").html( HMS.Data.days_date[5].reservTableStr() );
	$(".res-head #h7").html( HMS.Data.days_date[6].reservTableStr() );

	var i;
	var count = HMS.Data.order_room.length;
	for( i=0; i<count; i++ )
	{
		$("#content").append( HMS.Component.Get( "reserv_table_row" ) );
		$(".res-data:last .xh, .res-data:last .x0, .res-data:last .x1, .res-data:last .x2, .res-data:last .x3, .res-data:last .x4, .res-data:last .x5, .res-data:last .x6").addClass( "y"+i );
		$(".xh.y"+i).html( HMS.Tool.TableRoomLabel( i )).parent().attr("y",i);

		/*
		$(".y"+i).addClass("r"+HMS.Data.order_room[i]).mouseleave( function(){ $(".y"+$(this).parent().attr("y")+":not(.xh)").css( "background-color", "#FFF" );
		}).mouseenter( function(){ $(".y"+$(this).parent().attr("y")+":not(.xh)").css( "background-color", "#ebeef2" ); });
		*/
		$(".y"+i).addClass("r"+HMS.Data.order_room[i])

	}

	/*
	$(".x0").addClass("d"+HMS.Data.days_date[0].makeDbStr()).mouseleave( function(){ $(".x0").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x0").css( "background-color", "#ebeef2" ); });
	$(".x1").addClass("d"+HMS.Data.days_date[1].makeDbStr()).mouseleave( function(){ $(".x1").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x1").css( "background-color", "#ebeef2" ); });
	$(".x2").addClass("d"+HMS.Data.days_date[2].makeDbStr()).mouseleave( function(){ $(".x2").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x2").css( "background-color", "#ebeef2" ); });
	$(".x3").addClass("d"+HMS.Data.days_date[3].makeDbStr()).mouseleave( function(){ $(".x3").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x3").css( "background-color", "#ebeef2" ); });
	$(".x4").addClass("d"+HMS.Data.days_date[4].makeDbStr()).mouseleave( function(){ $(".x4").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x4").css( "background-color", "#ebeef2" ); });
	$(".x5").addClass("d"+HMS.Data.days_date[5].makeDbStr()).mouseleave( function(){ $(".x5").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x5").css( "background-color", "#ebeef2" ); });
	$(".x6").addClass("d"+HMS.Data.days_date[6].makeDbStr()).mouseleave( function(){ $(".x6").css( "background-color", "#FFF" );
	}).mouseenter( function(){ $(".x6").css( "background-color", "#ebeef2" ); });
	*/
	$(".x0").addClass("d"+HMS.Data.days_date[0].makeDbStr());
	$(".x1").addClass("d"+HMS.Data.days_date[1].makeDbStr());
	$(".x2").addClass("d"+HMS.Data.days_date[2].makeDbStr());
	$(".x3").addClass("d"+HMS.Data.days_date[3].makeDbStr());
	$(".x4").addClass("d"+HMS.Data.days_date[4].makeDbStr());
	$(".x5").addClass("d"+HMS.Data.days_date[5].makeDbStr());
	$(".x6").addClass("d"+HMS.Data.days_date[6].makeDbStr());

	var j;
	var rc = '<div class="bnew"></div>'; // reservation container
	var pc = '<div class="pnew"></div>'; // person container
	var cnt = '<span class="cnt"></span>'; // person count container
	var pid;
	var bid;
	var count_s;
	var count_p;
	var room;
	var dat;
	var allfeepaid;
	var status;
	var paxmid;
	count = HMS.Data.table_reservations.length;
	for( i=0; i<count; ++i )
	{
		bid = HMS.Data.table_reservations[ i ][ "id" ];
		allfeepaid = HMS.Data.table_reservations_byid[ bid ][ "allfeepaid" ];
		status = HMS.Data.table_reservations_byid[ bid ][ "status" ];

		count_s = HMS.Data.table_reservations_byid[ bid ][ "stay" ].length;
		for( j=0; j<count_s; ++j )
		{
			dat = HMS.Data.table_reservations_byid[ bid ][ "stay" ][j][0];
			room = HMS.Data.table_reservations_byid[ bid ][ "stay" ][j][1];
			$(".r" + room + ".d" + dat).append(rc);
		}
		$(".bnew").addClass( "b"+bid );
		if( allfeepaid == "1" ) $(".bnew").addClass( "afp" );
		$(".bnew").addClass( "arv"+status );
		$(".bnew").addClass( "reservc" );
		$(".bnew").attr( "bid", bid );

		count_p = HMS.Data.table_reservations_byid[ bid ][ "people" ].length;
		paxmid = HMS.Data.table_reservations_byid[ bid ][ "people" ][0];
		$(".bnew").append( pc );
		$(".pnew").text( HMS.Data.table_people_byid[ paxmid ][ "name" ] );
		$(".pnew").append( cnt );
		$(".pnew .cnt").append( " (" + count_p + ")" );
		$(".pnew").addClass( "paxm" ).removeClass( "pnew" );

		for( j=1; j<count_p; ++j )
		{
			pid = HMS.Data.table_reservations_byid[ bid ][ "people" ][j];
			$(".bnew").append( pc );
			$(".pnew").text( HMS.Data.table_people_byid[ pid ][ "name" ] );
			$(".pnew").addClass( "pax" ).removeClass( "pnew" );
		}

		$(".bnew").removeClass( "bnew" );
		$( ".b"+bid).mouseleave( function(){ $( ".b"+ $(this).attr("bid") ).css( "text-shadow", "none" );
		}).mouseenter( function(){ $( ".b"+ $(this).attr("bid") ).css( "text-shadow", "1px 1px 7px #011" ); });
	}

	if( HMS.Data.option[0] == 0 )
		$(".cnt").css( "display", "none" );
	if( HMS.Data.option[1] == 0 )
		$(".pax").css( "display", "none" );
	if( HMS.Data.option[2] == 0 )
		$(".arv3").css( "display", "none" );

	$("#res-nav-day").append( HMS.Component.Get( "option_day" )).val( HMS.Data.table_date.getDate().toString().addZero(2) );
	$("#res-nav-mon").append( HMS.Component.Get( "option_smonth" ) ).val( (HMS.Data.table_date.getMonth()+1).toString().addZero(2) );
	$("#res-nav-yea").append( HMS.Component.Get( "option_year" ) ).val( HMS.Data.table_date.getFullYear().toString() );

	$("#res-nav-day, #res-nav-mon, #res-nav-yea").change( function(){
		HMS.System.Table_Navigate();
		$("#content").html( HMS.Component.Get( "loading" ) );
	});

	$("#res-btn-left").mousedown( function(e){ if( e.which == 1 ){
		HMS.System.Table_Prev();
		$("#content").html( HMS.Component.Get( "loading" ) );
	}});

	$("#res-btn-right").mousedown( function(e){ if( e.which == 1 ){
		HMS.System.Table_Next();
		$("#content").html( HMS.Component.Get( "loading" ) );
	}});

	$("#res-legend").popover({
		html: true,
		placement: "right",
		trigger: "hover",
		title: "<b style='color: #000'>Legend</b>",
		content: HMS.Component.Get("reserv_table_legend"),
		delay: { show: 50, hide: 200 }
	});

	$("#res-btn-options").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Options_Edit();
	}});

	$("#res-btn-addnew").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_Add();
	}});

	$(".reservc").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Reservation_Edit( $(this).attr("bid") );
	}});
};














































HMS.Designer.SetPage_People = function()
{
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_people" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
};

HMS.Designer.SetPage_Finance = function()
{
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_finance" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
};

HMS.Designer.SetPage_Statistics = function()
{
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_statistics" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
};

// SETTINGS

HMS.Designer.SetPage_Settings = function()
{
	HMS.Designer.PreparePage();
	var html = HMS.Component.Get( "page_settings" );
	$("#content").html( html );
	HMS.Designer.AddCodeport();

	// add more func
	HMS.Maker.SettingsLink( "users" );
	HMS.Maker.SettingsLink( "rooms" );
	HMS.Maker.SettingsLink( "sources" );
	HMS.Maker.SettingsLink( "fees" );
	HMS.Maker.SettingsLink( "payments" );
};

HMS.Designer.SetSettingButton = function( setting )
{
	$("#settings-segment #btnbar .btni").addClass("btno").removeClass("btni");
	$("#settings-segment #btnbar #"+setting).addClass("btni").removeClass("btno");
	$("#settings-segment #gutter").css( "background-color", $("#settings-segment #btnbar #"+setting).css("background-color") );

	$("#settings-segment #css").remove();
	$("#settings-segment").prepend( '<style id="css" type="text/css">#settings-segment table td, #settings-segment table th{border-color:'
		+ $("#settings-segment #btnbar #"+setting).css("background-color")
		+ ';}</style>'
	);
};

HMS.Designer.Settings_Loading = function()
{
	$("#settings-segment #body").html( "<br/>" + HMS.Component.Get( "loading" ) );
};

HMS.Designer.Settings_Users = function()
{
	HMS.Designer.SetSettingButton( "users" );
	var i = 0;
	HMS.Data.settings_users_byid = HMS.Data.settings_users.arrangeById();
	var length = HMS.Data.settings_users.length;
	$("#settings-segment #body").html( HMS.Component.Get( "settings_row_users_head" ) );
	for( i=0; i<length; ++i )
	{
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_users" ) );
		$("#settings-segment .col-id:last").text( HMS.Data.settings_users[i]["id"] );
		$("#settings-segment .col-username:last").text( HMS.Data.settings_users[i]["username"] );
		$("#settings-segment .col-type:last").text( HMS.Data.settings_users[i]["type"] );
		$("#settings-segment .col-action:last").attr( "index", i );
		$("#settings-segment .col-action:last").attr( "dbid", HMS.Data.settings_users[i]["id"] );
	}
	$("#settings-segment #body").append( HMS.Component.Get( "settings_row_users_add" ) );



	$("#settings-segment #user-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.User_Edit( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #user-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.User_Delete( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #user-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.User_Add();
	}});

};

HMS.Designer.Settings_Rooms = function()
{
	HMS.Designer.SetSettingButton( "rooms" );
	var i = 0;
	var id;
	var length = HMS.Data.order_room.length;
	HMS.Data.settings_rooms_byid = HMS.Data.settings_rooms.arrangeById();
	$("#settings-segment #body").html( HMS.Component.Get( "settings_row_rooms_head" ) );
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_room[i];
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_rooms" ) );
		$("#settings-segment .col-id:last").text( id );
		$("#settings-segment .col-name:last").text( HMS.Data.settings_rooms_byid[id]["name"] );
		$("#settings-segment .col-type:last").text( HMS.Data.settings_rooms_byid[id]["type"] );
		$("#settings-segment .col-bedcount:last").text( HMS.Data.settings_rooms_byid[id]["bed"] );
		$("#settings-segment .col-action:last").attr( "index", i );
		$("#settings-segment .col-action:last").attr( "dbid", id );
	}
	$("#settings-segment #body").append( HMS.Component.Get( "settings_row_rooms_add" ) );

	$("#settings-segment #body").append( "<br/><br/>" + HMS.Component.Get( "settings_row_rooms_show" ) );

	length = HMS.Data.settings_rooms.length;
	var none = true;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.settings_rooms[i]["id"];
		if( $.inArray( id, HMS.Data.order_room ) === -1 )
		{
			$("#settings-segment #body").append( HMS.Component.Get( "settings_row_rooms_deleted" ) );
			$("#settings-segment .col-id:last").text( id );
			$("#settings-segment .col-name:last").text( HMS.Data.settings_rooms_byid[id]["name"] );
			$("#settings-segment .col-type:last").text( HMS.Data.settings_rooms_byid[id]["type"] );
			$("#settings-segment .col-bedcount:last").text( HMS.Data.settings_rooms_byid[id]["bed"] );
			$("#settings-segment .col-action:last").attr( "index", i );
			$("#settings-segment .col-action:last").attr( "dbid", id );
			none = false;
		}
	}
	if( none )
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_rooms_none" ) );

	// FUNC

	HMS.Data.show_deleted = false;
	$("#settings-segment #room-show").mousedown( function(e){ if( e.which == 1 ){
		HMS.Data.show_deleted = !HMS.Data.show_deleted;
		if( HMS.Data.show_deleted )
		{
			$("#settings-segment #room-show").html( '<span class="glyphicon glyphicon-eye-close"></span> Hide Deleted Rooms' );
			$("#settings-segment .deleted").css( "display", "table" );
		}
		else
		{
			$("#settings-segment #room-show").html( '<span class="glyphicon glyphicon-eye-open"></span> Show Deleted Rooms' );
			$("#settings-segment .deleted").css( "display", "none" );
		}
	}});


	$("#settings-segment #room-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Room_Edit( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #room-up").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Room_Up( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #room-down").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Room_Down( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #room-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Room_Delete( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #room-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Room_Add();
	}});
	$("#settings-segment #room-undelete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Room_Undelete( $(this).parent().attr("dbid") );
	}});
};

HMS.Designer.Settings_Sources = function()
{
	HMS.Designer.SetSettingButton( "sources" );
	var i = 0;
	var id;
	var length = HMS.Data.order_source.length;
	HMS.Data.settings_sources_byid = HMS.Data.settings_sources.arrangeById();
	$("#settings-segment #body").html( HMS.Component.Get( "settings_row_sources_head" ) );
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_source[i];
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_sources" ) );
		$("#settings-segment .col-id:last").text( id );
		$("#settings-segment .col-name:last").text( HMS.Data.settings_sources_byid[id]["name"] );
		$("#settings-segment .col-action:last").attr( "index", i );
		$("#settings-segment .col-action:last").attr( "dbid", id );
	}
	$("#settings-segment #body").append( HMS.Component.Get( "settings_row_sources_add" ) );

	$("#settings-segment #body").append( "<br/><br/>" + HMS.Component.Get( "settings_row_sources_show" ) );

	length = HMS.Data.settings_sources.length;
	var none = true;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.settings_sources[i]["id"];
		if( $.inArray( id, HMS.Data.order_source ) === -1 )
		{
			$("#settings-segment #body").append( HMS.Component.Get( "settings_row_sources_deleted" ) );
			$("#settings-segment .col-id:last").text( id );
			$("#settings-segment .col-name:last").text( HMS.Data.settings_sources_byid[id]["name"] );
			$("#settings-segment .col-action:last").attr( "index", i );
			$("#settings-segment .col-action:last").attr( "dbid", id );
			none = false;
		}
	}
	if( none )
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_sources_none" ) );

	// FUNC

	HMS.Data.show_deleted = false;
	$("#settings-segment #source-show").mousedown( function(e){ if( e.which == 1 ){
		HMS.Data.show_deleted = !HMS.Data.show_deleted;
		if( HMS.Data.show_deleted )
		{
			$("#settings-segment #source-show").html( '<span class="glyphicon glyphicon-eye-close"></span> Hide Deleted Sources' );
			$("#settings-segment .deleted").css( "display", "table" );
		}
		else
		{
			$("#settings-segment #source-show").html( '<span class="glyphicon glyphicon-eye-open"></span> Show Deleted Sources' );
			$("#settings-segment .deleted").css( "display", "none" );
		}
	}});


	$("#settings-segment #source-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Source_Edit( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #source-up").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Source_Up( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #source-down").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Source_Down( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #source-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Source_Delete( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #source-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Source_Add();
	}});
	$("#settings-segment #source-undelete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Source_Undelete( $(this).parent().attr("dbid") );
	}});
};

HMS.Designer.Settings_Fees = function()
{
	HMS.Designer.SetSettingButton( "fees" );
	var i = 0;
	var id;
	var length = HMS.Data.order_fee.length;
	HMS.Data.settings_fees_byid = HMS.Data.settings_fees.arrangeById();
	$("#settings-segment #body").html( HMS.Component.Get( "settings_row_fees_head" ) );
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_fee[i];
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_fees" ) );
		$("#settings-segment .col-id:last").text( id );
		$("#settings-segment .col-name:last").text( HMS.Data.settings_fees_byid[id]["name"] );
		$("#settings-segment .col-action:last").attr( "index", i );
		$("#settings-segment .col-action:last").attr( "dbid", id );
	}
	$("#settings-segment #body").append( HMS.Component.Get( "settings_row_fees_add" ) );

	$("#settings-segment #body").append( "<br/><br/>" + HMS.Component.Get( "settings_row_fees_show" ) );

	length = HMS.Data.settings_fees.length;
	var none = true;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.settings_fees[i]["id"];
		if( $.inArray( id, HMS.Data.order_fee ) === -1 )
		{
			$("#settings-segment #body").append( HMS.Component.Get( "settings_row_fees_deleted" ) );
			$("#settings-segment .col-id:last").text( id );
			$("#settings-segment .col-name:last").text( HMS.Data.settings_fees_byid[id]["name"] );
			$("#settings-segment .col-action:last").attr( "index", i );
			$("#settings-segment .col-action:last").attr( "dbid", id );
			none = false;
		}
	}
	if( none )
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_fees_none" ) );

	// FUNC

	HMS.Data.show_deleted = false;
	$("#settings-segment #fee-show").mousedown( function(e){ if( e.which == 1 ){
		HMS.Data.show_deleted = !HMS.Data.show_deleted;
		if( HMS.Data.show_deleted )
		{
			$("#settings-segment #fee-show").html( '<span class="glyphicon glyphicon-eye-close"></span> Hide Deleted Fees' );
			$("#settings-segment .deleted").css( "display", "table" );
		}
		else
		{
			$("#settings-segment #fee-show").html( '<span class="glyphicon glyphicon-eye-open"></span> Show Deleted Fees' );
			$("#settings-segment .deleted").css( "display", "none" );
		}
	}});


	$("#settings-segment #fee-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Fee_Edit( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #fee-up").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Fee_Up( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #fee-down").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Fee_Down( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #fee-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Fee_Delete( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #fee-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Fee_Add();
	}});
	$("#settings-segment #fee-undelete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Fee_Undelete( $(this).parent().attr("dbid") );
	}});
};

HMS.Designer.Settings_Payments = function()
{
	HMS.Designer.SetSettingButton( "payments" );
	var i = 0;
	var id;
	var length = HMS.Data.order_payment.length;
	HMS.Data.settings_payments_byid = HMS.Data.settings_payments.arrangeById();
	$("#settings-segment #body").html( HMS.Component.Get( "settings_row_payments_head" ) );
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_payment[i];
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_payments" ) );
		$("#settings-segment .col-id:last").text( id );
		$("#settings-segment .col-name:last").text( HMS.Data.settings_payments_byid[id]["name"] );
		$("#settings-segment .col-action:last").attr( "index", i );
		$("#settings-segment .col-action:last").attr( "dbid", id );
	}
	$("#settings-segment #body").append( HMS.Component.Get( "settings_row_payments_add" ) );

	$("#settings-segment #body").append( "<br/><br/>" + HMS.Component.Get( "settings_row_payments_show" ) );

	length = HMS.Data.settings_payments.length;
	var none = true;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.settings_payments[i]["id"];
		if( $.inArray( id, HMS.Data.order_payment ) === -1 )
		{
			$("#settings-segment #body").append( HMS.Component.Get( "settings_row_payments_deleted" ) );
			$("#settings-segment .col-id:last").text( id );
			$("#settings-segment .col-name:last").text( HMS.Data.settings_payments_byid[id]["name"] );
			$("#settings-segment .col-action:last").attr( "index", i );
			$("#settings-segment .col-action:last").attr( "dbid", id );
			none = false;
		}
	}
	if( none )
		$("#settings-segment #body").append( HMS.Component.Get( "settings_row_payments_none" ) );

	// FUNC

	HMS.Data.show_deleted = false;
	$("#settings-segment #payment-show").mousedown( function(e){ if( e.which == 1 ){
		HMS.Data.show_deleted = !HMS.Data.show_deleted;
		if( HMS.Data.show_deleted )
		{
			$("#settings-segment #payment-show").html( '<span class="glyphicon glyphicon-eye-close"></span> Hide Deleted Payments' );
			$("#settings-segment .deleted").css( "display", "table" );
		}
		else
		{
			$("#settings-segment #payment-show").html( '<span class="glyphicon glyphicon-eye-open"></span> Show Deleted Payments' );
			$("#settings-segment .deleted").css( "display", "none" );
		}
	}});


	$("#settings-segment #payment-edit").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Payment_Edit( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #payment-up").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Payment_Up( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #payment-down").mousedown( function(e){ if( e.which == 1 ){
		HMS.Designer.Settings_Loading();
		HMS.Action.Payment_Down( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #payment-delete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Payment_Delete( $(this).parent().attr("dbid") );
	}});
	$("#settings-segment #payment-add").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Payment_Add();
	}});
	$("#settings-segment #payment-undelete").mousedown( function(e){ if( e.which == 1 ){
		HMS.Control.Payment_Undelete( $(this).parent().attr("dbid") );
	}});
};