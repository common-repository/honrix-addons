<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Honrix_Menu')) {
    class Honrix_Menu extends Widget_Base
    {
        public function __construct($data = [], $args = null)
        {
            parent::__construct($data, $args);
            wp_enqueue_style('honrix-menu', plugin_dir_url(__FILE__) . 'css/style.css');

            wp_enqueue_script('honrix-menu',  plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0.0', true);
        }
        public function get_name()
        {
            return 'honrix_menu';
        }

        public function get_title()
        {
            return __('Honrix: Menu', 'honrix-addon');
        }

        public function get_icon()
        {
            return 'eicon-nav-menu';
        }

        public function get_categories()
        {
            return ['honrix-addon'];
        }

        protected function register_controls()
        {

            $this->start_controls_section(
                'layout_section',
                [
                    'label' => __('Layout', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $menus = wp_get_nav_menus();
            $menu_list = array(0 => esc_html__('Select', 'honrix-addon'));

            foreach ($menus as $menu) {
                $menu_list[$menu->term_id] = $menu->name;
            }

            $this->add_responsive_control(
                'menu_list',
                [
                    'label' => esc_html__('Menu', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'devices' => ['desktop', 'mobile'],
                    'default' => 0,
                    'options' => $menu_list,
                ]
            );

            $this->add_responsive_control(
                'menu_align',
                [
                    'label' => esc_html__('Alignment', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'devices' => ['desktop', 'mobile'],
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

            $this->end_controls_section();

            /* menu style */
            $this->start_controls_section(
                'menu_style_section',
                [
                    'label' => esc_html__('Menu', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'menu_bg_color',
                [
                    'label' => esc_html__('Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'menu_accessibility_color',
                [
                    'label' => esc_html__('Accessibility Color', 'honrix-addon'),
                    'description' => esc_html__('Accessibility Color is the color that the user accesses items with the keyboard.', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .hrix-navbar-nav li:focus-within > a' => 'border: 3px solid {{VALUE}} !important',
                        '{{WRAPPER}} .hrix-menu .hrix-navbar-toggler:focus-within' => 'border: 3px solid {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_responsive_control(
                'menu_toggler_color',
                [
                    'label' => esc_html__('Toggle Button Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .hrix-navbar-toggler .icon-bar' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'item_box_shadow',
                [
                    'label' => esc_html__('Box Shadow', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                    // 'devices' => ['desktop', 'tablet'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                    ],
                ]
            );

            $this->end_controls_section();

            /* item style */
            $this->start_controls_section(
                'item_style_section',
                [
                    'label' => esc_html__('Menu Items', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->start_controls_tabs(
                'style_item_color'
            );

            $this->start_controls_tab(
                'item_normal_color_tab',
                [
                    'label' => esc_html__('Normal', 'honrix-addon'),
                ]
            );

            $this->add_responsive_control(
                'item_color',
                [
                    'label' => esc_html__('Items Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_bg_color',
                [
                    'label' => esc_html__('Items Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'item_normal_hover_color_tab',
                [
                    'label' => esc_html__('Hover & Active', 'honrix-addon'),
                ]
            );

            $this->add_responsive_control(
                'item_hover_color',
                [
                    'label' => esc_html__('Items Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .hrix-navbar-nav > li.current_page_item > a' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_bg_hover_color',
                [
                    'label' => esc_html__('Items Hover Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a:hover' => 'background: {{VALUE}}',
                        '{{WRAPPER}} .hrix-navbar-nav > li.current_page_item > a' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_control(
                'd1',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'items_typography',
                    'selector' => '{{WRAPPER}} .hrix-navbar-nav > li > a',

                ]
            );

            $this->add_control(
                'd2',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_responsive_control(
                'items_padding',
                [
                    'label' => esc_html__('Padding', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'items_margin',
                [
                    'label' => esc_html__('Margin', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'd3',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'items_border',
                    'label' => esc_html__('Border', 'honrix-addon'),
                    'devices' => ['desktop', 'tablet'],
                    'selector' => '{{WRAPPER}} .hrix-navbar-nav > li > a',
                ]
            );

            $this->add_responsive_control(
                'items_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-navbar-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            // /* sub menu item style */
            $this->start_controls_section(
                'sub_menu_item_style_section',
                [
                    'label' => esc_html__('Sub Menu Items', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'sub_menu_bg_color',
                [
                    'label' => esc_html__('Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu ul ul' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'd4',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_responsive_control(
                'sub_menu_width',
                [
                    'label' => esc_html__('Width', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'devices' => ['desktop', 'tablet'],
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 250,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu' => 'min-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'd5',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->start_controls_tabs(
                'sub_menu_style_item_color'
            );

            $this->start_controls_tab(
                'sub_menu_item_normal_color_tab',
                [
                    'label' => esc_html__('Normal', 'honrix-addon'),
                ]
            );

            $this->add_responsive_control(
                'sub_menu_item_color',
                [
                    'label' => esc_html__('Items Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'sub_menu_item_bg_color',
                [
                    'label' => esc_html__('Items Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'sub_menu_item_normal_hover_color_tab',
                [
                    'label' => esc_html__('Hover & Active', 'honrix-addon'),
                ]
            );

            $this->add_responsive_control(
                'sub_menu_item_hover_color',
                [
                    'label' => esc_html__('Items Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .hrix-menu .sub-menu li.current_page_item a' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_responsive_control(
                'sub_menu_item_bg_hover_color',
                [
                    'label' => esc_html__('Items Hover Background Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'devices' => ['desktop', 'mobile'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a:hover' => 'background: {{VALUE}}',
                        '{{WRAPPER}} .hrix-menu .sub-menu li.current_page_item a' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_control(
                'd6',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'sub_menu_items_typography',
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a',
                    ]
                ]
            );

            $this->add_control(
                'd7',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_responsive_control(
                'sub_menu_items_padding',
                [
                    'label' => esc_html__('Padding', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'sub_menu_items_margin',
                [
                    'label' => esc_html__('Margin', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'd8',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'sub_menu_items_border',
                    'label' => esc_html__('Border', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .hrix-menu .sub-menu li a',
                ]
            );

            $this->add_responsive_control(
                'sub_menu_items_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'devices' => ['desktop', 'mobile'],
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'd9',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_responsive_control(
                'sub_menu_box_shadow',
                [
                    'label' => esc_html__('Box Shadow', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                    'devices' => ['desktop', 'tablet'],
                    'selectors' => [
                        '{{WRAPPER}} .hrix-menu .sub-menu' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {

            $settings = $this->get_settings_for_display();

            $menu_id = null;
            if (isset($settings['menu_list'])) {
                $menu_id = $settings['menu_list'];
            }
            if (wp_is_mobile()) {
                if (isset($settings['menu_list_mobile'])) {
                    $menu_id = $settings['menu_list_mobile'];
                }
            }

            if (!empty($menu_id) && wp_get_nav_menu_object($menu_id)->count > 0) :
?>
                <section class="section hrix-menu">
                    <nav class="hrix-navbar" focusout="honrix_close_menus(this)">
                        <button class="hrix-navbar-toggler collapsed" type="button" onclick="open_honrix_menu(this)">
                            <span class="icon-bar top-bar"></span>
                            <span class="icon-bar middle-bar"></span>
                            <span class="icon-bar bottom-bar"></span>
                        </button>
                        <div class="hrix-collapse">
                            <?php
                            $menu_align = 'hrix-menu-left';

                            switch ($settings['menu_align']) {
                                case 'left':
                                    $menu_align = 'hrix-menu-left';
                                    break;
                                case 'right':
                                    $menu_align = 'hrix-menu-right';
                                    break;
                                case 'center':
                                    $menu_align = 'hrix-menu-center';
                                    break;
                            }
                            if (wp_is_mobile()) {
                                switch ($settings['menu_align_mobile']) {
                                    case 'left':
                                        $menu_align = 'hrix-menu-left';
                                        break;
                                    case 'right':
                                        $menu_align = 'hrix-menu-right';
                                        break;
                                    case 'center':
                                        $menu_align = 'hrix-menu-center';
                                        break;
                                }
                            }

                            wp_nav_menu(array(
                                'menu'           => wp_get_nav_menu_object($menu_id)->slug,
                                'container'         => 'div',
                                'container_class'   => $menu_align,
                                'menu_class'        => 'hrix-navbar-nav',
                            ));
                            ?>
                        </div>
                    </nav>
                </section>
<?php
            endif;
        }
    }
    Plugin::instance()->widgets_manager->register_widget_type(new Honrix_Menu());
}
