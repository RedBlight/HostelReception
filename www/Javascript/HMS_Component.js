HMS.Component.Get = function( key )
{
    return $.jStorage.get( key, false );
};

HMS.Component.Set = function( key, val )
{
    $.jStorage.set( key, val );
};

HMS.Component.Flush = function()
{
    $.jStorage.flush();
};

HMS.Component.Delete = function( key )
{
    $.jStorage.deleteKey( key );
};

HMS.Component.LoadAllComponents = function()
{
    var success = false;
    var hash = 0;
    $.ajaxSetup( { async: false } );
    $.getJSON( "/load", { is_ajax: true, action: "get_components" }, function( data ) {
        $.each( data, function( key, val ) {
            HMS.Component.Set( key, val );
        });
        var keys = $.jStorage.index();
        for( var i=0; i<keys.length; ++i ) hash += ( keys[i] + HMS.Component.Get( keys[i] ) ).hash();
        HMS.Component.Set( "hash", hash );
        success = true;
    });
    $.ajaxSetup( { async: true } );
    return success;
};

HMS.Component.IntegrityCheck = function()
{
    var hash_valid = HMS.Component.Get( "hash" );
    var loaded = HMS.Component.Get( "loaded" );
    if( hash_valid === false || loaded === false ) HMS.System.GotoPage( "load" );
    HMS.Component.Delete( "hash" );
    HMS.Component.Delete( "loaded" );
    var hash_recent = 0;
    var keys = $.jStorage.index();
    for( var i=0; i<keys.length; ++i ) hash_recent += ( keys[i] + HMS.Component.Get( keys[i] ) ).hash();
    if( hash_recent != hash_valid ) HMS.System.GotoPage( "load" );
    else
    {
        HMS.Component.Set( "hash", hash_recent );
        HMS.Component.Set( "loaded", loaded );
    }
};