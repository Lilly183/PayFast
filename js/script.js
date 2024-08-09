// Ensure DOM has been loaded:

$(function()
{
    /*
    Select all HTML elements of class = "forceNumeric." Assign event 
    listeners for keypress, keyup, and blur events. Trigger a function 
    when fired.
    */

    $(".forceNumeric").on("keypress keyup blur", function (event) 
    {
        /*
        Force the value of the element which triggers the event to be numeric using 
        a combination of jQuery's replace() function and regular expressions. Only 
        numeric digits and a single decimal point will be allowed.
        */

        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) 
        {
            event.preventDefault();
        }
    });
});
