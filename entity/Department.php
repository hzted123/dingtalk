<?php

/*
 * Created Datetime:2016-1-8 21:09:15
 * Creator:Jimmy Jaw <web3d@live.cn>
 * Copyright:TimeCheer Inc. 2016-1-8 
 * 
 */

namespace hzted123\dingtalk\entity;

/**
 * 接口部门数据实体
 *
 * @author Jimmy Jaw <web3d@live.cn>
 */
class Department {/** 仅用于演示接口返回的数据结构 */

    /**
     * @var int $id 如'2'
     */
    public $id;

    /**
     * @var string $name 如'钉钉事业部'
     */
    public $name;

    /**
     * @var int $order 如'10'
     */
    public $order;

    /**
     * @var int $parentid 如'1'
     */
    public $parentid;

    /**
     * @var string $createDeptGroup 如'1'
     */
    public $createDeptGroup;

    /**
     * @var bool $autoAddUser 如'1'
     * 如果有新人加入部门是否会自动加入部门群
     */
    public $autoAddUser;

    /**
     * @var string $deptHiding 如'1'
     * 是否隐藏部门, true表示隐藏, false表示显示
     */
    public $deptHiding;

    /**
     * @var string $deptPerimits 如'3|4'
     * 可以查看指定隐藏部门的其他部门列表，如果部门隐藏，则此值生效，取值为其他的部门id组成的的字符串，使用 | 符号进行分割
     */
    public $deptPerimits;

    /**
     * @var string $userPerimits 如'3|4'
     * 可以查看指定隐藏部门的其他人员列表，如果部门隐藏，则此值生效，取值为其他的人员userid组成的的字符串，使用| 符号进行分割
     */
    public $userPerimits;

    /**
     * @var boolean $outerDept
     * 是否本部门的员工仅可见员工自己, 为true时，本部门员工默认只能看到员工自己
     */
    public $outerDept;

    /**
     * @var string $outerPermitDepts
     * 本部门的员工仅可见员工自己为true时，可以配置额外可见部门，值为部门id组成的的字符串，使用|符号进行分割
     */
    public $outerPermitDepts;

    /**
     * @var string $outerPermitUsers
     * 本部门的员工仅可见员工自己为true时，可以配置额外可见人员，值为userid组成的的字符串，使用|符号进行分割
     */
    public $outerPermitUsers;

    /**
     * @var string $orgDeptOwner 如'manager1122'
     * 企业群群主
     */
    public $orgDeptOwner;

    /**
     * @var string $deptManagerUseridList 如'manager1122|manager3211'
     * 部门的主管列表,取值为由主管的userid组成的字符串，不同的userid使用’| 符号进行分割
     */
    public $deptManagerUseridList;

}
