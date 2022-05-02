<?php

/* TEST WORK 412 */
add_action( 'add_meta_boxes', 'meta_box_add' );

function meta_box_add() {
	add_meta_box( '', 'Дополнительные поля', 'postbox_func', 'product', 'advanced', 'default' );
}

function postbox_func($post) {
	?>
<div class="panel woocommerce_options_panel" style="">

	

	<div class="options_group" style="display: block;">
		<!-- Date -->
		<p class="form-field">
			<label for="_created_time">Время создания</label>
			<input type="text" class="short wc_input_date" style="" name="_created_time" id="_created_time" value="<?php echo get_post_meta($post->ID,'_created_time',true); ?>" placeholder="">
		</p>	
	
		<!-- Type -->
		<p class="form-field">
			<label for="_product_type">Тип товара</label>
			<select style="" id="_product_type" name="_product_type" class="select short">
				<?php
					$product_type = get_post_meta($post->ID,'_product_type',true);
					$sel_text = ' selected="selected"';
				?>
				<option value="0"<?php if($product_type == 0) echo $sel_text; ?>>Rare</option>
				<option value="1"<?php if($product_type == 1) echo $sel_text; ?>>Frequent</option>
				<option value="2"<?php if($product_type == 2) echo $sel_text; ?>>Unusual</option>
			</select>
		</p>
		
		<!-- Images -->
		<p class="form-field">
			<label>Изображения</label>
			<?php
				/* Banner */ 
				$banner_img = get_post_meta($post->ID,'post_banner_img',true);
				?>
				<?php echo multi_media_uploader_field( 'post_banner_img', $banner_img ); ?>

		</p>
		
	
	</div>
</div>

<style type="text/css">
		.multi-upload-medias ul li .delete-img { position: absolute; right: 3px; top: 2px; background: aliceblue; border-radius: 50%; cursor: pointer; font-size: 14px; line-height: 20px; color: red; }
		.multi-upload-medias ul li { width: 120px; display: inline-block; vertical-align: middle; margin: 5px; position: relative; }
		.multi-upload-medias ul li img { width: 100%; }
</style>
<script type="text/javascript">
	// Uploader script
		jQuery(function($) {

			$('body').on('click', '.wc_multi_upload_image_button', function(e) {
				e.preventDefault();

				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					button: { text: 'Use this image' },
					multiple: true 
				}).on('select', function() {
					var attech_ids = '';
					attachments
					var attachments = custom_uploader.state().get('selection'),
					attachment_ids = new Array(),
					i = 0;
					attachments.each(function(attachment) {
						attachment_ids[i] = attachment['id'];
						attech_ids += ',' + attachment['id'];
						if (attachment.attributes.type == 'image') {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						} else {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						}

						i++;
					});

					var ids = $(button).siblings('.attechments-ids').attr('value');
					if (ids) {
						var ids = ids + attech_ids;
						$(button).siblings('.attechments-ids').attr('value', ids);
					} else {
						$(button).siblings('.attechments-ids').attr('value', attachment_ids);
					}
					$(button).siblings('.wc_multi_remove_image_button').show();
				})
				.open();
			});

			$('body').on('click', '.wc_multi_remove_image_button', function() {
				$(this).hide().prev().val('').prev().addClass('button').html('Добавить');
				$(this).parent().find('ul').empty();
				return false;
			});

		});

		jQuery(document).ready(function() {
			jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {
				var ids = [];
				var this_c = jQuery(this);
				jQuery(this).parent().remove();
				jQuery('.multi-upload-medias ul li').each(function() {
					ids.push(jQuery(this).attr('data-attechment-id'));
				});
				jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
			});
		})
	</script>
	<?php
}


function multi_media_uploader_field($name, $value = '') {
	/* Uploader func */
	$image = '">Добавить';
	$image_str = '';
	$image_size = 'full';
	$display = 'none';
	$value = explode(',', $value);

	if (!empty($value)) {
		foreach ($value as $values) {
			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
				$image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
			}
		}

	}

	if($image_str){
		$display = 'inline-block';
	}

	return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Очистить</a></div>';

}

