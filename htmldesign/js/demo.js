$(document).ready(function () {
    $("#msgid").html("This is Hello World by JQuery");
    $("#msgid").css("border", "3px solid red");
    $("#msgid").click(function () {
        alert("it is msgid");
    });
    $("#float-img-bg>img").css("border", "3px solid red");
    alert($('#float-img-bg').css('background-color'))

    $('span').addClass('line');

    $('span').click(function (e) {
        $('#notMe').removeClass().addClass(e.target.id);
        $('#notMe').removeClass('selected');
    });

    $('#waypointsTable tr').hover(function() {
        $(this).addClass('hover');
    }, function() {
        $(this).removeClass('hover');
    });

    function loop(e) {
        e.animate({
            top: "+=500"
        }, 2000);
        e.animate({
            top: "-=500"

        }, 2000, 'linear', function () {
            loop(e);
        });
    }

    function loop2(e) {
        e.animate({
            left: "+=500"
        }, 2000);
        e.animate({
            left: "-=500"
        }, 2000, 'linear', function () {
            loop2(e);
        });
    }

    function loop3(e) {
        e.animate({
            left: "+=500",
            top: "+=500"
        }, 2000);
        e.animate({
            left: "-=500",
            top: "-=500"
        }, 2000, 'linear', function () {
            loop3(e);
        });
    }

    loop($("#float-img-bg>img").eq(1));
    loop2($("#float-img-bg>img").eq(0));
    loop3($("#float-img-bg>img").eq(2));
});