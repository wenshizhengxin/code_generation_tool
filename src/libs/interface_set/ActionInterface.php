<?php
/**
 * 描述：
 * Created at 2021/4/13 17:27 by 陈庙琴
 */

namespace wenshizhengxin\code_generation_tool\libs\interface_set;


interface ActionInterface
{
    public function getCode($dbName = '', $args = []): string;
}