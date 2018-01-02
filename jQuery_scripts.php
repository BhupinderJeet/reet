<!-- FOOTER -->
<?php
global $rigid_is_blank;
?>
<!-- If it is not a blank page template -->
<?php if (!$rigid_is_blank): ?>
	<div id="footer">
		<?php
		$rigid_show_footer_logo = false;
		$rigid_show_footer_menu = false;

		if ( has_nav_menu( 'tertiary' ) ) {
			$rigid_show_footer_menu = true;
		}
		if ( rigid_get_option( 'show_logo_in_footer' ) && ( rigid_get_option( 'theme_logo' ) || rigid_get_option( 'footer_logo' ) ) ) {
			$rigid_show_footer_logo = true;
		}
		?>
		<?php if ( $rigid_show_footer_logo || $rigid_show_footer_menu ): ?>
            <div class="inner">
				<?php if ( $rigid_show_footer_menu ): ?>
					<?php
					/* Tertiary menu */
					$rigid_footer_nav_args = array(
						'theme_location' => 'tertiary',
						'container'      => 'div',
						'container_id'   => 'rigid_footer_menu_container',
						'menu_class'     => '',
						'menu_id'        => 'rigid_footer_menu',
						'depth'          => 1,
						'fallback_cb'    => '',
					);
					wp_nav_menu( $rigid_footer_nav_args );
					?>
				<?php endif; ?>
				<?php if ( $rigid_show_footer_logo ): ?>
                    <div id="rigid_footer_logo">
                        <a href="<?php echo esc_url( rigid_wpml_get_home_url() ); ?>"
                           title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php
							$rigid_theme_logo_img  = rigid_get_option( 'theme_logo' );
							$rigid_footer_logo_img = rigid_get_option( 'footer_logo' );

							// If footer logo, show footer logo, else main logo
							if ( $rigid_footer_logo_img ) {
								echo wp_get_attachment_image( $rigid_footer_logo_img, 'full', false );
							} elseif ( $rigid_theme_logo_img ) {
								echo wp_get_attachment_image( $rigid_theme_logo_img, 'full', false );
							}
							?>
                        </a>
                    </div>
				<?php endif; ?>
            </div>
		<?php endif; ?>
		<?php
		$rigid_meta_options = array();
		if (is_single() || is_page()) {
			$rigid_meta_options = get_post_custom(get_queried_object_id());
		}

		$rigid_show_sidebar = 'yes';
		if (isset($rigid_meta_options['rigid_show_footer_sidebar']) && trim($rigid_meta_options['rigid_show_footer_sidebar'][0]) != '') {
			$rigid_show_sidebar = $rigid_meta_options['rigid_show_footer_sidebar'][0];
		}

		$rigid_footer_sidebar_choice = rigid_get_option('footer_sidebar');
		if (isset($rigid_meta_options['rigid_custom_footer_sidebar']) && $rigid_meta_options['rigid_custom_footer_sidebar'][0] !== 'default') {
			$rigid_footer_sidebar_choice = $rigid_meta_options['rigid_custom_footer_sidebar'][0];
		}

		if ( $rigid_show_sidebar === 'no' ) {
			$rigid_footer_sidebar_choice = 'none';
		}
		?>
		<?php if (function_exists('dynamic_sidebar') && $rigid_footer_sidebar_choice != 'none' && is_active_sidebar($rigid_footer_sidebar_choice)) : ?>
			<div class="inner">
				<?php dynamic_sidebar($rigid_footer_sidebar_choice) ?>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		<div id="powered">
			<div class="inner">
				<!--	Social profiles in footer -->
				<?php if (rigid_get_option('social_in_footer')): ?>
					<?php get_template_part('partials/social-profiles'); ?>
				<?php endif; ?>

				<div class="author_credits"><?php echo wp_kses_post(rigid_get_option('copyright_text')) ?></div>
			</div>
		</div>
	</div>
	<!-- END OF FOOTER -->
	<!-- Previous / Next links -->
	<?php if (rigid_get_option('show_prev_next')): ?>
		<?php echo rigid_post_nav(); ?>
	<?php endif; ?>
