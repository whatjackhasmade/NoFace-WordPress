<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
  require_once $composer_autoload;
  $timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {
  add_action('admin_notices', function () {
    echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' .
      esc_url(admin_url('plugins.php#timber')) .
      '">' .
      esc_url(admin_url('plugins.php')) .
      '</a></p></div>';
  });

  add_filter('template_include', function ($template) {
    return get_stylesheet_directory() . '/static/no-timber.html';
  });
  return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
  /** Add timber support. */
  public function __construct()
  {
    add_action('init', array($this, 'register_blocks'));
    add_action('init', array($this, 'register_menus'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_taxonomies'));
    add_action('after_setup_theme', array($this, 'theme_supports'));
    add_filter('timber/context', array($this, 'add_to_context'));
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_filter('upload_mimes', array($this, 'cc_mime_types'));
    add_image_size('largest', 2560, '', true); // Largest Desktops
    add_image_size('desktop', 1920, '', true); // Large Desktops
    add_image_size('laptop', 1366, '', true); // Laptops
    add_image_size('tablet', 1024, '', true); // Tablets
    add_image_size('mobile', 640, '', true); // Mobile
    add_image_size('thumbnail-tall', 261, 406.5, true); // Thumbnail Default
    add_image_size('thumbnail-default', 406.5, 261, true); // Thumbnail Default
    add_image_size('thumbnail-small', 200, 200, true); // Thumbnail Default
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    parent::__construct();
  }
  /** This is where you can register custom post types. */
  public function register_post_types()
  {
    register_taxonomy_for_object_type('category', 'case-study');
    register_taxonomy_for_object_type('post_tag', 'case-study');
    register_post_type('case-study', array(
      'labels' => array(
        'name' => __('Case Study', 'case-study'),
        'singular_name' => __('Case Study', 'case-study'),
        'add_new' => __('Add New', 'case-study'),
        'add_new_item' => __('Add New Case Study', 'case-study'),
        'edit' => __('Edit', 'case-study'),
        'edit_item' => __('Edit Case Study', 'case-study'),
        'new_item' => __('New Case Study', 'case-study'),
        'view' => __('View Case Study', 'case-study'),
        'view_item' => __('View Case Study', 'case-study'),
        'search_items' => __('Search Case Study', 'case-study'),
        'not_found' => __('No Case Studys found', 'case-study'),
        'not_found_in_trash' => __(
          'No Case Studys found in Trash',
          'case-study'
        )
      ),
      'public' => true,
      'hierarchical' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-money',
      'can_export' => true,
      'taxonomies' => array('post_tag', 'category')
    ));
  }
  /** This is where you can register custom taxonomies. */
  public function register_taxonomies()
  {
  }

  public function cc_mime_types($mimes)
  {
    $mimes['webp'] = 'image/webp';
    return $mimes;
  }

  public function register_menus()
  {
    register_nav_menus(array(
      'header-menu' => 'Header Menu',
      'footer-menu' => 'Footer Menu',
      'primary' => 'Primary Menu'
    ));
  }

  /** This is where you add some context
   *
   * @param string $context context['this'] Being the Twig's {{ this }}.
   */
  public function add_to_context($context)
  {
    $context['menu'] = new Timber\Menu();
    $context['site'] = $this;
    return $context;
  }

  public function theme_supports()
  {
    if (function_exists('acf_add_options_page')) {
      acf_add_options_page();
    }

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('gallery'));

    add_theme_support('post-formats', array(
      'aside',
      'image',
      'video',
      'link',
      'gallery'
    ));

    add_theme_support('menus');

    add_theme_support('align-wide');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
  }

  /** This is where you can add your own functions to twig.
   *
   * @param string $twig get extension.
   */
  public function add_to_twig($twig)
  {
    $twig->addExtension(new Twig\Extension\StringLoaderExtension());
    return $twig;
  }
}

new StarterSite();
