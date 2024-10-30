<?php
if (!class_exists('Honrix_Addons_Settings')) {
    class Honrix_Addons_Settings
    {
        private $google_tag_manager = '';
        private $google_analytics = '';
        function __construct()
        {
            $json = get_option('honrix_addons_settings', '');
            if (!empty($json)) {
                $obj = json_decode($json);

                $this->setGoogleTag(isset($obj->google_tag_manager) ? $obj->google_tag_manager : '');
                $this->setGoogleanAlytics(isset($obj->google_analytics) ? $obj->google_analytics : '');
            }
        }

        public function setGoogleTag($google_tag_manager)
        {
            $this->google_tag_manager = esc_attr($google_tag_manager);
        }

        public function getGoogleTag()
        {
            return $this->google_tag_manager;
        }

        public function setGoogleanAlytics($google_analytics)
        {
            $this->google_analytics = esc_attr($google_analytics);
        }

        public function getGoogleAnalytics()
        {
            return $this->google_analytics;
        }

        public function save()
        {
            update_option('honrix_addons_settings', json_encode(get_object_vars($this)));
        }
    }
}
if (!function_exists('honrix_addons_admin_menu')) {
    function honrix_addons_admin_menu()
    {
        add_menu_page(
            __('Honrix Addons', 'honrix-addon'),
            __('Honrix Addons', 'honrix-addon'),
            'manage_options',
            'honrix-addons-settings',
            'honrix_addons_general_contents',
            'dashicons-schedule',
            3
        );
    }
    add_action('admin_menu', 'honrix_addons_admin_menu');
}

if (!function_exists('honrix_addons_general_contents')) {
    function honrix_addons_general_contents()
    {
        $settings = new Honrix_Addons_Settings();

        if (isset($_POST['honrix-addon-google-tag-manager'])) {
            $settings->setGoogleTag($_POST['honrix-addon-google-tag-manager']);
        }

        if (isset($_POST['honrix-addon-google-analytics'])) {
            $settings->setGoogleanAlytics($_POST['honrix-addon-google-analytics']);
        }

        $settings->save();
?>
        <h1>
            <?php esc_html_e('General Settings', 'honrix'); ?>
        </h1>
        <form method="POST" action="">
            <div class="setting">
                <h3><?php esc_html_e('Google Tag Manager ID (GTM-XXXX)', 'honrix'); ?></h3>
                <input type="text" name="honrix-addon-google-tag-manager" value="<?php echo esc_attr($settings->getGoogleTag()); ?>" />
            </div>
            <div class="setting">
                <h3><?php esc_html_e('Google Analytics ID (UA-XXXXX-Y)', 'honrix'); ?></h3>
                <input type="text" name="honrix-addon-google-analytics" value="<?php echo esc_attr($settings->getGoogleAnalytics()); ?>" />
            </div>
            <div class="submit">
                <input type="submit" class="button button-primary" value="<?php esc_html_e('Save Settings', 'honrix'); ?>" />
            </div>
        </form>
<?php
    }
}

if (!function_exists('honrix_addons_general_contents_code')) {
    function honrix_addons_general_contents_code()
    {
        $settings = new Honrix_Addons_Settings();
        $gtm_code = $settings->getGoogleTag();
        if (!empty($gtm_code)) :
            wp_add_inline_script('honrix-addons-script', "
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '" . esc_js($gtm_code) . "');
            ", 'before');
        endif;

        $ga_code = $settings->getGoogleAnalytics();
        if (!empty($ga_code)) :
            wp_add_inline_script('honrix-addons-script', "
            window.ga = window.ga || function() {
                (ga.q = ga.q || []).push(arguments)
            };
            ga.l = +new Date;
            ga('create', '" . esc_js($ga_code) . "', 'auto');
            ga('send', 'pageview');
            ", 'before');
        endif;
    }

    add_action('wp_head', 'honrix_addons_general_contents_code');
}
