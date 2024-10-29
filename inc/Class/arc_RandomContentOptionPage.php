<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 04/01/18
 * Time: 9.34
 */

class arc_RandomContentOptionPage
{
    ############### ATTR #################
    private $options;
    private $hidden_default_post_type = [
        "attachment",
        "revision",
        "nav_menu_item",
        "custom_css",
        "customize_changeset",
        "oembed_cache",
        "wo_client",
        "user_request"
    ];

    private $hidden_woocommerce_post_type = [
        "shop_order",
        "shop_coupon",
        "product_variation",
        "shop_order_refund"
    ];

    ############## METHODS ###############
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_plugin_page']);
        add_action('admin_init', [$this, 'page_init']);
    }

    public function add_plugin_page()
    {
        add_menu_page(
            __('Auto Random Content - Settings', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME),
            __('Auto Random Content', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME),
            'manage_options',
            'random-content-admin',
            array($this, 'create_admin_page'),
            RANDOM_CONTENT_PLUGIN_URL . 'assets/image/logo.jpg'
        );
    }

    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('random_content_option_name');
        ?>
        <div class="wrap">
            <h1 style="margin-bottom:25px;"><?php echo __('Auto Random Content - Settings', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME); ?></h1>
            <?php settings_errors(); ?>
            <form id="auto-random-content-form-option-page" method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('random_content_option_group');
                do_settings_sections('my-setting-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init()
    {
        register_setting(
            'random_content_option_group', // Option group
            'random_content_option_name', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'post_type', // ID
            __("Post Type", RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'post_type_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'post_number', // ID
            __('Number of Random post must be created', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'post_number_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'relate_thumb', // ID
            __("Relate Thumb", RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'relate_thumb_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'relate_term', // ID
            __("Relate Term", RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'relate_term_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'post_taxonomy', // ID
            __("Terms Taxonomy", RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'post_taxonomy_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'relate_comment', // ID
            __("Relate Comment", RANDOM_CONTENT_PLUGIN_DOMAIN_NAME), // Title
            array($this, 'relate_comment_callback'), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );


    }

    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['post_number'])) {
            $new_input['post_number'] = absint($input['post_number']);
        }

        if (isset($input['post_type'])) {
            $new_input['post_type'] = sanitize_text_field($input['post_type']);
        }

        if (isset($input['relate_term'])) {
            $new_input['relate_term'] = sanitize_text_field($input['relate_term']);
        }

        if (isset($input['relate_comment'])) {
            $new_input['relate_comment'] = sanitize_text_field($input['relate_comment']);
        }

        if (isset($input['relate_thumb'])) {
            $new_input['relate_thumb'] = sanitize_text_field($input['relate_thumb']);
        }

        if (isset($input['post_taxonomy'])) {
            $new_input['post_taxonomy'] = sanitize_text_field($input['post_taxonomy']);
        }

        return $new_input;
    }

    public function print_section_info()
    {
        print __('Set information about the randomize content:', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME);
    }

    public function post_number_callback()
    {
        $valore = isset($this->options['post_number']) ? esc_attr($this->options['post_number']) : '';
        echo '<input type="number" max="20" id="post_number" name="random_content_option_name[post_number]" value=' . $valore . '>';
        echo "<p class=\"description\">" . __('Max number of posts created at one time is 20.', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME) . "</p>";
    }

    public function post_type_callback()
    {
        $posts_type = get_post_types();
        $element_dont_show = array_merge($this->hidden_default_post_type, $this->hidden_woocommerce_post_type);

        echo "<select id=\"post_type\" name=\"random_content_option_name[post_type]\">";
        foreach ($posts_type as $post_type) {
            if (!in_array($post_type, $element_dont_show)) {
                if (isset($this->options['post_type']) && $this->options['post_type'] == $post_type) {
                    echo "<option selected value='$post_type' />" . strtoupper($post_type) . "</option>";
                } else {
                    echo "<option value='$post_type' />" . strtoupper($post_type) . "</option>";
                }
            }
        }
        echo "</select>";
    }

    public function post_taxonomy_callback()
    {
        echo "<select id=\"post_taxonomy\" name=\"random_content_option_name[post_taxonomy]\">";
        echo "</select>";
        echo "<p class=\"description\">" . __('The term\'s taxonomy. Example: Category', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME) . "</p>";
    }

    public function relate_thumb_callback()
    {
        if (!empty($this->options['relate_thumb']) && "checked" == $this->options['relate_thumb']) {
            echo "<input value='checked' type='checkbox' checked id=\"relate_thumb\" name=\"random_content_option_name[relate_thumb]\">";
        } else {
            echo "<input value='checked' type='checkbox' id=\"relate_thumb\" name=\"random_content_option_name[relate_thumb]\">";
        }
        echo "<p class=\"description\">" . __('If this is checked the procedure generate and assign one thumb at every post created.', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME) . "</p>";
    }

    public function relate_term_callback()
    {
        if (!empty($this->options['relate_term']) && "checked" == $this->options['relate_term']) {
            echo "<input value='checked' type='checkbox' checked id=\"relate_term\" name=\"random_content_option_name[relate_term]\">";
        } else {
            echo "<input value='checked' type='checkbox' id=\"relate_term\" name=\"random_content_option_name[relate_term]\">";
        }
        echo "<p class=\"description\">" . __('If this is checked the procedure assign a term at every post created.<br>The procedure generate terms too.', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME) . "</p>";
    }

    public function relate_comment_callback()
    {
        if (!empty($this->options['relate_comment']) && "checked" == $this->options['relate_comment']) {
            echo "<input value='checked' type='checkbox' checked id=\"relate_comment\" name=\"random_content_option_name[relate_comment]\">";
        } else {
            echo "<input value='checked' type='checkbox' id=\"relate_comment\" name=\"random_content_option_name[relate_comment]\">";
        }
        echo "<p class=\"description\">" . __('If this is checked the procedure generate some comments at every post created.<br>The procedure generate Users too.', RANDOM_CONTENT_PLUGIN_DOMAIN_NAME) . "</p>";
    }
}


