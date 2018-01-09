// Hotel Management System
HMS = {};

// Abstract functions for base js operations
HMS.Tool = {};

// Controls browser system, such as refresh, goto, cookie, etc...
HMS.System = {};

// Holds all kind of data
HMS.Data = {};

// Handles storing and retrieving HMTL local components
HMS.Component = {};

// Uses components to make useful components filled with data
HMS.Maker = {};

// Interferes with page HTML, assings events for objects
HMS.Designer = {};

// Uses ajax to do actions and retrieves data
HMS.Action = {};

// Abstract functions for controlling whole system
HMS.Control = {};

// PRELOAD
$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = this;
    });
};

var p = "/Image/";
$([
    p+'ajaxloading.gif',
    p+'logo.png'
]).preload();


