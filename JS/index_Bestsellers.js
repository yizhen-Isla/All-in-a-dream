


$(".bestsellers_li").on("mouseover", function(){
    let index = $(this).index();

    $(".bestsellers_li").removeClass("selected");
    $(this).addClass("selected");

    $(".TabContent").removeClass("selected");
    $(".TabContent").eq(index-1).addClass("selected");
});