<?php 
	namespace app\api\model;
	/**
	* 
	*/
	class User extends \think\Model
	{
		/**
		 * [changePhone  保存修改的手机号]
		 * @param  [string] $id    [用户id]
		 * @param  [string] $phone [手机号]
		 * @return [boolean]        [保存成功为true]
		 */
		function changePhone($id,$phone){
			try{
				db('user')->where(['id'=>$id])->update(['phone_number'=>$phone]);
				return true;
			}catch(\Exception $e){
				return false;
			}
		}
		function saveProfile($data,$id){
			$up_data = Array(
				'user.user_name'=>$data['nickname'],
				'user.whether' => true,
				'expert.rank' => $data['title'],
				'expert.begoodat' => $data['problem'],
				'expert.worth' => $data['money']
			);
			if(!empty($data['head_pic'])){
				$up_data['user.head_pic'] = $data['head_pic'];
			}
			try{
				$this->table('user,expert')->where([
					'user.id'=>$id,
					'expert.uid'=>'user.id'
				]).update($up_data);
			}catch(\Exception $e){

			}
		}
		/**
		 * [getPhoneCode 发送手机验证码]
		 * @param  [string] $phone [手机号码]
		 * @param  [string] $code  [需要发送的验证码]
		 * @return [obj]        [发送状态]
		 */
		function getPhoneCode($phone,$code){
			$host = "http://sms.market.alicloudapi.com";
		    $path = "/singleSendSms";
		    $method = "GET";
		    $appcode = "a82ba56603e0462a8bc2f911b0245ea9";
		    $headers = array();
		    $param = '{"no":"'.$code.'"}';
		    $sign = '小猪崽';
		    $temp = " ";
		    array_push($headers, "Authorization:APPCODE " . $appcode);
		    $querys = "ParamString=" . urlencode($param) . "&RecNum=" . urlencode($phone) . "&SignName=". urlencode($sign) ."&TemplateCode=" . urlencode($temp);
		    $bodys = "";
		    $url = $host . $path . "?" . $querys;

		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($curl, CURLOPT_FAILONERROR, false);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, true);
		    if (1 == strpos("$".$host, "https://"))
		    {
		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    }
		    return curl_exec($curl);
		}
	}
 ?>