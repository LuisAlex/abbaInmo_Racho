<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if($type == 'logout') : ?>
<form action="index.php" method="post" name="login" id="form-login">
<?php if ($params->get('greeting')) : ?>
	<div>
	<?php if ($params->get('name')) : {
		echo JText::sprintf( 'HINAME', $user->get('name') );
	} else : {
		echo JText::sprintf( 'HINAME', $user->get('username') );
	} endif; ?>
	</div>
<?php endif; ?>
	<div align="center">
		<input type="submit" name="Submit" class="buttonLogin" value="<?php echo JText::_( 'BUTTON_LOGOUT'); ?> +" />
	</div>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php else : ?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var modlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif; ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
	<?php echo $params->get('pretext'); ?>
	<fieldset class="input">
	<p id="form-login-username">
		<input id="modlgn_username" type="text" value="<?php echo JText::_('Username') ?>" name="username" class="inputbox" alt="username" onblur="if(this.value=='') this.value='<?php echo JText::_('Username') ?>';" onfocus="if(this.value=='<?php echo JText::_('Username') ?>') this.value='';" />
	</p>
	<p id="form-login-password">
		<input id="modlgn_passwd" type="password" value="<?php echo JText::_('Password') ?>" name="passwd" class="inputbox" onblur="if(this.value=='') this.value='<?php echo JText::_('Password') ?>';" onfocus="if(this.value=='<?php echo JText::_('Password') ?>') this.value='';" alt="password" />
	</p>
	<p style="text-align:right">
	<input type="submit" name="Submit" class="buttonLogin" value="<?php echo JText::_('LOGIN') ?>" />
	</fieldset>
	<a class="fp-link" href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
	<?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
	<?php
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration')) : ?>
			<a class="re-link" href="<?php echo JRoute::_( 'index.php?option=com_user&view=register' ); ?>">
				<?php echo JText::_('REGISTER'); ?></a>
		<?php endif; ?>
	</p>		
	<?php echo $params->get('posttext'); ?>

	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php endif; ?>