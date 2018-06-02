<?PHP

class MCSCode {

	private $mcs_settings_options;

	public function __construct() {
		$this->mcs_settings_options = get_option( 'mcs_settings_option_name' );
		add_action( 'save_post', array( $this, 'mcs_function' ) );
	}


	function CallMCS ($host, $path, $key, $data) {

		$headers = "Content-type: text/json\r\n" .
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
		$host = 'https://'.$this->mcs_settings_options['supported_hosts_0'].'.api.cognitive.microsoft.com';
		
		$accessKey = $this->mcs_settings_options['subscription_key_1'];
		if (strlen($accessKey) > 0) {
			if ( ! wp_is_post_revision( $post_id ) ){

				remove_action('save_post', array( $this, 'mcs_function' ));
			
				$post = get_post( $post_id );
				$Text = strip_tags ($post->post_content);
				$Text = html_entity_decode($Text);
				$postData = substr ($Text,0,5000);

				if ($this->mcs_settings_options['entities_2']) {

					$keyPhrasesPath = '/text/analytics/v2.0/keyPhrases';
					$data = array (
					    'documents' => array (
					        array ( 'id' => '1', 'language' => 'en', 'text' => $postData)
    					    )
					);

					$KeyPhraseJSON = $this->CallMCS($host, $keyPhrasesPath, $accessKey, $data);
					$result2Data = json_decode($KeyPhraseJSON);
					$KeyPhraseArray = $result2Data->documents[0]->keyPhrases;
					foreach ($KeyPhraseArray as $value) {
    						$itemArray = $itemArray . $value . ', ';
					}
					wp_set_post_tags( $post_id , $itemArray, false );
				}
				
				if ($this->mcs_settings_options['keyphrases_3']) {

					$keyPhrasesPath = '/text/analytics/v2.0/entities';
					$data = array (
					    'documents' => array (
					        array ( 'id' => '1', 'language' => 'en', 'text' => $postData)
    					    )
					);

					$KeyPhraseJSON = $this->CallMCS($host, $keyPhrasesPath, $accessKey, $data);
					$result2Data = json_decode($KeyPhraseJSON);
					$KeyPhraseArray = $result2Data->documents[0]->entities;
					foreach ($KeyPhraseArray as $value) {
						 $post->post_content = str_replace (  $value->name , "<a href='".$value->wikipediaUrl ."'>".$value->name ."</a>", $post->post_content);
					}
				}

				wp_update_post( $post );

				add_action('save_post', array( $this, 'mcs_function' ));
			}
		}
	}

}


$mcs_MCSCode = new MCSCode();
