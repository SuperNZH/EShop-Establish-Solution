<?php
namespace admin;

use models\BaseDao;
use JasonGrimes\Paginator;


class Order extends Admin {
    public function __construct()
    {
        parent::__construct();
        $this->assign('menumark', 'order');


    }

    /**
     * 订单列表页面
     */
    function index() {
        //获取数据库操作对象
        $db = new BaseDao();

        $num = $_GET['num'] ?? 1;

        $prosql['ORDER'] = ["id"=>"DESC"];
        $where = [];


        if(isset($_GET['state']) && $_GET['state'] !='') {
            $where['state'] = $_GET['state'];
            $state='&state='.$_GET['state'];
        }


        if(!empty($_GET['id']) ) {
            $where['id[~]'] = $_GET['id'];
            $id='&id='.$_GET['id'];
        }

        if(!empty($_GET['utname']) ) {
            $where['utname[~]'] = $_GET['tuname'];
            $utname='&utname='.$_GET['utname'];
        }


        if(!empty($_GET['uphone']) ) {
            $where['uphone[~]'] = $_GET['uphone'];
            $uphone='&uphone='.$_GET['uphone'];
        }





        $this->assign('get', $_GET);


        $totalItems = $db->count('order', $where);
        $itemsPerPage = 4;
        $currentPage = $num;
        $urlPattern = '/admin/order?num=(:num)'.$state.$id.$utname.$uphone;

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);


        $start = ($currentPage-1) * $itemsPerPage;
        $prosql['LIMIT'] = [$start, $itemsPerPage];

        $prosql = array_merge($prosql, $where);
        //获取全部的订单, 并能按ord排序
        $data = $db->select('order','*',$prosql);



        foreach($data as $k => $v) {
            $data[$k]['orderdata'] = $db->select('orderdata', '*', ['oid'=>$v['id']]);
        }


        $this->assign('paywayarr', ['1'=>'Alipay', '2'=>'Bank Transfer', '3'=>'Cash on Delivery']);

        // 将数据分给模版
        $this->assign('data', $data);
        $this->assign('fpage', $paginator);

        // 标题
        $this->assign('title', 'Order List');

        //导入模版
        $this->display('order/index');
    }


    function state($state) {
        $db = new BaseDao();
        $order_id = $_GET['id'];

        switch ($state) {
            case '2':
                $order = $db->get('order', '*', ['id'=>$order_id]);

                $_POST['state'] = $order['payway'] == '3' ? '4' :  '2'; // 如果支付方式是 3 ，是货到付款， 直接到4， 否则是2确认付款

                $_POST['ptime'] = time();

                if($db->update('order', $_POST, ['id'=>$order_id])) {
                    $this->success('/admin/order/mod/'.$order_id, 'Order payment successful!');
                }else{
                    $this->error('/admin/order/mod/'.$order_id, 'Order payment failure...');
                }

                break;
            case '3':
                if(isset($_POST['do_submit'])) {
                    $order = $db->get('order', '*', ['id'=>$order_id]);
                    $_POST['stime'] = time();

                    if($order['payway'] == '3') {
                        $_POST['state'] = '3';
                    }else{
                        $_POST['state'] = '4';
                    }

                    unset($_POST['do_submit']);



                    if($db->update('order', $_POST, ['id'=>$order_id])) {
                        $orderdata = $db->select('orderdata', ['id', 'pid', 'pnum'], ['oid'=>$order_id]);

                        foreach ($orderdata as $v ) {
                            $db -> update('product', ['sellnum[+]'=>$v['pnum']], ['id'=>$v['pid']]);
                        }


                        $this->topsuccess('/admin/order', 'Shipping Success');
                    }else{
                        $this->error('/admin/order', 'Delivery Failure...');
                    }

                }



                $this->assign('order_id', $order_id);
                $this->assign('wllist', ['SF Express','ST Express','YTO Express','Yunda Express','ZT Express','EMS Express']);
                $this->display('order/send');

                break;
        }

    }



    function mod($order_id) {

        $db = new BaseDao();

        $info = $db -> get('order', '*', ['id'=>$order_id]);
        $product_list = $db->select('orderdata', '*', ['oid'=>$order_id]);


        $this->assign($info);
        $this->assign('product_list', $product_list);

        $this->assign('paywayarr', ['1'=>'Alipay', '2'=>'Bank Transfer', '3'=>'Cash on Delivery']);

        $tmpay = $db->select('payway', "*", ['state'=>1,'ORDER'=>["ord"=>'ASC', 'id'=>'ASC']]);

        $payway = [];

        foreach($tmpay as $v) {
            $payway[$v['mark']] = $v;
        }

        $this->assign('cache_payway', $payway);


        $this->assign('title', 'Order Details Edit');
        $this->display('order/mod');
    }

    function doupdate() {
        $db = new BaseDao();

        $order_id = $_POST['id'];

        unset($_POST['id']);

        $_POST['money'] =  $_POST['productmoney'] + $_POST['wlmoney'];

        unset($_POST['do_submit']);

        if($db->update('order', $_POST, ['id'=>$order_id])) {
            $this->success('/admin/order/mod/'.$order_id, 'Order modified successfully!');
        }else{
            $this->error('/admin/order/mod/'.$order_id, 'Order modification failed...');
        }


    }


    function del($order_id) {
        $db = new BaseDao();


        // 删除订单
        if($db->delete('order', ['id'=>$order_id])) {
            $orderdata = $db->select('orderdata', ['id', 'pid', 'pnum'], ['oid'=>$order_id]);

            // 库存加回去
            foreach ($orderdata as $v ) {
                $db -> update('product', ['num[+]'=>$v['pnum']], ['id'=>$v['pid']]);
            }


            // 删除订单详情表对应的数据
            $db->delete('orderdata', ['oid'=>$order_id]);

            $this->success('/admin/order', 'successfully delete!');
        }else{
            $this->error('/admin/order', 'Fail to delete...');
        }
    }


}
