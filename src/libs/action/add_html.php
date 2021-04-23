<?php
/**
 * 描述：
 * Created at 2021/4/13 17:37 by 陈庙琴
 */

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class add_html implements ActionInterface
{

    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $formHtml = '';

        foreach ($args as $arg) {
            $var = explode('/', $arg)[0];
            $name = explode('/', $arg)[1];
            if (strpos($arg, '/ss') !== false) {
                $formHtml .= '
    <div class="form-group">
        <label>' . $name . '：</label>
        <input type="text" class="form-control" name="' . $var . '" placeholder="请输入' . $name . '" value="{$' . $dbName . '.' . $var . ' ? ""}">
    </div>';
            }
        }


        $code = <<<R
<form role="form" class="epii" method="post" data-form="1" action="">
    $formHtml
    <div class="form-footer">
        <input type="hidden" name="id" value="{\$$dbName.id ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
R;

        return $code;
    }
}