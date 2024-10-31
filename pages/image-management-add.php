<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$pisg_errors = array();
$pisg_success = '';
$pisg_error_found = FALSE;

// Preset the form fields
$form = array(
	'pisg_path' => '',
	'pisg_link' => '',
	'pisg_target' => '',
	'pisg_title' => '',
	'pisg_order' => '',
	'pisg_status' => '',
	'pisg_type' => ''
);

// Form submitted, check the data
if (isset($_POST['pisg_form_submit']) && $_POST['pisg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('pisg_form_add');
	
	$form['pisg_path'] = isset($_POST['pisg_path']) ? esc_url_raw($_POST['pisg_path']) : '';
	if ($form['pisg_path'] == '')
	{
		$pisg_errors[] = __('Please enter the image path.', 'pixelating-image-slideshow-gallery');
		$pisg_error_found = TRUE;
	}

	$form['pisg_link'] = isset($_POST['pisg_link']) ? esc_url_raw($_POST['pisg_link']) : '';
	if ($form['pisg_link'] == '')
	{
		$pisg_errors[] = __('Please enter the target link.', 'pixelating-image-slideshow-gallery');
		$pisg_error_found = TRUE;
	}
	
	$form['pisg_target'] = isset($_POST['pisg_target']) ? sanitize_text_field($_POST['pisg_target']) : '';
	if($form['pisg_target'] != "_blank" && $form['pisg_target'] != "_parent" && $form['pisg_target'] != "_self" && $form['pisg_target'] != "_new")
	{
		$form['pisg_target'] = "_blank";
	}
	
	$form['pisg_title'] = ""; // isset($_POST['pisg_title']) ? $_POST['pisg_title'] : '';
	
	$form['pisg_order'] = isset($_POST['pisg_order']) ? sanitize_text_field($_POST['pisg_order']) : '';
	if(!is_numeric($form['pisg_order'])) { $form['pisg_order'] = 1; }
	
	$form['pisg_status'] = isset($_POST['pisg_status']) ? sanitize_text_field($_POST['pisg_status']) : '';
	if($form['pisg_status'] != "YES" && $form['pisg_status'] != "NO")
	{
		$form['pisg_status'] = "YES";
	}
	
	$form['pisg_type'] = isset($_POST['pisg_type']) ? sanitize_text_field($_POST['pisg_type']) : '';

	//	No errors found, we can add this Group to the table
	if ($pisg_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_pisg_TABLE."`
			(`pisg_path`, `pisg_link`, `pisg_target`, `pisg_title`, `pisg_order`, `pisg_status`, `pisg_type`)
			VALUES(%s, %s, %s, %s, %d, %s, %s)",
			array($form['pisg_path'], $form['pisg_link'], $form['pisg_target'], $form['pisg_title'], $form['pisg_order'], $form['pisg_status'], $form['pisg_type'])
		);
		$wpdb->query($sql);
		
		$pisg_success = __('New image details was successfully added.', 'pixelating-image-slideshow-gallery');
		
		// Reset the form fields
		$form = array(
			'pisg_path' => '',
			'pisg_link' => '',
			'pisg_target' => '',
			'pisg_title' => '',
			'pisg_order' => '',
			'pisg_status' => '',
			'pisg_type' => ''
		);
	}
}

if ($pisg_error_found == TRUE && isset($pisg_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $pisg_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($pisg_error_found == FALSE && strlen($pisg_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $pisg_success; ?> <a href="<?php echo WP_pisg_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'pixelating-image-slideshow-gallery'); ?></a></strong></p>
	  </div>
	  <?php
	}
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var img_imageurl = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#pisg_path').val(img_imageurl);
        });
    });
});
</script>
<?php
wp_enqueue_script('jquery'); // jQuery
wp_enqueue_media(); // This will enqueue the Media Uploader script
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Pixelating image slideshow', 'pixelating-image-slideshow-gallery'); ?></h2>
	<form name="pisg_form" method="post" action="#" onsubmit="return pisg_submit()"  >
      <h3><?php _e('Add new image details', 'pixelating-image-slideshow-gallery'); ?></h3>
      <label for="tag-image"><?php _e('Enter image path (URL)', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_path" type="text" id="pisg_path" value="" size="80" />
	  <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
      <p><?php _e('Where is the picture located on the internet', 'pixelating-image-slideshow-gallery'); ?> 
	  (ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg)</p>
      <label for="tag-link"><?php _e('Enter target link', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_link" type="text" id="pisg_link" value="#" size="80" />
      <p><?php _e('When someone clicks on the picture, where do you want to send them', 'pixelating-image-slideshow-gallery'); ?></p>
      <label for="tag-target"><?php _e('Select target option', 'pixelating-image-slideshow-gallery'); ?></label>
      <select name="pisg_target" id="pisg_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p><?php _e('Do you want to open link in new window?', 'pixelating-image-slideshow-gallery'); ?></p>
      <!--<label for="tag-title">Enter image reference</label>
      <input name="pisg_title" type="text" id="pisg_title" value="" size="125" />
      <p>Enter image reference. This is only for reference.</p>-->
      <label for="tag-select-gallery-group"><?php _e('Select gallery type/group', 'pixelating-image-slideshow-gallery'); ?></label>
		<select name="pisg_type" id="pisg_type">
		<?php
		$sSql = "SELECT distinct(pisg_type) as pisg_type FROM `".WP_pisg_TABLE."` order by pisg_type, pisg_order";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["pisg_type"] = strtoupper($DistinctData['pisg_type']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["pisg_type"] = "GROUP" . $j;
		}
		$arrDistinctData[$j+1]["pisg_type"] = "WIDGET";
		$arrDistinctData[$j+2]["pisg_type"] = "SAMPLE";
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo $arrDistinct["pisg_type"]; ?>'><?php echo $arrDistinct["pisg_type"]; ?></option><?php
		}
		?>
		</select>
      <p><?php _e('This is to group the images. Select your slideshow group.', 'pixelating-image-slideshow-gallery'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'pixelating-image-slideshow-gallery'); ?></label>
      <select name="pisg_status" id="pisg_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p><?php _e('Do you want the picture to show in your galler?', 'pixelating-image-slideshow-gallery'); ?></p>
      <label for="tag-display-order"><?php _e('Display order', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_order" type="text" id="pisg_order" size="10" value="1" maxlength="3" />
      <p><?php _e('What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.', 'pixelating-image-slideshow-gallery'); ?></p>
      <input name="pisg_id" id="pisg_id" type="hidden" value="">
      <input type="hidden" name="pisg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="<?php _e('Insert Details', 'pixelating-image-slideshow-gallery'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="pisg_redirect()" value="<?php _e('Cancel', 'pixelating-image-slideshow-gallery'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="pisg_help()" value="<?php _e('Help', 'pixelating-image-slideshow-gallery'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('pisg_form_add'); ?>
    </form>
</div>
</div>