// Save Meta Box values.
add_action( 'save_post_product', 'wc_meta_box_save' );

function wc_meta_box_save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;	
	}

	if( !current_user_can( 'edit_post' ) ){
		return;	
	}
	
	if( isset( $_POST['post_banner_img'] ) ){
		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
	}
	if( isset( $_POST['_created_time'] ) ){
		update_post_meta( $post_id, '_created_time', $_POST['_created_time'] );
	}
	if( isset( $_POST['_product_type'] ) ){
		update_post_meta( $post_id, '_product_type', $_POST['_product_type'] );
	}
}


add_action( 'wp_ajax_createproduct', 'create_product_func' );
add_action( 'wp_ajax_nopriv_createproduct', 'create_product_func' );

function create_product_func() {
	// Validation fields
	$product_title = $_POST['product_title'];
	$product_type = $_POST['product_type'];
	$product_price = floatval($_POST['price']);
	if(!isset($product_title) OR (strlen($product_title) < 3 OR strlen($product_title) > 30)) {
		echo json_encode(array('status'=>'0','text' =>"Неправильная валидация"));
		wp_die();
	}
	$select_vals = array(0,1,2);
	if(!isset($product_type) OR !in_array($product_type,$select_vals)) {
		echo json_encode(array('status'=>'0','text' =>"Неправильная валидация 2"));
		wp_die();
	}
	if(!isset($product_price) OR (strlen($product_price) < 1 OR strlen($product_price) > 7)) {
		echo json_encode(array('status'=>'0','text' =>"Неправильная валидация цены"));
		wp_die();
	}

	
	// Check image
	if (isset( $_POST['my_image_upload_nonce'] ) AND wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )) {
		if(!empty($_FILES['product_image']['name'])) {
				$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg');

				if (in_array($_FILES['product_image']['type'], $arr_img_ext)) {

					if ( !empty( $_FILES["product_image"]["name"] ) ) {
						$attachment_id = media_handle_upload( 'product_image', 0 );
					}

					if ( is_wp_error( $attachment_id ) ) {
						echo json_encode(array('status'=>'0','text' =>"Ошибка загрузки медиафайла."));
						wp_die();
					} else {

					}
				} else {
					echo json_encode(array('status'=>'0','text' =>"Изображение неправильного формата"));
					wp_die();
				}
		}
	} else {
	echo json_encode(array('status'=>'0','text' =>"Проверка не пройдена."));
		wp_die();
}
	
	
	// Create product
	$post_args = array(
        'post_author' => 1, // The user's ID
        'post_title' => sanitize_text_field( $product_title ), // The product's Title
        'post_type' => 'product',
        'post_status' => 'publish' // This could also be $data['status'];
    );

    $post_id = wp_insert_post( $post_args );
   
    if ( ! empty( $post_id ) && function_exists( 'wc_get_product' ) ) {
        $product = wc_get_product( $post_id );
        $product->set_sku( 'pre-' . $post_id ); // Generate a SKU with a prefix. (i.e. 'pre-123') 
        $product->set_regular_price( $product_price ); // Be sure to use the correct decimal price.
        $product->save(); // Save/update the WooCommerce order object.
		if(!empty($attachment_id)) {
			update_post_meta( $post_id, 'post_banner_img', $attachment_id );
			set_post_thumbnail( $post_id, $attachment_id );
		}
		update_post_meta( $post_id, '_created_time', date('H:i:s d.m.Y') );
		update_post_meta( $post_id, '_product_type', $product_type );
		echo json_encode(array('status'=>'1','text' =>get_post_permalink($post_id)));
		wp_die();
    } else {
		echo json_encode(array('status'=>'0','text' =>"Ошибка создания продукта"));
		wp_die();
	}
	
	wp_die();
}

