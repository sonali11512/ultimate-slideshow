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

        $content ='<div class="container"><div id="slides">';
        foreach ($get_attachments as $attachemnt) {
            $content .= '<img src="'.wp_get_attachment_url($attachemnt).'" alt="">';
        }
        $content .= '<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
      <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a></div></div>';
        return $content;
    }

    public function enqueueScriptsCallback()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui');

        wp_enqueue_style('slideshow', plugins_url('css/slideshow.css', dirname(__FILE__)));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', dirname(__FILE__)));

        wp_register_script('jqueryslides', plugins_url('js/jquery.slides.min.js', dirname(__FILE__)));
        wp_enqueue_script('jqueryslides');

        wp_register_script('slides', plugins_url('js/slides.js', dirname(__FILE__)));
        wp_enqueue_script('slides');
    }
}
