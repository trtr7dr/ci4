/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var numlog = 0;

function recaptcha() {
    if(numlog <= 5){
        $.ajax({
            type: 'post',
            url: 'http://localhost/ci4/public/recap',
            data: {csrf_token: $('#csrf').val()},
            success: function (result) {
                numlog++;
                $('#cap').attr('src', "data:image/png;base64," + result + '');
            }
        });
    }else{
        $('#ref').css('display', 'none');
    }
}