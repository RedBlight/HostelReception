// JQUERY
jQuery.fn.extend({
    lmousedown: function( func ){
        $($(this).selector).mousedown( function( e ){
            if( e.which == 1 ) func();
        });
    }
});

// DATE
Date.prototype.monthNames = [
    "January", "February", "March",
    "April", "May", "June",
    "July", "August", "September",
    "October", "November", "December"
];

Date.prototype.dayNames = [
    "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
];

Date.prototype.getMonthName = function()
{
    return this.monthNames[ this.getMonth() ];
};

Date.prototype.getShortMonthName = function ()
{
    return this.getMonthName().substr( 0, 3 );
};

Date.prototype.getDayName = function()
{
    return this.dayNames[ this.getDay() ];
};

Date.prototype.getShortDayName = function()
{
    return this.getDayName().substr( 0 ,3 );
};

Date.prototype.getNavbarDate = function()
{
    return this.getDate().toString().addZero( 2 )
        + " " + this.getMonthName()
        + " " + this.getFullYear()
        + " " + this.getDayName()
        + ", "+ this.getHours().toString().addZero( 2 )
        + ":" + this.getMinutes().toString().addZero( 2 )
        + ":" + this.getSeconds().toString().addZero( 2 );
};

Date.prototype.getSummaryDate = function( day )
{
    var date;
    var str = "";
    switch( day )
    {
        case "yesterday":
            date = new Date( this.getTime() - (1000 * 60 * 60 * 24) );
            str = "Yesterday";
            break;

        case "today":
            date = this;
            str = "Today";
            break;

        case "tomorrow":
            date = new Date( this.getTime() + (1000 * 60 * 60 * 24) );
            str = "Tomorrow";
            break;
    }
    return str + ": ("
        + date.getDate().toString().addZero( 2 )
        + " " + date.getShortMonthName()
        + " " + date.getFullYear()
        + ", "+ date.getShortDayName()
        + ")";
};

Date.prototype.makeWeekDate = function()
{
	var offset = (this.getDay() + 6) % 7;
	var day = [];
	day[0] = new Date( this.getTime() - ( offset - 0 )*( 1000 * 60 * 60 * 24 )  );
	day[1] = new Date( this.getTime() - ( offset - 1 )*( 1000 * 60 * 60 * 24 )  );
	day[2] = new Date( this.getTime() - ( offset - 2 )*( 1000 * 60 * 60 * 24 )  );
	day[3] = new Date( this.getTime() - ( offset - 3 )*( 1000 * 60 * 60 * 24 )  );
	day[4] = new Date( this.getTime() - ( offset - 4 )*( 1000 * 60 * 60 * 24 )  );
	day[5] = new Date( this.getTime() - ( offset - 5 )*( 1000 * 60 * 60 * 24 )  );
	day[6] = new Date( this.getTime() - ( offset - 6 )*( 1000 * 60 * 60 * 24 )  );
	return day;
};

Date.prototype.reservTableStr = function()
{
	return this.getDate().toString().addZero( 2 )
		+ " " + this.getMonthName()
		+ "<br/>" + this.getDayName();
};

Date.prototype.makeDbStr = function()
{
	return this.getFullYear().toString() + (this.getMonth()+1).toString().addZero(2) + this.getDate().toString().addZero(2);
};

// STRING
String.prototype.isAlphaNumeric = function()
{
    var regExp = /^[A-Za-z0-9]+$/;
    return ( this.match( regExp ) );
};

String.prototype.isValidNote = function()
{
    return ( this.length > 0 && this.length < 3000 );
};

String.prototype.isUsernameExists = function()
{
    var exists = false;
    var i = 0;
    var length = HMS.Data.settings_users.length;
    for( i=0; (i < length && exists == false); ++i )
    {
        exists = ( this == HMS.Data.settings_users[i]["username"] );
    }
    return ( exists );
};


String.prototype.isValidUsername = function()
{
    return ( this.length > 0 && this.length < 33 );
};

String.prototype.isValidPassword = function()
{
    return ( this.length > 0 && this.length < 33 );
};

String.prototype.isValidRoomname = function()
{
    return ( this.length > 0 && this.length < 49 );
};

String.prototype.isValidRoomtype = function()
{
    return ( this.length > 0 && this.length < 49 );
};

String.prototype.isValidSourcename = function()
{
    return ( this.length > 0 && this.length < 49 );
};

String.prototype.isValidFeename = function()
{
    return ( this.length > 0 && this.length < 49 );
};

String.prototype.isValidPaymentname = function()
{
    return ( this.length > 0 && this.length < 49 );
};



String.prototype.hash = function()
{
    return this.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);
};

String.prototype.addZero = function( amount )
{
    var add = amount - this.length;
    var str = "";
    for( var i=0; i<add; ++i ) str += "0";
    return (str + this).toString();

};

String.prototype.dbdateToDatestr = function()
{
	var year = this.substr( 0, 4 );
	var month = this.substr( 4, 2 );
	var day = this.substr( 6, 2 );

	return day + "/" + month + "/" + year;

};

// ARRAY
Array.prototype.arrangeById = function()
{
    var i = 0;
    var length = this.length;
    var arr = [];
    for( i=0; i<length; ++i )
    {
        arr[ this[i]["id"] ] = this[i];
    }
    return arr;
};

// FUNCS
HMS.Tool.CheckLoginInput = function( str )
{
    return ( str.length > 0 && str.length < 33 );
};

HMS.Tool.AddZero = function( str )
{
    if( str < 10 ) return "0" + str;
    return str;
};

HMS.Tool.TableRoomLabel = function( index )
{
	var id = HMS.Data.order_room[index];
	return HMS.Data.table_rooms_byid[ id ]["name"] + "<br/>" + HMS.Data.table_rooms_byid[ id ]["bed"] + " Bed - " + HMS.Data.table_rooms_byid[ id ]["type"];
};

HMS.Tool.MakeOptionSource = function()
{
	var opt = "";
	var length = HMS.Data.order_source.length;
	var i;
	var id;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_source[ i ];
		opt += '<option value="' + id + '">' + HMS.Data.list_source[ id ] + '</option>';
	}
	return opt;
};

HMS.Tool.MakeOptionFee = function()
{
	var opt = "";
	var length = HMS.Data.order_fee.length;
	var i;
	var id;
	for( i=0; i<length; ++i )
	{
		id = HMS.Data.order_fee[ i ];
		opt += '<option value="' + id + '">' + HMS.Data.list_fee[ id ] + '</option>';
	}
	return opt;
};

// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
if (!Object.keys) {
	Object.keys = (function () {
		'use strict';
		var hasOwnProperty = Object.prototype.hasOwnProperty,
			hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
			dontEnums = [
				'toString',
				'toLocaleString',
				'valueOf',
				'hasOwnProperty',
				'isPrototypeOf',
				'propertyIsEnumerable',
				'constructor'
			],
			dontEnumsLength = dontEnums.length;

		return function (obj) {
			if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
				throw new TypeError('Object.keys called on non-object');
			}

			var result = [], prop, i;

			for (prop in obj) {
				if (hasOwnProperty.call(obj, prop)) {
					result.push(prop);
				}
			}

			if (hasDontEnumBug) {
				for (i = 0; i < dontEnumsLength; i++) {
					if (hasOwnProperty.call(obj, dontEnums[i])) {
						result.push(dontEnums[i]);
					}
				}
			}
			return result;
		};
	}());
}