<?php
namespace Wap\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index() {
        vendor('wechatThinkPHP.Wechat');

        $options = array(
			'token'=>'pinkanQW', //填写你设定的key
			'encodingaeskey'=>'uNXYHP7HGp2mVlgKuLC5ReKi0Yi85LEPv3j1ZCg0yUw', //填写加密用的EncodingAESKey
			'appid'=>'wxf02790fbcadf974a', //填写高级调用功能的app id
 			'appsecret'=>'d5f062346b24ca499e6997fc2f38d4db' //填写高级调用功能的密钥
         );
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $weObj = new \Wechat($options);
        $type = $weObj->getRev()->getRevType();
        $path='./Data/Log/'.date('Y-m-d',time());
        if (!file_exists($path)){
            mkdir($path,0777,true);
        }
        //file_put_contents($path."/".time().'.txt',$postStr);
        switch($type) {
            case \Wechat::MSGTYPE_TEXT:
                $weObj->text("hello, I'm wechat")->reply();
                exit;
                break;
            case \Wechat::EVENT_MENU_VIEW:
                $openid = $weObj->getRevFrom();
                file_put_contents($path."/".time().'.txt',$postStr);
                exit;
                break;
            default:
                $weObj->text("欢迎关注，品看生活网")->reply();
        }
//
//        $newmenu =  array(
//   		    "button"=>
//                array(
//
//                    array('type'=>'view','name'=>'品看生活','url'=>'http://www.pinkan.cn/wap')
//                )
//   		);
//
//        $weObj->createMenu($newmenu);

        $this->com_list=$this->get_com_list(6);
        $this->display();
    }
    /**
     * @todu 微信认证token
     */
    public function valid(){
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = '4lkg31sd23h1a6erg';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    public function test(){
        $data['username']="张勇";
        $data['ordid']=get_order_trade_no();
        $data['ordfee']=2000;
        $data['phone']='15371829847';
        $sms_info1 ="尊敬的".$data['username']."，你成功支付了订单号为".$data['ordid']."的账单".$data['ordfee']."元，现等待官方发货。";
        $_var = random(4,1);
        session('var',$_var);
        $_result = sendSMS($data['phone'],$_var,$sms_info1);
        p($_result);
    }
    public function get_article_list($cid=0,$s=5){
        if(!$cid){
            $this->ajaxReturn(array('msg'=>0,'msg'=>'栏目ID不能为空'));
        }
        $cols = M('column')->where('status=0')->select();
        $child = \Tool\Category::getChildrenForIds($cols,$cid);
        $child.=",".$cid;

        $map['status']=0;
        $map['column_id']=array('in',$child);
        $list = M('article')->where($map)->limit($s)->select();
        $this->list=$list;
        $data = $this->fetch('pro_list');
        $this->ajaxReturn(array('status'=>1,'list'=>$data));
    }

    /**
     * 获取推荐列表
     * @param int $s
     * @param int $o
     * @return mixed
     */
    public function get_com_list($s=5,$o=0){
        $map['status']=0;
        $map['column_id']=array('in','1,2,3,4');
        $list = M('article')->field('id,title,description,image,price,tprice')->where($map)->limit($s)->order('date desc')->select();
        if($o){
            $this->ajaxReturn(array('msg'=>1,'data'=>$list));
        }
        return $list;
    }
    /**
     * 获取推荐列表
     * @param int $s
     * @param int $o
     * @return mixed
     */
    public function get_redwine_list($s=6,$o=0){
        $map['status']=0;
        $map['column_id']=5;
        $list = M('article')->where($map)->limit($s)->select();
        if($o){
            $this->ajaxReturn(array('msg'=>1,'data'=>$list));
        }
        return $list;
    }
}