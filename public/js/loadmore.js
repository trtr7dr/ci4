function more() {

    var ids = [];
    $(".one_news").each(function () {
        ids.push($(this).attr('data-id'));
    });

    var lid = Math.min.apply(null, ids);

    if (lid < 6) {
        $('#more').css('display', 'none');
    }
    

    var str = '';
    $.ajax({
        type: 'post',
        url: 'http://localhost/ci4/public/newsmore',
        data: {'lid': lid, csrf_token: $('#csrf').val()},
        success: function (result) {
            JSON.parse(result).forEach((element) => {
                if (element['tag'] === null) {
                    element['tag'] = '';
                }
                str = '<div class="one_news" data-id="' + element['id'] + '">' +
                        '<a href="/news/' + element['url'] + '">' +
                        '<div></div>' + element['title'] + '</a></div>';
                
                $('#news').append(str);

            });
        }
    });
}

var timerMore;
$("#more").hover(
        function () {
            //$("#loadline").addClass('load_line_add');
            timerMore = setTimeout(function() {
                $('#more').trigger('click');
            }, 4000);
        }, function () {
            //$("#loadline").removeClass('load_line_add');
            clearTimeout(timerMore);
        }
);