<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Pixelating image slideshow', 'pixelating-image-slideshow-gallery'); ?></h2>
	<h3><?php _e('Widget Setting', 'pixelating-image-slideshow-gallery'); ?></h3>
    <?php
	$pisg_title = get_option('pisg_title');
	$pisg_maxsquare = get_option('pisg_maxsquare');
	$pisg_duration = get_option('pisg_duration');
	$pisg_slidespeed = get_option('pisg_slidespeed');
	$pisg_random = get_option('pisg_random');
	$pisg_type = get_option('pisg_type');
	
	if (isset($_POST['pisg_submit'])) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('pisg_form_setting');
			
		$pisg_title = stripslashes(sanitize_text_field($_POST['pisg_title']));
		$pisg_maxsquare = intval($_POST['pisg_maxsquare']);
		$pisg_duration = intval($_POST['pisg_duration']);
		$pisg_slidespeed = intval($_POST['pisg_slidespeed']);
		$pisg_random = stripslashes(sanitize_text_field($_POST['pisg_random']));
		$pisg_type = stripslashes(sanitize_text_field($_POST['pisg_type']));
		
		if(!is_numeric($pisg_maxsquare) || $pisg_maxsquare == 0) { $pisg_maxsquare = 15; }
		if(!is_numeric($pisg_duration) || $pisg_duration == 0) { $pisg_duration = 1; }
		if(!is_numeric($pisg_slidespeed) || $pisg_slidespeed == 0) { $pisg_slidespeed = 3000; }
		
		update_option('pisg_title', $pisg_title );
		update_option('pisg_maxsquare', $pisg_maxsquare );
		update_option('pisg_duration', $pisg_duration );
		update_option('pisg_slidespeed', $pisg_slidespeed );
		update_option('pisg_random', $pisg_random );
		update_option('pisg_type', $pisg_type );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'pixelating-image-slideshow-gallery'); ?></strong></p>
		</div>
		<?php
	}
	?>
    <form name="pisg_form" method="post" action="">
      
	  <label for="tag-title"><?php _e('Enter widget title', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_title" id="pisg_title" type="text" value="<?php echo $pisg_title; ?>" size="80" />
      <p><?php _e('Enter widget title, Only for widget.', 'pixelating-image-slideshow-gallery'); ?></p>
      
	  <label for="tag-width"><?php _e('Max Square (Only number)', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_maxsquare" id="pisg_maxsquare" type="text" value="<?php echo $pisg_maxsquare; ?>" />
      <p><?php _e('(only number).', 'pixelating-image-slideshow-gallery'); ?> (Example: 15)</p>
      
	  <label for="tag-height"><?php _e('Duration', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_duration" id="pisg_duration" type="text" value="<?php echo $pisg_duration; ?>" />
      <p><?php _e('(only number).', 'pixelating-image-slideshow-gallery'); ?> (Example: 1)</p>
	  
	  <label for="tag-height"><?php _e('Slide Speed', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_slidespeed" id="pisg_slidespeed" type="text" value="<?php echo $pisg_slidespeed; ?>" />
      <p><?php _e('Only Number / Pause time of the slideshow in milliseconds.', 'pixelating-image-slideshow-gallery'); ?></p>
	    
	  <label for="tag-height"><?php _e('Random', 'pixelating-image-slideshow-gallery'); ?></label>
      <input name="pisg_random" id="pisg_random" type="text" value="<?php echo $pisg_random; ?>" />
      <p><?php _e('Enter : YES (or) NO', 'pixelating-image-slideshow-gallery'); ?> (Example: YES)</p>
      
	  <label for="tag-height"><?php _e('Select your gallery group (Gallery  Type)', 'pixelating-image-slideshow-gallery'); ?></label>
	  <select name="pisg_type" id="pisg_type">
	 	<?php
		$selected = "";
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
		foreach ($arrDistinctData as $arrDistinct)
		{
			if(strtoupper($pisg_type) == strtoupper($arrDistinct["pisg_type"]) ) 
			{ 
				$selected = "selected='selected'"; 
			}
			?>
			<option value='<?php echo $arrDistinct["pisg_type"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["pisg_type"]); ?></option>
			<?php
			$selected = "";
		}
		?>
      </select>
      <p><?php _e('This field is to group the images. Select your group name to fetch the images for widget.', 'pixelating-image-slideshow-gallery'); ?></p>
      <br />
	  <input name="pisg_submit" id="pisg_submit" class="button-primary" value="<?php _e('Submit', 'pixelating-image-slideshow-gallery'); ?>" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="pisg_redirect()" value="<?php _e('Cancel', 'pixelating-image-slideshow-gallery'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="pisg_help()" value="<?php _e('Help', 'pixelating-image-slideshow-gallery'); ?>" type="button" />
	  <?php wp_nonce_field('pisg_form_setting'); ?>
    </form>
  </div>
</div>