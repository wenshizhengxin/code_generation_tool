<?php
/**
 * 描述：
 * Created at 2021/4/13 17:37 by 陈庙琴
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
                $formHtml .= '
                            <div class="form-group">
                                <label>' . $name . '：</label>
                                <input type="text" class="form-control" name="' . $var . '" placeholder="请输入' . $name . '">
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
                        </div>
                        <div class="form-inline">
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
    <div class="card-body table-responsive" style="padding-top: 0px">
        <a class="btn btn-outline-primary btn-table-tool btn-dialog" data-intop="1" data-area="50%,70%" title="新增"
           href="?app=$dbName@add">新增</a>
    </div>
    <div class="card-body table-responsive" style="padding-top: 0px">
        <table data-table="1" data-url="?app=$dbName@ajax_data" id="table1" class="table table-hover">
            <thead>
            <tr>
                $fieldHtml
                <th data-formatter="epiiFormatter.btns"
                    data-intop="1"
                    data-area="50%,70%"
                    data-btns="edit,del"
                    data-edit-url="?app=$dbName@add&id={id}"
                    data-edit-title="修改"
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
        return '<a class="btn btn-outline-primary btn-sm" data-url="?app=$dbName@detail&id=' + row.wxid + '">示例</a>';
    }
</script>
R;

        return $code;
    }
}