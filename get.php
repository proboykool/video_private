<?php 
error_reporting(0);
$token = 'EAAAAUaZA8jlABAN5x4ZBgXDJ3jSJSzoTeVKchl37OmkvWy7bZA2hja0G4nBLDxn8SOZCCEqqPmZAOgLCp6FsAeg61DprUZBqH6FftnwAUrJtDIa5HZC0YTlCvRH95EsjpoMZCOlsFsZAJe0MddgaOKZA0NkVbmsq7EbhdSHiFF61elDxrCrZAhBwtC2';

$id = $_GET['id'];
$type = $_GET['type'];
if($id != null)
{
	$GetInfo = json_decode(request_url('https://graph.facebook.com/v3.1/'.$id.'?fields=from&access_token='.$token));
	$video_id = base64_encode('S:_I'.$GetInfo->from->id.':VK:'.$GetInfo->id);
	if($type == 'stream')
	{
		$link_play = get_stream($video_id, $token);
	}else{
		$link_play = get_video($video_id, $token);
	}
    $data = json_decode($link_play,true);
    $count = count($data['data']);
    $i=0;
    $source = '';
    foreach ($data['data'] as $video)
    {
        $i++;
        $link = $video['link'];
        $label = $video['label'];
        $source .= "{ file: '$link', label : '$label'}".($i!=$count ? ',' : null);
    }
    if($data['sound'] != null)
    {
        $plugin = ',plugins: { "jwplayer/7.12.2/FB.js": { file: "'.$data['sound'].'"} }';
    }

}
function get_video($id, $token)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/graphql");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'variables={"56":"true","116":"true","124":[],"92":60,"83":"'.$id.'","likers_profile_image_size":60,"79":25,"84":{"styles_id":"b19cdc7b2f4f7293de4a2c31b9bb2924","pixel_ratio":1.5},"41":720,"42":60,"98":135,"97":203,"96":100,"89":3,"88":60,"116":"true","47":"1.5","37":"feed","72":"60","63":"1.5","51":"true","52":"true","115":15,"110":"false","81":"image/jpeg","93":"image/x-auto","102":"contain-fit","65":1280,"64":2048,"71":640,"70":2048,"69":427,"68":2048,"66":662,"67":1280,"78":3,"51":"true","52":"true","115":15,"7":"1.5","7":"1.5","84":{"styles_id":"b19cdc7b2f4f7293de4a2c31b9bb2924","pixel_ratio":1.5}}&method=post&doc_id=1678902862199300&query_name=NotificationStoryQueryDepth3&strip_defaults=true&strip_nulls=true&locale=en_US&client_country_code=VN&fb_api_req_friendly_name=NotificationStoryQueryDepth3&fb_api_caller_class=NotificationStoryQueryDepth3');
	curl_setopt($ch, CURLOPT_POST, 1);
	$headers = array();
	$headers[] = "Authorization: OAuth $token";
	$headers[] = "Host: graph.facebook.com";
	$headers[] = "User-Agent: [FBAN/FB4A;FBAV/173.0.0.62.99;FBBV/109748308;FBDM/{density=1.5,width=1280,height=720};FBLC/en_US;FBRV/0;FBCR/Viettel Telecom;FBMF/samsung;FBBD/samsung;FBPN/com.facebook.katana;FBDV/SM-G955N;FBSV/4.4.2;FBOP/1;FBCA/x86:armeabi-v7a;]";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	$data = json_decode($result,true);
	$xml = $data['data']['node']['attachments'][0]['media']['playlist'];
	$xml = simplexml_load_string($xml);
	$sound = $xml->Period->AdaptationSet[1]->Representation->BaseURL;
	$result2 = array();
	foreach ($xml->Period->AdaptationSet->Representation as $value) {
		$label =  $value->attributes()->FBQualityLabel;
		$link = $value->BaseURL;
		$result2[] = array('link' => "$link", 'label' => "$label");
	}
	return json_encode(array('data' => $result2, 'sound' => "$sound"));

}
function get_stream($id, $token)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/graphql");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'doc_id=1734751989975137&method=post&locale=en_US&pretty=false&format=json&variables={"96":135,"95":203,"94":100,"90":60,"87":5,"86":60,"81":{"styles_id":"b19cdc7b2f4f7293de4a2c31b9bb2924","pixel_ratio":1.5},"80":"'.$id.'","91":"image/x-auto","77":"image/jpeg","75":25,"74":3,"69":640,"67":427,"40":720,"114":"true","68":2048,"37":"feed","131":"true","115":"true","107":"false","likers_profile_image_size":60,"126":"true","66":2048,"129":[],"113":15,"100":"contain-fit","41":60,"55":"true","64":662,"46":"1.5","62":2048,"51":"true","53":"true","6":"1.5","50":"true","63":1280,"65":1280}&fb_api_req_friendly_name=StaticGraphQlStoryFeedbackQuery&fb_api_caller_class=graphservice&fb_api_analytics_tags=["GraphServices"]');
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = "Authorization: OAuth $token";
	$headers[] = "Host: graph.facebook.com";
	$headers[] = "User-Agent: [FBAN/FB4A;FBAV/173.0.0.62.99;FBBV/109748308;FBDM/{density=1.5,width=1280,height=720};FBLC/en_US;FBRV/0;FBCR/Viettel Telecom;FBMF/samsung;FBBD/samsung;FBPN/com.facebook.katana;FBDV/SM-G955N;FBSV/4.4.2;FBOP/1;FBCA/x86:armeabi-v7a;]";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	$data = json_decode($result,true);
	$xml = $data['data']['node']['attachments'][0]['media']['playlist'];
	$xml = simplexml_load_string($xml);
	foreach ($xml->Period->AdaptationSet->Representation as $value) {
		$label =  $value->attributes()->FBQualityLabel;
		$link = $value->FBRepresentationMPDURL;
		$result2[] = array('link' => "$link", 'label' => "$label");
	}
	return json_encode(array('data' => $result2, 'sound' => "$sound"));
}
function request_url ($url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return FALSE;
    }
    
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HEADER => FALSE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_ENCODING => '',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
        CURLOPT_AUTOREFERER => TRUE,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => 0
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response  = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    unset($options);
    return $http_code === 200 ? $response : FALSE;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Demo Facebook Video Private</title>
    <link href="jwplayer/skins/tube.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="jwplayer/7.12.2/jwplayer.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
    <style type="text/css">
    *{margin:0;padding:0}#player{position:absolute;width:100%!important;height:100%!important}
    </style>
    <body style="background: black;">
	    <div id="player"></div>
    <script type="text/javascript">
        jwplayer.key = "XYS/ica6YQUMq9rC6J2E77obUFoIPLeM";
        var player = jwplayer('player');

        player.setup({
            playlist: [{
                sources: [
                    <?php echo $source; ?>
                ]
            }],
            skin: {
                name: "tube",
                active: "#2ecc71",
                inactive: "#27ae60"
            },
            width: "100%",
            height: "100%"
			aspectratio: "16:9",
		    fullscreen: "true",
            // Plugin from trunguit
            <?php echo $plugin; ?>
        });

        player.addButton(
            "//icons.jwplayer.com/icons/white/download.svg",
            "Download",
            function() {
                window.location.href = player.getPlaylistItem()['file'];
            },
            "download"
        );
    </script>
</body>

</html>