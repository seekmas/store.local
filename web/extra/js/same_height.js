$(function(){

    if( $("div.same_height").length > 0 )
    {
        var maxHeight = 0;
        $("div.same_height").each(function(){
            if ($(this).height() > maxHeight) {
                maxHeight = $(this).height();
                //console.log(maxHeight);
            }
        });

        $("div.same_height").height(maxHeight);
    }
});