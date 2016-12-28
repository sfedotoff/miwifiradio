this.imagePreview = function(){
	/* CONFIG */

		xOffset = 10;
		yOffset = 30;

		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result

	/* END CONFIG */
	$("a.preview").hover(function(e){
		this.t = this.title;
		this.title = "";
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='preview'><img id='impr' src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");
    },
	function(){
		this.title = this.t;
		$("#preview").remove();
    });
	$("a.preview").mousemove(function(e){
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});
};


// starting the script on page load
$(document).ready(function(){
	imagePreview();
});



function checkAll(id){
   var f = document.getElementById(id);
   var inputs = f.getElementsByTagName("input");
   for(var t = 0;t < inputs.length;t++){
     if(inputs[t].type == "checkbox")
       inputs[t].checked = true;
   }
 }
 function uncheckAll(id){
   var f = document.getElementById(id);
   var inputs = f.getElementsByTagName("input");
   for(var t = 0;t < inputs.length;t++){
     if(inputs[t].type == "checkbox")
       inputs[t].checked = false;
   }
 }
 function invertAll(id){
   var f = document.getElementById(id);
   var inputs = f.getElementsByTagName("input");
   for(var t = 0;t < inputs.length;t++){
     if(inputs[t].type == "checkbox")
       inputs[t].checked = !inputs[t].checked;
   }
 }


function del_check(form, text) {
check = confirm(text);
if (check == false) return false;
}

/**
 *
 * @access public
 * @return void
 **/
function bulk_check(form, action) {
if(action=='approve') text = 'Вы действительно хотите опубликовать выбранные элементы?';
if(action=='unapprove') text = 'Вы действительно хотите снять с публикации выбранные элементы?';
if(action=='allow_comm') text = 'Вы действительно хотите разрешить комментировать выбранные элементы?';
if(action=='unallow_comm') text = 'Вы действительно хотите запретить комментировать выбранные элементы?';
if(action=='allow_rate') text = 'Вы действительно хотите разрешить оценивать выбранные элементы?';
if(action=='unallow_rate') text = 'Вы действительно хотите запретить оценивать выбранные элементы?';
if(action=='delete') text = 'Вы действительно хотите удалить выбранные элементы?';
check = confirm(text);
if (check == false) return false;
}

function slick_toggle() {
/*$('#slickbox').slideToggle('slow');
return false;
*/
if(document.getElementById('slickbox').style.display=='none') document.getElementById('slickbox').style.display = 'block'; else document.getElementById('slickbox').style.display = 'none';
}

/**
 *
 * @access public
 * @return void
 **/
function addtag(word){
	if(document.getElementById('tags').value.length==0) document.getElementById('tags').value += word;
	else document.getElementById('tags').value += ',' + word;
}


 var lat=new Array("jo","zh","i'","ch","sh","xh","je","ju","ja","a","b","v","g","d","e","z","i","k","l","m","n","o","p","r","s","t","u","f","x","c","'","y","`","j","h","","","","","","","","_","","","","","","","","","","","","");
 var cyr=new Array("ё","ж","й","ч","ш","щ","э","ю","я","а","б","в","г","д","е","з","и","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ь","ы","ъ","ж","х","-","+","!","?",";","'","\""," ",",","=","№","%",":","*","~","@","#","$","^","&");

 var latcap=new Array("jo","jo","zh","zh","i","ch","ch","sh","sh","xh","xh","je","je","ju","ju","ja","ja","a","b","v","g","d","e","z","i","k","l","m","n","o","p","r","s","t","u","f","x","c","y","j","h");
 var cyrcap=new Array("Ё","Ё","Ж","Ж","Й","Ч","Ч","Ш","Ш","Щ","Щ","Э","Э","Ю","Ю","Я","Я","А","Б","В","Г","Д","Е","З","И","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ы","Ж","Х");

 function translate(tex)
 {
 var buf=tex;
 var i;
 for (i=0;i<cyrcap.length;i++)
        {
        buf=replace(buf,cyrcap[i],latcap[i],1,0);
        }

 for (i=0;i<cyr.length;i++)
        {
        buf=replace(buf,cyr[i],lat[i],1,0);
        }

 tex=buf;
document.getElementById('translite').value = tex.toLowerCase();
// return tex;
 }

 function replace(target,oldTerm,newTerm,caseSens,wordOnly) {

        var work = target;
        var ind = 0;
        var next = 0;

        if (!caseSens) {
          oldTerm = oldTerm.toLowerCase();
          work = target.toLowerCase();
        }

        while ((ind = work.indexOf(oldTerm,next)) >= 0) {
          if (wordOnly) {
            var before = ind - 1;
            var after = ind + oldTerm.length;
            if (!(space(work.charAt(before)) && space(work.charAt(after)))) {
              next = ind + oldTerm.length;
              continue;
            }
          }
          target = target.substring(0,ind) + newTerm +
          target.substring(ind+oldTerm.length,target.length);
          work = work.substring(0,ind) + newTerm +
          work.substring(ind+oldTerm.length,work.length);
          next = ind + newTerm.length;
          if (next >= work.length) { break; }
        }

        return target;

 }

