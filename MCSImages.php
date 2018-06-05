<?PHP

class MCSImages {

	private $mcs_settings_options;

	public function __construct() {
		$this->mcs_settings_options = get_option( 'mcs_settings_option_name' );
		add_action( 'add_attachment', array( $this, 'mcs_function' ) );
	}

	function CallMCS ($host, $path, $key, $data) {

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $host . $path);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		if(curl_error($curl))
		{
    			error_log(curl_error($curl));
		}

		curl_close($curl);


		return $result;
	}


	function mcs_function( $post_id )
	{
		$host = 'https://'.$this->mcs_settings_options['supported_hosts_1'].'.api.cognitive.microsoft.com';
		$accessKey = $this->mcs_settings_options['subscription_key_2'];
		$path = '/vision/v2.0/describe';

		$url =  wp_get_attachment_url( $post_id );
			
		$data3 = "{\"url\":\"".$url."\"}";
		$result3 = $this->CallMCS($host, $path, $accessKey, $data3);

		$result2Data = json_decode($result3);
		if ($result2Data->description->captions[0]->text == "") 
		{
			if (!add_post_meta(  $post_id, '_wp_attachment_image_alt', "unable to retrieve the image description"))
			{
				update_post_meta( $post_id, '_wp_attachment_image_alt', "unable to retrieve the image description");
		}
		else 
		{
			if (!add_post_meta(  $post_id, '_wp_attachment_image_alt', $result2Data->description->captions[0]->text))
			{
				update_post_meta( $post_id, '_wp_attachment_image_alt', $result2Data->description->captions[0]->text);
			}
		}
	}

}
}


$mcs_MCSImages = new MCSImages();

