<?php
/**
 * 描述：
 * Created at 2021/4/13 17:37 by Temple Chan
 */

namespace wenshizhengxin\code_generation_tool\libs\action;


use wenshizhengxin\code_generation_tool\libs\interface_set\ActionInterface;

class index_html implements ActionInterface
{

    public function getCode($dbName = '', $args = []): string
    {
        // TODO: Implement getCode() method.
        $formHtml = '';
        $fieldHtml = '';

        foreach ($args as $arg) {
            $var = explode('/', $arg)[0];
            $name = explode('/', $arg)[1];
            if (strpos($arg, '/ss') !== false) {
                $inputHtml = '<input type="text" class="form-control" name="' . $var . '" placeholder="请输入' . $name . '">';
                if (strpos($arg, '/select') !== false) {
                    $inputHtml = '<select class="selectpicker" name="' . $var . '"></select>';
                }
                $formHtml .= '
                            <div class="form-group">
                                <label>' . $name . '：</label>
                                ' . $inputHtml . '
                            </div>';
            }
            if (strpos($arg, '/ll') !== false) {
                $fieldHtml .= '
                <th data-field="' . $var . '">' . $name . '</th>';
            }
        }


        $code = <<<R
<section class="content" style="padding: 10px">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">搜索</h3>
                </div>
                <div class="card-body">
                    <form role="form" data-form="1" data-search-table-id="1" data-title="自定义标题">
                        <div class="form-inline">
                            $formHtml
                            <div class="form-group" style="margin-left: 10px">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <button type="reset" class="btn btn-default">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="content">
    <div class="card-body table-responsive" style="padding-top: 0">
        <a class="btn btn-outline-primary btn-table-tool btn-dialog" data-intop="1" data-area="50%,70%" title="新增"
           href="?app=$dbName@add">新增</a>
    </div>
    <div class="card-body table-responsive" style="padding-top: 0">
        <table data-table="1" data-url="?app=$dbName@ajax_data" id="table1" class="table table-hover">
            <thead>
            <tr>
                $fieldHtml
                <th data-formatter="epiiFormatter.btns"
                    data-intop="1"
                    data-area="50%,70%"
                    data-btns="edit,del"
                    data-edit-url="?app=$dbName@add&id={id}"
                    data-edit-title="编辑"
                    data-del-url="?app=$dbName@del&id={id}"
                    data-del-title="删除"
                >操作
                </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    function example(field_value, row, index, field_name) {
        return '<a class="btn btn-outline-primary btn-sm btn-dialog" data-intop="1" data-area="50%,70%" title="编辑" href="?app=$dbName@add&id=' + row.id + '"><i class="fa fa-pencil"></i>编辑</a>';
    }
</script>
R;

        return $code;
    }
}