<?php endif; ?>
</div>
<!-- END OF MAIN WRAPPER -->
<?php
$rigid_is_compare = false;
if (isset($_GET['action']) && $_GET['action'] === 'yith-woocompare-view-table') {
	$rigid_is_compare = true;
}

$rigid_to_include_backgr_video = rigid_has_to_include_backgr_video($rigid_is_compare);
?>
<?php if ($rigid_to_include_backgr_video): ?>
	<?php
	$rigid_video_bckgr_url = $rigid_video_bckgr_start = $rigid_video_bckgr_end = $rigid_video_bckgr_loop = $rigid_video_bckgr_mute = '';

	switch ($rigid_to_include_backgr_video) {
		case 'postmeta':
			$rigid_custom = rigid_has_post_video_bckgr();
			$rigid_video_bckgr_url = isset($rigid_custom['rigid_video_bckgr_url'][0]) ? $rigid_custom['rigid_video_bckgr_url'][0] : '';
			$rigid_video_bckgr_start = isset($rigid_custom['rigid_video_bckgr_start'][0]) ? $rigid_custom['rigid_video_bckgr_start'][0] : '';
			$rigid_video_bckgr_end = isset($rigid_custom['rigid_video_bckgr_end'][0]) ? $rigid_custom['rigid_video_bckgr_end'][0] : '';
			$rigid_video_bckgr_loop = isset($rigid_custom['rigid_video_bckgr_loop'][0]) ? $rigid_custom['rigid_video_bckgr_loop'][0] : '';
			$rigid_video_bckgr_mute = isset($rigid_custom['rigid_video_bckgr_mute'][0]) ? $rigid_custom['rigid_video_bckgr_mute'][0] : '';
			break;
		case 'blog':
			$rigid_video_bckgr_url = rigid_get_option('blog_video_bckgr_url');
			$rigid_video_bckgr_start = rigid_get_option('blog_video_bckgr_start');
			$rigid_video_bckgr_end = rigid_get_option('blog_video_bckgr_end');
			$rigid_video_bckgr_loop = rigid_get_option('blog_video_bckgr_loop');
			$rigid_video_bckgr_mute = rigid_get_option('blog_video_bckgr_mute');
			break;
		case 'shop':
		case 'shopwide':
			$rigid_video_bckgr_url = rigid_get_option('shop_video_bckgr_url');
			$rigid_video_bckgr_start = rigid_get_option('shop_video_bckgr_start');
			$rigid_video_bckgr_end = rigid_get_option('shop_video_bckgr_end');
			$rigid_video_bckgr_loop = rigid_get_option('shop_video_bckgr_loop');
			$rigid_video_bckgr_mute = rigid_get_option('shop_video_bckgr_mute');
			break;
		case 'global':
			$rigid_video_bckgr_url = rigid_get_option('video_bckgr_url');
			$rigid_video_bckgr_start = rigid_get_option('video_bckgr_start');
			$rigid_video_bckgr_end = rigid_get_option('video_bckgr_end');
			$rigid_video_bckgr_loop = rigid_get_option('video_bckgr_loop');
			$rigid_video_bckgr_mute = rigid_get_option('video_bckgr_mute');
			break;
		default:
			break;
	}
	?>
    <div id="bgndVideo" class="rigid_bckgr_player"
         data-property="{videoURL:'<?php echo esc_url($rigid_video_bckgr_url) ?>',containment:'body',autoPlay:true, loop:<?php echo esc_js($rigid_video_bckgr_loop) ? 'true' : 'false'; ?>, mute:<?php echo esc_js($rigid_video_bckgr_mute) ? 'true' : 'false'; ?>, startAt:<?php echo esc_js($rigid_video_bckgr_start) ? esc_js($rigid_video_bckgr_start) : 0; ?>, opacity:.9, showControls:false, addRaster:true, quality:'default'<?php if ($rigid_video_bckgr_end): ?>, stopAt:<?php echo esc_js($rigid_video_bckgr_end) ?><?php endif; ?>}">
    </div>
	<?php if (!$rigid_video_bckgr_mute): ?>
        <div class="video_controlls">
            <a id="video-volume" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").toggleVolume()') ?>"><i class="fa fa-volume-up"></i></a>
            <a id="video-play" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").playYTP()') ?>"><i class="fa fa-play"></i></a>
            <a id="video-pause" href="#" onclick="<?php echo esc_js('jQuery("#bgndVideo").pauseYTP()') ?>"><i class="fa fa-pause"></i></a>
        </div>
	<?php endif; ?>
