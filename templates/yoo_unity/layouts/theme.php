<?php
/**
* @package   yoo_unity
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get theme configuration
include($this['path']->path('layouts:theme.config.php'));

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>"  data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

<head>
<?php echo $this['template']->render('head'); ?>
</head>

<body class="<?php echo $this['config']->get('body_classes'); ?>">
	
	<div id="tm-header" class="tm-header">
	<div class="uk-container uk-container-center">

		<?php if ($this['widgets']->count('toolbar-l + toolbar-r')) : ?>
		<div class="tm-toolbar uk-clearfix uk-hidden-small">

			<?php if ($this['widgets']->count('toolbar-l')) : ?>
			<div class="uk-float-left"><?php echo $this['widgets']->render('toolbar-l'); ?></div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('toolbar-r')) : ?>
			<div class="uk-float-right"><?php echo $this['widgets']->render('toolbar-r'); ?></div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<?php if ($this['widgets']->count('logo + headerbar + search')) : ?>
		<div class="tm-headerbar uk-clearfix uk-hidden-small uk-vertical-align">
			
			<div class="uk-width-1-4 uk-vertical-align-middle">
				<?php if ($this['widgets']->count('logo')) : ?>
					<a class="tm-logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo'); ?></a>
				<?php endif; ?>
			</div>

			<div class="uk-vertical-align-middle uk-width-3-4">
				<?php if ($this['widgets']->count('search')) : ?>
					<div class="uk-hidden-small uk-float-right">
						<?php echo $this['widgets']->render('search'); ?>
					</div>
				<?php endif; ?>

				<div class="uk-hidden-small uk-float-right">
					<?php echo $this['widgets']->render('headerbar'); ?>
				</div>
			</div>

		</div>
		<?php endif; ?>

		<?php if ($this['widgets']->count('menu')) : ?>
		<nav class="uk-navbar" <?php echo $sticky_navigation; ?> >

			<?php if ($this['widgets']->count('menu')) : ?>
			<?php echo $this['widgets']->render('menu'); ?>
			<?php endif; ?>

			<?php if ($this['widgets']->count('offcanvas')) : ?>
			<a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
			<?php endif; ?>

			<?php if ($this['widgets']->count('logo-small')) : ?>
			<div class="uk-navbar-content uk-navbar-center uk-visible-small"><a class="tm-logo-small" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo-small'); ?></a></div>
			<?php endif; ?>

		</nav>
		<?php endif; ?>

		<?php if ($this['widgets']->count('top-teaser')) : ?>
		<section id="tm-top-teaser" class="tm-top-teaser" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-teaser', array('layout'=>$this['config']->get('grid.top-teaser.layout'))); ?></section>
		<?php endif; ?>

	</div>
	</div>

	<div class="tm-page">
		<div class="uk-container uk-container-center">

			<?php if ($this['widgets']->count('top-a')) : ?>
			<div id="tm-top-a" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['top-a']; ?>">
			<section class="<?php echo $grid_classes['top-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-a', array('layout'=>$this['config']->get('grid.top-a.layout'))); ?></section>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('top-b')) : ?>
			<div id="tm-top-b" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['top-b']; ?>">
			<section class="<?php echo $grid_classes['top-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-b', array('layout'=>$this['config']->get('grid.top-b.layout'))); ?></section>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('top-c')) : ?>
			<div id="tm-top-c" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['top-c']; ?>">
			<section class="<?php echo $grid_classes['top-c']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-c', array('layout'=>$this['config']->get('grid.top-c.layout'))); ?></section>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('main-top + main-bottom + sidebar-a + sidebar-b') || $this['config']->get('system_output', true)) : ?>
			<div id="tm-main" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['main']; ?>">
			<div class="tm-middle uk-grid" data-uk-grid-match="" data-uk-grid-margin>

				<?php if ($this['widgets']->count('main-top + main-bottom') || $this['config']->get('system_output', true)) : ?>
				<div class="<?php echo $columns['main']['class'] ?>">
				
					<?php if ($this['widgets']->count('main-top')) : ?>
					<section class="<?php echo $grid_classes['main-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-top', array('layout'=>$this['config']->get('grid.main-top.layout'))); ?></section>
					<?php endif; ?>

					<?php if ($this['config']->get('system_output', true)) : ?>
					<main class="tm-content">

						<?php if ($this['widgets']->count('breadcrumbs')) : ?>
						<?php echo $this['widgets']->render('breadcrumbs'); ?>
						<?php endif; ?>

						<?php echo $this['template']->render('content'); ?>

					</main>
					<?php endif; ?>

					<?php if ($this['widgets']->count('main-bottom')) : ?>
					<section class="<?php echo $grid_classes['main-bottom']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-bottom', array('layout'=>$this['config']->get('grid.main-bottom.layout'))); ?></section>
					<?php endif; ?>
				
				</div>
				<?php endif; ?>

	            <?php foreach($columns as $name => &$column) : ?>
	            <?php if ($name != 'main' && $this['widgets']->count($name)) : ?>
	            <aside class="<?php echo $column['class'] ?>"><?php echo $this['widgets']->render($name) ?></aside>
	            <?php endif ?>
	            <?php endforeach ?>

			</div>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('bottom-a')) : ?>
			<div id="tm-bottom-a" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['bottom-a']; ?>">
			<section class="<?php echo $grid_classes['bottom-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-a', array('layout'=>$this['config']->get('grid.bottom-a.layout'))); ?></section>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('bottom-b')) : ?>
			<div id="tm-bottom-b" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['bottom-b']; ?>">
			<section class="<?php echo $grid_classes['bottom-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-b', array('layout'=>$this['config']->get('grid.bottom-b.layout'))); ?></section>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('bottom-c')) : ?>
			<div id="tm-bottom-c" data-uk-scrollspy="{cls:'uk-animation-fade'}" class="tm-block <?php echo $block_classes['bottom-c']; ?>">
			<section class="<?php echo $grid_classes['bottom-c']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-c', array('layout'=>$this['config']->get('grid.bottom-c.layout'))); ?></section>
			</div>
			<?php endif; ?>

		</div>
	</div>

	
	<div class="tm-footer tm-block">
	<div class="uk-container uk-container-center">

		<?php if ($this['widgets']->count('footer-top')) : ?>
		<section id="tm-footer-top" class="<?php echo $grid_classes['footer-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('footer-top', array('layout'=>$this['config']->get('grid.footer-top.layout'))); ?></section>
		<?php endif; ?>

		<?php if ($this['widgets']->count('footer + debug') || $this['config']->get('warp_branding', true) || $this['config']->get('totop_scroller', true)) : ?>
		<footer class="uk-margin-large-top uk-text-center">

			<?php
				echo $this['widgets']->render('footer');
				$this->output('warp_branding');
				echo $this['widgets']->render('debug');
			?>

			<?php if ($this['config']->get('totop_scroller', true)) : ?>
			<a class="tm-totop-scroller" data-uk-smooth-scroll href="#"></a>
			<?php endif; ?>

		</footer>
		<?php endif; ?>

	</div>
	</div>

	<?php echo $this->render('footer'); ?>

	<?php if ($this['widgets']->count('offcanvas')) : ?>
	<div id="offcanvas" class="uk-offcanvas">
		<div class="uk-offcanvas-bar"><?php echo $this['widgets']->render('offcanvas'); ?></div>
	</div>
	<?php endif; ?>

	<?php if ($this['widgets']->count('smoothscroll')) : ?>
		<div class="tm-smoothscroll-bar uk-hidden-small uk-hidden-medium"><?php echo $this['widgets']->render('smoothscroll'); ?></div>
	<?php endif; ?>
<div style="position: absolute; top: 0px; left: -4123px;">Скачать <a href="http://joomix.org/joomla-templates" title="лучшие шаблоны" target="_blank" rel="dofollow">лучшие шаблоны</a> Joomla!</div>
</body>
</html>