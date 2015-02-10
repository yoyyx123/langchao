<div class="row" style="text-align:center;">
     <h2>工单列表</h2>
</div>
<div class="row">
    <div class="box col-md-12">
        <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control" name="user_id" id="user_id">
                <?php foreach ($user_list as $key => $value) {
                ?>
                <option value="<? echo $value['id'];?>" <?if(isset($user_id)&&$user_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">月份</div>
              <input id="event_month" class="form-control date-picker" type="text" value="<?if(isset($event_month)){echo $event_month;}?>" name="event_month">
            </div>
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">事件状态</div>
              <select class="form-control" name="status" id="status">
                <option value="1" <?if(isset($status)&&$status==1){echo "selected=selected";}?>>待添加</option>
                <option value="2" <?if(isset($status)&&$status==2){echo "selected=selected";}?>>待审核</option>
              </select>
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search">查询</a>
        </form>
    </div>
</div>

<div class="row event_info" id="event_info">
    <?php
    if(isset($event_list)&&!empty($event_list)&&isset($is_event)){
    ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>事件列表</th>
                <th colspan="2">使用人：<?php echo $user['name'];?></th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期、时间</th>
                <th>客户简称</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>工单</th>
                <th>费用</th>
                <th>有效期</th>
                <th colspan="2">操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_time'];?></td>
                <td><?php echo $value['short_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td><?php echo $value['work_order_num'];?></td>
                <td><?echo $value['cost_fee'];?></td>
                <td><?php echo $value['event_less_time'];?></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=add_work_order')."&event_id=".$value['id']."&back_url=".urlencode($back_url);?>" >添加工单</a></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=edit_work_order')."&event_id=".$value['id']."&back_url=".urlencode($back_url);;?>">查看</a></td>
            </tr>
            <? } ?>
        </tbody>
        
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
            </tr>
        </tbody>
    </table>
<?php }elseif(isset($is_event)){?>
<p>查询不到事件信息!</p>
<?php }?>
</div>


<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
var sel_time_data = function (per_page) {
    user_id = $('#user_id').val();
    event_month = $('#event_month').val();
    status = $('#status').val();    
    var url = '<?php echo site_url("ctl=event&act=event_list");?>'+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&status="+status;
    var getobj = {};
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

$(function() {
        $('.date-picker').datepicker({
            format: 'yyyy-mm',
            autoclose:true,
            startView: "year",
            language:"zh-CN",
            minViewMode:"months"
          })

        $(".do_search").click(function() {
            _self = this;
            user_id = $('#user_id').val();
            event_month = $('#event_month').val();
            status = $('#status').val();
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }            
            if (user_id == '' && event_time == '' && status == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'event_list'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&status="+status;
            window.location.href = url;
            /**
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_search'))?>"+"&is_event=1&user_id="+user_id+"&event_time="+event_time+"&status="+status,
                data: "",
                success: function(result){
                    $("#event_info").html(result);
                }
             });
          **/
        });        

})
</script>