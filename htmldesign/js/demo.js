$(document).ready(function () {
    $("#msgid").html("This is Hello World by JQuery");
    $("#msgid").css("border", "3px solid red");
    $("#msgid").click(function () {
        alert("it is msgid");
    });
    $('img').click(function () {
        alert("it is image");
    });
});