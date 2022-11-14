<?php

/**
 * 描述：
 * Created at 2021/4/13 17:37 by Temple Chan
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
                $inputHtml = '<input type="text" class="form-control" name="' . $var . '" id="' . $var . '" placeholder="请输入' . $name . '" value="{$' . $dbName . '[\'' . $var . '\'] ? \'\'}">';
                if (strpos($arg, '/select') !== false) {
                    $inputHtml = '<select class="selectpicker" name="' . $var . '" id="' . $var . '">{:options,,}</select>';
                } else if (strpos($arg, '/textarea') !== false) {
                    $inputHtml = '<textarea rows="5" class="form-control" name="' . $var . '" id="' . $var . '" placeholder="请输入' . $name . '">{$' . $dbName . '[\'' . $var . '\'] ? \'\'}</textarea>';
                }
                $formHtml .= '
    <div class="form-group">
        <label>' . $name . '：</label>
        ' . $inputHtml . '
    </div>';
            }
        }


        $code = <<<R
<form role="form" class="epii" method="post" data-form="1" action="">
    $formHtml
    <div class="form-footer">
        <input type="hidden" name="id" value="{\$${dbName}['id'] ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
R;

        return $code;
    }
}