/**
 *
 * @access public
 * @return void
 **/
function addrow (tableID) {
// pass every cell content as a futher arg
  var table =
    document.all ? document.all[tableID] :
      document.getElementById(tableID);
  var row = table.insertRow(0);
  row.setAttribute("id", "adder");
  /*
  if (arguments.length > 1) {
    var row = table.insertRow(0);

    if (document.all) {
      for (var i = 1; i < arguments.length; i++) {
        var cell = row.insertCell(i - 1);
        cell.innerHTML = arguments[i];
      }
    }
    else if (document.getElementById) {
//NN6 bug inserting cells in wrong sequence
      for (var i = arguments.length - 1; i >= 1; i--) {
        var cell = row.insertCell(arguments.length - 1 - i);
        cell.appendChild(document.createTextNode(arguments[i]));
      }
    }
  }*/
}


function edit_comment(id){
	  var r1 = document.getElementById('' + id + '');
	  while (r1.hasChildNodes()) r1.removeChild(r1.childNodes.item(0));
      var editorial = document.createElement("td");
	  editorial.setAttribute("id", "edit_" + id);
      editorial.setAttribute("colSpan","6");
      editorial.setAttribute("align","center");
      editorial.innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
      r1.appendChild(editorial);

	var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			editorial.setAttribute("align", "left");
            document.getElementById('edit_'+id+'').innerHTML = req.responseText;
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { id: id, action: 'edit_comment' } );
}

/**
 *
 * @access public
 * @return void
 **/
function editsave_comment(id) {
	author = document.getElementById('author').value;
	author_email = document.getElementById('author_email').value;
	author_url = document.getElementById('author_url').value;
	content = document.getElementById('content').value;
	if(document.getElementById('approve').checked) approve = "1"; else approve = "0";
	day = document.getElementById('day_adddate').value;
	month = document.getElementById('month_adddate').value;
	year = document.getElementById('year_adddate').value;
	hour = document.getElementById('hour_adddate').value;
	minute = document.getElementById('minute_adddate').value;
	document.getElementById('edit_' + id + '').setAttribute("align", "center");
	document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
	  var req = new JsHttpRequest();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
		document.getElementById('edit_' + id + '').setAttribute("align", "left");
            // Write result to page element (_RESULT become responseJS).
			var r1 = document.getElementById('' + id + '');
	  		while (r1.hasChildNodes()) r1.removeChild(r1.childNodes.item(0));
      		var editorial = document.createElement("td");
      		editorial.innerHTML = req.responseJS.author;
      		r1.appendChild(editorial);
			var editorial2 = document.createElement("td");
      		editorial2.innerHTML = req.responseJS.content;
      		r1.appendChild(editorial2);
			var editorial3 = document.createElement("td");
      		editorial3.innerHTML = req.responseJS.author_info;
      		r1.appendChild(editorial3);
			var editorial4 = document.createElement("td");
      		editorial4.innerHTML = req.responseJS.adddate;
      		r1.appendChild(editorial4);
			var editorial5 = document.createElement("td");
			editorial5.setAttribute('id', '' + req.responseJS.approve_attr + '');
			editorial5.setAttribute('align', 'center');
      		editorial5.innerHTML = req.responseJS.approve;
      		r1.appendChild(editorial5);
			var editorial6 = document.createElement("td");
			editorial6.setAttribute('nowrap', 'nowrap');
			editorial6.setAttribute('align', 'center');
      		editorial6.innerHTML = req.responseJS.options;
      		r1.appendChild(editorial6);
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { id: id, author: author, author_email: author_email, author_url: author_url, content: content, approve: approve, day: day, month: month, year: year, hour: hour, minute: minute, action: 'save_comment' } );
}

/**
 *
 * @access public
 * @return void
 **/
