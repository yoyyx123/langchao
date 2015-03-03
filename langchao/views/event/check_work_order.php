<div class="box col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="3">事件数据</th>
                </tr>
            </thead>
            <tbody>
                <tr align="center">
                    <th>工单数量</th>
                    <td><?php echo $work_order_num;?>件</td>
                    <td rowspan="7"><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=edit_work_order&event_id='.$event["id"]);?>" target="_blank">查看</a></td>
                </tr>
                <tr align="center">
                    <th>有效工时</th>
                    <td><?php echo $event['worktime_count'];?>小时</td>
                </tr>
                <tr align="center">
                    <th>平时加班</th>
                    <td><?php echo $event['week_more'];?>小时</td>
                </tr>
                <tr align="center">
                    <th>周末加班</th>
                    <td><?php echo $event['weekend_more'];?>小时</td>
                </tr>
                <tr align="center">
                    <th>节假日加班</th>
                    <td><?php echo $event['holiday_more'];?>小时</td>
                </tr>
                <tr align="center">
                    <th>事件反馈</th>
                    <td>
                        <?foreach ($work_order_list as $key => $value) {
                            if($value['schedule']==0){
                                $schedule = "已完成";
                            }elseif($value['schedule']==1){
                                $schedule = "部分完成";
                            }else{
                                $schedule = "未完成";
                            }
                            echo "<a target='_blank' href='".site_url('ctl=event&act=edit_work_order')."&event_id=".$event['id']."&work_order_id=".$value['id']."'>".$schedule."</a>;";
                        }?>
                    </td>
                </tr>
                <tr align="center">
                    <th>是否超时</th>
                    <td><?php if($event_less_time==0){echo "已超时";}elseif($event_less_time==1){echo "未超时";}?></td>
                </tr>                                                                      
            </tbody>
        </table>
</div>

<div class="box col-md-7">
    <form class="form-horizontal" action="<?php echo site_url('ctl=event&act=add_check_event_info');?>" method="post"  onsubmit="return do_add();">
        <table class="table table-bordered">
            <tbody>
                <tr align="center">
                    <th>是否投诉</th>
                    <td>
                        是<input type="radio" name="is_complain" id="is_complain" value="1" <?if(isset($check)&&$check['is_complain']==1){echo "checked='checked'";}?>>
                        否<input type="radio" name="is_complain" id="is_complain" value="0" <?if(isset($check)&&$check['is_complain']==0){echo "checked='checked'";}?>>
                    </td>
                </tr>
                <tr align="center">
                    <th>是否生效</th>
                    <td>
                        是<input type="radio" name="event_status" id="event_status" value="1" <?if(isset($check)&&$check['event_status']==1){echo "checked='checked'";}?>>
                        否<input type="radio" name="event_status" id="event_status" value="0" <?if(isset($check)&&$check['event_status']==0){echo "checked='checked'";}?>>
                    </td>
                </tr>
                <tr align="center">
                    <th>绩效完成率</th>
                    <td>
                        <select name="performance_id" id="performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['performance_id'])&&$check['performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?></option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>备注</th>
                    <td>
                        <input type="text" name="memo" id="memo" value="<?if(isset($check)){echo $check['memo'];}?>">
                    </td>
                </tr>                                                                     
            </tbody>
        </table>
        <input type="hidden" name="event_id" value="<?echo $event['id']?>;">
        <input type="hidden" name="check_id" value="<?if(isset($check)){echo $check['id'];}?>">
        <button type="submit" class="btn btn-primary">审核</button>&nbsp&nbsp&nbsp
        <a class="btn btn-primary do_delete" event_id='<?php echo $event['id'];?>'>删除</a>        
    </form>
</div>


<script type="text/javascript">
$(function () {
    $(".do_delete").click(function() {
     if(confirm("确认删除吗")){
        _self = this;
        url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'delete_check_event'))?>"+"&event_id="+$(this).attr('event_id');
        window.location.href=url;
     }else{
        return;
     }
    });
})


function do_add(){
is_complain = $("#is_complain").val();
    event_status = $("#event_status").val();
    performance_id = $("#performance_id").val();
    memo = $("#memo").val();
    if (is_complain== '') {
        var n = noty({
          text: "请选择是否投诉",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (event_status== '') {
        var n = noty({
          text: "请选择是否生效",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (performance_id== '') {
        var n = noty({
          text: "请选择绩效完成率",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    /**
    if (memo== '') {
        var n = noty({
          text: "请输入备注",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }**/
    if (!confirm("确认要审核")) {
           return false;
        }
    return true;    
}
</script>