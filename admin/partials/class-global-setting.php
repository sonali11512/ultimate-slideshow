<?php
namespace Wpslide;

class GlobalSettings
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'wdmAddMenu'));
        add_action('admin_enqueue_scripts', array($this, 'wdmEnqueueCallback'), 10, 1);

        add_action('wp_ajax_saveimages', array($this, 'saveimagesClbk'));
        add_action('wp_ajax_nopriv_saveimages', array($this, 'saveimagesClbk'));
    }

    public function wdmEnqueueCallback()
    {
    
        wp_enqueue_script('jquery');
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_register_script('uploader', plugins_url('js/uploader.js', dirname(__FILE__)), array('jquery','jquery-ui-core','jquery-ui-sortable'));
        wp_enqueue_script('uploader');
        wp_localize_script('uploader', 'uploader_obj', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_style('slideshow', plugins_url('css/ultimateslideshow.css', dirname(__FILE__)));
    }

    /**
     * This adds menu in navigation bar.
     */
    public function wdmAddMenu()
    {
        add_menu_page(
            __('Ultimate Slideshow', 'ultimate-slideshow'),
            __('Ultimate Slideshow', 'ultimate-slideshow'),
            'manage_options',
            'globalsettings',
            array($this, 'globalsettingsCallback')
        );
    }

    public function globalsettingsCallback()
    {
        ?>
        <div class="wrap">
        <form id="uploader" method="post">
        <input type="button" class="button wp_slide_image_upload" name="<?php _e('Select Images', 'ultimate-slideshow'); ?>" value="<?php _e('Select Images', 'ultimate-slideshow'); ?>">
        <input type="submit" name="submit" id="submit" class="save_btn button button-primary" value="Save Changes">
        </form>

        <div class="dx-eig-gallery-row-content" id="gallery">
                <?php
                
                $get_attachments = get_option('my_slideshow_images');
                if (isset($get_attachments) && !empty($get_attachments)) {?>
                <p class="no-images-message" style="display: none;"><?php echo __('Please add images in this gallery', 'ultimate-slideshow');?></p>
                <ul id='sortable1' class="gallery_images">
                    <div class="dx-eig-images sortable ui-sortable">
                    <?php
                    foreach ($get_attachments as $attachemnt) {
                        echo '<li class="image attachment details ui-state-highlight" data-attachment_id="'.$attachemnt.'" data-gallery="'.$gallery_count.'">
                            <div class="attachment-preview">
                                <div class="thumbnail">
                                    '. wp_get_attachment_image($attachemnt, 'thumbnail') . '
                                </div>
                               <a href="#" class="delete_dx_image check" title="Remove Image"><div class="media-modal-icon"></div></a>
                            </div>
                        </li>';
                    }
                    ?>
                    </div>
                    <div class="dx-eig-clear"></div>
                </ul>
                    <?php
                } else {
                    echo '<p class="no-images-message">'. __('Please add images in this gallery', 'ultimate-slideshow') .'</p>';
                }
                ?>
            </div>



    </div>


        <?php
    }

    public function saveimagesClbk()
    {
        if (isset($_POST['ids']) && !empty($_POST['ids'])) {
            $ids = $_POST['ids'];
            update_option('my_slideshow_images', array_unique($ids));
            _e('Images Saved Sucessfully', 'ultimate-slideshow');
        } else {
            _e('Please Select the images', 'ultimate-slideshow');
        }
        die();
    }
}
