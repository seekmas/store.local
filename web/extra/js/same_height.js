$(function(){
    $("div.same_height").each(function(){
        maxHeight = 0;
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });

    $("div.same_height").height(maxHeight);
});