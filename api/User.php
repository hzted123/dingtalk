<?php

/*
 * Created Datetime:2016-1-8 19:44:11
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\api;

/**
 * 成员相关接口
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class User extends Base
{

    const API_GET = '/user/get';
    const API_CREATE = '/user/create';
    const API_UPDATE = '/user/update';
    const API_DELETE = '/user/delete';
    const API_DELETE_ALL = '/user/batchdelete';
    const API_LIST = '/user/list';
    const API_LIST_SIMPLE = '/user/simplelist';
    const API_GET_INFO = '/user/getuserinfo';

    /**
     * 获取部门成员（详情）
     *
     * @param int $deptId
     * @return array 数组中结构参看相应数据实体类
     * @see \hzted123\dingtalk\entity\User []
     */
    public static function query($deptId)
    {
        $data = self::doGet(self::API_LIST, ['department_id' => $deptId]);
        if ($data === false || empty($data['userlist'])) {
            return [];
        }

        return $data['userlist'];
    }

    /**
     * 获取部门成员（简单）
     *
     * @param int $deptId
     * @return array 数组中结构参看相应数据实体类 只返回其中的 userid name active
     * @see \hzted123\dingtalk\entity\User []
     */
    public static function querySimple($deptId)
    {
        $data = self::doGet(self::API_LIST_SIMPLE, ['department_id' => $deptId]);
        if ($data === false || empty($data['userlist'])) {
            return [];
        }

        return $data['userlist'];
    }

    /**
     * 获取成员详情
     *
     * @param int $userId
     * @return array 数组中结构参看相应数据实体类 只返回其中的
     * @see \hzted123\dingtalk\entity\User
     */
    public static function get($userId)
    {
        $user = self::doGet(self::API_GET, ['userid' => $userId]);

        if ($user === false) {
            return [];
        }

        return $user;
    }

    /**
     * CODE换取用户信息
     *
     * @param string $code
     * @return array
     */
    public static function getUserInfo($code)
    {
        $user = self::doGet(self::API_GET_INFO, ['code' => $code]);

        if ($user === false) {
            return [];
        }

        return $user;
    }

    /**
     * 创建成员
     *
     * @link http://ddtalk.github.io/dingTalkDoc/#创建成员
     * @param \hzted123\dingtalk\entity\User $user
     * @return string|bool
     */
    public static function create(\hzted123\dingtalk\entity\User $user)
    {
        $result = self::doPost(self::API_CREATE, (array)$user);

        return empty($result['userid']) ? false : $result['userid'];
    }

    /**
     * 更新成员
     *
     * @param \hzted123\dingtalk\entity\User $user
     * @return bool
     */
    public static function update(\hzted123\dingtalk\entity\User $user)
    {
        $result = self::doPost(self::API_UPDATE, (array)$user);

        return ($result === false) ? false : true;
    }

    /**
     * 删除成员
     *
     * @param string $userId
     * @return boolean
     */
    public static function delete($userId)
    {
        $result = self::doGet(self::API_DELETE, ['userid' => $userId]);

        if ($result === false) {
            return false;
        }

        return true;
    }

    /**
     * 批量删除成员
     *
     * @param array $userIds
     * @return boolean
     */
    public static function deleteAll(array $userIds)
    {
        $result = self::doPost(self::API_DELETE_ALL, ['useridlist' => $userIds]);

        if ($result === false) {
            return false;
        }

        return true;
    }
}
