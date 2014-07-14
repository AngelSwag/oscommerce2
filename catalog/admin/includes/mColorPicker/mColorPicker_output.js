$(document).ready(function () {
    $('form#colorPicker').bind('submit', function () {
        alert($(this).serialize());
        return false;
    });
    //$('#color1').bind('change', function () {
        //$('p').css('background-color', $(this).val());
    //});
    $('#option_themecolor').bind('colorpicked', function () {
        //alert($(this).val());
    });

    $('#option_textcolor').bind('colorpicked');
    $('#option_linkcolor').bind('colorpicked');
    $('#option_linkhovercolor').bind('colorpicked');
    $('#option_bgcolor').bind('colorpicked');

    $('#option_captions_text_color').bind('colorpicked');

});
