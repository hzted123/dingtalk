<?php

/*
 * 钉钉服务器端API封装
 * Created Datetime:2016-1-8 16:12:19
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\api;
use Yii;

/**
 * API访问基类
 * 
 * 定义api的地址前缀\封装通用访问方法等
 * @link http://ddtalk.github.io/dingTalkDoc/
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class Base {
    /**
     * 发起get请求
     * @param string $api 具体api端uri
     * @param array $params get请求需带的参数,不包括access_token
     * @return mixed|array|bool ===false为失败
     */
    public static function doGet($api, $params = array()) {
        return Yii::$app->dingtalk->http_get($api, $params);
    }

    /**
     * 发起post请求
     * @param string $api
     * @param array $data
     * @param array $params
     * @return mixed|array|bool ===false为失败
     */
    public static function doPost($api, $data, $params = array()) {
        return Yii::$app->dingtalk->http_post($api, $data, $params);
    }
}
