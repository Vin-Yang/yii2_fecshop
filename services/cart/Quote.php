<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
namespace fecshop\services\cart;
use Yii;
use yii\base\InvalidValueException;
use yii\base\InvalidConfigException;
use fecshop\services\Service;
use fecshop\models\mysqldb\Cart as MyCart;
/**
 * Cart services
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Quote extends Service
{
	
	
	protected $_my_cart;		# 购物车cart对象
	protected $_cart_id;
	const SESSION_CART_ID = 'current_session_cart_id';
	
	public $items_count;
	
	/**
	 * 得到购物车中产品的个数。
	 */
	public function getCartItemCount(){
		$cart_id = Yii::$app->session->get(self::SESSION_CART_ID);
		if($cart_id){
			$cart_id = $this->getCartId();
			if($cart_id ){
				$cart = $this->getMyCart();
				return $cart['items_count'] ? $cart['items_count'] : 0;
			}
		}
		return 0;
	}
	
	public function computeCartInfo(){
		$cart_id = $this->getCartId();
		if($cart_id){
			if(!$this->_my_cart){
				$this->getMyCart();
			}
			$item_qty = Yii::$service->cart->quoteItem->getItemQty();
			$this->items_count = $item_qty;
			$this->_my_cart->items_count = $item_qty;
			$this->_my_cart->save();
		}
		
		
	}
	/**
	 * 返回当前的购物车Db对象
	 */
	public function getMyCart(){
		if(!$this->_my_cart){
			if($cart_id = $this->getCartId()){
				if(!$this->_my_cart){
					$this->_my_cart = MyCart::findOne(['cart_id'=>$cart_id]);
				}
			}else{
				$this->createCart();
			}
		}
		return $this->_my_cart;
	}
	
	public function getCartId(){
		if(!$this->_cart_id){
			$cart_id = Yii::$app->session->get(self::SESSION_CART_ID);
			if($cart_id){
				$one = MyCart::findOne($cart_id);
				if($one['cart_id']){
					$this->_cart_id = $cart_id;
					$this->_my_cart = $one;
				}
			}
		}
		return $this->_cart_id;
	}
	
	protected function setCartId($cart_id){
		$this->_cart_id = $cart_id;
		Yii::$app->session->set(self::SESSION_CART_ID,$cart_id);
	}
	
	/**
	 * 初始化创建cart信息，
	 * 在用户的第一个产品加入购物车时，会在数据库中创建购物车
	 */
	protected function createCart(){
		$myCart = new MyCart;
		$myCart->store = Yii::$service->store->currentStore;
		$myCart->created_at = time();
		$myCart->updated_at = time();
		if(!Yii::$app->user->isGuest){
			$identity 	= Yii::$app->user->identity;
			$id 		= $identity['id'];
			$firstname 	= $identity['firstname'];
			$lastname 	= $identity['lastname'];
			$email 		= $identity['email'];
			$myCart->customer_id 		= $id;
			$myCart->customer_email 	= $email;
			$myCart->customer_firstname = $firstname;
			$myCart->customer_lastname 	= $lastname;
			$myCart->customer_is_guest	= 2;
		}else{
			$myCart->customer_is_guest	= 1;
		}
		$myCart->remote_ip = \fec\helpers\CFunc::get_real_ip();
		$myCart->app_name  = Yii::$service->helper->getAppName();
		$myCart->save();
		$cart_id = Yii::$app->db->getLastInsertId();
		$this->setCartId($cart_id);
		
		$this->_my_cart = MyCart::findOne($cart_id);
	}
	
	
	
	
}