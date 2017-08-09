<?php
/**
 * Created by PhpStorm.
 * User: songming
 * Date: 17/8/8
 * Time: 下午5:06
 */

namespace hzted123\dingtalk\api;


class Role extends Base
{
    const API_GET = '/corp/role/get';
//    const API_CREATE = '/role/create';
//    const API_UPDATE = '/role/update';
    const API_DELETE = '/corp/role/deleterole';
    const API_LIST = '/corp/role/list';
    const API_LIST_SIMPLE = '/corp/role/simplelist';
    const API_GET_ROLE_GROUP = '/corp/role/getrolegroup';
    const API_DELETE_ROLE = '/corp/role/deleterole'; //删除角色信息

    /**
     * 获取企业角色列表
     *
     * @return array 数组中结构参看相应数据实体类
     */
    public static function query()
    {
        $data = self::doGet(self::API_LIST);
        if ($data === false || empty($data)) {
            return [];
        }

        return $data;
    }

    /**
     * 获取角色组信息
     *
     * @return array 数组中结构参看相应数据实体类
     */
    public static function getrolegroup($group_id)
    {
        $data = self::doGet(self::API_GET_ROLE_GROUP, ['group_id' => $group_id]);
        if ($data === false || empty($data['role_group'])) {
            return [];
        }

        return $data['role_group'];
    }

    /**
     * 获取角色的员工列表
     *
     * @param     $role_id
     * @param int $size
     * @param int $offset
     * @return array
     */
    public static function simplelist ($role_id, $size = 20, $offset = 0){
        $data = self::doGet(self::API_LIST_SIMPLE, ['role_id' => $role_id, 'size'=>$size, 'offset'=>$offset]);
        if ($data === false || empty($data)) {
            return [];
        }

        return $data;
    }
}
