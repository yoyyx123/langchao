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
              <select class="form-control" name="cost_status" id="cost_status">
                <option value="1" <?if(isset($cost_status)&&$cost_status==1){echo "selected=selected";}?>>未审核</option>
                <option value="2" <?if(isset($cost_status)&&$cost_status==2){echo "selected=selected";}?>>待报销</option>
                <option value="3" <?if(isset($cost_status)&&$cost_status==3){echo "selected=selected";}?>>已报销</option>
              </select>
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search">查询</a>
        </form>
    </div>
</div>

<div class="row event_info" id="event_info">
    <?php
    if(isset($month_list)&&!empty($month_list)&&isset($is_event)){
    ?>    
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th>序号</th>
                <th>使用人</th>
                <th>月份</th>
                <th>状态</th>
                <th>预报销总额</th>
                <th>操作</th>
                <th>实际报销总额</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($month_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['user_name'];?></td>
                <td><?php echo $key;?></td>
                <td><?if($value['cost_status']==1){echo "未审核";}elseif($value['cost_status']==2){echo "待报销";}elseif($value['cost_status']==3){echo "已报销";}?></td>
                <td><?php echo $value['total_fee'];?></td>              
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=get_event_biil_list')."&user_id=".$value['user_id']."&event_month=".$key;?>">查看</a></td>
                <td><?php echo $value['rel_total_fee'];?></td>
            </tr>
            <? } ?>
        </tbody>
        <!--
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
            </tr>
        </tbody>        
      -->
    </table>
<?php }elseif(isset($is_event)){?>
<p>查询不到事件信息!</p>
<?php }?>

</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
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
            cost_status = $('#cost_status').val();
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }            
            if (user_id == '' && event_month == '' && cost_status == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'cost_check'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&cost_status="+cost_status;
            window.location.href = url;
            /**
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_event_cost_search'))?>",
                data: "is_event=1&user_id="+user_id+"&event_month="+event_month+"&cost_status="+cost_status,
                success: function(result){
                    $("#event_info").html(result);
                }
             });
          **/
        });        

})
</script>