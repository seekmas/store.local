$(function(){

    if( $("div.product-prew").length > 0 )
    {
        var maxHeight = 0;
        $("div.product-prew").each(function(){
            if ($(this).height() > maxHeight) {
                maxHeight = $(this).height();
                console.log(maxHeight);
            }
        });
        $("div.product-prew").height(maxHeight);
    }
});