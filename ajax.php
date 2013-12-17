<?php
function elog($data)
{
	static $log=[];
	if($data=='push')
		file_put_contents('log',print_r($log,true));
	else $log[]=$data;
}
function query($sql)
{
	static $conn=false;
	if(false===$conn)
	{
		if(false == ($conn=mysql_connect('localhost','root','')) || false == mysql_select_db('test',$conn))
			return false;
		//Явно объявляю кодировку
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER SET 'utf8'");
	}
	if(false==$conn)//Если нет подключения
		die('НЕТ ПОДКЛЮЧЕНИЯ');
	elog($sql);
	return mysql_query($sql,$conn);
}
if(!empty($_GET['act']))
{
	$response=false;
	switch ($_GET['act'])
	{
		case 'get_list':
			if(empty($_POST['limit']) || !isset($_POST['offset']))
				break;
			$res=query('SELECT SQL_CALC_FOUND_ROWS `id`,`title`,`public`,`date` FROM `news` ORDER BY `date` desc LIMIT '.$_POST['limit'].' OFFSET '.$_POST['offset']);
			$response=
			[
				'list'=>[],
				'total_count'=>0,
			];
			while($row=mysql_fetch_object($res))
				$response['list'][]=$row;
			$res=query('SELECT found_rows()');
			$row=mysql_fetch_array($res);
			$response['total_count']=$row[0];
			break;
		case 'get_news':
			if(empty($_POST['id']))
				break;
			$res=query('SELECT * FROM `news` where id ='.$_POST['id']);
			$response=mysql_fetch_assoc($res);
			break;
		case 'save':
			$data=[];
			foreach(['id', 'title', 'date', 'annotation', 'description', 'public',] as $f_name)
			{
				if(!isset($_POST[$f_name]))
				{
					$data=false;
					return;
				}
				elseif($f_name=='id' && !is_numeric($_POST[$f_name]))
					$data['id']='null';
				elseif($f_name=='date' && $_POST[$f_name]=='')
					$data['date']='now()';
				else
					$data[$f_name]='"'.addslashes($_POST[$f_name]).'"';
			}
			if($data==false)
				break;
			if($data['id']!='null')
			{
				//update
				query("UPDATE `news` set `title`={$data['title']}, `date`={$data['date']}, `annotation`={$data['annotation']}, `description`={$data['description']}, `public`={$data['public']}  where id={$data['id']} ");
				$response=true;
			}
			else
			{
				//Insert
				unset($data['id']);
				query('INSERT INTO `news`( `title`, `date`, `annotation`, `description`, `public`)VALUES('.implode(',', $data).')');
				$response=mysql_insert_id();
			}
			break;
		case 'delete':
			if(!empty($_POST['id']) && is_numeric($_POST['id']))
				query('DELETE FROM `news` WHERE `id`='.$_POST['id']);
			break;

		default:

			break;
	}
	echo json_encode(['action'=>$_GET['act'],'data'=>$response]);
}
elog('push');
die(' ');