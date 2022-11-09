<?php
/**
 * Plugin Name:     GravityExport Lite
 * Version:         1.11.3
 * Plugin URI:      https://gfexcel.com
 * Description:     Export all Gravity Forms entries to Excel (.xlsx) or CSV via a secret shareable URL.
 * Author:          GravityKit
 * Author URI:      https://www.gravitykit.com/extensions/gravityexport/
 * License:         GPL2
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     gf-entries-in-excel
 * Domain Path:     /languages
 *
 * @package         GFExcel
 */

defined('ABSPATH') or die('No direct access!');

use GFExcel\Action\ActionAwareInterface;
use GFExcel\GFExcel;
use GFExcel\GFExcelAdmin;
use GFExcel\ServiceProvider\AddOnProvider;
use GFExcel\ServiceProvider\BaseServiceProvider;
use League\Container\Container;
use League\Container\ReflectionContainer;

if ( ! defined( 'GFEXCEL_PLUGIN_FILE' ) ) {
	define( 'GFEXCEL_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'GFEXCEL_PLUGIN_VERSION' ) ) {
	define( 'GFEXCEL_PLUGIN_VERSION', '1.11.3' );
}

if ( ! defined( 'GFEXCEL_MIN_PHP_VERSION' ) ) {
	define( 'GFEXCEL_MIN_PHP_VERSION', '7.2' );
}

if ( version_compare( phpversion(), GFEXCEL_MIN_PHP_VERSION, '<' ) ) {
	$show_minimum_php_version_message = function () {
		$message = wpautop( sprintf( esc_html__( 'GravityExport Lite requires PHP %s or newer.', 'gf-entries-in-excel' ), GFEXCEL_MIN_PHP_VERSION ) );
		echo "<div class='error'>$message</div>";
	};

	add_action( 'admin_notices', $show_minimum_php_version_message );

	return;
}

add_action('gform_loaded', static function (): void {
    if (!class_exists('GFForms') || !method_exists('GFForms', 'include_addon_framework')) {
        return;
    }

    load_plugin_textdomain('gf-entries-in-excel', false, basename(__DIR__) . '/languages');
    GFForms::include_addon_framework();
	GFForms::include_feed_addon_framework();

    if (!class_exists('GFExport')) {
        require_once(GFCommon::get_base_path() . '/export.php');
    }

    $autoload = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once($autoload);
    }

    // Start DI container.
    $container = (new Container())
        ->defaultToShared()
        // add internal service provider
        ->addServiceProvider(new BaseServiceProvider())
        ->addServiceProvider(new AddOnProvider())
        // auto wire it up
        ->delegate(new ReflectionContainer());

    // Instantiate add on from container.
    $addon = $container->get(GFExcelAdmin::class);

    // Set instance for Gravity Forms and register the add-on.
    GFExcelAdmin::set_instance($addon);
    GFAddOn::register(GFExcelAdmin::class);

    // Dispatch event including the container.
    do_action('gfexcel_loaded', $container);

    // Start actions
    if ($container->has(ActionAwareInterface::ACTION_TAG)) {
        $container->get(ActionAwareInterface::ACTION_TAG);
    }
    if ($container->has(AddOnProvider::AUTOSTART_TAG)) {
        $container->get(AddOnProvider::AUTOSTART_TAG);
    }

    if (!is_admin()) {
        $container->get(GFExcel::class);
    }
});
