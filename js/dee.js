/**
 *	Новости DEEX CMF
 *
 *	14.12.2013
 *	@version 1
 *	@copyright BRANDER
 *	@author Deemon<a@dee13.ru>
 */

$(function() {

	var limit=20;
	var active_news=false;

	var new_list=$( "#news_list" );

	var radioset=$( "#radioset" ).buttonset();

	$( "#datepicker" ).datepicker({inline: true, altFormat:'yy-mm-dd', altField: "#actualDate" , });
	$( 'textarea' ).ckeditor();
	var dlg_remove=$( ".dialog._remove" ).dialog({autoOpen: false, width: 400, buttons: [
		{text: "Да", click: function() {
			console.log('removing');
			console.log(active_news);
			$( this ).dialog( "close" );
			ajax('delete',{'id':active_news});
		}},
		{text: "Нет", click: function() {
			$( this ).dialog( "close" );
		}}]});
	var dlg_success=$('.dialog._success').dialog({autoOpen: false});

	var form=$('form._edit');
	var page_count=0;
	var current=$('._current').change(function(){setPager(0);});
	var last_current=1;
	var tabs=$( "#tabs" ).tabs({beforeActivate:function(event,ui){
		if(ui.newTab.attr('aria-controls')=='tabs-1')
			refreshList()
	}});
	var refreshList=function()
	{
		ajax('get_list',{'limit':limit,'offset':last_current-1});
	}
	var setPager=function(mod)
	{
		var val=current.val()-0+mod;
		if(val>=page_count)
		{
			val=page_count;
			btn_next.button( "disable" );
		}
		else
			btn_next.button( "enable" );
		if(val<=1)
		{
			val=1;
			btn_prev.button( "disable" );
		}
		else
			btn_prev.button( "enable" );
		current.val(val);
		if(val!=last_current)
			last_current=val;
	}
	var response=function(data)
	{
		if(data==' ')
			return;
		eval('data='+data);
		var action=data.action;
		data=data.data;

		if(action=="get_list")
		{
			page_count=Math.ceil(data.total_count/limit);
			new_list.empty();
			for(var key in data.list)
			{
				var val=data.list[key];
				new_list.append(
					$('<li>').css('color',(val['public']==1?'green':'blue'))
					.data('id',val.id)
					.append(btn_edit.clone(true).show())
					.append(btn_delete.clone(true).show())
					.append(' '+val.date+' - '+val.title)
				);
			}
			setPager(0);
		}
		else if(action=="get_news")
		{
			setData(data);
		}
		else if(action=="delete")
		{
			dlg_success.dialog('open');
			refreshList();
		}
		else if(action=="save")
		{
			if(data>0)
				form.find('[name=id]').val(data);
			dlg_success.dialog('open');
		}
	};
	var ajax=function(action,data)
	{
		$.post('/ajax.php?act='+action,data,response);
	}
	var setData=function(data)
	{
		tabs.tabs( "option", "active", 1 );
		if(arguments.length==0)
			data=
			{
				'id':'new',
				'title':'',
				'date':'',
				'annotation':'',
				'description':'',
				'public':1,
			}
		data.view_date=data.date;
		if(data.view_date!='')
			data.view_date=data.view_date.replace(/^(\d+)-(\d+)-(\d+)$/,'$3.$2.$1');
		for(var f_name in data)
			if(f_name=='public')
			{
				form.find('[name='+f_name+']:eq('+(1-data['public'])+')').prop('checked',true);
				radioset.buttonset( "refresh" );
			}
			else
				form.find('[name='+f_name+'],input._'+f_name).val(data[f_name]);
	}

	refreshList();

	var btns=$( ".btn" ).button()
		.filter('._fu').button("option","icons",{secondary:'ui-icon-folder-open'}).click(function(){
			console.log('file manager');
			window.open('/fu/elfinder.html','pmw','scrollbars=0,top=0,left=0,resizable=1,width=1000,height=400');return false;
		}).end()
		.filter('._save').button("option","icons",{secondary:'ui-icon-circle-check'}).click(function(){
			console.log('saving');
			ajax('save',form.serializeArray());
		}).end()
		// Добавление
		.filter('._add').button("option","icons",{secondary:"ui-icon-circle-plus"}).click(function(){
			setData();
			console.log('adding');
		}).end();
		// Редактирование
		btn_edit=btns.filter('._edit').button( "option", "icons", {secondary:"ui-icon-pencil"})
		.click(function(){
			console.log('editing');
			active_news=$(this).parent().data('id');
			ajax('get_news',{'id':active_news});
		}).hide();
		// Удаление
		btn_delete=btns.filter('._delete').button("option","icons",{secondary:"ui-icon-circle-close"})
		.click(function(){
			active_news=$(this).parent().data('id');
			dlg_remove.dialog( "open" );
		}).hide();
		// назад
		var btn_prev=btns.filter('._prev').button("option","icons",{primary:"ui-icon-circle-arrow-w"})
		.click(function(){setPager(-1)});
		// вперед
		var btn_next=btns.filter('._next').button("option","icons",{secondary:"ui-icon-circle-arrow-e"})
		.click(function(){setPager(1)});
});
// Русский язык
jQuery(function($){$.datepicker.regional['ru'] = {closeText: 'Закрыть', prevText: '&#x3C;Пред', nextText: 'След&#x3E;', currentText: 'Сегодня', monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'], dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], weekHeader: 'Нед', dateFormat: 'dd.mm.yy', firstDay: 1, isRTL: false, showMonthAfterYear: false, yearSuffix: ''}; $.datepicker.setDefaults($.datepicker.regional['ru']); });