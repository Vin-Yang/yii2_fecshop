<div class="main container one-column">
	<div class="col-main">
		<div class="product_page">
			<div class="product_view">
				<input type="hidden" class="product_view_id" value="<?=  $_id ?>">
				<input type="hidden" class="sku" value="<?= $sku; ?>" />
				<input type="hidden" class="product_csrf" name="" value="" />
				<div class="product_info">
					<h1><?= $name; ?></h1>
					<div>
						<div class="rbc_cold">
							<span>
								<span class="average_rating">Average rating :</span>
								<span class="review_star review_star_<?= $reviw_rate_star_average ?>" style="font-weight:bold;" itemprop="average"></span>  
								
								<a rel="nofollow" href="#text-reviews">
									(<span itemprop="count"><?= $review_count ?> reviews</span>)
								</a>
							</span>
						</div>
					</div>
					<div class="item_code">Item Code: <?= $sku; ?></div>
					
					<div class="price_info">
						<?php # 价格部分
							$priceView = [
								'view'	=> 'catalog/product/index/price.php'
							];
							$priceParam = [
								'price_info' => $price_info,
							];
						?>
						<?= Yii::$service->page->widget->render($priceView,$priceParam); ?>
					
					</div>
					<div class="product_info_section">
						<div class="product_options">
							<?php # options部分
								$optionsView = [
									'view'	=> 'catalog/product/index/options.php'
								];
								$optionsParam = [
									'options' => $options,
								];
							?>
							<?= Yii::$service->page->widget->render($optionsView,$optionsParam); ?>
						
						</div>
						<div class="product_custom_options">
							<?php # custom options部分
								$optionsView = [
									'class' =>  'fecshop\app\appfront\modules\Catalog\block\product\CustomOption',
									'view'	=> 'catalog/product/index/custom_option.php',
									'custom_option' 	=> $custom_option,
									'attr_group'		=> $attr_group,
									'middle_img_width' 	=> $media_size['middle_img_width'],
								];
								$optionsParam = [
									
								];
								
								
							?>
							<?= Yii::$service->page->widget->render($optionsView,$optionsParam); ?>
						
						</div>
						
						<div class="product_qty pg">
							<div class="label">Qty:</div>
							<div class="rg">
								<input type="text" name="qty" class="qty" value="1" />
							</div>
							<div class="clear"></div>
						</div>
						
						<div class="addtocart">
							<button  type="button" id="js_registBtn" class="redBtn addProductToCart"><em><span><i></i>Add To Cart</span></em></button>
							
							<div class="myFavorite_nohove" id="myFavorite">
								<i></i>
								<a href="javascript:void(0)" url="<?= Yii::$service->url->getUrl('catalog/favoriteproduct/add',['product_id'=>$_id]); ?>" class="addheart" id="divMyFavorite" rel="nofollow" >
									Add to Favorites
								</a>				
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="tier_price_info">
						<?php # tier price 部分。
							$priceView = [
								'view'	=> 'catalog/product/index/tier_price.php'
							];
							$priceParam = [
								'tier_price' => $tier_price,
							];
						?>
						<?= Yii::$service->page->widget->render($priceView,$priceParam); ?>
					
					</div>
				</div>
				<div class="media_img">
					<div class="col-left ">
						<?php # 图片部分。
							$imageView = [
								'view'	=> 'catalog/product/index/image.php'
							];
							$imageParam = [
								'media_size' => $media_size,
								'image' => $image,
								'productImgMagnifier' => $productImgMagnifier,
							];
						?>
						<?= Yii::$service->page->widget->render($imageView,$imageParam); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			
			<div>
				<?php # tier price 部分。
					$buyAlsoBuyView = [
						'view'	=> 'catalog/product/index/buy_also_buy.php'
					];
					$buyAlsoBuyParam = [
						'products' => $buy_also_buy,
					];
				?>
				<?= Yii::$service->page->widget->render($buyAlsoBuyView,$buyAlsoBuyParam); ?>
			
			</div>
			
			<div class="clear"></div>
			<div class="product_description_info">
				
				
				
				
				<div class="nav" id="nav-container">  
					<ul id="nav-box">
						<li  class="nav_tab cur" rel="description">DESCRIPTION</li>  
						<li  class="nav_tab" rel="reviews">REVIEWS</li>  
						<li  class="nav_tab" rel="questions">SHIPPING & PAYMENT</li>  
						<!-- <li   class="nav_tab" rel="wholesale">WHOLESALE</li>   -->
					</ul>    
				</div>  
				<div id="text">  
					<div class="text-description" style="">
						<?= $description; ?>
					</div>  
					<div class="text-reviews" id="text-reviews" style="">
						<?php # review部分。
							$reviewView = [
								'class' 		=> 'fecshop\app\appfront\modules\Catalog\block\product\Review',
								'view'			=> 'catalog/product/index/review.php',
								'product_id' 	=> $_id,
								'spu'			=> $spu,
							];
							
						?>
						<?= Yii::$service->page->widget->render($reviewView,$reviewParam); ?>
					</div>  
					<div class="text-questions" style="">
						<?php # payment部分。
							$paymentView = [
								'view'			=> 'catalog/product/index/payment.php',
							];
							
						?>
						<?= Yii::$service->page->widget->render($paymentView); ?>
					
					
						
					</div>  
					<!--					
					<div class="text-wholesale" style="width:100%;height:500px;background:yellow;text-align:center;">
						
					</div>  
					-->
				</div> 
			</div>
		</div>
		<div class="proList">
		</div>
	</div>
