<?php

/*
 * Created Datetime:2016-1-8 20:10:17
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\api;

/**
 * 普通会话消息接口
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class Message extends Base {
    
    const API_SEND = '/message/send';
    const API_SEND_CONVERSATION = '/message/send_to_conversation';

    /**
     * @param string $message
     * @param string $agentId 企业应用id
     * @param array $toUser 员工id列表，多个接收者用|分隔
     * @param array $toParty 部门id列表，多个接收者用|分隔
     * @return array
     */
    public static function send($message, $agentId, $toUser = null, $toParty = null) {
        $parameters = array('agentid' => $agentId);
        if ($toUser) $parameters['touser'] = $toUser;
        if ($toParty) $parameters['toparty'] = $toParty;
        $data = self::doPost(self::API_SEND, array_merge($parameters, $message));
        return $data;
    }
}
