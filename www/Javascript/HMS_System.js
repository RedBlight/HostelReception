HMS.System.Reload = function()
{
    location.reload(true);
};

HMS.System.Goto = function( url )
{
    window.location.href = url;
};

HMS.System.GotoPage = function( page )
{
    var mainurl = "http://localhost/";
    var pageurl = mainurl + page;
    HMS.System.Goto( pageurl );
};

HMS.System.SetCookie = function( key, val, exp )
{
    $.cookie( key, val, { expires: exp, path: '/' } );
};

HMS.System.GetCookie = function( key )
{
    return $.cookie( key );
};

HMS.System.DeleteCookie = function( key )
{
    $.removeCookie( key, { path: '/' } );
};

HMS.System.Table_Navigate = function()
{
	HMS.System.GotoPage( "reservations?date=" + $("#res-nav-yea").val() + $("#res-nav-mon").val() + $("#res-nav-day").val() ) ;
};

HMS.System.Table_Prev = function()
{
	var prevdate = new Date((HMS.Data.table_timestamp - (7*60*60*24))*1000);
	HMS.System.GotoPage( "reservations?date=" + prevdate.makeDbStr()  ) ;
};

HMS.System.Table_Next = function()
{
	var prevdate = new Date((HMS.Data.table_timestamp + (7*60*60*24))*1000);
	HMS.System.GotoPage( "reservations?date=" + prevdate.makeDbStr()  ) ;
};
