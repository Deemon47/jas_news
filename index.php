<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>Редактирование новостей</title>
	<link href="/css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="/js/jquery-1.9.1.js"></script>
	<script src="/js/jquery-ui-1.10.3.custom.js"></script>
	<script src="/ckeditor/ckeditor.js"></script>
	<script src="/ckeditor/adapters/jquery.js"></script>
	<script src="/js/dee.js"></script>
	<style>
	body{
		font: 62.5% "Trebuchet MS", sans-serif;
		margin: 50px;
	}
	.title,textarea{width:100%}
	</style>
</head>
<body>

<h1>Новости</h1>

<!-- Tabs -->
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Список новостей</a></li>
		<li><a href="#tabs-2">Редактирование</a></li>
	</ul>
	<div id="tabs-1">
		<button class="btn _add">Добавить</button>
		<br>
		<!-- Список новостей -->
		<ul id="news_list">
		</ul>

		<div class="pager ">
			<button class="btn _prev">Назад</button>
			<input type="text" value="1" class="_current">
			<button class="btn _next">Вперед</button>
		</div>
		<br>
		<button class="btn _edit" >Редактировать</button>
		<button class="btn _delete" >Удалить</button>
	</div>
	<div id="tabs-2">
		<!-- Редактирование -->
		<form style="margin-top: 1em;" class="_edit">

			<input type="hidden" name="id" value="new">

			<!--  -->
			<h4>Заголовок</h4>
			<input type="text" name="title" id="" class="title">

			<!--  -->
			<h4>Дата</h4>
			<input type="text" id="datepicker" class="_view_date">
			<input type="hidden" name="date" value="2013-12-12" id="actualDate">

			<!--  -->
			<h4>Короткое описание</h4>
			<textarea name="annotation" id="" cols="30" rows="10"></textarea>

			<!--  -->
			<h4>Полное описание</h4>
			<textarea name="description" id="" cols="30" rows="10"></textarea>

			<!--  -->
			<h4>Статус</h4>
			<div id="radioset">
				<input type="radio" id="radio1" name="public" checked="checked" value="1"><label for="radio1">Опубликовано</label>
				<input type="radio" id="radio2" name="public" value="0"><label for="radio2">Скрыто</label>
			</div>

			<!--  -->
			<br>
			<button class="btn _save" type="button">Сохранить</button>
		</form>
		<br>
		<button class="btn _fu" type="button">Менеджер файлов</button>
	</div>

</div>


<!-- ui-dialog -->
<div class="dialog _remove" title="Удаление новости">
	<div class="ui-widget">
		<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			Вы уверены, что хотите <b>удалить</b> новость ?</p>
		</div>
	</div>
</div>
<div class="dialog _success" title="Удаление новости">
	<p>готово</p>
</div>


</body>
</html>
