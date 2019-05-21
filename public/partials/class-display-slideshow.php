<?php
namespace Wpslide;

class UltimateSlideshow
{
    public function __construct()
    {
        
        add_shortcode('myslideshow', array($this,'myslideshowCallback' ));
        add_action('wp_enqueue_scripts', array($this,'enqueueScriptsCallback'));
    }

    public function myslideshowCallback()
    {
        $get_attachments = get_option('my_slideshow_images', true);

        if (isset($get_attachments) && !empty($get_attachments)) {
            $content ='<div class="expanded row"><div class="slider myslide">';
            foreach ($get_attachments as $attachemnt) {
                $content .= '<div><img src="'.wp_get_attachment_url($attachemnt).'" alt=""></div>';
            }
            $content .= '</div></div>';
        }

        return $content;
    }

    public function enqueueScriptsCallback()
    {
        global $post;
        if (has_shortcode($post->post_content, 'myslideshow')) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui');

            wp_register_style('slickcss', plugins_url('css/slick.css', dirname(__FILE__)));
            wp_enqueue_style('slickcss');

            wp_register_style('slickthemecss', plugins_url('css/slick-theme.css', dirname(__FILE__)));
            wp_enqueue_style('slickthemecss');

            wp_register_style('slideshow', plugins_url('css/slideshow.css', dirname(__FILE__)));
            wp_enqueue_style('slideshow');

            wp_register_script('slickjs', plugins_url('js/slick.min.js', dirname(__FILE__)));
            wp_enqueue_script('slickjs');
            
            wp_register_script('slides', plugins_url('js/slides.js', dirname(__FILE__)), array('slickjs'));
            wp_enqueue_script('slides');
        }
    }
}
