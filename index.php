<?php
/*
copyright @ bncautowork.com
Modified by Ilyasa
And Modified by BillieDhikaS
2017
*/
require_once('./line_class.php');
$channelAccessToken = 'PkY/i10WmtAM0pCcSb+QDq0jQDwMIriB2iMiDW9kVpak7/9BabEJOKYVULinM24v6R1MEd9aVP0lIOsTM1lj9G1G97pXzoN5SOPfw5duiIh3SI9cdvEvw5uR1KnnMHgUxNmgVIM8XYBmf7qFy20wuQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'aab7e75d0e6e8fc1b1555266e07e4086';//Your Channel Secret
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];
if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'jangan pake sticker dehh.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'b9d3c370-5169-4679-9766-118d5931c6f1'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Pake bahasa yg bener donggg :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Sorry '.$profil->displayName.' gw lg sibuk nih.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);
file_put_contents('./reply.json',$result);
$client->replyMessage($balas);
