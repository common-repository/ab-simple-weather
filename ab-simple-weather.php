<?php 
/* 
Plugin Name: AB Simple Weather
Description: A simple but powerful plugin to show current weather in your website
Author: Aboobacker P Ummer
Version: 1.2
*/
register_activation_hook(__FILE__, 'absw_defaults_fn');
add_action('admin_init', 'abswoptions_init_fn' );
add_action('admin_menu', 'abswWeather_setup_menu');
function absw_defaults_fn() {
	$tmp = get_option('absw_plugin_options');
		$arr = array(
            "absw_weather_unit"=>"Celsius", "weather_loc" => "Dubai", "humidity" => "", "country" => "on", "city" => "on", "wind" => "", "weather_icon" =>"on", "condition" =>"", "absw_element" => "div");
		update_option('absw_plugin_options', $arr);
}
function abswoptions_init_fn(){
	register_setting('absw_plugin_options', 'absw_plugin_options', 'absw_plugin_options_validate' );
    add_settings_section('main_section', 'Usage & Settings', 'absw_section_text_fn', __FILE__);
    add_settings_field('weather_loc', 'Location (<i>City or GPS coordinates</i>)', 'absw_setting_string_fn', __FILE__, 'main_section');
    add_settings_field('absw_weather_unit', 'Unit', 'absw_setting_dropdown_fn', __FILE__, 'main_section');
    add_settings_field('absw_element', 'Container Element', 'absw_setting_element_fn', __FILE__, 'main_section');
    add_settings_field('absw_weather_icon', 'Display Weather Icon', 'absw_setting_weather_icon_fn', __FILE__, 'main_section');
    add_settings_field('absw_city', 'Display City/Region', 'absw_setting_city_fn', __FILE__, 'main_section');
    add_settings_field('absw_country', 'Display Country Name', 'absw_setting_country_fn', __FILE__, 'main_section');
    add_settings_field('absw_condition', 'Display Current Condition', 'absw_setting_condition_fn', __FILE__, 'main_section');
    add_settings_field('absw_humidity', 'Display Humidity', 'absw_setting_humidity_fn', __FILE__, 'main_section');
    add_settings_field('absw_wind', 'Display Wind', 'absw_setting_wind_fn', __FILE__, 'main_section');
}
function absw_weather_assets() {
    wp_enqueue_style( 'abWeatherStyle', plugin_dir_url( __FILE__ ).'assets/css/abWeather.css', false ); 
    wp_enqueue_script( 'abWeatherScript', plugin_dir_url( __FILE__ ).'assets/js/jquery.simpleWeather.min.js', 'jQuery', '', true );
}
function enqueue_abswTiny_script($plugin_array){
    $plugin_array["InsertWeather_button"] =  plugin_dir_url(__FILE__) . "assets/js/abTiny.js";
    return $plugin_array;
}
function register_absw_button_editor($buttons){
    array_push($buttons, "InsertWeather");
    return $buttons;
}
add_filter("mce_buttons", "register_absw_button_editor");
add_filter("mce_external_plugins", "enqueue_abswTiny_script");
add_action( 'wp_enqueue_scripts', 'absw_weather_assets' );
function absw_weather_script() { 
    $options = get_option('absw_plugin_options'); ?>
    <script type="text/javascript ">
    //Docs at http://simpleweatherjs.com
    jQuery(document).ready(function() { 
        jQuery.simpleWeather({
            location: '<?php echo $options["weather_loc"];?>',  
            woeid: '',
            unit: '<?php echo $unit = $options["absw_weather_unit"] == 'Celsius' ? 'c' : 'f'; ?>',
            success: function(weather) {
                html = '<<?php echo $options["absw_element"];?> class="abWeatherDisplay">';
                <?php if ( isset($options["weather_icon"] ) && $options['weather_icon'] != '' ) { ?>
                html += '<i class="absicoin_<?php echo $options["absw_element"];?> icon-' + weather.code + '"></i> ';
                <?php } ?>
                html += weather.temp + '&deg;' + weather.units.temp;
                html += '</<?php echo $options["absw_element"];?>>';
                html += '<ul>';
                <?php if ( isset($options["city"] ) && $options["city"] != '' ) { ?>
                html += '<li>' + weather.city + ', ' + weather.region;
                <?php } ?>
                <?php if ( isset($options["country"] ) && $options["country"] != '' ) { ?>
                html += ', ' + weather.country + ' </li>';
                <?php } else  { ?>
                html += ' </li>';
                <?php } ?>
                <?php if ( isset($options["condition"] ) && $options["condition"] != '' ) { ?>
                html += '<li class="currently">' + weather.currently + '</li>';
                <?php } ?>
                <?php if ( isset($options["humidity"] ) && $options["humidity"] != '' ) { ?>
                html += '<li class="humidity">Humidity ' + weather.humidity + '%</li>'; 
                <?php } ?>
                <?php if ( isset($options["wind"] ) && $options["wind"] != '' ) { ?>
                html += '<li>' + weather.wind.direction + ' ' + weather.wind.speed + ' ' + weather.units.speed + '</li>';
                <?php } ?>
                html += '</ul>';

                jQuery("#absWeather").html(html);
            },
            error: function(error) {
                jQuery("#abWeather").html('<p>' + error + '</p>');
            }
        });
    });
</script>
    <?php
}
add_action( 'wp_footer', 'absw_weather_script', 50 );


