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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
