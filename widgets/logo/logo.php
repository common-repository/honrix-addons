<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Honrix_Site_Logo')) {
    class Honrix_Site_Logo extends Widget_Base
    {
        public function __construct($data = [], $args = null)
        {
            parent::__construct($data, $args);
            wp_enqueue_style('honrix-logo', plugin_dir_url(__FILE__) . 'css/style.css');
        }

        public function get_name()
        {
            return 'honrix_logo';
        }

        public function get_title()
        {
            return __('Honrix: Site Logo', 'honrix-addon');
        }

        public function get_icon()
        {
            return 'eicon-site-logo';
        }

        public function get_categories()
        {
            return ['honrix-addon'];
        }

        protected function register_controls()
        {
            $this->start_controls_section(
                'logo_style_section',
                [
                    'label' => esc_html__('Logo', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'text_align',
                [
                    'label' => esc_html__('Alignment', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'honrix-addon'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'honrix-addon'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'honrix-addon'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'toggle' => true,
                ]
            );

            $this->add_responsive_control(
                'width',
                [
                    'label' => esc_html__('Width', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'tablet_default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'mobile_default' => [
                        'size' => 150,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-logo img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

?>
            <div class="hrix-logo logo-<?php echo esc_attr($settings['text_align']); ?>">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                endif;
                ?>
            </div>
<?php
        }
    }
    Plugin::instance()->widgets_manager->register_widget_type(new Honrix_Site_Logo());
}