function abswWeather_setup_menu() {
    add_menu_page( 'AB Weather Settings', 'Simple Weather', 'manage_options', 'abs-weather', 'absw_options_page_fn' );
}
function  absw_section_text_fn() {
	echo "<p>To display the weather in a page or post, add this shortcode to the content area: <strong><code>[abs-weather]</code></strong></p><p>To display the weather in a template use this code: <strong><code> &lt;?php if(function_exists('absWeather')) { echo absWeather(); } ?&gt; </code></strong></p>";
}

function  absw_setting_dropdown_fn() {
	$options = get_option('absw_plugin_options');
	$items = array("Celsius", "Fahrenheit");
	echo "<select id='absw_weather_unit' name='absw_plugin_options[absw_weather_unit]'>";
	foreach($items as $item) {
		$selected = ($options['absw_weather_unit']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}
function  absw_setting_element_fn() {
	$options = get_option('absw_plugin_options');
	$items = array("h2", "h3", "div", "p", "span");
	echo "<select id='absw_element' name='absw_plugin_options[absw_element]'>";
	foreach($items as $item) {
		$selected = ($options['absw_element']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select> <i>Markup setting - decides how the weather to be displayed.</i>";
}
function absw_setting_string_fn() {
	$options = get_option('absw_plugin_options');
	echo "<input id='weather_loc' name='absw_plugin_options[weather_loc]' size='40' type='text' value='{$options['weather_loc']}' /> <input style='display:none;' id='abs_autodetect' type='button' value='&laquo; Autofill GPS coordinates' />";
}
function absw_setting_weather_icon_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['weather_icon'] ) && $options['weather_icon'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_weather_icon' name='absw_plugin_options[weather_icon]' type='checkbox' />";
}
function absw_setting_city_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['city'] ) && $options['city'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_city' name='absw_plugin_options[city]' type='checkbox' />";
}
function absw_setting_country_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['country'] ) && $options['country'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_country' name='absw_plugin_options[country]' type='checkbox' />";
}
function absw_setting_humidity_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['humidity'] ) && $options['humidity'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_humidity' name='absw_plugin_options[humidity]' type='checkbox' />";
}
function absw_setting_condition_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['condition'] ) && $options['condition'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_condition' name='absw_plugin_options[condition]' type='checkbox' />";
}
function absw_setting_wind_fn() {
    $options = get_option('absw_plugin_options');
    isset($options['wind'] ) && $options['wind'] != '' ? $checked = ' checked="checked" ' : $checked =''; 
	echo "<input ".$checked." id='absw_wind' name='absw_plugin_options[wind]' type='checkbox' />";
}
function absw_options_page_fn() { ?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>AB Simple Weather Settings</h2>
		<form action="options.php" method="post">
<?php if ( function_exists('wp_nonce_field') ) 
	wp_nonce_field('ab-simple-weather-action_' . "yep"); ?>
		<?php settings_fields('absw_plugin_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
    </div>
    <script type="text/javascript">
    abs_autodetect
        if ("geolocation" in navigator) {
            jQuery("input#abs_autodetect").show();
            jQuery("input#abs_autodetect").on("click", function(){ 
                function processCoords(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    var absLatlong = document.getElementById('weather_loc');
                    absLatlong.value = `${latitude}, ${longitude}`;
                }
                navigator.geolocation.getCurrentPosition(processCoords);
             });
        }
    </script>
<?php }
function absw_plugin_options_validate($input) {
    $input['weather_loc'] =  wp_filter_nohtml_kses($input['weather_loc']);
    $input['absw_weather_unit'] =  wp_filter_nohtml_kses($input['absw_weather_unit']);	
	return $input;
}
function absWeather(){
    $data = '<div id="absWeather" class="absWeather"></div>';
    return $data;
}
add_shortcode('abs-weather','absWeather');