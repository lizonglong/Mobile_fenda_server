<?php
namespace app\admin\model;



class Single extends \think\Model{
	// 保存信息
	public function insertInfo()
	{
		$add_data = input();
		// $add_data['create_time'] = date("Y-m-d h-m-s",time());
		// $add_data['create_time'] = time();
		db('single')->insert($add_data);
	}

}

?>