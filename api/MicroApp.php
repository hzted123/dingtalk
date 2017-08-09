<?php

/*
 * Created Datetime:2016-1-8 19:47:48
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\api;

/**
 * 微应用
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class MicroApp extends Base {
    const API_CREATE = '/microapp/create';
    
    /**
     * 创建微应用
     *
     * @param \hzted123\dingtalk\entity\MicroApp $app
     * @return int|boolean
     */
    public static function create(\hzted123\dingtalk\entity\MicroApp $app) {
        $result = self::doPost(self::API_CREATE, (array) $app);
        
        return empty($result['id']) ? false : $result['id'];
    }
}
