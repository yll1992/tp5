<?php

namespace app\common\model;

use think\Model;

class Cart extends Model
{
     //声明模型对应的表名（注：默认表名就是小写类名，特殊情况需要声明重写规则）
    protected $table = 'cart';

    //声明插入数据时间字段自动填充
    protected $autoWriteTimestamp = true;
    //创建时间字段
    protected $createTime = 'created_at';
    //更新时间字段
    protected $updateTime = 'updated_at';

    /**
     * 加入购物车
     * @param int    $goodsId       商品编号
     * @param int    $number        商品数量
     * @param string $goodsAttrIds  商品属性
     */
    public static function addCart($goodsId, $number, $goodsAttrIds){
    	if(session('frontUserinfo')){

    			$where=[
    				'user_id'=>session('frontUserinfo.user_id'),
    				'goods_id'=>$goodsId,
    				'goods_attr_ids'=>$goodsAttrIds
    			];

    			$cart=Cart::where($where)->find();
    			if($cart){
    				$cart->goods_number+=$number;
    				$sr=$cart->save();
    			}else{
    				$where['goods_number']=$number;
    				$sr=self::create($where);
    			}
    			return $sr;
    	}else{
    		 $data = cookie('cart') ? unserialize(cookie('cart')): [];
    		$key=$goodsId.'-'.$goodsAttrIds;
    		  if(isset($data[$key])){
                //存在相同记录 累加数量
                $data[$key] += $number;
            }else{
                //不存在相同记录 添加一个键值对
                $data[$key] = $number;
            }
            //重新存储到cookie中
            cookie('cart', serialize($data), 86400 * 7 );
            return true;
       		
    	}
    }

    //显示购物车数据
    public static function getCart(){
        if(session('frontUserinfo')){
            $carts=self::where('user_id',Session("frontUserinfo.user_id"))->select();
            foreach($carts as $cart){
                $cart->goodsinfo=Goods::where('goods_id',$cart->goods_id)->find();
                $cart->goods_attr=GoodsAttr::field('attribute.attr_name,goods_attr.*')
                    ->join('attribute','goods_attr.attr_id=attribute.attr_id')
                    ->where('goods_attr.id','in',$cart->goods_attr_ids)
                    ->select();
             }

        }else{
            $datas=cookie('cart')?unserialize(cookie('cart')): [];
            $carts=[];
            foreach($datas as $k=>$nuber){
                    $temp=explode('-', $k);
                    $goodsId=$temp[0];
                    $goodsAttrs=$temp[1];
                    array_push($carts,[
                            'goods_id'=>$goodsId,
                            'goods_attr_ids'=>$goodsAttrs,
                            'goods_number'=>$nuber,
                            'goodsinfo'=>Goods::where('goods_id',$goodsId)->find(),
                            'goods_attr'=>GoodsAttr::field('attribute.attr_name,goods_attr.*')
                                        ->join('attribute','goods_attr.attr_id=attribute.attr_id')
                                        ->where('goods_attr.id','in',$goodsAttrs)
                                        ->select()
                        ]);
            }

        }
        return $carts;
    }

      /**
     * 修改购物车
     * @param int    $goodsId       商品编号
     * @param int    $number        商品数量
     * @param string $goodsAttrIds  商品属性
     */
    public static function updateNum($goodsId,$goodsAttrIds,$number){
     
        if(session('frontUserinfo')){
            $where=[
                'goods_id'=>$goodsId,
                'goods_attr_ids'=>$goodsAttrIds
            ];
            $cart=self::where($where)->find();
            if($cart){
                $cart->goods_number=$number;
                $sr=$cart->save();
                return $sr;
            }
            return false;
        }else{
            $data=cookie('cart')?unserialize(cookie('cart')): [];
            $key=$goodsId.'-'.$goodsAttrIds;
            if(isset($data[$key])){
                $data[$key]=$number;
            }else{
                return false;
            }
            cookie('cart',serialize($data),3600*24*7);
            return true;
        }
    }


      /**
     * 删除购物车商品
     * @param int    $goodsId       商品编号
     * @param string $goodsAttrIds  商品属性
     */

      public static function deleteCart($goodsId,$goodsAttrIds){
        if(session('frontUserinfo')){
            $where=[
                'user_id'=>session('frontUserinfo.user_id'),
                'goods_id'=>$goodsId,
                'goods_attr_ids'=>$goodsAttrIds
            ];
            $sr=self::where($where)->delete();
            return $sr;

        }else{
            $data=cookie('cart')? unserialize(cookie('cart')):[];
            $key=$goodsId.'-'.$goodsAttrIds;
            if(isset($data[$key])){
                unset($data[$key]);
            }else{
                return false;
            }
            cookie('cart',serialize($data),3600*24*7);
            return true;
        }
      }

    /**
     * 登录时cookie入库
     */
    public static function cookieTodb(){
        $datas=cookie('cart')?unserialize(cookie('cart')):[];
        foreach($datas as $key=>$number){
            $temp=explode('-', $key);
            $goodsId=$temp[0];
            $goodsAttrIds=$temp[1];
            $cart=self::where(['goods_id'=>$goodsId,'goods_attr_ids'=>$goodsAttrIds])
                        ->find();
            if($cart){
                $cart->goods_number+=$number;
                $cart->save();
            }else{
                self::create(['goods_id'=>$goodsId,
                            'goods_attr_ids'=>$goodsAttrIds,
                            'goods_number'=>$number,
                            'user_id'=>session('frontUserinfo.user_id')
                            ]);
            }
        }
        cookie('cart',null);
    }

    /**
     * 检查库存
     *@param string    $poatData       商品编号
     */
    public static function checkNumber($postData){
        $carts=self::field('cart.*,goods.goods_name,goods.goods_number as goods_total')
             ->join('goods', 'cart.goods_id = goods.goods_id', 'left')
             ->where('cart_id','in',$postData)
             ->select();
        foreach($carts as $key=>$cart){
            if($cart->goods_number > $cart->goods_total){
                return "商品库存不足";
            }
        }
        return true;
    }

     /**
     * 结算商品价格
     *@param string    $cartId       购买的商品Id
     */

     public static function getPriceTotal($cartId){
           return self::join('goods', 'cart.goods_id=goods.goods_id', 'left')
                        ->where('cart.cart_id','in', $cartId)
                        ->sum('goods.goods_price*cart.goods_number');
     }


      /**
     * 删除购物车中已购买的商品
     *@param string    $cartId       购买的商品Id
     */
     public static function truncateCart($cartId){
        return self::where('cart_id','in',$cartId)->delete();
     }
}
