	<?php global $theme_option; ?>
	<div class="clear" ></div>
	</div><!-- content wrapper -->

	<?php 
		// page style
		global $gdlr_post_option;
		if( empty($gdlr_post_option) || empty($gdlr_post_option['page-style']) ||
			  $gdlr_post_option['page-style'] == 'normal' || 
			  $gdlr_post_option['page-style'] == 'no-header'){ 
	?>	
	<footer class="footer-wrapper" >
		<?php if( $theme_option['show-footer'] != 'disable' ){ ?>
		<div class="footer-container container">
			<?php 	
				$i = 1;
        
				$theme_option['footer-layout'] = empty($theme_option['footer-layout'])? '1': $theme_option['footer-layout'];
        
				$gdlr_footer_layout = array(
					'1'=>array('twelve columns'),
					'2'=>array('three columns', 'three columns', 'three columns', 'three columns'),
					'3'=>array('three columns', 'three columns', 'six columns',),
					'4'=>array('four columns', 'four columns', 'four columns'),
					'5'=>array('four columns', 'four columns', 'eight columns'),
					'6'=>array('eight columns', 'four columns', 'four columns'),
				); //Den definere grid størrelsen ud theme option footer layout
        
        
			?>
			<?php foreach( $gdlr_footer_layout[$theme_option['footer-layout']] as $footer_class ){ ?>
            <!--Løkke der henter widget indhold-->
				<div class="footer-column <?php echo $footer_class; ?>" id="footer-widget-<?php echo $i; ?>" >
					<?php dynamic_sidebar('Footer ' . $i); ?>
				</div>
			<?php $i++; ?>
            <?php
                if($i == 3) {
            ?>
				<div class="footer-column three columns" id="footer-widget-<?php echo $i; ?>" >
                    <div id="text-5" class="widget widget_text gdlr-item gdlr-widget">
                        <h3 class="gdlr-widget-title">Nyhedsbrev</h3>
                        <div class="clear"></div>
                        <div class="textwidget">
                            <!--Nyhedsbrev form-->
                            <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
                                <input type="email" name="emailadresse" placeholder="E-mail Adresse.." required>
                                <input type="submit" name="tilmelddig" value="Tilmeld">
                            </form>
                        </div>
                    </div>
				</div>
            <?php
                }
            ?>
			<?php } ?>
			<div class="clear"></div>
		</div>
		<?php } ?>
		
		<?php if( $theme_option['show-copyright'] != 'disable' ){ ?>
		<div class="copyright-wrapper">
			<div class="copyright-container container">
				<div class="copyright-left">
					<?php if( !empty($theme_option['copyright-left-text']) ) echo $theme_option['copyright-left-text']; ?>
				</div>
				<div class="copyright-right">
					<?php if( !empty($theme_option['copyright-right-text']) ) echo $theme_option['copyright-right-text']; ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php } ?>
	</footer>
	<?php } // page style ?>
</div> <!-- body-wrapper -->
<?php wp_footer(); ?>
</body>
</html>