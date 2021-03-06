<?php if (!defined('THINK_PATH')) exit();?><div class="ticket" style="float: right; margin: 20px 0 10px 0;">
        <span class="ticket_top">
            <a href="javascript:void(0);" class="current" id="current">领取礼盒</a><a href="javascript:void(0);" id="logistics">
            查询订单状态</a>
            <!-- <b class="xtips1"><font></font><i>礼品券换礼盒</i></b> -->
        </span>
    <!-- 礼品券 -->
    <span id="ticket_edit" class="ticket_edit ticket1">
            <input type="text" name="ticket_code" class="ticket_code" placeholder="请输入礼品券编号" />
            <input type="button" name="fetch" class="fetch" value="领取" />
        </span>
</div>
<form action="<?php echo U('oder/get_goods');?>" method="post" autocomplete="off">
    <!-- 购物列表 -->
    <div class="cart_pro_list">
        <!-- 购买的商品 -->
        <div>
           <h2> 领取卡号：<?php echo ($no); ?></h2>
        </div>
        <div class="cart_product car_check" data-index="<?php echo ($key); ?>">
                    <span class="cart_pro_left">
                        <input type="checkbox" checked="checked" style="display:none;">
                        <!-- <label for="product2"></label> -->
                        <b><img src="<?php echo ($vo["image"]); ?>"></b>
                        <strong>
                            <a><?php echo ($vo["coupons_title"]); ?><span class="claret_red_bg">礼盒</span></a>
                            <i>优质阳澄湖大闸蟹不一样的螃蟹</i>
                            <em><?php echo (get_pro_left($vo["description"])); ?><font>&nbsp;&nbsp;|&nbsp;&nbsp;</font><?php echo (get_pro_right($vo["description"])); ?>
                            </em>
                            <div>
                                <img src="/Public/Home/images/zhengpin.fw.png">
                            </div>
                        </strong>
                    </span>
            <span class="cart_pro_right">
                        <h2>￥<i class="single_price"><?php echo ($vo["tprice"]); ?></i><span>元</span></h2>
                    <strong style="display:none;">

                         <input type="hidden" name="mass" value="<?php echo ($vo["mass"]); ?>" id="mass" class="mass" data-fufei='1'>
                         <input type="hidden" name="huan" value="1" id="huan" class="number">
                    </strong>
                    </span>
                <input type="hidden" name="id" value="<?php echo ($vo["coupons_id"]); ?>" id="id">
                <input type="hidden" name="tprice" value="<?php echo ($vo["tprice"]); ?>" id="tprice">
                <input type="hidden" name="coupon_cid" value="<?php echo ($vo["coupon_cid"]); ?>" id="coupon_cid">
                <input type="hidden" name="shunfeng_price" value="0" id="shunfeng_price">
        </div>
    </div>
    <!-- 用户信息 -->
    <div class="user_info">
			<span class="details_info user_left">
				<i></i>
				<h5>购买人信息</h5>
				<span>
					<em>姓名</em><input type="text" name="suser" id="suser"/>
				</span>
				<span>
					<em>手机号</em><input type="text" name="sphone" id="sphone" />
				</span>
			</span>
        <span class="details_info user_right">
				<h5>收货人信息</h5>
				<span>
					<em>姓名</em><input type="text" name="huser" id="huser" />
				</span>
				<span class="width width1">
					<em>省份/市区</em><input type="text" name="city" id="city" value="江苏省-苏州市-姑苏区"/>
				</span>
				<span>
					<em>手机号</em><input type="text" name="hphone" id="hphone"/>
				</span>
				<span class="width width2">
					<em>收货地址</em><input type="text" name="street" id="street" />
				</span>
			</span>
    </div>
    <div class="clear"></div>
    <!-- 支付信息 -->
    <div class="cart_pay">
        <strong>顺丰/<font id="shunfeng"><?php echo ($mass_totals); ?></font>元<label><input type="checkbox"  onclick="plushEMS(this)" value="1" name="shunfeng_ems" class="shunfeng_ems">到付</label></strong>
        <span>
				<strong>
                    <em>共 <font id="pro_sum"><?php echo ($nums); ?></font> 件商品</em>
                    <i>￥<i id="totals_price"><?php echo ($mass_totals); ?></i><font>元</font></i>
                    <input type="hidden" name="totals_price" value="<?php echo ($totals); ?>" id="totals_price1">
                </strong>
				<div class="clear"></div>
				<span>
					支付成功后，您将收到订单编号，可随时登录官方查看物流信息
					<input type="submit" id="qrzf" value="确认兑换">
				</span>
				<div class="clear"></div>
				<i>如未收到短信息请联系客服</i>
			</span>
            <label id="express_price" style="display:none;">12</label>
            <label id="express_overweight" style="display:none;">2</label>
            <label id="express_kg" style="display:none;"><?php echo ($kg); ?></label>
    </div>
