<?php
/**
 * Template Name: Create product
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="card">
				<form method="POST" enctype="multipart/form-data" id="create-product">
				<div class="data-row">
					<label for="product_title">Product name:</label>
					<input name="product_title" value="" id="product_title" placeholder="Product name" type="text" class="counter" maxlength="30">
					<div class="text-field__counter"></div>
					<div class="validation_text"></div>
				</div>
				<div class="data-row">
					<label for="price">Price:</label>
					<div class="icon-right dollar">
						<input name="price" value="" id="price" placeholder="Price" type="number" class="price_input" maxlength="7">
					</div>
					<div class="validation_text"></div>
				</div>
				<div class="data-row">
					<label for="product_type">Product type:</label>
					<select id="product_type" name="product_type" class="select">
						<option value="0" selected>Rare</option>
						<option value="1">Frequent</option>
						<option value="2">Unusual</option>
					</select>
				</div>
					
				<div class="data-row">
					<label for="product_type">Image:</label>
					<div class="form-input">
						<div class="preview">
						   <img id="file-ip-1-preview">
						 </div>
						<label for="file-ip-1">Upload Image</label>
 						<input type="file" name="product_image" id="file-ip-1" accept="image/*">
					</div>
					<div class="validation_text"></div>
				</div>
				<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>	
				</form>
				
				<div class="submit-row">
					<div class="submit-btn">
						Create
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
