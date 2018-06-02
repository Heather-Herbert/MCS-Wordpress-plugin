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
		$result = file_get_contents ($host . $path, false, $context);
		return $result;
	}


	function mcs_function( $post_id ){
		$host = 'https://'.$this->mcs_settings_options['supported_hosts_1'].'.api.cognitive.microsoft.com';
		$accessKey = $this->mcs_settings_options['subscription_key_2'];
		$path = '/vision/v2.0/describe?maxCandidates=1&language=en';

		$ImageData = wp_get_attachment_metadata( $post_id );
		$url = get_site_url(null, 'wp-content/uploads/' . $ImageData->file, 'https');

		$data3 = array ( 'url' => $url);
		$result3 = GetKeyPhrases ($host, $path, $accessKey, $data3);

		$result2Data = json_decode($result3);
		update_post_meta($attachment_id, '_wp_attachment_image_alt', $result2Data->description->captions[0]->text);
	}

}


$mcs_MCSCode = new MCSCode();