</form>
<div class="clear"></div>
<!-- 选中地区 开始 -->
<link rel="stylesheet" type="text/css" href="/Public/Home/js/city/city.css">
<script src="/Public/Home/js/city/Popt.js"></script>
<script src="/Public/Home/js/city/cityJson.js"></script>
<script src="/Public/Home/js/city/citySet.js"></script>
<!-- 选中地区 结束 -->
<script type="text/javascript">
    $(function(){
        $('.fetch').click(function (e) {
            e.preventDefault();
            $val = $(this).siblings('input.ticket_code').val();
            if($val==''){
                layer.alert('请填写礼品券号',{icon:2});
                return false;
            }
            $.post("<?php echo U('/Getgoods/details');?>",{no:$val},function (data) {
                if(data.status==0){
                    layer.alert(data.msg,{icon:2});
                }else {
                    $('.main').html(data);
                }
            });
        });
        // 礼品券
        $('#current').click(function(){
            var ticket = "<input type=\"text\" name=\"ticket_code\" class=\"ticket_code\" placeholder=\"请输入礼品券编号\" /><input type=\"button\" name=\"fetch\" class=\"fetch\" value=\"领取\" />";
            $('#ticket_edit').attr("class","ticket_edit ticket1");
            $('#ticket_edit').html(ticket);
        });
        // 订单信息
        $('#logistics').click(function(){
            var ticket = '<input type="text" name="ticket_code" id="ticket_code" class="ticket_code" placeholder="请输入订单号" /><a href="javascript:void(0);" onclick="searchEMS()">查询</a>';
            $('#ticket_edit').attr("class","ticket_edit ticket2");
            $('#ticket_edit').html(ticket);
        });

        //get_ems_price();
        // 选中地区
        $("#city").click(function (e) {
            SelCity(this,e);
        });
        // 送礼收礼
        $('#suser').keyup(function(event) {
            /* Act on the event */
            $('#huser').val($(this).val());
        });
        $('#sphone').keyup(function(){
            $('#hphone').val($(this).val());
        });
        // 提交
        $('#qrzf').click(function(e){
            e.preventDefault();
            // 姓名
            if($('#suser').val() == ""){
                $('#suser').parent().addClass("error");
                return false;
            }else{
                $('#suser').parent().removeClass("error");
            }
            // 手机号
            if($('#sphone').val() == "" || !phoneReg.test($('#sphone').val())){
                $('#sphone').parent().addClass("error");
                return false;
            }else{
                $('#sphone').parent().removeClass("error");
            }
            // 手机号
            if($('#hphone').val() == "" || !phoneReg.test($('#hphone').val())){
                $('#hphone').parent().addClass("error");
                return false;
            }else{
                $('#hphone').parent().removeClass("error");
            }
            // 省份
            if($('#city').val() == ""){
                $('#city').parent().addClass("error");
                return false;
            }else{
                $('#city').parent().removeClass("error");
            }
            // 街道
            if($('#street').val() == ""){
                $('#street').parent().addClass("error");
                return false;
            }else{
                $('#street').parent().removeClass("error");
            }

            $form = $('form');
//            layer.load(2, {
//                shade: [0.3,'#000'] //0.1透明度的白色背景
//            });
            $.post($form.attr('action'),$form.serialize(),function (data) {
                if(data.status==2){
                    layer.closeAll('loading');
                    clearCookie();
                    //询问框
                    layer.confirm(data.msg, {
                        btn: ['我选好了现在支付','不买了我没有想好'] //按钮
                    }, function(){
                        layer.closeAll();
                        layer.open({
                            type: 2,
                            area: ['1024px', '850px'],
                            fix: false, //不固定
                            maxmin: true,
                            content: data.redirect
                        });
                    }, function(){
//                        $.post('<?php echo U("oder/cancel");?>',{id:data.order_id},function (data) {
//                            if(data.status==1){
//                                window.location.href=data.redirect;
//                            }else {
//                                layer.alert(data.msg,{icon:2});
//                            }
//                        });
                    });
                }else if (data.status==1){
                    layer.alert(data.msg,{icon:1,end:function () {
                        window.location.reload();
                    }});
                }else {
                    layer.alert(data.msg,{icon:2,end:function () {
                        window.location.reload();
                    }});
                }
            });
        });
        $('input[type="text"]').focus(function(){
            $(this).parent().removeClass('error');
        });
    });

    var phoneReg = /^1[3|4|5|7|8]\d{9}$/;
    // 手机验证
    function checkPhone(obj){
        $obj = $(obj);
        var val = $obj.val();
        if(!phoneReg.test(val)){
            $obj.parent().addClass("error");
        }else{
            $obj.parent().removeClass("error");
        }
    }
    function change_sum(obj,p) {
        $obj = $(obj);
        $sum = $obj.val();
        if($sum==''){
            $sum=0;
        }
        $tt= get_all_price($obj);
        $('#totals_price').text($tt);
        //$('#pro_sum').text($sum);
    }
    /**
     * 获取除去自己外其他的价格
     * @param obj
     * @returns {number}
     */
    function get_orther_price(obj,num) {
        $prices =0;
        $sf =0;
        $p = obj.parent().parent().parent();
        $('.cart_product').each(function () {
            if($(this).index()!=$p.attr('data-index')){
                if($(this).children('span.cart_pro_left').children('input[type="checkbox"]').is(':checked')){
                    $price = $(this).children('span.cart_pro_right').children('h2').children('i.single_price').text();
                    $sum = $(this).children('span.cart_pro_right').children('strong').children('input[type="text"]').val();
                    $sf += parseInt($sum);
                    $prices += parseInt($price)*parseInt($sum);
                }
            }
        });
        $sm = get_ems_price();

        if($('.shunfeng_ems').is(':checked')){
            $sm=0;
        }
        $('#pro_sum').text($sf);
        $('#totals_price1').val($prices + $sm);
        return $sm;
    }
    /**
     * 获取所有的价格
     * @returns {number}
     */
    function get_all_price() {
        $prices =0;
        $sf=0;
        $('.cart_product').each(function () {
            $price = $(this).children('span.cart_pro_right').children('h2').children('i.single_price').text();
            $sum = 1;
            $ll =parseInt($price)*parseInt($sum);
            $prices +=$ll;
            $sf += parseInt($sum);
        });
        $('#pro_sum').text($sf);
        $tt= get_ems_price();
        if($('.shunfeng_ems').is(':checked')){
            $tt=0;
        }
        $('#totals_price1').val($tt);
        $('#shunfeng_price').val($tt);
        return $tt;
    }
    /**
     * 删除项
     * @param obj
     */
    function delItem(obj) {
        $obj = $(obj).parent();
        layer.confirm('您确定要删除吗？删除后您将不能找回商品', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('/Home/Getgoods/delItem',{i:$obj.attr('data-index')},function (data) {
                if(data.status=1){
                    layer.closeAll();
                    $obj.remove();
                    $('#totals_price').text(get_all_price());
                }
            });
        });

    }
    function clearItem() {
        layer.confirm('您确定要删除吗？删除后您将不能找回商品', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.get('/Home/Getgoods/delItems',function (data) {
                if(data.status==1){
                    layer.closeAll();
                    $('.cart_pro_list').empty();
                    $('#totals_price').text(get_all_price());
                }
            });
        });
    }

    function plushEMS(obj) {

        $('#totals_price').text(get_all_price());
    }

    function get_ems_price() {
        $mass=0;
        $tal=0;
        $kg = 0;
        $('.cart_product').each(function () {
            if($(this).children('span.cart_pro_left').children('input[type="checkbox"]').is(':checked')){
                $number = $(this).children('span.cart_pro_right').children('strong').children('input.number').val();
                $input = $(this).children('span.cart_pro_right').children('strong').children('input.mass');
                if($input.attr('data-fufei')==1){
                    if($input.val()!=''){
                        $mass = parseFloat($input.val());
                        $kg +=$mass*$number;
                    }
                }
            }
        });
        if($kg>0){
            $price = $('#express_price').text();
            $overweight = $('#express_overweight').text();
            $tal = overweight1(parseFloat($price),parseFloat($overweight),parseFloat($kg));
        }

        if($tal!=NaN){
            $('#shunfeng').text("￥"+$tal);
            $('#totals_price').val($tal);
            return parseFloat($tal);
        }else {
            return 0;
        }
    }

    function overweight1(p,p1,h) {
        if(h<=1){
            return p;
        }else{
            return p+(h-1)*p1;
        }
    }
</script>