add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts(){
	/* Create product page scripts */
  ?>
  	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function () {
	// ON KEY UP CLEAR INVALID
	if($('input[type="text"],input[type="number"]').keyup(function() {
		$(this).parent().removeClass('invalid');
		$(this).parent().parent().removeClass('invalid');
		$(this).parent().children('.validation_text').eq(0).text('');
		$(this).parent().parent().children('.validation_text').eq(0).text('');
	}));
	
	// VALIDATION
	
	$('input[name="product_image"]').change(function (event) {
		var err = 0;
		var validExtensions = ["jpg",,"jpeg","png"]
		var file = $(this).val().split('.').pop();
		if (validExtensions.indexOf(file) == -1) {
			$('input[name="product_image"]').val('');
			$('input[name="product_image"]').parent().parent().addClass('invalid');
			$('input[name="product_image"]').parent().parent().children('.validation_text').eq(0).text('Allowed only .png,.jpg,.jpeg');
			err++;
		} else if($(this).prop('files')[0].size > 200000) {
			$('input[name="product_image"]').val('');
			$('input[name="product_image"]').parent().parent().addClass('invalid');
			$('input[name="product_image"]').parent().parent().children('.validation_text').eq(0).text('Size limit 200kb');
			err++;
		} else {
			showPreview(event);
			$('input[name="product_image"]').parent().parent().children('.validation_text').eq(0).text('');
		}

	});
	
	// SEND AJAX
 
    $(".submit-btn").click(function (event) {
 		var err = 0;
        //stop submit the form, we will post it manually.
        event.preventDefault();
		
		
		if($('input[name="product_title"]').val().length < 3 || $('input[name="product_title"]').val().length > 30) {
			$('input[name="product_title"]').parent().addClass('invalid');
			$('input[name="product_title"]').parent().children('.validation_text').eq(0).text('Length of this row must to be at least 3 symbols and not large 30 symobols');
			err++;
		}
		
		if($('input[name="price"]').val().length < 1 || $('input[name="price"]').val().length > 6) {
			$('input[name="price"]').parent().parent().addClass('invalid');
			$('input[name="price"]').parent().parent().children('.validation_text').eq(0).text('Write a correct price(max $1M)');
			err++;
		}

		if(err == 0) {
			
			// Get form
			var form = $('#create-product')[0];

		   // Create an FormData object 
			var datas = new FormData(form);

		   // disabled the submit button
			$(".submit-btn").addClass('loading');
			$(".submit-btn").text('Creating');

			datas.append('action', 'createproduct');
			
			$.ajax({
				type: "POST",
				url: "<?php echo admin_url( "admin-ajax.php" ) ?>",
				data: datas, // можно также передать в виде массива или объекта
				processData: false,
				contentType: false,
				success: function (data) {

					console.log("RES: ", data);
					$(".submit-btn").removeClass('loading');
					$(".submit-btn").text('Create');
					if(JSON.parse(data)['status'] == 1) {
						$(".submit-btn").text('Ready');
						window.location.href = JSON.parse(data)['text'];
					} else {
						alert(JSON.parse(data)['text']);
					}
					

				},
				error: function (e) {

					$("#output").text(e);
					console.log("ERROR : ", e);
					$(".submit-btn").removeClass('loading');

				}
			});
		}
 
    });
 
});		
	
/* INPUT COUNTER */
const elemLogin = document.querySelector('.counter');
const elemCounter = elemLogin.nextElementSibling;
const maxLength = elemLogin.maxLength;
const updateCounter = (e) => {
  const len = e ? e.target.value.length : 0;
  elemCounter.textContent = `${len} / ${maxLength}`;
}
updateCounter();
elemLogin.addEventListener('keyup', updateCounter);
elemLogin.addEventListener('keydown', updateCounter);
	
/* UPLOADER PREVIEW */
 function showPreview(event){
  if(event.target.files.length > 0){
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("file-ip-1-preview");
    preview.src = src;
    preview.style.display = "block";
  }
}
</script>
  <?php
}