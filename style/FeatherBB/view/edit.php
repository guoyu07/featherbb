<?php

/**
 * Copyright (C) 2015 FeatherBB
 * based on code by (C) 2008-2012 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */
 
// Make sure no one attempts to run this script "directly"
if (!defined('FEATHER')) {
    exit;
}

$cur_index = 1;

?>

<div class="linkst">
	<div class="inbox">
		<ul class="crumbs">
			<li><a href="<?php echo get_base_url() ?>"><?php echo __('Index') ?></a></li>
			<li><span>»&#160;</span><a href="<?php echo get_link('forum/'.$cur_post['fid'].'/'.url_friendly($cur_post['forum_name']).'/') ?>"><?php echo feather_escape($cur_post['forum_name']) ?></a></li>
			<li><span>»&#160;</span><a href="<?php echo get_link('topic/'.$cur_post['tid'].'/'.url_friendly($cur_post['subject']).'/') ?>"><?php echo feather_escape($cur_post['subject']) ?></a></li>
			<li><span>»&#160;</span><strong><?php echo __('Edit post') ?></strong></li>
		</ul>
	</div>
</div>

<?php

// If there are errors, we display them
if (!empty($errors)) :
?>
<div id="posterror" class="block">
	<h2><span><?php echo __('Post errors') ?></span></h2>
	<div class="box">
		<div class="inbox error-info">
			<p><?php echo __('Post errors info') ?></p>
			<ul class="error-list">
<?php
    foreach ($errors as $cur_error) {
        echo "\t\t\t\t".'<li><strong>'.$cur_error.'</strong></li>'."\n";
    }
?>
			</ul>
		</div>
	</div>
</div>
<?php
elseif ($feather->request->post('preview')):
?>
<div id="postpreview" class="blockpost">
	<h2><span><?php echo __('Post preview') ?></span></h2>
	<div class="box">
		<div class="inbox">
			<div class="postbody">
				<div class="postright">
					<div class="postmsg">
						<?php echo $preview_message."\n" ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
endif;
?>
<!-- Init BBcode editor toolbar -->
<?php $lang_bbeditor = ''; ?>
<script>
    var baseUrl = '<?php echo feather_escape(get_base_url(true)); ?>',
        langBbeditor = JSON.parse('<?= json_encode($lang_bbeditor); ?>');
</script>
<script src="<?php echo get_base_url() ?>/js/bbeditor.js"></script>
<div id="editform" class="blockform">
	<h2><span><?php echo __('Edit post') ?></span></h2>
	<div class="box">
		<form id="edit" method="post" action="<?php echo get_link('edit/'.$id.'/') ?>" onsubmit="return process_form(this)">
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<div class="inform">
				<fieldset>
					<legend><?php echo __('Edit post legend') ?></legend>
					<input type="hidden" name="form_sent" value="1" />
					<div class="infldset txtarea">
<?php if ($can_edit_subject): ?>						<label class="required"><strong><?php echo __('Subject') ?> <span><?php echo __('Required') ?></span></strong><br />
						<input class="longinput" type="text" name="req_subject" size="80" maxlength="70" tabindex="<?php echo $cur_index++ ?>" value="<?php echo feather_escape($feather->request->post('req_subject') ? $feather->request->post('req_subject') : $cur_post['subject']) ?>" /><br /></label>
<?php endif; ?>						<label class="required"><strong><?php echo __('Message') ?> <span><?php echo __('Required') ?></span></strong><br />
						<script>postEditorToolbar('req_message');</script>
                        <textarea name="req_message" id="req_message" rows="20" cols="95" tabindex="<?php echo $cur_index++ ?>"><?php echo feather_escape($feather->request->post('req_message') ? $post['message'] : $cur_post['message']) ?></textarea><br /></label>
						<ul class="bblinks">
							<li><span><a href="<?php echo get_link('help/#bbcode') ?>" onclick="window.open(this.href); return false;"><?php echo __('BBCode') ?></a> <?php echo($feather_config['p_message_bbcode'] == '1') ? __('on') : __('off'); ?></span></li>
							<li><span><a href="<?php echo get_link('help/#url') ?>" onclick="window.open(this.href); return false;"><?php echo __('url tag') ?></a> <?php echo($feather_config['p_message_bbcode'] == '1' && $feather->user->g_post_links == '1') ? __('on') : __('off'); ?></span></li>
							<li><span><a href="<?php echo get_link('help/#img') ?>" onclick="window.open(this.href); return false;"><?php echo __('img tag') ?></a> <?php echo($feather_config['p_message_bbcode'] == '1' && $feather_config['p_message_img_tag'] == '1') ? __('on') : __('off'); ?></span></li>
							<li><span><a href="<?php echo get_link('help/#smilies') ?>" onclick="window.open(this.href); return false;"><?php echo __('Smilies') ?></a> <?php echo($feather_config['o_smilies'] == '1') ? __('on') : __('off'); ?></span></li>
						</ul>
					</div>
				</fieldset>
			</div>
<?php
if (!empty($checkboxes)):
?>
			<div class="inform">
				<fieldset>
					<legend><?php echo __('Options') ?></legend>
					<div class="infldset">
						<div class="rbox">
							<?php echo implode("\n\t\t\t\t\t\t\t", $checkboxes)."\n" ?>
						</div>
					</div>
				</fieldset>
			</div>
<?php
endif;
?>
			<p class="buttons"><input type="submit" name="submit" value="<?php echo __('Submit') ?>" tabindex="<?php echo $cur_index++ ?>" accesskey="s" /> <input type="submit" name="preview" value="<?php echo __('Preview') ?>" tabindex="<?php echo $cur_index++ ?>" accesskey="p" /> <a href="javascript:history.go(-1)"><?php echo __('Go back') ?></a></p>
		</form>
	</div>
</div>