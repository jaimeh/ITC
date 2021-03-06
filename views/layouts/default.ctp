<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('ProCode:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('style');
		echo $this->Html->css('geshi');
		echo $this->Html->css('jquery-ui-1.8.custom');
		echo $this->Html->script('jquery-1.4.2.min');
		echo $this->Html->script('jquery-ui-1.8.custom.min');
		echo $this->Html->script('procode');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<?php echo $this->element('layouts/header-bar');?>
			<div class="reviewCount"><?php echo $reviewCount; ?><span>Reviews</span></div>
			<h1>ProCode a web based community here to review develper code...</h1>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<div id="tabs"><?php echo $this->element('layouts/navigation')?></div>
		</div>
		<div id="body">
			<div id="sidebar">
				<?php if ($this->params['controller'] == 'sources' && $this->params['action'] == 'view') {
					echo $this->element('reviews/sidebar');
				} ?>
				<?php echo $this->element('layouts/sidebar');?>
			</div>
			<div id="content"><?php echo $content_for_layout; ?></div>
		</div>
		<div id="footer">
			<?php echo $this->element('layouts/footer');?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>

