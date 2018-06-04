<?PHP

class MCSImages {

	private $mcs_settings_options;

	public function __construct() {
		$this->mcs_settings_options = get_option( 'mcs_settings_option_name' );
		add_action( 'add_attachment', array( $this, 'mcs_function' ) );
	}

	function CallMCS ($host, $path, $key, $data) {

		$headers = "Content-type: application/json\r\n" .
        		"Ocp-Apim-Subscription-Key: $key\r\n";

    		$data = json_encode ($data);
		$options = array (
			'http' => array (
        		'header' => $headers,
        		'method' => 'POST',
        		'content' => $data
        		)
    		);
		$context = stream_context_create ($options);
		$url = urlencode($host . $path);
		$result = file_get_contents ($url, false, $context);
		return $result;
	}


	function mcs_function( $post_id ){
		$host = 'https://'.$this->mcs_settings_options['supported_hosts_1'].'.api.cognitive.microsoft.com';
		$accessKey = $this->mcs_settings_options['subscription_key_2'];
		$path = '/vision/v2.0/describe?maxCandidates=1&language=en';

		$url =  wp_get_attachment_url( $post_id );
			
		$data3 = array ( 'url' => $url);
		
		$result3 = CallMCS($host, $path, $accessKey, $data3);

		$result2Data = json_decode($result3);

		if (!add_post_meta(  $post_id, '_wp_attachment_image_alt', $result2Data->description->captions[0]->text)){
			update_post_meta( $post_id, '_wp_attachment_image_alt', $result2Data->description->captions[0]->text);
		}
	}

}


$mcs_MCSImages = new MCSImages();

