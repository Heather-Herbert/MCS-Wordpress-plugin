<?php

class MCSSettings {
	private $mcs_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mcs_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mcs_settings_page_init' ) );
	}

	public function mcs_settings_add_plugin_page() {
		add_menu_page(
			'MCS Settings', // page_title
			'MCS Settings', // menu_title
			'manage_options', // capability
			'mcs-settings', // menu_slug
			array( $this, 'mcs_settings_create_admin_page' ), // function
			'dashicons-screenoptions', // icon_url
			3 // position
		);
	}

	public function mcs_settings_create_admin_page() {
		$this->mcs_settings_options = get_option( 'mcs_settings_option_name' ); ?>

		<div class="wrap">
			<h2>MCS Settings</h2>
			<p>Settings for Microsoft Cognitive Services.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'mcs_settings_option_group' );
					do_settings_sections( 'mcs-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function mcs_settings_page_init() {
		register_setting(
			'mcs_settings_option_group', // option_group
			'mcs_settings_option_name', // option_name
			array( $this, 'mcs_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'mcs_settings_setting_section', // id
			'Settings', // title
			array( $this, 'mcs_settings_section_info' ), // callback
			'mcs-settings-admin' // page
		);

		add_settings_field(
			'supported_hosts_0', // id
			'Supported hosts', // title
			array( $this, 'supported_hosts_0_callback' ), // callback
			'mcs-settings-admin', // page
			'mcs_settings_setting_section' // section
		);

		add_settings_field(
			'subscription_key_1', // id
			'Subscription key', // title
			array( $this, 'subscription_key_1_callback' ), // callback
			'mcs-settings-admin', // page
			'mcs_settings_setting_section' // section
		);

		add_settings_field(
			'entities_2', // id
			'entities', // title
			array( $this, 'entities_2_callback' ), // callback
			'mcs-settings-admin', // page
			'mcs_settings_setting_section' // section
		);

		add_settings_field(
			'keyphrases_3', // id
			'keyPhrases', // title
			array( $this, 'keyphrases_3_callback' ), // callback
			'mcs-settings-admin', // page
			'mcs_settings_setting_section' // section
		);
	}

	public function mcs_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['supported_hosts_0'] ) ) {
			$sanitary_values['supported_hosts_0'] = $input['supported_hosts_0'];
		}

		if ( isset( $input['subscription_key_1'] ) ) {
			$sanitary_values['subscription_key_1'] = sanitize_text_field( $input['subscription_key_1'] );
		}

		if ( isset( $input['entities_2'] ) ) {
			$sanitary_values['entities_2'] = $input['entities_2'];
		}

		if ( isset( $input['keyphrases_3'] ) ) {
			$sanitary_values['keyphrases_3'] = $input['keyphrases_3'];
		}

		return $sanitary_values;
	}

	public function mcs_settings_section_info() {
		
	}

	public function supported_hosts_0_callback() {
		?> <select name="mcs_settings_option_name[supported_hosts_0]" id="supported_hosts_0">
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'westus') ? 'selected' : '' ; ?>
			<option value="westus" <?php echo $selected; ?>>West US</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'westus2') ? 'selected' : '' ; ?>
			<option value="westus2" <?php echo $selected; ?>>West US 2</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'eastus') ? 'selected' : '' ; ?>
			<option value="eastus" <?php echo $selected; ?>>East US</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'eastus2') ? 'selected' : '' ; ?>
			<option value="eastus2" <?php echo $selected; ?>>East US 2</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'westcentralus') ? 'selected' : '' ; ?>
			<option value="westcentralus" <?php echo $selected; ?>>West Central US</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'southcentralus') ? 'selected' : '' ; ?>
			<option value="southcentralus" <?php echo $selected; ?>>South Central US</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'westeurope') ? 'selected' : '' ; ?>
			<option value="westeurope" <?php echo $selected; ?>>West Europe</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'northeurope') ? 'selected' : '' ; ?>
			<option value="northeurope" <?php echo $selected; ?>>North Europe</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'southeastasia') ? 'selected' : '' ; ?>
			<option value="southeastasia" <?php echo $selected; ?>>Southeast Asia</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'eastasia') ? 'selected' : '' ; ?>
			<option value="eastasia" <?php echo $selected; ?>>East Asia</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'australiaeast') ? 'selected' : '' ; ?>
			<option value="australiaeast" <?php echo $selected; ?>>Australia East</option>
			<?php $selected = (isset( $this->mcs_settings_options['supported_hosts_0'] ) && $this->mcs_settings_options['supported_hosts_0'] === 'brazilsouth') ? 'selected' : '' ; ?>
			<option value="brazilsouth" <?php echo $selected; ?>>Brazil South</option>
		</select> <?php
	}

	public function subscription_key_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="mcs_settings_option_name[subscription_key_1]" id="subscription_key_1" value="%s">',
			isset( $this->mcs_settings_options['subscription_key_1'] ) ? esc_attr( $this->mcs_settings_options['subscription_key_1']) : ''
		);
	}

	public function entities_2_callback() {
		printf(
			'<input type="checkbox" name="mcs_settings_option_name[entities_2]" id="entities_2" value="entities_2" %s> <label for="entities_2">Check to generation tags based on the content</label>',
			( isset( $this->mcs_settings_options['entities_2'] ) && $this->mcs_settings_options['entities_2'] === 'entities_2' ) ? 'checked' : ''
		);
	}


	public function keyphrases_3_callback() {
		printf(
			'<input type="checkbox" name="mcs_settings_option_name[keyphrases_3]" id="keyphrases_3" value="keyphrases_3" %s> <label for="keyphrases_3">Check to insert Wikipedia links for key phrases</label>',
			( isset( $this->mcs_settings_options['keyphrases_3'] ) && $this->mcs_settings_options['keyphrases_3'] === 'keyphrases_3' ) ? 'checked' : ''
		);
	}

}

if ( is_admin() )
	$mcs_settings = new MCSSettings();

