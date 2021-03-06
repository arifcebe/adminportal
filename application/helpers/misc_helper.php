<?php  

/**
 * @package    adminportal / 2016
 * @author     Sabbana
 * @copyright  portal.ilmuberbagi.id
 * @version    1.0
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function UR_exists($url){
	if($url != ''){
		$headers=get_headers($url);
		return stripos($headers[0],"200 OK")?true:false;
	}else
		return false;
}

function image_url($url){
	if($url != "")
		$img = $url;
	else
		$img = site_url().'assets/img/foto/default.png';
	return $img;
}

function set_image($url, $param = null){
	if($url != null){
		if($param == "thumb"){
			$res = str_replace('uploads/','uploads/thumbs/', $url);
		}else if($param == "profile-thumb"){
			$res = str_replace('/foto/','/thumbs/', $url);
		}else
			$res = $url;
	}else
		$res = base_url().'assets/img/default.jpg';
	
	return $res;
		
}

function gen_member_status($sts){
	switch($sts){
		case 1 : $label = '<span class="label label-success">Aktif</span>'; break;
		case 2 : $label = '<span class="label label-danger">Blokir</span>'; break;
		default : $label = '<span class="label label-default">Pending</span>'; break;
	}
	return $label;
}

function generatePassword($length, $strength){
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1)
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    if ($strength & 2) 
        $vowels .= "AEUY";
    if ($strength & 4) 
        $consonants .= '23456789';
    if ($strength & 8) 
        $consonants .= '@#$%';

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++){
        if ($alt == 1){
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        }else{
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}
function headline($txt){
	$str = strip_tags($txt);
	return substr($str, 0, 200).' ...';
}

function generate_code_member($count){
	$count = sprintf("%04d",$count);
	$string = 'IBF'.date('Y').$count;
	return $string;
}

function label_privilage($uid, $app_id, $priv){
	switch($priv){
		case 0 : $label = '<span class="label label-danger" data-toggle="modal" data-target="#modalPriv" style="cursor:pointer" onclick="return privilage(\''.$app_id.'#'.$uid.'#'.$priv.'\')">B</span>'; break;
		case 1 : $label = '<span class="label label-success" data-toggle="modal" data-target="#modalPriv" style="cursor:pointer"  onclick="return privilage(\''.$app_id.'#'.$uid.'#'.$priv.'\')">U</span>'; break;
		case 2 : $label = '<span class="label label-warning" data-toggle="modal" data-target="#modalPriv" style="cursor:pointer" onclick="return privilage(\''.$app_id.'#'.$uid.'#'.$priv.'\')">R</span>'; break;
		case 3 : $label = '<span class="label label-primary" data-toggle="modal" data-target="#modalPriv" style="cursor:pointer" onclick="return privilage(\''.$app_id.'#'.$uid.'#'.$priv.'\')">A</span>'; break;
	}
	return $label;
}

function get_image_from_content($html){
	preg_match_all('/<img[^>]+>/i',$html, $result);
	$res = '';
	if(!empty($result)){
		$res = $result[0][0]; 
	}
	return str_replace('img', 'img class="content-img"', $res);
}

?>