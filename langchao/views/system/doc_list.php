<div class="row">
    <div class="box col-md-5">
    <form action="<?php echo site_url(array('ctl'=>'system', 'act'=>'doc_add'))?>" method="post" enctype="multipart/form-data" onsubmit="return do_upload();" accept-charset="utf-8">
        <table class="table table-bordered">
            <tr>
                <th>选择文件</th>
                <th>文档名称</th>
                <th>操作</th>
            </tr>
            <tr>
                <td><input type="file" name="file" id="file" /></td>
                <td><input type="text" name="name" id="name"></td>
                <td><input class="btn btn-primary" type="submit" name="submit" value="上传" /></td>
            <tr>
        </table>
    </form>        
    </div>

</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>文档管理</h4></th>
                </tr>               
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($list as $key => $value) {?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><a class="btn btn-info doedit" setting_id='<?php echo $value['id'];?>'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" setting_id='<?php echo $value['id'];?>'>删除</a>
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

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=system&act=doc_list");?>';
    var getobj = {};
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

function do_upload(){
    file = $('#file').val();
    name = $('#name').val(); 
    if (file== '') {
        var n = noty({
          text: "请选择上传文件",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (name== '') {
        var n = noty({
          text: "请输入文档名称",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }    
    return true;
        
}
</script>
 