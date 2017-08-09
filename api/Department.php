<?php

/*
 * Created Datetime:2016-1-8 19:41:48
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\api;

/**
 * 部门管理
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class Department extends Base
{

    const API_LIST = '/department/list';
    const API_GET = '/department/get';
    const API_CREATE = '/department/create';
    const API_UPDATE = '/department/update';
    const API_DELETE = '/department/delete';

    /**
     * 获取部门列表
     *
     * @link http://ddtalk.github.io/dingTalkDoc/?spm=a3140.7785475.0.0.6qW6Py#管理通讯录
     * @return array 数组中结构参看相应数据实体类
     * @see \hzted123\dingtalk\entity\Department []
     */
    public static function query()
    {
        $data = self::doGet(self::API_LIST);
        if ($data === false || empty($data['department'])) {
            return [];
        }

        return $data['department'];
    }

    /**
     * 获取部门详情
     *
     * @param int $id
     * @return array
     * @see \hzted123\dingtalk\entity\Department
     */
    public static function get($id)
    {
        $data = self::doGet(self::API_GET, ['id' => $id]);

        if ($data === false) {
            return [];
        }

        return $data;
    }

    /**
     * 创建部门
     *
     * @param string $name
     * @param int    $parentid
     * @param int    $order
     * @param bool   $createDeptGroup
     * @return int|bool 失败返回false 成功返回id
     */
    public static function create($name, $parentid, $order = 0, $createDeptGroup = false)
    {
        $result = self::doPost(self::API_CREATE, [
                'name'            => $name,
                'parentid'        => $parentid,
                'order'           => $order,
                'createDeptGroup' => $createDeptGroup,
            ]);

        return empty($result['id']) ? false : $result['id'];
    }

    /**
     * 更新部门
     *
     * @param \hzted123\dingtalk\entity\Department $dept
     * @return bool
     */
    public static function update(\hzted123\dingtalk\entity\Department $dept)
    {
        $result = self::doPost(self::API_UPDATE, (array)$dept);

        return ($result === false) ? false : true;
    }

    /**
     * 删除部门
     *
     * @param int $id
     * @return boolean
     */
    public static function delete($id)
    {
        $data = self::doGet(self::API_DELETE, ['id' => $id]);

        if ($data === false) {
            return false;
        }

        return true;
    }
}
