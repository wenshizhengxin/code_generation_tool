<?php
/**
 * 描述：
 * Created at 2021/4/13 17:37 by Temple Chan
 */

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class index implements ActionInterface
{

    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.

        $code = <<<R
public function index() {
    try {
        \$this->adminUiDisplay();
    } catch (\\Exception \$e) {
        \$this->error(\$e->getMessage());
    }
}
R;

        return $code;
    }
}