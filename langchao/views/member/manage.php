<div>
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-primary" href="<?php echo site_url('ctl=member&act=add');?>">添加客户</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>客户管理</h4></th>
                </tr>
                <tr>
                    <th>客户列表</th>
                    <th colspan="3"></th>
                    <th>搜索</th>
                    <th>
                    </th>
                    <th>查询</th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>客户编号</th>
                    <th>客户简称</th>
                    <th>客户联系人</th>
                    <th>联系电话</th>
                    <th>客户属性</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($member_list as $key => $value) {?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['code'];?></td>
                    <td><?php echo $value['short_name'];?></td>
                    <td><?php echo $value['contacts'];?></td>
                    <td><?php echo $value['mobile'];?></td>
                    <td><?php echo $value['member_type_name'];?></td>
                    <td><a class="btn btn-info doedit" member_id='<?php echo $value['id'];?>'>修改</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" member_id='<?php echo $value['id'];?>'>删除</a>
                    </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                </tr>
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
            url = "<?php echo site_url(array('ctl'=>'member', 'act'=>'do_delete'))?>"+"&id="+$(this).attr('member_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'member', 'act'=>'edit'))?>"+"&id="+$(this).attr('member_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('修改客户信息'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

})

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url('ctl=member&act=manage');?>';
    var getobj = {};
    //getobj.from_node_id=$('#from_node_id_searsh').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

</script>