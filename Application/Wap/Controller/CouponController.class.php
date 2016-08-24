<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 2016/5/23
 * Time: 10:42
 */

namespace Wap\Controller;
use Think\Controller;

class CouponController extends BaseController{
    private $Wappage='';
    public function _initialize(){
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function index($cid=0){

        $map['status']=0;
        if(!$cid){
            //$map['column_id']=array('neq',5);
        }else{
            $cols = M('column')->where('status=0')->select();
            $child = \Tool\Category::getChildrenForIds($cols,$cid);
            if($child){
                $child.=",".$cid;
            }else{
                $child.=$cid;
            }
            
            $map['coupon_cid']=array('in',$child);
        }

        $list = $this->getlist(M('coupons'),$map,'','coupon_cid',9);
        foreach ($list as $k=> $v){
            $t = explode('|',$v['coupons_val']);
            $v['coupons_product'] =  M('article')->find($t[0]);
            $list[$k]=$v;
        }
        $this->list=$list;
        $this->display();
    }

    public function details($id=0){
        if(!$id){
            $this->display("Common:404");
        }
        $coupons = M('coupons')->find($id);
        $t = explode('|',$coupons['coupons_val']);
        $coupons['coupons_product'] =  M('article')->find($t[0]);
        $this->vo=$coupons;
        $this->get_order=$this->get_new_order();
        $this->display();
    }
    //注意 city方法 本身是 protected 方法
    protected function _empty(){
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码

       if(strstr($_SERVER['REQUEST_URI'],'/t')){
          $url = str_replace('/t','http://ni2.org',$_SERVER['REQUEST_URI']);
           header('location:'.$url);
       }
        $this->assign('Wap',$this->Wappage);
        $this->display("Common:404");
    }

}