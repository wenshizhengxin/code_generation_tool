<?php

/**
 * 描述：
 * Created at 2021/4/13 17:37 by Temple Chan
 */

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class ajax_data implements ActionInterface
{

    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $whereText = '';
        $alias = substr($dbName, 0, 1);

        foreach ($args as $arg) {
            $var = explode('/', $arg)[0];
            $whereText .= "
        if (\$$var = Args::params('$arg')) {
            \$where[] = [
                \$alias . '.$var', 'like', '%' . \$$var . '%'
            ];
        }";
        }

        $code = <<<R
public function ajax_data()
{
    try {
        \$alias = '$alias';
        \$where = [];      
$whereText 
        
        \$query = Db::name('$dbName')->alias(\$alias)->order(\$alias . '.id', 'DESC');
        return \$this->tableJsonData(\$query, \$where, function (\$row) {
            \$row['create_time'] = date('Y-m-d H:i:s', \$row['create_time']);
            return \$row;
        });
    } catch (\Exception \$e) {
    }
}
R;

        return $code;
    }
}
