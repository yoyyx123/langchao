<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=system&act=role_add');?>" class="btn btn-primary">添加角色</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>角色管理</h4></th>
                </tr>               
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($role_list as $key => $value) {?>
                <tr>
                    <td><?php echo $value['role_id'];?></td>
                    <td><?php echo $value['role_name'];?></td>
                    <td><?php echo $value['role_memo'];?></td>
                    <td><a class="btn btn-info doedit" role_id='<?php echo $value['role_id'];?>'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" role_id='<?php echo $value['role_id'];?>'>删除</a>
                    </td>
                </tr>
                <div class="clearfix"></div><br>
                <?php $i++;} ?>

            </tbody>
        </table>
    </div>
</div>

<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {
        $(".dodelete").click(function() {
         if(confirm("确认删除吗")){
            _self = this;
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'role_delete'))?>"+"&role_id="+$(this).attr('role_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'role_edit'))?>"+"&role_id="+$(this).attr('role_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('编辑角色'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });
         $(".dialog_close").click(function() {
            $(this).dialog('close');
         });
})
</script>
 