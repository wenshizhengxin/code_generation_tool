<?php
/**
 * 描述：
 * Created at 2021/4/13 17:37 by 陈庙琴
 */

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class ajax_data implements ActionInterface
{

    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $whereText = '';

        foreach ($args as $arg => $arg2) {
            $whereText .= "
        if (\$$arg = Args::params('$arg')) {
            \$where[] = [
                '$arg', 'like', '%' . \$$arg . '%'
            ];
        }";
        }

        $code = <<<R
public function ajax_data()
{
    try {
        \$where = [];      
$whereText 
        
        return \$this->tableJsonData('$dbName', \$where, function (\$row) {
            return \$row;
        });
    } catch (\Exception \$e) {
    }
}
R;

        return $code;
    }
}