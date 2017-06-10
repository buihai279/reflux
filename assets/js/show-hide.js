//jQuery to show-hide the detail on contact
$("#show").click(function (e){
    e.stopPropagation();
    $("#contact-focus-2").show();
});
$("#close").click(function (){
    $("#contact-focus-2").hide();
});
$('#contact-focus-2').click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
    $('#contact-focus-2').hide();
});

$("#show-2").click(function (e){
    e.stopPropagation();
    $("#contact-detail-2").show();
});
$("#close-2").click(function (){
    $("#contact-detail-2").hide();
});
$('#contact-detail-2').click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
    $('#contact-detail-2').hide();
});

$("#show-kansai-1").click(function (e){
    e.stopPropagation();
    $("#contact-kansai-1").show();
});
$("#close-kansai-1").click(function (){
    $("#contact-kansai-1").hide();
});
$('#contact-kansai-1').click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
    $('#contact-kansai-1').hide();
});