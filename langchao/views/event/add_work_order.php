<form class="form-horizontal" action="<?php echo site_url('ctl=event&act=do_add_work_order');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">

<div class="box col-lg-12 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>事件类型</th>
                <td>
                    <?echo $event['event_type_name']; ?>
                </td>
                <th>客户部门</th>
                <td>
                    <input type="text" name="custom_department">
                </td>
            </tr>
            <tr>
                <th>到达时间(签到)</th>
                <td>
                    <input type="text" name="arrive_time">
                </td>
                <th>离场时间(签退)</th>
                <td>
                    <input type="text" name="back_time">
                </td>                
            </tr>
            <tr>
                <th>保修症状</th>
                <td colspan="3">
                    <textarea  name="symptom" rows="1" cols="50"></textarea>
                </td>
            </tr>            
            <tr>
                <th>故障分类</th>
                <td>
                   日常<input type="radio" name="failure_mode" id="failure_mode" value="0" checked="checked">
                </td>
                <td>
                   软件<input type="radio" name="failure_mode" id="failure_mode" value="1">
                </td>
                <td>
                   硬件<input type="radio" name="failure_mode" id="failure_mode" value="2">
                </td>
            </tr>
            <tr>
                <th>故障等级</th>
                <td>
                   一级<input type="radio" name="failure_level" id="work_type" value="0" checked="checked">
                </td>
                <td>
                   二级<input type="radio" name="failure_level" id="failure_level" value="1">
                </td>
                <td>
                   三级<input type="radio" name="failure_level" id="failure_level" value="2">
                </td>
            </tr>
            <tr>
                <th>故障分析</th>
                <td colspan="3">
                    <textarea name="failure_analysis" rows="1" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>风险预测</th>
                <td colspan="3">
                    <textarea  name="risk_profile" rows="1" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>解决方案</th>
                <td colspan="3">
                    <textarea  name="solution" rows="1" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>使用人描述</th>
                <td colspan="3">
                    <textarea  name="desc" rows="1" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>事件反馈</th>
                <td>
                   已完成<input type="radio" name="schedule" id="schedule" value="0" checked="checked">
                </td>
                <td>
                   部分完成<input type="radio" name="schedule" id="schedule" value="1">
                </td>
                <td>
                   未完成<input type="radio" name="schedule" id="schedule" value="2">
                </td>
            </tr>
            <tr>
                <th>备注</th>
                <td colspan="3">
                    <textarea  name="memo" rows="1" cols="50"></textarea>
                </td>
            </tr>

        </tbody>
    </table>
    <input type="hidden" name="event_id" value="<?echo $event['id']; ?>">
</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
        <button type="submit" class="btn btn-primary">添加</button>&nbsp&nbsp&nbsp
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