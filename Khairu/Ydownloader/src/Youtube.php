<?php 

namespace Khairu\Ydownloader;

class Youtube
{
	var $msg = [];
	var $api = "AIzaSyBUyCSuLcpGt7sVP8K8I85zIGOh96cmhhc";
	
	public function Download($url, $api=false, $format='mp4')
	{
		if(!empty($url)){
			if(filter_var($url, FILTER_VALIDATE_URL)){
				$is_valid = $this->cekDomain($url);
				if($is_valid){
					if(!$api){
						$this->withOutApi($url, $format);
					}else{
						$this->withApi($url);
					}
				}
			}else{
				$this->msg = [
					'status'=>false,
					'msg'=>'Invalid Url'
				];
			}	
		}else{
			$this->msg = [
				'status'=>false,
				'msg'=>'url cannot be empty'
			];
		}
	}
	
	public function withOutApi($url, $format)
	{
		$id = $this->getId($url);
		$uri = "http://youtube.com/get_video_info?video_id=".$id."";		
		$response = \Requests::get($uri);
		if($response->status_code == 200){
			parse_str($response->body, $info);
			if(!isset($info['url_encoded_fmt_stream_map'])){
				$this->msg = [
					'status'=>false,
					'msg'=>'Content Protected, Download Not Available'
				];
			}else{
				$streams = $info['url_encoded_fmt_stream_map'];
				$streams = explode(',',$streams);
			
				$availabel_format = [];
				$video = [];					
			
				foreach($streams as $stream){
					parse_str($stream,$data);
					if(stripos($data['type'],$format) !== false){
						$video = [
							'url'=>$data['url'],
							'quality'=>$data['quality'],
							'type'=>$data['type']
						];
					}else{
						$availabel_format[] = $data['type'];
					}
				}
			
				$this->msg = [
					'status'=>true,
					'video'=>$video,
					'availabel_format'=>$availabel_format
				];
			}
		}
		
	}
	
	public function withApi($url)
	{
		$id = $this->getId($url);
		$api = $this->YoutubeApi($id);
		if($api)
		{
			$this->msg = [
				'status'=>true,
				'msg'=>'success',
				'data'=>$api
			];
		}
	}
	
	public function getId($url)
	{
		$info = parse_url($url);
		$videoId = explode("=", $info['query']);
		
		return $videoId[1];
	}

	public function cekDomain($url){
		$domain = implode('.', array_slice(explode('.', parse_url($url, PHP_URL_HOST)), -2));
       	if ($domain == 'youtube.com') {
       		return true;
       	}else{
			$this->msg = [
				'status'=>false,
				'msg'=>'Invalid Youtube Video url'
			];	
       		return false;
       	}
	}
	
	public function YoutubeApi($id)
	{
		$url = "https://www.googleapis.com/youtube/v3/videos?id=$id&key={$this->api}&part=snippet,contentDetails,statistics";
		$headers = array('Content-Type' => 'application/json');
		$response = \Requests::get($url, $headers);
		if($response->status_code == 200){
			$ret = json_decode($response->body);
			return $ret->items[0];
		}else{
			return false;
		}
	}
	
	public function SaveVideo($video, $saveto){
		//soon
	}
}