<?php

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class add implements ActionInterface
{
    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $insertData = '';
        foreach ($args as $arg) {
            $var = explode('/', $arg)[0];
            $insertData .= "
            '$var' => Args::params('$arg'),";
        }

        $code = <<<R
public function add()
{
    try {
        \$id = Args::params('id/d', 0);
        if (\$_SERVER['REQUEST_METHOD'] === 'POST') {                
            \$insertData = [
                $insertData
            ];

            \$timestamp = time();

            /************事务开始************/
            Db::startTrans();
            if (\$id === 0) { // 新增
                \$insertData['create_time'] = \$insertData['update_time'] = \$timestamp;
                \$res = Db::name('$dbName')->insert(\$insertData, false, true);
                if (!\$res) {
                    throw new \Exception('添加失败');
                }
                \$id = \$res;
            } else { // 修改
                \$insertData['update_time'] = \$timestamp;
                \$res = Db::name('$dbName')->where('id', \$id)->update(\$insertData);
                if (!\$res) {
                    throw new \Exception('修改失败');
                }
            }
            Db::commit();
            /************事务结束************/

            \$this->success();
        } else {
            if (\$id > 0) {
                \$$dbName = Db::name('$dbName')->where('id', \$id)->find();
                \$this->assign('$dbName', \$$dbName);
            }

            \$this->adminUiDisplay();
        }
    } catch (\Exception \$e) {
        Db::rollback();
        \$this->error(\$e->getMessage());
    }
}
R;
        return $code;
    }
}