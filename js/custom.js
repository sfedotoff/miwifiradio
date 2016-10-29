$(document).ready(function() {

		$('#navbar').droppy();


		//LANGUAGE //
		$(".flag").hide();
		$(".language_button").click(function() {
			$(".flag").toggle('drop');
		});

		//BOX SORTABLE //
		$(".column.half").sortable({
			connectWith: '.column.half',
			handle: '.box-header'
		});
		$(".column.full").sortable({
			connectWith: '.column.full',
			handle: '.box-header'
		});
		$(".box").find(".box-header").prepend('<span class="close"></span>').end();
		$(".box-header .close ").click(function() {
			$(this).parents(".box .box-header").toggleClass("box-header closed").toggleClass("box-header");
			$(this).parents(".box:first").find(".box-content").toggle();
			$(this).parents(".box:first").find(".example").toggle();
		});

		//MESSAGE - TAG HIDE //
		$(".message").click(function() {
                      $(this).hide('blind', 500);
                      return false;
        });
		$(".tag").click(function() {
                      $(this).hide('highlight', 500);
                      return false;
        });

		//SEARCH INPUT//
		$("#search_input").focusin(
		function() {
			$('#search_input').val('');
		});
		$("#search_input").focusout(
		function() {
			$('#search_input').val('Search...');
		});

		//TEXTAREA INPUT//
			$("#form-message").resizable({
			handle: "se",
			containment: '#formtest'
			});
			$("textarea.form-field").resizable({
			handle: "se",
			containment: '.box-content'
			});

		//CHECKBOX //

		$(".checkbox").button();
		$(".radiocheck").buttonset();

		$(".openable").click(function()
		{
			$(this).parents().next(".openable-tr").toggle();
		});

		//GALLERY//
		$(".gallery-list li").hover(function() {
			$(this).find(".gallery-buttons").toggle();
		});

		//ACCORDION//
		$(".accordion").accordion();

		//DIALOG//
		$('.dialog').dialog({
			autoOpen: false,
			width: 800,
			height: 260,
			modal: true
		});
		$('.opener').click(function() {
			$('.dialog').dialog('open');
		});
		$('.closer').click(function() {
			$('.dialog').dialog('close');
		});

		//DATAPICKER//
		$(".datepicker").datepicker();

		//TABS - SORTABLE//
		$(".tabs").tabs();
		$(".tabs.sortable").tabs().find(".ui-tabs-nav").sortable({axis:'x'});

		//SKIN//
		$(".skin_block").hide();
		$('.skin_button').click(function() {
			$(".skin_block").toggle('drop');
		});

		//TABLE//
		oTable = $('#tabledata').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"oLanguage": {
                	"sProcessing":   "Подождите...",
    				"sLengthMenu":   "Показать _MENU_ записей",
    				"sZeroRecords":  "Записи отсутствуют.",
    				"sInfo":         "Показаны _START_ - _END_ из _TOTAL_",
    				"sInfoEmpty":    "Показаны _START_ - _END_ из _TOTAL_",
    				"sInfoFiltered": "(отфильтровано из _MAX_ записей)",
    				"sInfoPostFix":  "",
    				"sSearch":       "Поиск:",
    				"sUrl":          "",
    				"oPaginate": {
        				"sFirst": "&lt;&lt;",
        				"sPrevious": "&larr;",
        				"sNext": "&rarr;",
        				"sLast": "&gt;&gt;"
    				}
            	},
            	"fnDrawCallback": function(){
      				$('td').bind('mouseenter', function () { $(this).parent().children().each(function(){$(this).addClass('datatablerowhighlight');}); });
      				$('td').bind('mouseleave', function () { $(this).parent().children().each(function(){$(this).removeClass('datatablerowhighlight');}); });
      				$('.nosort').unbind('click').children('span').remove();
				}
			});
		$("#checkboxall").click(function()
		{
			var checked_status = this.checked;
			$("input[name=checkall]").each(function()
			{
				this.checked = checked_status;
			});
		});
		$("#checkboxalltabs").click(function()
		{
			var checked_status = this.checked;
			$("input[name=checkalltabs]").each(function()
			{
				this.checked = checked_status;
			});
		});
		$("#checkboxalltabs2").click(function()
		{
			var checked_status = this.checked;
			$("input[name=checkalltabs2]").each(function()
			{
				this.checked = checked_status;
			});
		});
		$(".openable").click(function()
		{
			$(this).parents().next(".openable-tr").toggle();
		});

		//SLIDER//
		$(".slider-vertical").slider({
			orientation: "vertical",
			range: "min",
			min: 0,
			max: 100,
			value: 60,
			slide: function(event, ui) {
				$(".amount-vert").val(ui.value);
			}
		});
		$(".amount-vert").val($(".slider-vertical").slider("value"));

		$(".slider-horizontal").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function(event, ui) {
				$(".amount-hor").val('$' + ui.values[0] + ' - $' + ui.values[1]);
			}
		});
		$(".amount-hor").val('$' + $(".slider-horizontal").slider("values", 0) + ' - $' + $(".slider-horizontal").slider("values", 1));

		//PROGRESSBAR//

		$(".progressbar").progressbar({value:0});
		$(".progressbar .ui-progressbar-value").animate({width:'5%'}, 1500);

		$("#prog-10").click(function() {
			$(".progressbar .ui-progressbar-value").animate({width:'10%'}, 1500);
		});
		$("#prog-30").click(function() {
			$(".progressbar .ui-progressbar-value").animate({width:'30%'}, 1500);
		});
		$("#prog-50").click(function() {
			$(".progressbar .ui-progressbar-value").animate({width:'50%'}, 1500);
		});
		$("#prog-70").click(function() {
			$(".progressbar .ui-progressbar-value").animate({width:'70%'}, 1500);
		});
		$("#prog-100").click(function() {
			$(".progressbar .ui-progressbar-value").animate({width:'100%'}, 1500);
		});

		$(".progressbaractive").progressbar({value: 0});
		$(".progressbarpending").progressbar({value: 0});
		$(".progressbarsuspended").progressbar({value: 0});

		$(".progressbaractive .ui-progressbar-value").animate({width:'60%'}, 1500);
		$(".progressbarpending .ui-progressbar-value").animate({width:'30%'}, 1500);
		$(".progressbarsuspended .ui-progressbar-value").animate({width:'10%'}, 1500);
});

/**
 *
 * @access public
 * @return void
 **/
function showhide_fields(val){
	if(val=="link") {
		$('#shablon, #tit, #tit2, #parent, #showmenu, #cont, #keys, #desc').hide();
		$('#link_pref').show();
	} else {
		$('#shablon, #tit, #tit2, #parent, #showmenu, #cont, #keys, #desc').show();
		$('#link_pref').hide();
	}
}

/**
 *
 * @access public
 * @return void
 **/
function showinfo_special(val){
	if((val=='none') || (val=='colors')) {
		$('#showm').attr('checked', 'true');
		$('#showmenu').show();
		$('#pid').removeAttr('disabled');
	} else {
		$('#showm').attr('checked', 'false');
		$('#showmenu').hide();
		$('#pid').attr('disabled', 'true');
	}
	if(val=="index") $('#tit2').hide();
}