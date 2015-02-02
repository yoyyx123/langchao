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
            <div class="input-group-addon">部门</div>
              <select  class="form-control department_id" name="department_id" id="department_id">
                <option value="">无</option>
                <?php foreach ($department_list as $key => $value) {
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
              <div class="input-group-addon">月份</div>
              <input class="form-control form_datetime" type="text" value="<?if(isset($event_month)){echo $event_month;}?>" name="event_month" id="event_month">
            </div>
          </div>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control user_id" name="user_id" id="user_id">
                <option value="">无</option>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">数据列别</div>
              <select  class="form-control" name="data_type" id="data_type">
                <option value="work_time">工时</option>
                <option value="fee">报销费用</option>
              </select>
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
  if(isset($info_list)&&!empty($info_list)&&isset($is_search)){
  ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>月份</th>
                <th>使用人</th>
                <th>状态</th>
                <th>工时</th>
                <th>平时加班时间</th>
                <th>周末加班时间</th>
                <th>节日加班时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($info_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_month'];?></td>
                <td><?php echo $value['user_name'];?></td>
                <td></td>
                <td><?php echo $value['worktime_count'];?></td>
                <td><?echo $value['week_more'];?></td>
                <td><?echo $value['weekend_more'];?></td>
                <td><?echo $value['holiday_more'];?></td>
                <td><a class="btn btn-info">查看</a></td>
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
            format: "yyyy-mm", 
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 3,
            minView:3,
            forceParse: 0,
            showMeridian: 1,

        });

        $(".department_id").change(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
                data: "&department_id="+$(this).val(),
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();
                    if(result){
                      $(".user_id").append('<option value="all">全部</option>');
                    }
                    $.each(data, function(key,value){

                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
             });            
        });              

        $(".do_search").click(function() {
            _self = this;
            department_id = $('#department_id').val();
            user_id = $('#user_id').val();
            event_month = $('#event_month').val();
            data_type = $('#data_type').val();            
            if (event_month == '') {
                    var n = noty({
                      text: "y月份必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (department_id == '') {
                    var n = noty({
                      text: "部门必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }                
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'data_export'))?>"+"&is_search=1&user_id="+user_id+"&department_id="+department_id+"&event_month="+event_month+"&data_type="+data_type;
            window.location.href = url;
        });        

})
</script>