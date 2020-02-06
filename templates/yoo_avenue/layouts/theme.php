<?php
/**
* @package   yoo_avenue
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
<!--AdSense-->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-1657686926357883",
          enable_page_level_ads: true
     });
</script>
<!--AdSense-->


<?php // <!-- viboom --> ?>
<?php // <!--  Rotator --> ?>
<!--<script type='text/javascript' id="s-5c660a5ba3788f9e">!function(t,e,n,o,a,c,s){t[a]=t[a]||function(){(t[a].q=t[a].q||[]).push(arguments)},t[a].l=1*new Date,c=e.createElement(n),s=e.getElementsByTagName(n)[0],c.async=1,c.src=o,s.parentNode.insertBefore(c,s)}(window,document,"script","//aurabom.ru/player/","vbm"); vbm('get', {"platformId":101348,"format":2,"align":"top","width":"640","height":"390","sig":"5c660a5ba3788f9e"});</script>-->
<?php // <!-- Overrol  --> ?>
<script type='text/javascript' id="s-0b5526a5a316e01c">!function(t,e,n,o,a,c,s){t[a]=t[a]||function(){(t[a].q=t[a].q||[]).push(arguments)},t[a].l=1*new Date,c=e.createElement(n),s=e.getElementsByTagName(n)[0],c.async=1,c.src=o,s.parentNode.insertBefore(c,s)}(window,document,"script","//aurabom.ru/player/","vbm"); vbm('get', {"platformId":101348,"format":3,"overrollType":"embeded","sig":"0b5526a5a316e01c"});</script>

<?php // <!-- viboom end--> ?>

<?php // <!-- videoseed --> ?>
<!--script type='text/javascript' id='s-181e74d815ce191104468128faeca83d'>(function() { var s = document.getElementById('s-181e74d815ce191104468128faeca83d'); s.id = +new Date()+Math.floor(Math.random()*1000)+'-vseed'; var v = document.createElement('script'); v.type = 'text/javascript'; v.async = true; v.src = 'https://ytimgg.com/oO/rotator?align=1&height=0&width=0&key=181e74d815ce191104468128faeca83d&adaptive=1&pid=52616&tmpv=7b43e8f4dc6de9801d24e9f8d6aa0fd8&tmpt=5&tmpo=1&csid='+s.id; v.charset = 'utf-8'; s.parentNode.insertBefore(v, s); })(); </script-->
<?php // <!-- videoseed end--> ?>
</head>

<body class="<?php echo $this['config']->get('body_classes'); ?>">
    <div class="page-bg">
    <div class="tm-page-bg">

        <div class="uk-container uk-container-center">

            <div class="tm-container">

                                <?php if ($this['widgets']->count('video_add_banner')) : ?>
                                    <div class="video_add_banner">
                                        <?php echo $this['widgets']->render('video_add_banner'); ?>
                                    </div>
                                <?php endif; ?>


<!--	            --><?php //if ($this['modules']->count('video_add_banner')) : ?>
<!--                    <div id="video_add_banner">--><?php //echo $this['modules']->render('video_add_banner'); ?><!--</div>-->
<!--	            --><?php //endif;  ?>

                <?php if ($this['widgets']->count('logo + search + headerbar')) : ?>
                <div class="tm-headerbar uk-clearfix uk-hidden-small">

                    <?php if ($this['widgets']->count('logo')) : ?>
                    <a class="tm-logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo'); ?></a>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('search')) : ?>
                    <div class="tm-search uk-float-right">
                        <?php echo $this['widgets']->render('search'); ?>
                    </div>
                    <?php endif; ?>

                    <?php echo $this['widgets']->render('headerbar'); ?>

                </div>
                <?php endif; ?>

                <?php if ($this['widgets']->count('menu + toolbar-l + toolbar-r')) : ?>
                <div class="tm-top-block tm-grid-block">

                    <?php if ($this['widgets']->count('menu')) : ?>
                    <nav class="tm-navbar uk-navbar">

                        <?php if ($this['widgets']->count('menu')) : ?>
                        <?php echo $this['widgets']->render('menu'); ?>
                        <?php endif; ?>
                        
						<?php if ($this['widgets']->count('search-menu')) : ?>
						<div id="search"><?php echo $this['widgets']->render('search-menu'); ?></div>
						<?php endif; ?>    
                        
                        <?php if ($this['widgets']->count('offcanvas')) : ?>
                        <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                        <?php endif; ?>

                        <?php if ($this['widgets']->count('logo-small')) : ?>
                        <div class="uk-navbar-content uk-navbar-center uk-visible-small"><a class="tm-logo-small" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo-small'); ?></a></div>
                        <?php endif; ?>

                    </nav>
                    <?php endif; ?>

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

                </div>
                <?php endif; ?>

                <?php if ($this['widgets']->count('top-a')) : ?>
                <section class="<?php echo $grid_classes['top-a']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('top-a', array('layout'=>$this['config']->get('grid.top-a.layout'))); ?></section>
                <?php endif; ?>

                <?php if ($this['widgets']->count('top-b')) : ?>
                <section class="<?php echo $grid_classes['top-b']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('top-b', array('layout'=>$this['config']->get('grid.top-b.layout'))); ?></section>
                <?php endif; ?>

                <?php if ($this['widgets']->count('main-top + main-bottom + sidebar-a + sidebar-b') || $this['config']->get('system_output', true)) : ?>
                <div class="tm-middle uk-grid" data-uk-grid-match>

                    <?php if ($this['widgets']->count('main-top + main-bottom') || $this['config']->get('system_output', true)) : ?>
                    <div class="<?php echo $columns['main']['class'] ?>">

                        <?php if ($this['widgets']->count('main-top')) : ?>
                        <section class="<?php echo $grid_classes['main-top']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('main-top', array('layout'=>$this['config']->get('grid.main-top.layout'))); ?></section>
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
                        <section class="<?php echo $grid_classes['main-bottom']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('main-bottom', array('layout'=>$this['config']->get('grid.main-bottom.layout'))); ?></section>
                        <?php endif; ?>

                    </div>
                    <?php endif; ?>

                    <?php foreach($columns as $name => &$column) : ?>
                    <?php if ($name != 'main' && $this['widgets']->count($name)) : ?>
                    <aside class="<?php echo $column['class'] ?>"><?php echo $this['widgets']->render($name) ?></aside>
                    <?php endif ?>
                    <?php endforeach ?>

                </div>
                <?php endif; ?>

                <?php if ($this['widgets']->count('bottom-a')) : ?>
                <section class="<?php echo $grid_classes['bottom-a']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('bottom-a', array('layout'=>$this['config']->get('grid.bottom-a.layout'))); ?></section>
                <?php endif; ?>

                <?php if ($this['widgets']->count('bottom-b + bottom-c + footer + debug')) : ?>
                <div class="tm-block-bottom">

                    <?php if ($this['widgets']->count('bottom-b')) : ?>
                    <section class="<?php echo $grid_classes['bottom-b']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('bottom-b', array('layout'=>$this['config']->get('grid.bottom-b.layout'))); ?></section>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('bottom-c')) : ?>
                    <section class="<?php echo $grid_classes['bottom-c']; ?> tm-grid-block" data-uk-grid-match="{target:'> div > .uk-panel'}"><?php echo $this['widgets']->render('bottom-c', array('layout'=>$this['config']->get('grid.bottom-c.layout'))); ?></section>
                    <?php endif; ?>

                    <?php if ($this['widgets']->count('footer + debug') || $this['config']->get('warp_branding', true) || $this['config']->get('totop_scroller', true)) : ?>
                    <footer class="tm-footer">

                        <?php if ($this['config']->get('totop_scroller', true)) : ?>
                        <a class="tm-totop-scroller" data-uk-smooth-scroll href="#"></a>
                        <?php endif; ?>

                        <?php
                            echo $this['widgets']->render('footer');
                            // $this->output('warp_branding');
                            echo $this['widgets']->render('debug');
                        ?>

                    </footer>
                    <?php endif; ?>

                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
    </div>

    <?php echo $this->render('footer'); ?>

    <?php if ($this['widgets']->count('offcanvas')) : ?>
    <div id="offcanvas" class="uk-offcanvas">
        <div class="uk-offcanvas-bar"><?php echo $this['widgets']->render('offcanvas'); ?></div>
    </div>
    <?php endif; ?>

</body>
</html>