function del_comment(id) {
	if(confirm('Вы действительно хотите удалить этот комментарий')==true) {
	var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			if(req.responseText=='yes') {
				var r1 = document.getElementById('' + id + '');
	  			while (r1.hasChildNodes()) r1.removeChild(r1.childNodes.item(0));
			}
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { id: id, action: 'del_comment' } );
	}
}

function approve_comment(id) {
	document.getElementById('approve_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0" alt="">';
	var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			if(req.responseText=='1') {
				document.getElementById('approve_' + id + '').innerHTML = '<img src="/images/admin/template/small/plus.png" border="0" alt="">';
			} else {
				document.getElementById('approve_' + id + '').innerHTML = '<img src="/images/admin/template/small/minus.png" border="0" alt="">';
			}
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { id: id, action: 'approve_comment' } );
}

function microtime (get_as_float) {
    // http://kevin.vanzonneveld.net
    // +   original by: Paulo Ricardo F. Santos
    // *     example 1: timeStamp = microtime(true);
    // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000

    var now = new Date().getTime() / 1000;
    var s = parseInt(now, 10);

    return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}

function pausecomp(millis)
{
var date = new Date();
var curDate = null;

do { curDate = new Date(); }
while(curDate-date < millis);
}

function add_comment(id) {
	author = document.getElementById('author').value;
	author_email = document.getElementById('author_email').value;
	author_url = document.getElementById('author_url').value;
	content = document.getElementById('content').value;
	if(document.getElementById('approve').checked) approve = "1"; else approve = "0";
	day = document.getElementById('day_adddate').value;
	month = document.getElementById('month_adddate').value;
	year = document.getElementById('year_adddate').value;
	hour = document.getElementById('hour_adddate').value;
	minute = document.getElementById('minute_adddate').value;
	  var req = new JsHttpRequest();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			var newid = microtime(false);
			var r1 = document.getElementById('adder');
	  		while (r1.hasChildNodes()) r1.removeChild(r1.childNodes.item(0));
      		var editorial = document.createElement("td");
      		editorial.innerHTML = req.responseJS.author;
      		r1.appendChild(editorial);
			var editorial2 = document.createElement("td");
      		editorial2.innerHTML = req.responseJS.content;
      		r1.appendChild(editorial2);
			var editorial3 = document.createElement("td");
      		editorial3.innerHTML = req.responseJS.author_info;
      		r1.appendChild(editorial3);
			var editorial4 = document.createElement("td");
      		editorial4.innerHTML = req.responseJS.adddate;
      		r1.appendChild(editorial4);
			var editorial5 = document.createElement("td");
			editorial5.setAttribute('id', '' + req.responseJS.approve_attr + '');
			editorial5.setAttribute('align', 'center');
      		editorial5.innerHTML = req.responseJS.approve;
      		r1.appendChild(editorial5);
			var editorial6 = document.createElement("td");
			editorial6.setAttribute('nowrap', 'nowrap');
			editorial6.setAttribute('align', 'center');
      		editorial6.innerHTML = req.responseJS.options;
      		r1.appendChild(editorial6);
			r1.removeAttribute("id");
			r1.setAttribute("id", newid);
			addrow('comments');
			document.getElementById('comm_add_form').reset();
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { id: id, author: author, author_email: author_email, author_url: author_url, content: content, approve: approve, day: day, month: month, year: year, hour: hour, minute: minute, action: 'add_comment' } );
}

/**
 *
 * @access public
 * @return void
 **/
function switch_pan(id) {
	$(".pan").hide('slide');
	$("#" + id + "").show('slide');
}

function GeneratePassword() {

    var length=8;
    var sPassword = "";
    var noPunction = true;
    var randomLength = false;

    for (i=0; i < length; i++) {

        numI = getRandomNum();
        if (noPunction) { while (checkPunc(numI)) { numI = getRandomNum(); } }

        sPassword = sPassword + String.fromCharCode(numI);
    }

    $('#passwd').val(sPassword);
    return true;
}

function getRandomNum() {

    // between 0 - 1
    var rndNum = Math.random()

    // rndNum from 0 - 1000
    rndNum = parseInt(rndNum * 1000);

    // rndNum from 33 - 127
    rndNum = (rndNum % 94) + 33;

    return rndNum;
}

function checkPunc(num) {

    if ((num >=33) && (num <=47)) { return true; }
    if ((num >=58) && (num <=64)) { return true; }
    if ((num >=91) && (num <=96)) { return true; }
    if ((num >=123) && (num <=126)) { return true; }

    return false;
}

function get_city(rid) {
	  var req = new JsHttpRequest();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			document.getElementById('citylist').innerHTML = req.responseText;
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { rid: rid, action: 'get_city' } );
}

