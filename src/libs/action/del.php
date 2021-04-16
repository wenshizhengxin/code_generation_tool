<?php

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class del implements ActionInterface
{
    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $code = <<<R
public function del()
{
    try {
        \$id = Args::params('id');
        \$res = Db::name('$dbName')->where('id', \$id)->delete();
        if (!\$res) {
            throw new \Exception('删除失败');
        }

        \$this->success();
    } catch (\Exception \$e) {
        \$this->error(\$e->getMessage());
    }
}
R;

        return $code;
    }
}