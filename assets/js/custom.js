


/*=============================================================
    Authour URI: www.binarytheme.com
    License: Commons Attribution 3.0

    http://creativecommons.org/licenses/by/3.0/

    100% To use For Personal And Commercial Use.
    IN EXCHANGE JUST GIVE US CREDITS AND TELL YOUR FRIENDS ABOUT US
   
    ========================================================  */


(function ($) {
    "use strict";
    var mainApp = {

        main_fun: function () {
           
            /*====================================
              LOAD APPROPRIATE MENU BAR
           ======================================*/
            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });

          
     
        },

        initialization: function () {
            mainApp.main_fun();

        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.main_fun();
    });

}(jQuery));

$(document).ready(function() {
    $('body').on('contextmenu', 'a.client', function() {
        var clid = $(this).data("clid");
        //var clid = document.getElementById("client").dataset.clid;

        document.getElementById("client-menu").className = "show-client-menu";
        document.getElementById("client-menu").style.top =  mouseY(event) + 'px';
        document.getElementById("client-menu").style.left = mouseX(event) + 'px';

        document.getElementById("client-nickname").href = "?client=nickname&clid="+clid;
        document.getElementById("client-group").href = "?client=group&clid="+clid;
        document.getElementById("client-kick-channel").href = "?client=kick-channel&clid="+clid;
        document.getElementById("client-kick-server").href = "?client=kick-server&clid="+clid;
        document.getElementById("client-ban").href = "?client=ban&clid="+clid;
        document.getElementById("client-move").href = "?client=move&clid="+clid;

        window.event.returnValue = false;
    });
});

$(document).bind("click", function(event) {
    document.getElementById("client-menu").className = "hide-client-menu";
});

function mouseX(evt) {
    if (evt.pageX) {
        return evt.pageX;
    } else if (evt.clientX) {
       return evt.clientX + (document.documentElement.scrollLeft ?
           document.documentElement.scrollLeft :
           document.body.scrollLeft);
    } else {
        return null;
    }
}

function mouseY(evt) {
    if (evt.pageY) {
        return evt.pageY;
    } else if (evt.clientY) {
       return evt.clientY + (document.documentElement.scrollTop ?
       document.documentElement.scrollTop :
       document.body.scrollTop);
    } else {
        return null;
    }
}