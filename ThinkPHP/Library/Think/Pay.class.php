<?php

/**
 * ONCOO.NET支付接口类
 * @author 昂酷网络<www.oncoo.net>
 */

namespace Think;

/**
  数据库
  CREATE TABLE `think_pay` (
  `out_trade_no` varchar(100) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `callback` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `param` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`out_trade_no`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */
class Pay {

    /**
     * 支付驱动实例
     * @var Object
     */
    private $payer;

    /**
     * 配置参数
     * @var type 
     */
    private $config;

    /**
     * 构造方法，用于构造上传实例
     * @param string $driver 要使用的支付驱动
     * @param array  $config 配置
     */
    public function __construct($driver, $config = array()) {
        /* 配置 */
        $pos = strrpos($driver, '\\');
        $pos = $pos === false ? 0 : $pos + 1;
        $apitype = strtolower(substr($driver, $pos));
        $this->config['notify_url'] = U("Home/Public/notify", array('apitype' => $apitype, 'method' => 'notify'), false, true);
        $this->config['return_url'] = U("Home/Public/notify", array('apitype' => $apitype, 'method' => 'return'), false, true);

        $config = array_merge($this->config, $config);

        /* 设置支付驱动 */
        $class = strpos($driver, '\\') ? $driver : 'Think\\Pay\\Driver\\' . ucfirst(strtolower($driver));
        $this->setDriver($class, $config);
    }

    public function buildRequestForm(Pay\PayVo $vo) {
        $this->payer->check();
        //生成本地记录数据
        $payObj = M("Pay");
        $swhere = array('out_trade_no'=>$vo->getOrderNo());
        if($payObj->where($swhere)->count()){
          $sdata =array(
              'money' => $vo->getFee(),
              'status' => 0,
              'callback' => $vo->getCallback(),
              'url' => $vo->getUrl(),
              'param' => serialize($vo->getParam()), //获取订单的额外参数
              'update_time' => time()
          );
          $check = $payObj->where($swhere)->save($sdata);
        }else{
          $adata = array(
              'out_trade_no' => $vo->getOrderNo(), //获取订单号
              'money' => $vo->getFee(),
              'status' => 0,
              'callback' => $vo->getCallback(),
              'url' => $vo->getUrl(),
              'param' => serialize($vo->getParam()), //获取订单的额外参数
              'create_time' => time(),
              'update_time' => time()
          );
          $check = $payObj->add($adata);
        }
        

        if ($check !== false) {
            return $this->payer->buildRequestForm($vo);
        } else {
            E(M("Pay")->getDbError());
        }
    }

    /**
     * 设置支付驱动
     * @param string $class 驱动类名称
     */
    private function setDriver($class, $config) {
        $this->payer = new $class($config);
        if (!$this->payer) {
            E("不存在支付驱动：{$class}");
        }
    }

    public function __call($method, $arguments) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array(&$this, $method), $arguments);
        } elseif (!empty($this->payer) && $this->payer instanceof Pay\Pay && method_exists($this->payer, $method)) {
            return call_user_func_array(array(&$this->payer, $method), $arguments);
        }
    }

}
