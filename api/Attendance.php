<?php

namespace hzted123\dingtalk\api;

/**
 * 考勤
 *
 * @author jibo
 */
class Attendance extends Base
{

    const API_LIST = '/attendance/list';

    /**
     * 获取员工考勤打卡数据
     *
     * @param string $userId
     * @param        $workDateFrom yyyy-MM-dd hh:mm:ss
     * @param        $workDateTo yyyy-MM-dd hh:mm:ss
     * @return array
     */
    public static function query($userId, $workDateFrom, $workDateTo)
    {
        $data = self::doPost(self::API_LIST, ['userId' => $userId, 'workDateFrom' => $workDateFrom, 'workDateTo' => $workDateTo]);
        if ($data === false || empty($data['recordresult'])) {
            return [];
        }
        return $data['recordresult'];
    }
}