/**
 *
 * @access public
 * @return void
 **/
function load_profile(){
	var req = new JsHttpRequest();
	uname = $('#username').val();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			$('#uphone').val(req.responseJS.uphone);
			$('#umail').val(req.responseJS.umail);
			$('#uname_ru').val(req.responseJS.uname_ru);
			$('#uname_en').val(req.responseJS.uname_en);
			$('#uname_he').val(req.responseJS.uname_he);
			$('#uregion option[value=' + req.responseJS.uregion + ']').attr('selected', 'selected');
			$('#citylist').html(req.responseJS.citylist);
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { uname: uname, action: 'load_profile' } );
}
function load_profile_coms(){
	var req = new JsHttpRequest();
	uname = $('#username').val();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			$('#umail').val(req.responseJS.umail);
			$('#uname_ru').val(req.responseJS.uname_ru);
			$('#uname_en').val(req.responseJS.uname_en);
			$('#uname_he').val(req.responseJS.uname_he);
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { uname: uname, action: 'load_profile' } );
}
function load_profile_salon(){
	var req = new JsHttpRequest();
	uname = $('#username').val();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			$('#uphone').val(req.responseJS.uphone);
			$('#umail').val(req.responseJS.umail);
			$('#uregion option[value=' + req.responseJS.uregion + ']').attr('selected', 'selected');
			$('#citylist').html(req.responseJS.citylist);
			$('#accounts_select').html(req.responseJS.accountlist);
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { uname: uname, action: 'load_profile_salon' } );
}
function load_profile_club(){
	var req = new JsHttpRequest();
	uname = $('#username').val();
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
			$('#uphone').val(req.responseJS.uphone);
			$('#umail').val(req.responseJS.umail);
			$('#uregion option[value=' + req.responseJS.uregion + ']').attr('selected', 'selected');
			$('#citylist').html(req.responseJS.citylist);
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { uname: uname, action: 'load_profile_club' } );
}

/**
 *
 * @access public
 * @return void
 **/
function load_props(){
	var req = new JsHttpRequest();
	cat = $('#ac_cat').val();
	if($('#editorial').length != 0) {
		acid = $('#editorial').val();
	} else acid = 0;
//	  document.getElementById('edit_' + id + '').innerHTML = '<img src="/images/admin/template/loader.gif" border="0">';
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            // Write result to page element (_RESULT become responseJS).
            $('.props').remove();
			$('#weight').after(req.responseJS.props);
			$('#services').html(req.responseJS.services);
			$('#services input.checkbox').each(function(){
				$(this).click(function (){
					if($(this).attr('checked'))	{
						$('#t1_' + $(this).attr('id')).removeAttr('disabled');
						$('#t2_' + $(this).attr('id')).removeAttr('disabled');
						$('#t3_' + $(this).attr('id')).removeAttr('disabled');
					} else {
						$('#t1_' + $(this).attr('id')).attr('disabled', 'disabled');
						$('#t2_' + $(this).attr('id')).attr('disabled', 'disabled');
						$('#t3_' + $(this).attr('id')).attr('disabled', 'disabled');
					}
				});
			});
        }
    }
    // Prepare request object (automatically choose GET or POST).
    req.open(null, '/ajax_admin.php', true);
    // Send data to backend.
    req.send( { cat: cat, action: 'load_props', acid: acid } );
}

/**
 *
 * @access public
 * @return void
 **/
function ap_start(){
	$('#apservices input.checkbox').each(function(){
				$(this).click(function (){
					if($(this).attr('checked'))	{
						$('#t1_' + $(this).attr('id')).removeAttr('disabled');
						$('#t2_' + $(this).attr('id')).removeAttr('disabled');
						$('#t3_' + $(this).attr('id')).removeAttr('disabled');
					} else {
						$('#t1_' + $(this).attr('id')).attr('disabled', 'disabled');
						$('#t2_' + $(this).attr('id')).attr('disabled', 'disabled');
						$('#t3_' + $(this).attr('id')).attr('disabled', 'disabled');
					}
				});
			});
}

function sync(s){
var xhr = new XMLHttpRequest();

xhr.open('GET', s, false);

// 3. Отсылаем запрос
xhr.send();

// 4. Если код ответа сервера не 200, то это ошибка
if (xhr.status != 200) {
  // обработать ошибку
  alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
} else {
  // вывести результат
  alert( xhr.responseText ); // responseText -- текст ответа.
}
}