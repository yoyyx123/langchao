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
              <input class="form-control" type="text" placeholder="" name="start_time" id="start_time">
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
              <input class="form-control" type="text" placeholder="" name="end_time" id="end_time">
            </div>
          </div>
        </td>
        <td><a class="btn btn-info do_search">查询</a></td>
        </tr>     
    </table>
</div>     

</div>

<div class="row event_info" id="event_info">
   
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {

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
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(array('ctl'=>'search', 'act'=>'data_search'))?>"+"&is_search=1&user_id="+user_id+"&short_name="+short_name+"&start_time="+start_time+"&end_time="+end_time,
                data: "",
                success: function(result){
                    $("#event_info").html(result);
                }
             });
        });        

})
</script>