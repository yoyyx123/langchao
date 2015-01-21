<form class="form-horizontal" action="<?php echo site_url('ctl=event&act=do_add_event');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">

<div class="box col-lg-7 col-md-7">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>客户全称</th>
                <td colspan="5">
                    <?echo $member['name']; ?>
                </td>
            </tr>
            <tr>
                <th width="80px">客户简称</th>
                <td colspan="5">
                    <?echo $member['short_name']; ?>
                </td>
            </tr>                          
            <tr>
                <th>部门</th>
                <td>
                    <select name="department_id" id="department_id" class="department_id">
                            <option value="">请选择</option>
                        <?php foreach ($department_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>使用人</th>
                <td>
                    <select name="user_id" id="user_id" class="user_id">                                        
                    </select>
                </td>
            </tr>            
            <tr>
                <th>事件类型</th>
                <td>
                    <select name="event_type_id" id="event_type_id">                                        
                        <?php foreach ($event_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>  
            </tr>
            <tr>
                <th>是否驻派</th>
                <td>
                    非驻派<input type="radio" name="work_type" id="work_type" value="0" checked/>&nbsp&nbsp&nbsp
                    驻派<input type="radio" name="work_type" id="work_type" value="1">
                </td>
            </tr>            
            <tr>
                <th>事件描述</th>
                <td colspan="5">
                   <textarea name="desc"></textarea>
                </td>
            </tr>
            <tr>
                <th>工作日区间</th>
                <td>
                    <select name="worktime_id" id="worktime_id">                                        
                        <?php foreach ($worktime_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>事件时间</th>
                <td>
                    <div id="event_timediv" class="input-group col-xs-4">
                        <input type="text" placeholder="事件时间" name="event_time" id="event_time">
                        <input type="text" class="inp wdate" name="event_time" id="event_time" onfocus="WdatePicker({startDate:'<?php echo date('Y-m-d');?>', maxDate:'#F{$dp.$D(\'nEndDate\',{d:0});}', minDate:'#F{$dp.$D(\'nEndDate\',{M:-6})}'})" value="<?php echo date('Y-m-d');?>" readonly="readonly" />
                    </div>                    
                </td>               
            </tr>                                                                                                                                                                                                                         
        </tbody>
    </table>
    <input type="hidden" name="member_id" value="<?echo $member['id']; ?>">
</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
        <button type="submit" class="btn btn-primary">添加</button>&nbsp&nbsp&nbsp
        <a class="btn btn-primary do_all_add" member_id='<?php echo $value['id'];?>'>批量添加</a>        
    </p>
</div> 

</form>


<script type="text/javascript">
$(function() {

        $(".do_all_add").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'add_event'))?>",
                data: "&id="+$(this).attr('member_id'),
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('事件开设'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
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
                    $.each(data, function(key,value){
                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
             });            
        });        
})
</script>