<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Honrix_Team_Member')) {
    class Honrix_Team_Member extends Widget_Base
    {
        public function __construct($data = [], $args = null)
        {
            parent::__construct($data, $args);
            wp_enqueue_style('honrix-member', plugin_dir_url(__FILE__) . 'css/style.css');
        }
        public function get_name()
        {
            return 'honrix_team_member';
        }

        public function get_title()
        {
            return __('Honrix: Team Member', 'honrix-addon');
        }

        public function get_icon()
        {
            return 'eicon-person';
        }

        public function get_categories()
        {
            return ['honrix-addon'];
        }

        protected function register_controls()
        {
            $this->start_controls_section(
                'member_section',
                [
                    'label' => __('Member', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'image',
                [
                    'label' => esc_html__('Choose Image', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'exclude' => [],
                    'include' => [],
                    'default' => 'large',
                ]
            );

            $this->add_control(
                'name',
                [
                    'label' => __('Name', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Name', 'honrix-addon'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title',
                [
                    'label' => __('Title', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Title', 'honrix-addon'),
                    'label_block' => true,
                ]
            );

            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'social_icon',
                [
                    'label' => esc_html__('Social Media Icon', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fab fa-facebook-f',
                        'library' => 'solid',
                    ],
                ]
            );

            $repeater->add_control(
                'social_link',
                [
                    'label' => esc_html__('Link', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => esc_html__('#', 'honrix-addon'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'social_list',
                [
                    'label' => esc_html__('Social Media Items', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'social_icon' => 'fab fa-facebook-f',
                            'social_link' => '#',
                        ],
                    ],
                ]
            );

            $this->end_controls_section();

            /* style */
            $this->start_controls_section(
                'layout_style_section',
                [
                    'label' => esc_html__('Layout', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'layout_align',
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
                    'default' => 'center',
                    'toggle' => true,
                ]
            );
            $this->end_controls_section();

            /* image style */
            $this->start_controls_section(
                'image_style_section',
                [
                    'label' => esc_html__('Image', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'animation_style',
                [
                    'label' => esc_html__('Animation', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'  => esc_html__('None', 'honrix-addon'),
                        'rotate'  => esc_html__('Rotate', 'honrix-addon'),
                        'zoom' => esc_html__('Zoom', 'honrix-addon'),
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'image_border',
                    'label' => esc_html__('Border', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .avatar',
                ]
            );

            $this->add_control(
                'image_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'image_box_shadow',
                    'label' => esc_html__('Box Shadow', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .avatar',
                ]
            );

            $this->end_controls_section();

            /* name style */
            $this->start_controls_section(
                'name_style_section',
                [
                    'label' => esc_html__('Name', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'name_align',
                [
                    'label' => esc_html__('Alignment', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Left', 'honrix-addon'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'honrix-addon'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('Right', 'honrix-addon'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );

            $this->add_control(
                'name_color',
                [
                    'label' => esc_html__('Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .name' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => esc_html__('Typography', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .name',
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'name_text_shadow',
                    'label' => esc_html__('Text Shadow', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .name',
                ]
            );

            $this->add_control(
                'name_padding',
                [
                    'label' => esc_html__('Padding', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'name_margin',
                [
                    'label' => esc_html__('Margin', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'title_style_section',
                [
                    'label' => esc_html__('Title', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'title_align',
                [
                    'label' => esc_html__('Alignment', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Left', 'honrix-addon'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'honrix-addon'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('Right', 'honrix-addon'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Typography', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .title',
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'title_text_shadow',
                    'label' => esc_html__('Text Shadow', 'honrix-addon'),
                    'selector' => '{{WRAPPER}} .honrix-team-member .title',
                ]
            );

            $this->add_control(
                'title_padding',
                [
                    'label' => esc_html__('Padding', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'title_margin',
                [
                    'label' => esc_html__('Margin', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            /* social style */
            $this->start_controls_section(
                'social_style_section',
                [
                    'label' => esc_html__('Social Media', 'honrix-addon'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'social_align',
                [
                    'label' => esc_html__('Alignment', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'start' => [
                            'title' => esc_html__('Left', 'honrix-addon'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'honrix-addon'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__('Right', 'honrix-addon'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );

            $this->add_control(
                'social_style_border',
                [
                    'label' => esc_html__('Border Style', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'circle',
                    'options' => [
                        'circle'  => esc_html__('Circle', 'honrix-addon'),
                        'square' => esc_html__('Square', 'honrix-addon'),
                    ],
                ]
            );

            $this->add_control(
                'social_size',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Size', 'honrix-addon'),
                    'size_units' => ['px', 'em', 'rem'],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'rem',
                        'size' => 1.2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .social-media a' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->start_controls_tabs(
                'style_social_color'
            );

            $this->start_controls_tab(
                'social_normal_color_tab',
                [
                    'label' => esc_html__('Normal', 'honrix-addon'),
                ]
            );

            $this->add_control(
                'social_color',
                [
                    'label' => esc_html__('Icon Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .social-media a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'social_bg_color',
                    'label' => esc_html__('Background', 'honrix-addon'),
                    'types' => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .honrix-team-member .social-media a',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'social_hover_color_tab',
                [
                    'label' => esc_html__('Hover', 'honrix-addon'),
                ]
            );

            $this->add_control(
                'social_bg_color',
                [
                    'label' => esc_html__('Icon Color', 'honrix-addon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .honrix-team-member .social-media a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'social_bg_hover_color',
                    'label' => esc_html__('Background', 'honrix-addon'),
                    'types' => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .honrix-team-member .social-media a:hover',
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->end_controls_section();
        }

        protected function render()
        {

            $settings = $this->get_settings_for_display();
            $animation = $settings['animation_style'];
?>
            <section class="section">
                <div class="honrix-team-member honrix-<?php echo esc_attr($settings['layout_align']); ?> honrix-animation-<?php echo esc_attr($animation); ?>">
                    <div class="avatar-social">
                        <div class="avatar">
                            <?php
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
                            ?>
                        </div>
                        <?php if ($settings['social_list']) : ?>
                            <div class="social-media" style="<?php echo esc_attr('justify-content:' . $settings['social_align']); ?>">
                                <?php
                                $delay = 0;
                                ?>
                                <?php foreach ($settings['social_list'] as $item) : ?>
                                    <a href="<?php echo esc_url($item['social_link']['url']); ?>" target="_blank" class="<?php echo esc_html($settings['social_style_border'] == 'circle' ? 'rounded-circle' : 'rounded-square'); ?>" style="-webkit-transition-delay: <?php echo $delay += 0.1; ?>s;transition-delay: <?php echo $delay; ?>s;">
                                        <?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($settings['name'])) : ?>
                        <h3 class="name" style="<?php echo esc_attr('justify-content:' . $settings['name_align']); ?>">
                            <?php echo esc_html($settings['name']); ?>
                        </h3>
                    <?php endif; ?>
                    <?php if (isset($settings['title'])) : ?>
                        <span class="title" style="<?php echo esc_attr('justify-content:' . $settings['title_align']); ?>">
                            <?php echo esc_html($settings['title']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </section>
<?php
        }
    }
    Plugin::instance()->widgets_manager->register_widget_type(new Honrix_Team_Member());
}
