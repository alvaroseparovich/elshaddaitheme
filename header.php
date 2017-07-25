<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until </header>
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

/*------------------------- teste de ssl ----------------------------*/
if ( is_user_logged_in() ){
	if (! isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off' ) {
    		$redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    		header("Location: $redirect_url");
    		exit();
	}
}
    $url_atual = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (! isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off' ){
	if ($url_atual == 'elshaddai.com.br/entrar/' or $url_atual == 'elshaddai.com.br/registrar/' or $url_atual == 'elshaddai.com.br/reset-password/'){
		$url_atual_izada = "https://" . $url_atual ;
		header("Location: $url_atual_izada");	
	}
}
/*------------------------------------------*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<style>.lmp_load_more_button .lmp_button{display:inline-block;padding:12px 24px!important;font-size:46px!important;color:#fff!important;background-color:#f2bd00!important;text-decoration:none!important;border-radius:80px;line-height:1em}.tg-container .cat-description,.widget-area .slider-content,p.woocommerce-result-count{display:none}.lmp_load_more_button .lmp_button:hover{background-color:#f0c92c!important;color:#fff}div.tg-container{margin:0 auto;max-width:1268px;width:inherit}.archive-grid div#primary{margin-left:0;width:78%}aside#secondary{float:right;width:20%}#main .tg-container{padding:0}.woocommerce div .products ul,.woocommerce div ul.products{padding:15px 0 15px 15px}#post-8824 .wp-caption .wp-caption-text{min-height:56px}.no_sidebar_full_width .tg-container div#primary{width:100%}.slider-caption-wrapper .slider-title{font-size:32px;line-height:16px}.slider-caption-wrapper .slider-title a{color:#fff;font-size:13px;line-height:0}.widget-area .slider-title{font-size:24px}.widget-area .slider-caption-wrapper .slider-title{line-height:15px;margin:10px 0 22px}.widget-area ul.home-slider{margin-left:0}.widget .bx-viewport li .wp-post-image{opacity:.5}#secondary .category-slider .slider-caption-wrapper .slider-btn{padding:3px 13px}#secondary .woocommerce-product-search input{margin-bottom:10px;width:50%}#secondary .widget_product_search input[type=search]{width:100%}@media (max-width:670px){.widget .slider-caption-wrapper .slider-title{line-height:20px}.widget .slider-caption-wrapper .slider-title a{font-size:20px;line-height:0}}div .bottom-header-wrapper{background:#f2bd00}div #site-navigation ul li a{color:#000}div #site-navigation ul li:hover>a{color:#fff}div #site-navigation ul.sub-menu li.menu-item:hover>a{color:#f2bd00}div .logo-wrapper{margin:0}.site-title-wrapper.with-logo-text{background-image:url(https://elshaddai.com.br/wp-content/themes/El-Shaddai-1-0-0/img/logo-elshaddai.png);height:88px;background-repeat:no-repeat;background-size:contain}#site-title>a{font-size:0;height:86px;width:120px;display:inherit}#site-navigation ul li.current-menu-item>a.sf-with-ul,div.toggle-wrap:hover span.toggle i.fa.fa-reorder{color:#fff}.tg-container .page-description,.tg-container .term-description,body.home .page-header.clearfix,div .wishlist-wrapper .wishlist-value{display:none}.copy-right::after{content:'Livraria El-Shaddai desde 2003. São Paulo, SP, R. Conde de Sarzedas, Nº 166 loja 18/19 , Bairro Liberdade. CNPJ: 05.750.164/0001-50';font-size:12px}div#bottom-footer .copy-right{font-size:0;float:none}#colophon div#bottom-footer{text-align:center}#woocommerce_top_rated_products-3,section#woocommerce_recent_reviews-3{background:rgba(240,248,255,0)}.cart-wrapper .woocommerce.widget_shopping_cart .cart_list li img,.woocommerce-cart #main .woocommerce table.shop_table.cart tr.cart_item td.product-thumbnail img{border-radius:2px}div .woocommerce .woocommerce-error{border-color:red;background-color:#ffebeb}.woocommerce ul.woocommerce-error:before{color:red}.woocommerce.widget_shopping_cart .cart_list li img{border-radius:0!important}.woocommerce-cart .woocommerce table.shop_table.cart tr.cart_item.yith-wcpb-child-of-bundle-table-item td{background:#f5f5f5;height:84px}.woocommerce-cart #main .woocommerce table.shop_table.cart tr.cart_item.yith-wcpb-child-of-bundle-table-item td.product-thumbnail img{height:50px;width:auto}.woocommerce-page table.shop_table_responsive tr.yith-wcpb-child-of-bundle-table-item{border:2px solid #e4e4e4}.single-format-standard .entry-content-text-wrapper .entry-content p{font-size:18px}article.hentry h1.entry-title{font-size:33px}.woocommerce-page ul.products li.product .products-img img,figure.products-img a .attachment-shop_catalog.size-shop_catalog.wp-post-image{height:auto;width:auto;max-width:180px;max-height:200px;margin:0 auto}figure>a.woocommerce-LoopProduct-link{height:100%;width:100%;display:block}.products-hover-block>a.woocommerce-LoopProduct-link{display:none!important}.woocommerce-page div ul.products li.product .products-img .products-hover-wrapper{height:60px;left:inherit;position:relative;margin:-67px auto -4px;bottom:inherit;width:120px}.products-title>a{color:#454545!important}.products-hover-block{visibility:visible!important;opacity:1!important}.woocommerce-page ul.products li.product figure.products-img{border:none;min-height:217px}div.sales-tag{display:none}.woocommerce ul.products li.product a:first-child{min-height:inherit!important}.woocommerce-page ul.products li.product .products-img .products-hover-wrapper div.products-hover-block a{vertical-align:middle}.WOOF_Widget .chosen-container{width:100%!important}.products-block h3.products-title{min-height:57px}.woocommerce-page ul.products li.product .yith-wcwl-add-to-wishlist .add_to_wishlist.button.alt,.woocommerce-page ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,.woocommerce-page ul.products li.product .yith-wcwl-add-to-wishlist div.yith-wcwl-wishlistexistsbrowse a{border-radius:20px;height:auto}.woocommerce ul.products li.product span.price{min-height:25px}.yith-wcwl-add-button.show{border:1px solid #f2bd00;border-radius:25px}div .added_to_cart.wc-forward{bottom:inherit}.woocommerce-page ul.products li.product span.price{font-size:0}.woocommerce-page ul.products li.product .price span.amount{margin-left:0}.woocommerce-page ul.products li.product span.price ins{color:#000;display:block;font-weight:700;font-size:20px}.woocommerce-page ul.products li.product span.price del{color:#555653;margin-left:0;display:block;font-size:14px;line-height:7px}.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product,.woocommerce.columns-4 ul.products li.product{float:inherit!important;margin:0 .8% 40px;width:23%;display:inline-block;vertical-align:top}.products-hover-block a.added_to_cart.wc-forward{display:none!important}div blockquote{margin:0 15px;font-size:13px;font-style:italic;font-family:'Open Sans',sans-serif;font-weight:300}.single-product.woocommerce-page .product .product_title{line-height:30px}.woocommerce div.product div.images div.thumbnails a.zoom{width:15%!important;clear:none!important;margin-right:4.8%!important;display:inline-block;border:none;float:none!important}form.cart table.yith-wcpb-product-bundled-items tr{display:inline-block}form.cart td.yith-wcpb-product-bundled-item-image img{height:90px;width:auto;display:inline-block}form.cart td.yith-wcpb-product-bundled-item-data{display:none}form.cart table.yith-wcpb-product-bundled-items{box-shadow:none;border:none!important}.woocommerce div.product form.cart table td.yith-wcpb-product-bundled-item-image{width:auto}table.yith-wcpb-product-bundled-items h3{background:#f9de80;color:#000;font-size:11px;z-index:2;padding:3px 7px;border-radius:5px;position:absolute}table.yith-wcpb-product-bundled-items td div.bundle-flag{transition:.5s;opacity:0;margin-top:-55px;display:block;position:absolute;width:50px;height:50px;overflow:hidden}table.yith-wcpb-product-bundled-items td:hover div.bundle-flag{opacity:1;width:40%;height:43px;overflow:visible}.woocommerce-account .woocommerce-MyAccount-navigation{float:right!important;width:30%;border:1px solid;padding:12px}.woocommerce-MyAccount-navigation>ul{list-style:none;margin:0}li.woocommerce-MyAccount-navigation-link{border:1px solid #e6e6e6;padding:5px;margin:0 0 10px;text-align:center;background:#f5f5f5;font-weight:600}li.woocommerce-MyAccount-navigation-link>a{color:#7f7d7d;\   width:100%;height:100%;display:block}.woocommerce.columns-4 div .products-content-wrapper .star-rating,.woocommerce.columns-4 div .products-hover-wrapper{display:none}li.woocommerce-MyAccount-navigation-link.is-active>a{color:#f2bd00}li.woocommerce-MyAccount-navigation-link.is-active{border:1px solid #f2bd00!important;background:rgba(242,189,0,.05)}.woocommerce.columns-4 div .products-content-wrapper{text-align:center}.woocommerce ul.products li.product div.products-content-wrapper span.price{font-size:0}.woocommerce.columns-4 div div.products-content-wrapper span.price del{font-size:13px;color:#000}.woocommerce.columns-4 div .products-content-wrapper span.price ins{font-size:20px;color:#000}.woocommerce.columns-4 figure.products-img{height:220px}.woocommerce.columns-4 h3.products-title a{font-size:15px}.woocommerce.columns-4 .yith-wcwl-add-to-wishlist .ajax-loading{display:none!important}#wprmenu_menu.wprmenu_levels ul li a,#wprmenu_menu.wprmenu_levels ul li a:hover{padding:5px 14px}#wprmenu_menu.wprmenu_levels span.wprmenu_icon_par{padding:7px 9px;width:35px}#wprmenu_menu.wprmenu_levels ul li ul.sub-menu li.wprmenu_parent_item_li a.wprmenu_parent_item{margin-left:30px;border-left:0}#wprmenu_menu.wprmenu_levels ul#wprmenu_menu_ul li.menu-item ul li span.wprmenu_icon_par{margin:0}#wprmenu_menu.wprmenu_levels ul li ul li.menu-item{padding-left:31px;border:0}#wprmenu_menu_ul ul.sub-menu{margin-left:8px;border:0!important;margin-bottom:8px;box-shadow:0 0 20px 0 rgba(0,0,0,.5)}#wprmenu_menu.wprmenu_levels ul li.menu-item{border-bottom:0;border-top:0}div#wprmenu_menu.wprmenu_levels ul li ul li{padding-left:45px;background:rgba(107,107,107,.29)}div#wprmenu_menu.wprmenu_levels a.wprmenu_parent_item{margin-left:30px;border:0}@media (max-width:1100px){.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product{width:31%}}@media (max-width:800px){.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product{width:48%}.tg-container aside#secondary{width:25%}.archive-grid div#primary,.tg-container div#primary{width:74%}.tg-column-4.footer-block{padding-left:2%}.woof_container.woof_container_categoriasdeproduto::before{content:'Categoria de Produto';font-weight:800}.woof_container.woof_container_editora::before{content:'Editora';font-weight:800}.woof_container.woof_container_autor::before{content:'Autor';font-weight:800}.woof_container.woof_container_ano::before{content:'Ano';font-weight:800}.woof_container.woof_container_mselect{padding-bottom:0;margin-bottom:0}}@media (min-width:769px){#site-navigation ul li.current-menu-item>a{color:#fff!important}.woocommerce #content div.product div.summary,.woocommerce div div.product div.summary,.woocommerce-page div #content div.product div.summary,.woocommerce-page div.product div.summary{width:100%}.woocommerce div #content div.product div.images,.woocommerce div div.product div.images,.woocommerce-page div #content div.product div.images,.woocommerce-page div.product div.images{width:50%;margin:auto}}@media (max-width:770px){.woocommerce div #content div#primary div.product div.images,.woocommerce div div#primary div.product div.images,.woocommerce-page div #content div#primary div.product div.images,.woocommerce-page div#primary div.product div.images{margin:auto;width:50%}.woocommerce #content div#primary div.product div.summary,.woocommerce div div#primary div.product div.summary,.woocommerce-page div #content div#primary div.product div.summary,.woocommerce-page div#primary div.product div.summary{width:100%}.woocommerce-cart div.woocommerce table.shop_table.cart tr.cart_item td{height:auto!important}.woocommerce-cart div.woocommerce table.shop_table.cart tr.cart_item td.product-thumbnail{display:block!important}.woocommerce table.shop_table_responsive tr td:before,.woocommerce-page table.shop_table_responsive tr td:before{display:none}}@media (max-width:670px){.archive-grid div#primary,.tg-container aside#secondary,.tg-container div#primary{width:100%}.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product{width:31%}.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div .products ul,.woocommerce div ul.products{padding:15px 0}.products-block h3.products-title{min-height:95px}}@media (max-width:570px){.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product{width:47%}}@media (max-width:350px){.entry-content-wrapper .woocommerce.columns-4 ul.products li.product,.woocommerce div ul.products li.product,.woocommerce-page div ul.products li.product{width:100%}}.tg-container #primary{width:77%}.woocommerce div #content div.product div.images,.woocommerce div div.product div.images,.woocommerce-page div #content div.product div.images,.woocommerce-page div.product div.images{width:20%}.woocommerce #content div.product div.summary,.woocommerce div div.product div.summary,.woocommerce-page div #content div.product div.summary,.woocommerce-page div.product div.summary{width:74%}.woocommerce div.product p.price ins,.woocommerce div.product span.price ins{color:#000;font-size:30px}.woocommerce div div.product p.stock{background:#77a464;color:#fff;font-weight:700;display:inline-block;padding:5px;border-radius:5px;margin:10px 5px;vertical-align:top}.woocommerce div div.product p.stock.out-of-stock{background:#c72727}.woocommerce div div.product form.cart div.quantity{margin:0}.single-product.woocommerce-page div.product.product-type-variable .cart{vertical-align:bottom;margin:0 5px 10px;width:100%}.yith-wcwl-wishlistexistsbrowse span.feedback{display:none}.single-product.woocommerce-page div.product .yith-wcwl-add-to-wishlist{margin:10px}.single-product.woocommerce-page div.product .cart .single_add_to_cart_button{padding:1px 1px 1px 3px;margin:0 5px;font-size:16px;width:120px;display:block;background:#006400}.yith-wcwl-wishlistexistsbrowse.show{margin:2px 0}.woocommerce span.onsale{display:none}div#tab-description,div#tab-reviews{display:block!important}div#tab-additional_information{display:block!important;padding:20px 20px 0;border-top:1px solid #e1e1e1;margin-top:10px}div#tab-additional_information h2{font-size:18px}div#tab-reviews{border-top:1px solid #e1e1e1}ul.tabs.wc-tabs{display:none}#commentform>p.comment-form-rating>p>span{font-size:35px}.woocommerce div #review_form #respond p.stars{margin:0 0 -23px}div#review_form_wrapper{padding:20px;margin-top:20px;border:1px solid #f2bd00}@media (max-width:600px){.woocommerce-checkout div.entry-content div.woocommerce{width:inherit}}.woocommerce-checkout #payment:before{content:"*Pagamento em Boleto Bancário Disponíveis em compras de no mínimo R$ 99,9.";color:coral;padding:10px}@media screen and (max-width:1090px){.banner_wrapper .banner>img{margin-left:-14vw;width:130%;max-width:200%}}@media screen and (max-width:900px){.banner_wrapper .banner>img{margin-left:-24vw;width:150%;max-width:200%}}@media screen and (max-width:600px){.banner_wrapper .banner>img{margin-left:-40vw;width:182%;max-width:200%}}.custom-banners-cycle-slideshow{z-index:0}.woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-enabled{display:inline-block;vertical-align:bottom;width:180px;margin-left:0}.woocommerce-variation-availability{display:inline-block}.woocommerce-variation.single_variation{display:inline-block;vertical-align:baseline}.product-type-variable div[itemprop=offers] p.price ins{font-size:16px}form.variations_form.cart .woocommerce-variation-price .price:before{content:"Preço do produto selecionado";font-size:12px;display:block;margin-bottom:-15px}.woocommerce div.product form.cart .variations td.value select{max-width:61%;min-width:64%;display:inline-block;margin-right:1em}.simple-theme.woocommerce-products-carousel-all-in-one .woocommerce-products-carousel-all-in-one-title{text-align:center;font-size:11px}</style>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'tg_before' ); ?>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'estore' ); ?></a>

		<?php do_action( 'estore_before_header' ); ?>
		<header id="masthead" class="site-header" role="banner">
		<?php if( get_theme_mod( 'estore_bar_activation' ) == '1' ) : ?>
			<div class="top-header-wrapper clearfix">
				<div class="tg-container">
					<div class="left-top-header">
						<div id="header-ticker" class="left-header-block">
							<?php
							$header_bar_text = get_theme_mod( 'estore_bar_text' );
							echo wp_kses_post($header_bar_text);
							?>
						</div> <!-- header-ticker end-->
					</div> <!-- left-top-header end -->

					<div class="right-top-header">
						<div class="top-header-menu-wrapper">
							<?php wp_nav_menu(
								array(
									'theme_location' => 'header',
									'menu_id'        => 'header-menu',
									'fallback_cb'    => false
								)
							);
							?>
						</div> <!-- top-header-menu-wrapper end -->
						<?php
						if (class_exists('woocommerce')):
						if(get_theme_mod('estore_header_ac_btn', '' ) == '1' ):
						?>
						<div class="login-register-wrap right-header-block">
							<?php if ( is_user_logged_in() ) { ?>
									<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr__('My Account','estore'); ?>" class="user-icon"><?php esc_html_e('My Account', 'estore'); ?></a>
								<?php }
								else { ?>
									<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr__('Login/Register','estore'); ?>"class="user-icon"><?php esc_html_e('Login/ Register', 'estore'); ?><i class="fa fa-angle-down"> </i></a>
								<?php } ?>
						</div>
						<?php endif;
						if(get_theme_mod('estore_header_currency', '' ) == '1' ):
						?>
						<div class="currency-wrap right-header-block">
							<a href="#"><?php echo esc_html( get_woocommerce_currency()); ?><?php echo "(" . esc_html ( get_woocommerce_currency_symbol() ) . ")"; ?></a>
						</div> <!--currency-wrap end -->
						<?php endif; // header currency check ?>

						<?php
						if (function_exists('icl_object_id')) {
							if(get_theme_mod( 'estore_header_lang' ) == 1 ) {
								do_action('wpml_add_language_selector');
							}
						}
						endif; // woocommerce check
						?>
					</div>
				</div>
		  </div>
	  	<?php endif; ?>

		 <div class="middle-header-wrapper clearfix">
			<div class="tg-container">
			   <div class="logo-wrapper clearfix">
				 <?php if( ( get_theme_mod( 'estore_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'estore_logo_placement', 'header_text_only' ) == 'header_logo_only' ) ) {

				 	// Checking for theme defined logo
				 	if( get_theme_mod( 'estore_logo', '' ) != '' ) {
				 	?>
					<div class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url(get_theme_mod('estore_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
					</div> <!-- logo end -->
					<?php }
					if( function_exists( 'the_custom_logo' ) && has_custom_logo( $blog_id = 0 ) ) {
						estore_the_custom_logo();
					}

				} // Checks for logo appearance

				$screen_reader = 'with-logo-text';
				if( get_theme_mod( 'estore_logo_placement', 'header_text_only' ) == 'header_logo_only' || get_theme_mod( 'estore_logo_placement', 'header_text_only' ) == 'disable' ) {
					$screen_reader = 'screen-reader-text';
				}
				?>

				<div class="site-title-wrapper <?php echo $screen_reader; ?>">
				<?php if ( is_front_page() || is_home() ) : ?>
					<h1 id="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
				<?php else : ?>
					<h3 id="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h3>
				<?php endif;
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p id="site-description"><?php echo $description; ?></p>
				<?php endif; ?>
				  </div>
			   </div><!-- logo-end-->

			<div class="wishlist-cart-wrapper clearfix">
				<?php
				if (function_exists('YITH_WCWL')) {
					$wishlist_url = YITH_WCWL()->get_wishlist_url();
					?>
					<div class="wishlist-wrapper">
						<a class="quick-wishlist" href="<?php echo esc_url($wishlist_url); ?>" title="Wishlist">
							<i class="fa fa-heart"></i>
							<span class="wishlist-value"><?php echo absint( yith_wcwl_count_products() ); ?></span>
						</a>
					</div>
					<?php
				}
				if ( class_exists( 'woocommerce' ) ) : ?>
					<div class="cart-wrapper">
						<div class="estore-cart-views">
							<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="wcmenucart-contents">
								<i class="fa fa-shopping-cart"></i>
								<span class="cart-value"><?php echo wp_kses_data ( WC()->cart->get_cart_contents_count() ); ?></span>
							</a> <!-- quick wishlist end -->
							<div class="my-cart-wrap">
								<div class="my-cart"><?php esc_html_e('Total', 'estore'); ?></div>
								<div class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div>
							</div>
						</div>
						<?php the_widget( 'WC_Widget_Cart', '' ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'header' ); ?>

			</div>
		 </div> <!-- middle-header-wrapper end -->

		 <div class="bottom-header-wrapper clearfix">
			<div class="tg-container">

				<?php
				$menu_location  = 'secondary';
				$menu_locations = get_nav_menu_locations();
				$menu_object    = (isset($menu_locations[$menu_location]) ? wp_get_nav_menu_object($menu_locations[$menu_location]) : null);
				$menu_name      = (isset($menu_object->name) ? $menu_object->name : '');
				if ( has_nav_menu( $menu_location ) ) {
				?>
				<div class="category-menu">
					<div class="category-toggle">
						<?php echo esc_html($menu_name); ?><i class="fa fa-navicon"> </i>
					</div>
					<nav id="category-navigation" class="category-menu-wrapper hide" role="navigation">
						<?php wp_nav_menu(
							array(
								'theme_location' => 'secondary',
								'menu_id'        => 'category-menu',
								'fallback_cb'    => 'false'
							)
						);
						?>
					</nav>
				</div>
				<?php } ?>

 				<div class="search-user-wrapper clearfix">
					<div class="search-wrapper search-user-block">
						<div class="search-icon">
							<i class="fa fa-search"> </i>
						</div>
						<div class="header-search-box">
							<?php get_search_form(); ?>
						</div>
					</div>
					<div class="user-wrapper search-user-block">
						<?php if ( is_user_logged_in() ) { ?>
							<a href="<?php echo esc_url (get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr__('My Account','estore'); ?>" class="user-icon"><i class="fa fa-user"></i></a>
						<?php }
						else { ?>
							<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr__('Login / Register','estore'); ?>" class="user-icon"><i class="fa fa-user-times"></i></a>
						<?php } ?>
					</div>
				</div> <!-- search-user-wrapper -->
				<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="toggle-wrap"><span class="toggle"><i class="fa fa-reorder"> </i></span></div>
					<?php wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
			   </nav><!-- #site-navigation -->

			</div>
		 </div> <!-- bottom-header.wrapper end -->
            <!-- $FM Verificando template carregado caso o usuário tenha permissões corretas
         Isso significa não mostrar esse debug para usuários comuns -->
    <?php 
    // If the current user can manage options(ie. an admin)
    if( current_user_can( 'manage_options' ) ) 
        // Print the saved global 
        printf( '<div><strong>Current template:</strong> %s</div>', get_current_template() ); 
    ?>
    <!-- Fim $FM -->
	</header>
	<?php do_action( 'estore_after_header' ); ?>
    <?php do_action( 'estore_before_main' ); ?>	