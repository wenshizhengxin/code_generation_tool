<?php
/**
 * 描述：
 * Created at 2021/4/13 17:27 by Temple Chan
 */

namespace wenshizhengxin\code_generation_tool\libs\interface_set;


interface ActionInterface
{
    public function getCode($dbName = '', $args = []): string;
}