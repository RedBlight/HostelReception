HMS.Maker.NavbarLink = function( page )
{
    $("#navbar #"+page).mousedown( function(e){ if( e.which == 1 ){
        HMS.Designer.SetContent_Loading();
        HMS.Designer.SetNavbarButton( page );
        HMS.System.GotoPage( page );
    }});
};

HMS.Maker.SettingsLink = function( setting )
{
    $("#settings-segment #btnbar #" + setting).mousedown( function(e){ if( e.which == 1 ){
        HMS.Designer.Settings_Loading();
        HMS.Designer.SetSettingButton( setting );
        HMS.Action.GetSetting( setting );
    }});
};