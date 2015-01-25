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
                <option value="<? echo $value['id'];?>"><?echo $value['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" placeholder="" name="short_name" id="short_name">
            </div>
          </div>&nbsp&nbsp          
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">月份</div>
              <input class="form-control" type="text" placeholder="" name="event_time" id="event_time">
            </div>
          </div>&nbsp&nbsp
        &nbsp&nbsp<a class="btn btn-info do_search">查询</a>
        </form>
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
            event_time = $('#event_time').val();
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
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_event_search'))?>",
                data: "is_event=1&user_id="+user_id+"&event_time="+event_time+"&short_name="+short_name,
                success: function(result){
                    $("#event_info").html(result);
                }
             });
        });        

})
</script>