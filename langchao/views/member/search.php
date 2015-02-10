<div class="row">
    <div class="box col-md-12">
        <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" placeholder="" name="short_name" id="short_name">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户编号</div>
              <input class="form-control" type="text" placeholder="" name="code" id="code">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户联系人</div>
              <input class="form-control" type="text" placeholder="" name="contacts" id="contacts">
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search" member_id='<?php echo $value['id'];?>'>查询</a>
        </form>
    </div>
</div>
<div class="row member_info">
</div>

<div class="row shijian_list">
</div>

<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {
        $(".do_search").click(function() {
            _self = this;
            short_name = $('#short_name').val();
            code = $('#code').val();
            contacts = $('#contacts').val();
            if (short_name == '' && code == '' && contacts == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'member', 'act'=>'do_search'))?>",
                data: "short_name="+short_name+"&code="+code+"&contacts="+contacts,
                success: function(result){
                    $(".member_info").html(result);
                }
             });
        });

})
</script>