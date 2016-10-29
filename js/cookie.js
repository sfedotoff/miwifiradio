jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
/**
 *
 * @access public
 * @return void
 **/
function send_question(){
	var name = $('#quname').val();
	var mail = $('#qumail').val();
    var phone = $('#quphone').val();
	var quest = $('#qmessage').val();
    if((name.length==0)||(mail.length==0)||(phone.length==0)||(quest.length==0)||(name=="Ваше имя")||(mail=="E-mail")||(phone=="Контактный телефон")||(quest=="Вопрос"))
        alert("Необходимо заполнить все поля");
    else
	$.ajax({
  		url: '/ajax.php',
  		data: 'name='+name+'&mail='+mail+'&mes='+quest+'&phone='+phone+'&act=question',
  		success: function( data ) {
    		$('#sendquest').html('<br><b style="color:green;">Ваш вопрос успешно отправлен</b>.<br>Ожидайте ответа').show('fast').delay(3000).hide('fast');
    		$('#quname').val('');
    		$('#qumail').val('');
            $('#quphone').val('');
    		$('#qmessage').val('');
  		}
	});
}