<?php
//文章
if(!defined('IN_T')){
	die('hacking attempt');
}
$act = Common::sfilter($_REQUEST['act']);
if ($act == 'list') {//ajax 加载
	$tag = intval($_REQUEST['tag']);
	$page = intval($_REQUEST['page']);
	$page = $page<1?1:$page;
	$size =  10;
	$list = get_article($tag,$page,$size);
	foreach($list as $k=>$v){
		$tags = rtrim(substr(strip_tags($v['content']),0,600))."...";

		$preg="/([^\"'>]+.(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG))/i";
		preg_match_all($preg,$v['content'],$match);
		$img= $match[0][0];

		$res[$k]['id'] =$v['id'];
		$res[$k]['title'] =$v['title'];
		$res[$k]['keywords'] =$v['keywords'];
		$res[$k]['createtime'] =$v['createtime'];
//		$res[$k]['tags'] =$tags;
		$res[$k]['img'] =$img;
	}
	echo $Json->encode($res);
	exit;
}

//提取文章内容
function get_article($tag,$page,$size){
	$sql = "SELECT * FROM ".$GLOBALS['Base']->table('article')." WHERE is_nav ='left_bottom' ";

	$sql .= " order by u_article.createtime desc limit ".($page-1)*$size.",".$size;
	$res = $GLOBALS['Db']->query($sql);
	return $res;
}

?>