<?php endif; ?>


<script>
	jQuery('document').ready(function(){
		
		 if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) 
		 	{
		 		var width = jQuery(window).width();
		 		if(width <= 414){
		 			jQuery('a.rigid-filter-widgets-triger').css('top','0px');
		 			jQuery('.down .rigid-search-cart-holder').css('text-align', 'center');
		 			jQuery('.down .rigid-search-cart-holder').css('width', '100%');
		 			jQuery('.down #rigid-account-holder').css('height', '58px');
		 			jQuery('.down .rigid-search-cart-holder .rigid-search-trigger').css('height', '60px');
		 			jQuery('.down .rigid-search-cart-holder .rigid-search-trigger').css('width', '19px');
		 			jQuery('.down .rigid-search-cart-holder .rigid-search-trigger').css('padding', '0px');
		 			jQuery('.down .rigid-wishlist-counter').css('height', '54px');
		 			jQuery('.rigid-search-cart-holder').css('float', 'right');
		 			jQuery('.product-filter .limit').css('margin-left', '0px');
		 			jQuery('.product-filter .limit').css('float', 'left');
		 			jQuery('.nice-select.orderby').css('padding-left', '0px');
		 		}
		 	}
		
		jQuery(".woocommerce-Price-currencySymbol").html("Koins");

		jQuery('.buy-now-btn .button').html('Comprar ahora');
		jQuery('form .form-row .imp-msg').html('IMPORTANTE: para comprar con éxito tus Koins,por favor, asegúrate de que <a href="http://koins.club/carrito/" style="">no haya otros productos en tu carrito</a> al momento de pagar.');
		jQuery('li#dashboard-menu-item- a').html('Consola');
		jQuery('li#dashboard-menu-item-settings a').html('Configuración');
		jQuery('li#dashboard-menu-item-shop_coupon a').html('Cupones');
		jQuery('.sort>b').html('ORDENAR POR');
		jQuery('div#post-2270 th.th1').html('Nombre');
		jQuery('div#post-2270 th.th3').html('Precio');
		
		jQuery('div#post-2270 .scooby-oba').insertAfter('div#post-2270 p.woocommerce-LostPassword.lost_password');

		jQuery('div#post-2270 .scooby-oba-signup').insertAfter('div#post-2270 p.woocommerce-FormRow.form-row input.woocommerce-Button.button');

		jQuery('div#post-4534 .scooby-oba').insertAfter('div#post-4534 p.woocommerce-LostPassword.lost_password');

		jQuery('div#post-4534 .scooby-oba-signup').insertAfter('div#post-4534 p.woocommerce-FormRow.form-row input.woocommerce-Button.button');


		setTimeout(function(){ 
			jQuery(".owl-nav > .owl-prev:contains('Login')").text('Entrar');
			jQuery(".owl-nav > .owl-next:contains('Register')").text('Registro');
			var koincount = jQuery("#post-2270 p:contains('You have') > strong").text();
			jQuery("#post-2270 p:contains('You have')").html("Tienes <strong>"+ koincount +"</strong> Koins.");
			jQuery("div#post-2270 p:contains('To add or edit products, view sales and orders') ").text('Para agregar o editar productos, ver las ventas y los pedidos de su cuenta de proveedor o configurar su tienda, visite el Panel de proveedores.');
			
			

			jQuery("div#post-5155 h3:contains('No orders found')").html("No se encontraron órdenes");

			jQuery("div#post-5155 h3:contains('No products found')").html("No se encontraron productos");

			jQuery("a.wcv-button.button:contains('Add Product')").html("Agregar producto");

			jQuery("div#post-5155 h3:contains('Commission Due')").html("Koins Pendientes");

			jQuery("div#post-5155 h3:contains('Comisiónes pagadas')").html("Koins Pagados");

			jQuery("div#post-5155 td strong:contains('Totals')").html("Totales");

			
			if(jQuery(".woocommerce-cart-form__cart-item.cart_item td.product-name:contains('Koins')")) {
				
				jQuery('td.product-price span.woocommerce-Price-amount.amount .woocommerce-Price-currencySymbol').text("$");
				jQuery("span.woocommerce-Price-amount.amount span.woocommerce-Price-currencySymbol").text("$");
				jQuery(".cart-collaterals span.woocommerce-Price-currencySymbol").text("$");
				jQuery(".checkout.woocommerce-checkout #order_review .woocommerce-Price-currencySymbol").text("$");

			}else{
				jQuery(".woocommerce-Price-currencySymbol").html("Koins");

			}

			jQuery(".widget.woocommerce.widget_shopping_cart a:contains('Finalizar compra')").html("Pagar");

			var cbal = jQuery(".wc_payment_method.payment_method_wdc_woo_credits > label:contains('Koins  | Your Current Balance:') > strong").text();
			//alert(cbal);
			jQuery(".wc_payment_method.payment_method_wdc_woo_credits > label:contains('Koins  | Your Current Balance:')").html("Koins | Tienes: <strong>"+ cbal +"</strong> saldo | <a class='buy-more-credits' href='https://koins.club/mi-cuenta/'>Compre más Koins</a>");

			jQuery(".woocommerce-cart-form td.actions .coupon + input.button").val("Actualización de la compra");

			jQuery(".woocommerce-cart-form td.actions .coupon input.button").val("Aplicar cupón");

			jQuery(".cart-collaterals th:contains('Subtotal')").html("Total parcial");

			jQuery(".cart-collaterals tr.shipping th:contains('Shipping')").html("Envío");

			jQuery(".product-filter .price_label > p").contents().filter(function() {
	            return this.nodeType == 3;
	        }).first().replaceWith("Rango de precios:");

	        jQuery("th:contains('Order')").html("Pedido");
	        jQuery("th:contains('Totals')").html("Totales");
	        jQuery("th:contains('Details')").html("Detalles");
	        jQuery("th:contains('Status')").html("Estado");

	        jQuery("h3:contains('No Orders found.')").html("No se encontraron pedidos.");
	        jQuery("h3:contains('No Products found.')").html("No se encontraron productos.")

	        jQuery(".blog-post-excerpt p:contains('Apologies, but no results were found. Perhaps searching will help find a related post.')").html("Disculpas, pero no se encontraron resultados. Tal vez buscar ayudará a encontrar una publicación relacionada.");
	        jQuery(".blog-post-meta.post-meta-top a:contains('Uncategorized')").html("Sin categoría");

	        jQuery("div#post-2270 h2:contains('Acceder')").html("Entrar");
	        jQuery("div#post-2270 h2:contains('Registrar')").html("Registro");

	        jQuery(".row-actions.row-actions-product a:contains('Edit')").html("Editar");
			jQuery(".row-actions.row-actions-product a:contains('Duplicate')").html("Duplicar");
	        jQuery(".row-actions.row-actions-product a:contains('Delete')").html("Borrar");
	        jQuery(".row-actions.row-actions-product a:contains('View')").html("Ver");

	        jQuery(".order_details credits_remaining li").text('Koins Restantes');

	        var koin_txt = jQuery(".summary.entry-summary .download-credits").text();
			var k_bal1 = parseInt(koin_txt.replace(/[^0-9\.]/g, ''), 10);
			jQuery(".summary.entry-summary p.download-credits:contains('You have')").html("Tienes "+ k_bal1 +" Koins disponibles.<br><a class='buy-more-credits' href='https://koins.club/mi-cuenta/'>Obtener Koins</a>.");

			var link_pre = jQuery("#post-5155 .woocommerce-message:contains('Product submitted for review.')>a").attr('href');
			jQuery("#post-5155 .woocommerce-message:contains('Product submitted for review.')").html("Producto enviado para revisión. <a href='"+ link_pre +"'>Vista previa del producto</a>");

			//alert(chkout_kbal);

		}, 1000);
		 setInterval(function(){
			var price1 = jQuery("#rigid_price_range .from").text();
			var price11 = parseInt(price1.replace(/[^0-9\.]/g, ''), 10);
			var price2 = jQuery("#rigid_price_range .to").text();
			var price22 = parseInt(price2.replace(/[^0-9\.]/g, ''), 10);
			jQuery("#rigid_price_range .from").text(price11 + " KOINS");
			jQuery("#rigid_price_range .to").text(price22 + " KOINS");


			var btntxt = jQuery(".woocommerce-cart-form__contents .actions .button").val();
			if( btntxt == "Update cart" ) {
				jQuery(".woocommerce-cart-form__contents .actions .button").val("Actualizar");
			}

			jQuery("button.button.media-button.button-primary.button-large.media-button-select:contains('Set Product Feature Image')").html('Seleccionar Imagen');
			
			jQuery(".media-frame-title h1:contains('Select or Upload a Feature Image')").html("Subir Imagen");

			jQuery(".woocommerce-error li:contains('Payment error: Insufficient Koins. Please purchase more Koins or use a different payment method.')").text("Error de pago: Insuficiente Koins. Compra más Koins o utiliza un método de pago diferente.");

		 }, 10);
		
		setInterval(function(){
			jQuery(".widget.woocommerce.widget_shopping_cart.active_cart a:contains('Finalizar compra')").html("Pagar");
			var html = jQuery(".woocommerce-cart-form__cart-item.cart_item td.product-name:contains('Koins')").length;

			if(html != 0) {
				
				jQuery('td.product-price span.woocommerce-Price-amount.amount .woocommerce-Price-currencySymbol').text("$");
				jQuery("span.woocommerce-Price-amount.amount span.woocommerce-Price-currencySymbol").text("$");
				jQuery(".cart-collaterals span.woocommerce-Price-currencySymbol").text("$");
				jQuery(".checkout.woocommerce-checkout #order_review .woocommerce-Price-currencySymbol").text("$");

			}else{
				jQuery(".woocommerce-Price-currencySymbol").html("Koins");
			}

			var chkpname = jQuery("#order_review .product-name:contains('Koins')").length;
			if( chkpname != 0 ) {
				jQuery(".checkout.woocommerce-checkout #order_review .woocommerce-Price-currencySymbol").text("$");
			}

			var sidecart = jQuery(".widget.woocommerce.widget_shopping_cart.active_cart .woocommerce-mini-cart-item.mini_cart_item:contains('Koins')").length;
			if(sidecart != 0) {
				jQuery(".widget.woocommerce.widget_shopping_cart.active_cart .woocommerce-Price-currencySymbol").text("$");
			}


			jQuery("button.wcv-button:contains('Search')").html("Buscar");
			jQuery("button.wcv-button:contains('Buscar')").css('color', '#ffffff');

			jQuery(".media-frame-title h1:contains('Añadir imágenes a la galería de productos')").html("Añadir Imágenes");

			jQuery("#post-2270 .woocommerce .woocommerce-message:contains('Your feedback has been saved.')").html("Sus comentarios han sido guardados.");

			var chkout_kbal = jQuery(".checkout.woocommerce-checkout #order_review #payment .wc_payment_methods.payment_methods.methods .wc_payment_method.payment_method_wdc_woo_credits label strong").text();
			jQuery(".checkout.woocommerce-checkout #order_review #payment .wc_payment_methods.payment_methods.methods .wc_payment_method.payment_method_wdc_woo_credits label").html("Koins | Tu Balance: <strong>"+ chkout_kbal +"</strong> <a class='buy-more-credits' href='https://koins.club/mi-cuenta/'>Comprar Koins</a>");

		}, 50);
		
		jQuery("div#post-5155 h3:contains('No ratings found.')").html("No se encontraron evaluaciones.");
		jQuery("li#dashboard-menu-item-rating a:contains('Evaluationes')").html("Evaluaciones");
		
		jQuery("form#wcv-product-edit a:contains('Ajuste de imagen principal')").html("Añadir foto principal");

		jQuery("table.wcvendors-table th:contains('Customer')").html("Cliente");
		jQuery("table.wcvendors-table th:contains('Shipped')").html("Enviado");

		jQuery(".all-50.align-right a:contains('Export Orders')").html("Pedidos de exportación");
		jQuery(".row-actions.row-actions-order a:contains('View Order Details')").html("Ver detalles de la orden");
		jQuery(".row-actions.row-actions-order a:contains('Mark Shipped')").html("Mark enviado");

		jQuery(".wcv-grid h3:contains('Settings')").html("Configuraciones");
		jQuery(".leave_feedback").text('Calificar');
		jQuery("ul.tabs-nav li a:contains('Attributes')").html("Atributos");
		jQuery("ul.tabs-nav li a:contains('Variations')").html("Variaciones");

		jQuery(".wcv-cols-group.wcv-horizontal-gutters label:contains('Precio normal ($)')").html("Precio normal (Koins)");
		jQuery(".wcv-cols-group.wcv-horizontal-gutters label:contains('Precio de venta ($)')").html("Precio de venta (Koins)");
		jQuery("select.attribute_taxonomy option:contains('Select an attribute')").html('Seleccione un atributo');
		jQuery("button.button.add_attribute:contains('Add')").html("Añadir");
		jQuery("span.expand-close a:contains('Expand')").html("Expandir");
		jQuery("span.expand-close a:contains('Close')").html("Cerca");

		jQuery(".wcv-product-basic.wcv-product textarea#post_content").attr("placeholder", "Escribe una descripción detallada del producto que incluya todas sus características");
		jQuery(".wcv-product-basic.wcv-product textarea#post_excerpt").attr("placeholder", "Escribe una descripción corta del producto para mostrar en tu tienda");
			
		var koin_val = jQuery(".order_details.credits_remaining li strong").text();
		
		jQuery(".order_details.credits_remaining li").text('Koins Restantes:'+koin_val);
	
		
		jQuery("label:contains('Seller Info')").html("Información del vendedor");
		jQuery(".status-publish mark:contains('completed')").text('terminado');

		jQuery("a.button.product:contains('Añadir Producto')").css("background-color", "#71a947");		
		
		var proadd = jQuery("input#store_save_button").val();
		if( proadd == "Suscribes para ser Vendedor" ) {
			jQuery("input#store_save_button").val("Crear Tienda");
		}

		jQuery("a.wcv-button.button:contains('Pedidos de exportación')").html("Exportar");

		var btnpend = jQuery(".wcv-tabs.top input#product_save_button").val();
		if( btnpend == "Save Pending" ) {
			jQuery(".wcv-tabs.top input#product_save_button").val("Publicar Ahora");
		}

		jQuery("tr.woocommerce-cart-form__cart-item.cart_item td.product-name").attr("data-title", "Producto");

		jQuery("tr.woocommerce-cart-form__cart-item.cart_item td.product-price").attr("data-title", "Precio");

		jQuery("tr.woocommerce-cart-form__cart-item.cart_item td.product-quantity").attr("data-title", "Cantidad");

		jQuery("div.limit>b:contains('Show')").text("Mostrar");

		//var zzo = jQuery("table.wcvendors-table.wcvendors-table-recent_product.wcv-table tbody>tr>td:nth-child(3):contains('Online')").text();
		
		jQuery("div#post-5588 p.cart-empty:contains('Your Wishlist is currently empty.')").html("Tu lista de deseos esta actualmente vacía.");
		jQuery("div#post-5588 a.button.wc-backward:contains('Return To Shop')").html("Volver a comprar");
		jQuery("div#post-5588 table.tinvwl-table-manage-list th.product-name span.tinvwl-full:contains('Product Name')").html("Nombre Del Producto");
		jQuery("div#post-5588 table.tinvwl-table-manage-list th.product-name span.tinvwl-mobile:contains('Product')").html("Producto");
		jQuery("div#post-5588 table.tinvwl-table-manage-list th.product-price:contains('Unit Price')").html("Precio unitario");
		jQuery("div#post-5588 table.tinvwl-table-manage-list th.product-date:contains('Date Added')").html("Fecha Agregada");
		jQuery("div#post-5588 button.button.tinvwl-break-input.tinvwl-break-checkbox:contains('Apply')").html("Aplicar acción");
		jQuery(".wcvendors-table.wcvendors-table-order.wcv-table td .row-actions.row-actions-order a:contains('Mark enviado')").html('Marcar como enviado');

		jQuery("div#post-5150 form.wcv-form textarea").attr("placeholder", "Comentarios (ej. experiencia de compra, entrega, artículos como se describen, calidad, etc)");
		jQuery("div#post-5150 form.wcv-form input:nth-child(6)").attr("placeholder", "Titulo");
		var btntxt = jQuery("form.wcv-form p>input").val();
		if( btntxt == 'Enviar sugerencia' ) {
			jQuery("form.wcv-form p>input").attr("value", "Enviar");
		}

		jQuery("#post-5155 .control-group label:contains('Precio normal ($)')").html("Precio normal (Koins)");

		jQuery(".woocommerce-MyAccount-navigation-link.woocommerce-MyAccount-navigation-link--tinv_wishlist a:contains('Wishlist')").html("Deseados");


		jQuery(".all-100 table.wcvendors-table.wcvendors-table-product.wcv-table tbody tr td:nth-child(4):contains('Online')").each(function(){
			var str = jQuery(this).text();
			var s1 = str.substr(0,str.indexOf(' '));
			var s2 = str.substr(str.indexOf(' ')+1);

			jQuery(this).html("Publicado <br>" + s2);

		});
			


		jQuery("table.wcvendors-table.wcvendors-table-recent_product.wcv-table tbody>tr>td:nth-child(3):contains('Online')").each(function(){
			var rec_pro_online = jQuery(this).text();
			var on1 = rec_pro_online.substr(0, rec_pro_online.indexOf(' '));
			var on2 = rec_pro_online.substr(rec_pro_online.indexOf(' ')+1);
			
			jQuery(this).html("Publicado <br>" + on2);
			
		});


		setTimeout(function(){
		var terms_text = jQuery("#post-2270 p.forgetmenot.agree-to-terms-container label").html();
		
		var input_chk = terms_text.substr(0, terms_text.indexOf('I'));
		
		jQuery("#post-2270 p.forgetmenot.agree-to-terms-container label").html(" "+ input_chk +" HE LEÍDO Y ACEPTO LOS <a target='top' href='https://koins.club/terminos/'>TÉRMINOS Y CONDICIONES</a>.");


		}, 2000);

		jQuery("#post-2270 form.register .phn-field-regis").insertAfter("#post-2270 form.register > p.woocommerce-form-row.woocommerce-form-row--wide.form-row.form-row-wide:nth-child(2)");

		var change_img_txt = jQuery("#post-2270 .submit #submit").val();
		if( change_img_txt == "Perfil actualizado" ) {
			jQuery("#post-2270 .submit #submit").val("Actualizar Perfil");
		}

	setTimeout(function(){
		if(jQuery(".woocommerce .woocommerce-MyAccount-content .myaccount_user").find("form.edit-account").length > 0) {
			jQuery(".wpua-edit").insertAfter(".woocommerce .woocommerce-MyAccount-content .myaccount_user form.woocommerce-EditAccountForm.edit-account");
		} else {
			jQuery(".wpua-edit").css('display', 'none');
		}
	}, 1000);

	if(jQuery(".shop_table.shop_table_responsive.cart tr.woocommerce-cart-form__cart-item.cart_item td.product-name:contains('Koins')").length > 0)
	{
		var blu = jQuery(".cart-collaterals .cart_totals .shop_table tr.cart-subtotal td").html();
		var blu2 = blu.split("(");
		var prt1 = blu2[0];
		var prt2 = blu2[1];
		var koin_amt = parseInt(prt2.replace(/[^0-9\.]/g, ''), 10);
		jQuery(".cart-collaterals .cart_totals .shop_table tr.cart-subtotal td").html(prt1 + " (por " + koin_amt + " Koins) ");
		

		var b11 = jQuery(".cart-collaterals .cart_totals .shop_table tr.order-total td strong").html();
		var b12 = b11.split("(");
		var prt11 = b12[0];
		var prt22 = b12[1];
		var koin_amt1 = parseInt(prt22.replace(/[^0-9\.]/g, ''), 10);
		jQuery(".cart-collaterals .cart_totals .shop_table tr.order-total td strong").html(prt11 + " (por " + koin_amt1 + " Koins) ");
		

	}
		

	setInterval(function(){
		if (jQuery(".widget.woocommerce.widget_shopping_cart.active_cart .widget_shopping_cart_content ul li.woocommerce-mini-cart-item.mini_cart_item:contains('Koins')").length > 0) {
			var side_crt_for = jQuery(".widget.woocommerce.widget_shopping_cart.active_cart .widget_shopping_cart_content p.woocommerce-mini-cart__total.total").html();
			var str_for1 = side_crt_for.split("(");
			var prt111 = str_for1[0];
			var prt222 = str_for1[1];
			var koin_amt2 = parseInt(prt222.replace(/[^0-9\.]/g, ''), 10);
			jQuery(".widget.woocommerce.widget_shopping_cart.active_cart .widget_shopping_cart_content p.woocommerce-mini-cart__total.total").html(prt111 + " ( por " + koin_amt2 + " Koins) ");

		}
	}, 100);

	setInterval(function(){
		if(jQuery(".woocommerce-checkout-review-order .shop_table.woocommerce-checkout-review-order-table tbody tr.cart_item td.product-name:contains('Koins')").length > 0)
		{
			var chk_for = jQuery(".checkout.woocommerce-checkout #order_review .shop_table.woocommerce-checkout-review-order-table tfoot tr.cart-subtotal td").html();
			var chk_spl = chk_for.split("(");
			var chk_prt1 = chk_spl[0];
			var chk_prt2 = chk_spl[1];
			var chk_koin_amt = parseInt(chk_prt2.replace(/[^0-9\.]/g, ''), 10);
			
			jQuery(".woocommerce-checkout-review-order .woocommerce-checkout-review-order-table tfoot tr.cart-subtotal td").html(chk_prt1 + " (por " + chk_koin_amt + " Koins) ");
			
			var chk_for1 = jQuery(".checkout.woocommerce-checkout #order_review .shop_table.woocommerce-checkout-review-order-table tfoot tr.order-total td strong").html();
			var chk_spl1 = chk_for1.split("(");
			var chk_prt11 = chk_spl1[0];
			var chk_prt22 = chk_spl1[1];
			var chk_koin_amt1 = parseInt(chk_prt22.replace(/[^0-9\.]/g, ''), 10);
			
			jQuery(".woocommerce-checkout-review-order .woocommerce-checkout-review-order-table tfoot tr.order-total td strong").html(chk_prt11 + " (por " + chk_koin_amt1 + " Koins) ");
			
		}

		}, 1000);

	// setTimeout(function(){
	// 	if(jQuery(".checkout.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tr.cart_item td.product-name:contains('Koins')").length > 0) {
	// 		var chkout_for = jQuery(".checkout.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tfoot tr.cart-subtotal td").html();
	// 		var chkout_for_spl = chkout_for.split("(");
	// 		var prt_ck1 = chkout_for_spl[0];
	// 		var prt_ck2 = chkout_for_spl[1];
	// 		var koin_amt_chk2 = parseInt(prt_ck2.replace(/[^0-9\.]/g, ''), 10);
	// 		jQuery(".checkout.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr.cart-subtotal td").html(prt_ck1 + " (por " + koin_amt_chk2 + " Koins) ");
	// 	}
	// }, 1500);

	// var lbl_pass = jQuery(".woocommerce .woocommerce-MyAccount-content .myaccount_user form fieldset > legend:contains('Cambio de contraseña')").length;
	
	// if( lbl_pass != 0 ) {
	// 	jQuery("#wpua-edit-13").insertAfter(".woocommerce .woocommerce-MyAccount-content .myaccount_user form.woocommerce-EditAccountForm.edit-account");

	// } else {
	// 	jQuery("#wpua-edit-13").css('display', 'none');
	// }
// var wid = jQuery(window).width();
// alert(wid);
	});
</script>
<?php wp_footer(); ?>
</body>
</html>
