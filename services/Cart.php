<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fecshop\services;
use Yii;
use yii\base\InvalidValueException;
use yii\base\InvalidConfigException;
use fec\helpers\CSession;
use fecshop\models\mysqldb\Cart as MyCart;
use fecshop\models\mysqldb\Cart\Item as MyCartItem;
/**
 * Cart services
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Cart extends Service
{
	
	/**
	 * 将某个产品加入到购物车中
	 * @property $item|Array
	 * $item = [
	 *		'product_id' 		=> 22222,
	 *		'custom_option_sku' => ['color'=>'red','size'=>'l'],
	 *		'qty' 				=> 22,
	 * ];
	 */
	protected function actionAddProductToCart($item){
		$product = Yii::$service->product->getByPrimaryKey($item['product_id']);
		$productValidate = Yii::$service->cart->info->validateProduct($item,$product);
		if(!$productValidate){
			return false;
		}
		//echo $item['custom_option_sku'];
		if(isset($item['custom_option_sku']) && !empty($item['custom_option_sku'])){
			$custom_option_sku = Yii::$service->cart->info->getCustomOptionSku($item,$product);
			if(!$custom_option_sku){
				return false;
			}
			$item['custom_option_sku'] = $custom_option_sku;
		}
		
		
		Yii::$service->cart->quote->getMyCart();
		$innerTransaction = Yii::$app->db->beginTransaction();
		try {
			Yii::$service->cart->quoteItem->addItem($item);
			$innerTransaction->commit();
		} catch (Exception $e) {
			$innerTransaction->rollBack();
		}
		return true;
		
	}
	# 得到购物车中产品的个数
	protected function actionGetCartItemQty(){
		return Yii::$service->cart->quote->getCartItemCount();
		
	}
	
	/**
	 * 初始化
	 */
	/*
	protected function initAddItem($product_id,$co_sku,$qty){
		$product = $this->_product;
		
		$base_price = Yii::$service->product->price->getFinalPrice(
			$product['price'],$product['special_price']	,
			$product['special_from'],$product['special_to']	,
			$qty, $product['tier_price']
		);
		$base_row_total = $base_price * $qty;
		
		$current_currency_price = Yii::$service->page->currency->getCurrentCurrencyPrice($base_price);
		$row_total = $current_currency_price * $qty;
		
		$weight = $product['weight'];
		$row_weight = $weight * $qty;
		
		$this->_add_item = [
			'product_id'		=> $product_id,
			'co_sku'			=> $co_sku,
			'qty' 				=> $qty,
		];
	}
	*/
	
	
	
	protected function actionGetUserCartInfo(){
		
		
	}
	
	protected function actionChangeItemQty($sku){
		
	}
	
	/**
	 *  merge cart , if current cart currency is not equals to user cart currency when user login account.
	 */
	protected function actionMergeCartAfterUserLogin(){
		
		
	}
	
	/**
	 * change current cart currency 
	 * 1. check if currency is allowed to change.
	 */
	protected function actionChangeCartCurrency(){
		
		
	}
	
	/**
	 * @property $language|String
	 * change current language , cart product  language change to current language.
	 */
	protected function actionChangeProductLanguage($language=''){
		
		
	}
	
	/**
	 * @property $address|Array
	 * save cart address.like,,  customer name,tel,email,address ,,etc,,.
	 */
	protected function actionSaveCartAddress($address){
		
		
	}
	
	/**
	 * @property $shippingId | Int 
	 * 1.check if $shippingId is effective
	 * 2.add or change shipping to cart.
	 * 3.change shipping cost after change
	 * 
	 */
	protected function actionSaveCartShipping($shippingId){
		
		
	}
	
	/**
	 * @property $payment | Int 
	 * 1.check if $paymentId is effective
	 * 2.add or change payment to cart.
	 */
	protected function actionSaveCartPayment($paymentId){
		
		
	}
	
	/**
	 * $item_ids
	 * remove cart items by $items_ids
	 */
	protected function actionRemoveItems($item_ids){
		
		
	}
	
	/**
	 * clear cart product.
	 */
	protected function actionClearCart(){
		
		
	}
	
	/**
	 * generate order by current Cart.
	 */
	protected function actionGenerateOrderByCart(){
		
		
	}
	
	/**
	 * add cart items by pending order Id
	 * 1. check if the order is exist ,and belong to current customer.
	 * 2. get all item sku and custom option.
	 * 3. add to cart like in product page ,click add to cart button.
	 */
	protected function actionAddItemsByPendingOrder($order_id){
		
		
	}
	
	
}