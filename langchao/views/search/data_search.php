<div class="row" style="text-align:center;">
     <h2>工单列表</h2>
</div>
<div class="row">
    <div class="box col-md-8">
    <table> 
        <tr>
          <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control" name="user_id" id="user_id">
                <option value="" selected=selected>无</option>
                <?php foreach ($user_list as $key => $value) {
                ?>
                <option value="<? echo $value['id'];?>"><?echo $value['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">开始时间</div>
              <input class="form-control form_datetime" type="text" placeholder="" name="start_time" id="start_time">
            </div>
          </div>
        </td>
        <td></td>
      </tr>
      <tr>
          <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" placeholder="" name="short_name" id="short_name">
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">结束时间</div>
              <input class="form-control form_datetime" type="text" placeholder="" name="end_time" id="end_time">
            </div>
          </div>
        </td>
        <td><a class="btn btn-info do_search">查询</a></td>
        </tr>     
    </table>
</div>     

</div>

<div class="row event_info" id="event_info">
  <?php
  if(isset($event_list)&&!empty($event_list)&&isset($is_search)){
  ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>客户简称</th>
                <th>小计</th>
                <th>使用人</th>
                <th>路程耗时</th>
                <th>工作耗时</th>
                <th>个人记录次数</th>
                <th>审核有效次数</th>
                <th>投诉次数</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['short_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td><?php echo $value['work_order_num'];?></td>
                <td><?echo $value['cost_fee'];?></td>
                <td><?php echo $value['event_less_time'];?></td>
            </tr>
            <? } ?>
        </tbody>
        
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
            </tr>
        </tbody>
    </table>
  <?php }elseif(isset($is_search)){?>
    <p>查询不到事件信息!</p>
  <?php }?>   
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {

        $('.form_datetime').datetimepicker({
            format: "yyyy-mm-dd", 
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView:2,
            forceParse: 0,
            showMeridian: 1,

        });      

        $(".do_search").click(function() {
            _self = this;
            user_id = $('#user_id').val();
            short_name = $('#short_name').val();
            start_time = $('#start_time').val();
            end_time = $('#end_time').val();            
            if (start_time == '' || end_time == '') {
                    var n = noty({
                      text: "开始结束时间必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '' && short_name == '') {
                    var n = noty({
                      text: "使用人或者客户必填一个",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'data_search'))?>"+"&is_search=1&user_id="+user_id+"&short_name="+short_name+"&start_time="+start_time+"&end_time="+end_time;
            window.location.href = url;
            /**
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(array('ctl'=>'search', 'act'=>'data_search'))?>"+"&is_search=1&user_id="+user_id+"&short_name="+short_name+"&start_time="+start_time+"&end_time="+end_time,
                data: "",
                success: function(result){
                    $("#event_info").html(result);
                }
             });
          **/
        });        

})
</script>