</div>

<script>
	// add to cart js	
	<?php $this->beginBlock('add_to_cart') ?>
	$(document).ready(function(){
		$(".addProductToCart").click(function(){
			i = 1;
			$(".product_custom_options .pg .rg ul.required").each(function(){
				val = $(this).find("li.current a.current").attr("value");
			    if(!val){
				    $(this).parent().parent().css("border","1px dashed #cc0000").css('padding-left','10px').css("margin-left","-10px");
					i = 0;
				}else{
					$(this).parent().parent().css("border","none").css('padding-left','0px').css("margin-left","0px");
			    
			    }
			});
			if(i){
				custom_option = new Object();
				$(".product_custom_options .pg .rg ul").each(function(){
					$m = $(this).find("li.current a.current");
					attr = $m.attr("attr");
					value = $m.attr("value");
					custom_option[attr] = value;
				});
				custom_option_json = JSON.stringify(custom_option);
				//alert(custom_option_json);
				sku = $(".sku").val();
				qty = $(".qty").val();
				qty = qty ? qty : 1;
				csrfName = $(".product_csrf").attr("name");
				csrfVal  = $(".product_csrf").val();
				
				$(".product_custom_options").val(custom_option_json);
				$(this).addClass("dataUp");
				// ajax 提交数据
				
				addToCartUrl = "<?= Yii::$service->url->getUrl('checkout/cart/add'); ?>";
				$data = {};
				$data['custom_option'] 	= custom_option_json;
				$data['product_id'] 	= "<?= $_id ?>";
				$data['qty'] 			= qty;
				$data[csrfName] 		= csrfVal;
				jQuery.ajax({
					async:true,
					timeout: 6000,
					dataType: 'json', 
					type:'post',
					data: $data,
					url:addToCartUrl,
					success:function(data, textStatus){ 
						if(data.status == 'success'){
							items_count = data.items_count;
							$("#js_cart_items").html(items_count);
							alert('add to cart success');
						}else{
							alert('add to cart fail');
						}
						
					},
					error:function (XMLHttpRequest, textStatus, errorThrown){}
				});
				
			}
		});
	   
	   // product favorite
	   $("#divMyFavorite").click(function(){
			if($(this).hasClass('act')){
				alert("You already favorite this product");
			}else{
				url = $(this).attr('url');
				$(this).addClass('act');
				window.location.href = url;
			}
	   });
	});
	<?php $this->endBlock(); ?> 
	<?php $this->registerJs($this->blocks['add_to_cart'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

	
	//tab 切换js
	<?php $this->beginBlock('product_info_tab') ?> 
	var navContainer = document.getElementById("nav-container");  
	var navBox = document.getElementById("nav-box");  
	var text = document.getElementById("text");  
	var navBoxChild = navBox.children;  
	var textChild = text.children;  
	var num = navContainer.offsetTop;  
	var a = navContainer.offsetHeight;  
	window.onscroll = function(){  
		var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;  
		if(scrollTop >= num){  
			navContainer.className = "nav fixed";  
			text.style.paddingTop = a +"px";  
		}else{  
			navContainer.className = "nav";  
			text.style.paddingTop = "";  
		}  
		//当导航与相应文档接触的时候自动切换  
		//method1  
		for(var i=0;i<navBoxChild.length;i++){  
			if( scrollTop + a >= textChild[i].offsetTop){  
				for(var j=0;j<navBoxChild.length;j++){  
					navBoxChild[j].className = "";  
				}  
				navBoxChild[i].className = "cur";  
		   }  
		}  
	};  
	for(var i=0;i<navBoxChild.length;i++){  
		var interval;  
		navBoxChild[i].index = i;  
		navBoxChild[i].onclick = function(){  
			var self = this;  
			clearInterval(interval); 
			
			if(document.body.scrollTop){
				scroll = document.body;
			}else if(document.documentElement.scrollTop){
				scroll = document.documentElement;
			}

			interval = setInterval(function(){  
				if(scroll.scrollTop + a<=textChild[self.index].offsetTop){  
					scroll.scrollTop += 40;  
					if(scroll.scrollTop + a>=textChild[self.index].offsetTop){  
						scroll.scrollTop = textChild[self.index].offsetTop-a;  
						clearInterval(interval);  
					}  
				}else{  
					scroll.scrollTop /= 1.1;  
					if(scroll.scrollTop + a<=textChild[self.index].offsetTop){  
						scroll.scrollTop = textChild[self.index].offsetTop-a;  
						clearInterval(interval);  
					}  
				}  
			},40);  
		};  
	}  
	<?php $this->endBlock(); ?>  
	<?php $this->registerJs($this->blocks['product_info_tab'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</script> 
  
 