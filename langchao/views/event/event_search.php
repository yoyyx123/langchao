<div class="row" style="text-align:center;">
     <h2>工单列表</h2>
</div>
<div class="row">
    <div class="box col-md-9">
        <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control" name="user_id" id="user_id">
                <option value="" selected=slected>请选择</option>
                <?php foreach ($user_list as $key => $value) {
                ?>
                <option value="<? echo $value['id'];?>" <?if(isset($user_id)&&$user_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" value="<?if(isset($short_name)){echo $short_name;}?>" name="short_name" id="short_name">
            </div>
          </div>&nbsp&nbsp          
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">月份</div>
              <input id="event_month" class="form-control date-picker" type="text" value="<?if(isset($event_month)){echo $event_month;}?>" name="event_month">

            </div>
          </div>&nbsp&nbsp
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
                <th colspan="2"><?if($title=="user"){echo"使用人：".$user['name'];}elseif($title=="member"){echo"客户简称：".$member['short_name'];}?></th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期、时间</th>
                <th>客户简称/使用人</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>报修症状</th>
                <th>故障分析</th>
                <th>解决方案</th>
                <th>事件状态</th>
                <th>报销状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_time'];?></td>
                <td><?php echo $value['short_name'];?>/<?php echo $value['user_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?if($value['status']==1){echo "待添加";}elseif($value['status']==2){echo "待审核";}elseif($value['status']==3){echo "已审核";}?></td>
                <td></td>                
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=edit_work_order')."&event_id=".$value['id']."&back_url=".urlencode($back_url);?>">查看</a></td>
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
    short_name = $('#short_name').val();    
    var url = '<?php echo site_url("ctl=event&act=event_search");?>'+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&short_name="+short_name;
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
            short_name = $('#short_name').val();      
            if (user_id == '' && short_name == '') {
                    var n = noty({
                      text: "使用人和客户简称中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }

            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'event_search'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&short_name="+short_name;
            window.location.href = url;
            /**    
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_event_search'))?>",
                data: "is_event=1&user_id="+user_id+"&event_time="+event_time+"&short_name="+short_name,
                success: function(result){
                    $("#event_info").html(result);
                }
             });
            **/
        });        

})
</script>