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

// If there are errors, we display them
if (!empty($errors)) {
    ?>
<div id="posterror" class="block">
	<h2><span><?php _e('Registration errors') ?></span></h2>
	<div class="box">
		<div class="inbox error-info">
			<p><?php _e('Registration errors info') ?></p>
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

}
?>
<div id="regform" class="blockform">
	<h2><span><?php _e('Register') ?></span></h2>
	<div class="box">
		<form id="register" method="post" action="" onsubmit="this.register.disabled=true;if(process_form(this)){return true;}else{this.register.disabled=false;return false;}">
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<div class="inform">
				<div class="forminfo">
					<h3><?php _e('Important information') ?></h3>
					<p><?php _e('Desc 1') ?></p>
					<p><?php _e('Desc 2') ?></p>
				</div>
				<fieldset>
					<legend><?php _e('Username legend') ?></legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<input type="hidden" name="username" value="" />
						<input type="hidden" name="password" value="" />
						<label class="required"><strong><?php _e('Username') ?> <span><?php _e('Required') ?></span></strong><br /><input type="text" name="req_user" value="<?php if ($feather->request->post('req_user')) {
    echo feather_escape($feather->request->post('req_user'));
} ?>" size="25" maxlength="25" /><br /></label>
					</div>
				</fieldset>
			</div>
<?php if ($feather_config['o_regs_verify'] == '0'): ?>			<div class="inform">
				<fieldset>
					<legend><?php _e('Pass legend') ?></legend>
					<div class="infldset">
						<label class="conl required"><strong><?php _e('Password') ?> <span><?php _e('Required') ?></span></strong><br /><input type="password" name="req_password1" value="<?php if ($feather->request->post('req_password1')) {
    echo feather_escape($feather->request->post('req_password1'));
} ?>" size="16" /><br /></label>
						<label class="conl required"><strong><?php _e('Confirm pass') ?> <span><?php _e('Required') ?></span></strong><br /><input type="password" name="req_password2" value="<?php if ($feather->request->post('req_password2')) {
    echo feather_escape($feather->request->post('req_password2'));
} ?>" size="16" /><br /></label>
						<p class="clearb"><?php _e('Pass info') ?></p>
					</div>
				</fieldset>
			</div>
<?php endif; ?>			<div class="inform">
				<fieldset>
					<legend><?php echo($feather_config['o_regs_verify'] == '1') ? __('Email legend 2') : __('Email legend') ?></legend>
					<div class="infldset">
<?php if ($feather_config['o_regs_verify'] == '1'): ?>						<p><?php _e('Email info') ?></p>
<?php endif; ?>						<label class="required"><strong><?php _e('Email') ?> <span><?php _e('Required') ?></span></strong><br />
						<input type="text" name="req_email1" value="<?php if ($feather->request->post('req_email1')) {
    echo feather_escape($feather->request->post('req_email1'));
} ?>" size="50" maxlength="80" /><br /></label>
<?php if ($feather_config['o_regs_verify'] == '1'): ?>						<label class="required"><strong><?php _e('Confirm email') ?> <span><?php _e('Required') ?></span></strong><br />
						<input type="text" name="req_email2" value="<?php if ($feather->request->post('req_email2')) {
    echo feather_escape($feather->request->post('req_email2'));
} ?>" size="50" maxlength="80" /><br /></label>
<?php endif; ?>					</div>
				</fieldset>
			</div>
<?php
        // Only display the language selection box if there's more than one language available
        if (count($languages) > 1) {
            ?>
			<div class="inform">
				<fieldset>
					<legend><?php _e('Localisation legend') ?></legend>
					<div class="infldset">
							<label><?php _e('Language') ?>
							<br /><select name="language">
<?php

            foreach ($languages as $temp) {
                if ($feather_config['o_default_lang'] == $temp) {
                    echo "\t\t\t\t\t\t\t\t".'<option value="'.$temp.'" selected="selected">'.$temp.'</option>'."\n";
                } else {
                    echo "\t\t\t\t\t\t\t\t".'<option value="'.$temp.'">'.$temp.'</option>'."\n";
                }
            }

            ?>
							</select>
							<br /></label>
					</div>
				</fieldset>
			</div>
<?php

        }
?>
			<div class="inform">
				<fieldset>
					<legend><?php _e('Robot title') ?></legend>
					<div class="infldset">
						<p><?php _e('Robot info')    ?></p>
						<label class="required"><strong><?php echo sprintf(__('Robot question'), $question[$index_questions]) ?> <span><?php _e('Required') ?></span></strong><br /><input name="captcha" id="captcha" type="text" size="10" maxlength="30" /><input name="captcha_q" value="<?php echo $qencoded ?>" type="hidden" /></label>
					</div>
				</fieldset>
			</div>
			<p class="buttons"><input type="submit" name="register" value="<?php _e('Register') ?>" /></p>
		</form>
	</div>
</div>