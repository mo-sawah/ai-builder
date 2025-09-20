<?php
/**
 * Plugin Name:       AI Builder
 * Plugin URI:        https://sawahsolutions.com
 * Description:       Generates comprehensive website concepts, including strategy, wireframes, and design recommendations using AI.
 * Version:           1.0.1
 * Author:            Mohamed Sawah
 * Author URI:        https://sawahsolutions.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ai-builder
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define('AI_BUILDER_VERSION', '1.0.1');
define('AI_BUILDER_PATH', plugin_dir_path(__FILE__));
define('AI_BUILDER_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once AI_BUILDER_PATH . 'includes/ajax-handler.php';

class AI_Website_Builder {

    public function __construct() {
        // Register shortcode
        add_shortcode('ai_website_concept_generator', [$this, 'render_shortcode']);
        
        // Register admin menu and settings
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Render the shortcode form and enqueue scripts/styles.
     * This is a more reliable method to ensure assets are loaded.
     */
    public function render_shortcode() {
        // Enqueue scripts and styles directly here
        wp_enqueue_style('ai-builder-tailwind', 'https://cdn.tailwindcss.com', [], null);
        wp_enqueue_style('ai-builder-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap', [], null);
        wp_enqueue_style('ai-builder-style', AI_BUILDER_URL . 'assets/style.css', [], AI_BUILDER_VERSION);
        
        wp_enqueue_script('ai-builder-script', AI_BUILDER_URL . 'assets/script.js', [], AI_BUILDER_VERSION, true);
        
        // Pass data to script
        wp_localize_script('ai-builder-script', 'aiBuilderAjax', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('ai_builder_nonce')
        ]);

        ob_start();
        include(AI_BUILDER_PATH . 'includes/shortcode-form.php');
        return ob_get_clean();
    }
    
    /**
     * Add the admin menu page.
     */
    public function add_admin_menu() {
        add_options_page(
            'AI Builder Settings',
            'AI Builder',
            'manage_options',
            'ai-builder',
            [$this, 'create_settings_page']
        );
    }

    /**
     * Create the settings page HTML.
     */
    public function create_settings_page() {
        ?>
        <div class="wrap">
            <h1>AI Builder Settings</h1>
            <p>Configure your AI provider and API keys below.</p>
            <form method="post" action="options.php">
                <?php
                settings_fields('ai_builder_options_group');
                do_settings_sections('ai-builder');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register plugin settings.
     */
    public function register_settings() {
        register_setting('ai_builder_options_group', 'ai_builder_settings', [$this, 'sanitize_settings']);

        add_settings_section(
            'ai_builder_api_section',
            'API Configuration',
            null,
            'ai-builder'
        );

        add_settings_field(
            'ai_provider',
            'AI Provider',
            [$this, 'render_provider_field'],
            'ai-builder',
            'ai_builder_api_section'
        );
        
        add_settings_field(
            'openai_api_key',
            'OpenAI API Key',
            [$this, 'render_openai_key_field'],
            'ai-builder',
            'ai_builder_api_section'
        );

        add_settings_field(
            'openrouter_api_key',
            'OpenRouter API Key',
            [$this, 'render_openrouter_key_field'],
            'ai-builder',
            'ai_builder_api_section'
        );
    }
    
    /**
     * Sanitize settings fields.
     */
    public function sanitize_settings($input) {
        $sanitized_input = [];
        if (isset($input['ai_provider'])) {
            $sanitized_input['ai_provider'] = sanitize_text_field($input['ai_provider']);
        }
        if (isset($input['openai_api_key'])) {
            $sanitized_input['openai_api_key'] = sanitize_text_field($input['openai_api_key']);
        }
        if (isset($input['openrouter_api_key'])) {
            $sanitized_input['openrouter_api_key'] = sanitize_text_field($input['openrouter_api_key']);
        }
        return $sanitized_input;
    }

    /**
     * Render settings fields.
     */
    public function render_provider_field() {
        $options = get_option('ai_builder_settings');
        ?>
        <select name="ai_builder_settings[ai_provider]" id="ai_provider">
            <option value="openai" <?php selected($options['ai_provider'] ?? 'openai', 'openai'); ?>>OpenAI (gpt-4o-mini)</option>
            <option value="openrouter" <?php selected($options['ai_provider'] ?? '', 'openrouter'); ?>>OpenRouter (Claude 3.5 Sonnet)</option>
        </select>
        <p class="description">Select your preferred AI service provider.</p>
        <?php
    }

    public function render_openai_key_field() {
        $options = get_option('ai_builder_settings');
        ?>
        <input type="password" name="ai_builder_settings[openai_api_key]" value="<?php echo esc_attr($options['openai_api_key'] ?? ''); ?>" class="regular-text">
        <p class="description">Enter your API key for OpenAI.</p>
        <?php
    }

    public function render_openrouter_key_field() {
        $options = get_option('ai_builder_settings');
        ?>
        <input type="password" name="ai_builder_settings[openrouter_api_key]" value="<?php echo esc_attr($options['openrouter_api_key'] ?? ''); ?>" class="regular-text">
         <p class="description">Enter your API key for OpenRouter. Your site URL (<?php echo esc_url(home_url()); ?>) should be added to the "HTTP Referer" allowlist in your OpenRouter settings.</p>
        <?php
    }
}

new AI_Website_Builder();

