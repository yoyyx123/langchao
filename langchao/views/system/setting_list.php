<div class="row">
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-primary doadd">添加信息</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>信息管理</h4></th>
                </tr>               
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($list as $key => $value) {?>
                <tr>
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['name'];?></td>                    
                    <td><?php 
                        if($value['type']=="city"){echo "地区";}
                        if($value['type']=="custom"){echo "客户类型";}
                        if($value['type']=="department"){echo "部门";}
                        if($value['type']=="worktime"){echo "工作时间";}
                        if($value['type']=="performance"){echo "绩效完成率";}
                        if($value['type']=="filetype"){echo "文档类型";}
                        if($value['type']=="position"){echo "职位";}
                     ?></td>
                    <td><a class="btn btn-info doedit" setting_id='<?php echo $value['id'];?>'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" setting_id='<?php echo $value['id'];?>'>删除</a>
                    </td>
                </tr>
                
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
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_delete'))?>"+"&id="+$(this).attr('setting_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doadd").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_add'))?>",
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('添加部门'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_edit'))?>"+"&id="+$(this).attr('setting_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('编辑部门'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });
         $(".dialog_close").click(function() {
            alert(1111);
            //$(this).dialog('close');
         });

})
</script>
 