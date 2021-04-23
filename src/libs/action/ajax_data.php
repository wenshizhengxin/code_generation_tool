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

        foreach ($args as $arg) {
            $var = explode('/', $arg)[0];
            $whereText .= "
        if (\$$var = Args::params('$var')) {
            \$where[] = [
                '$var', 'like', '%' . \$$var . '%'
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