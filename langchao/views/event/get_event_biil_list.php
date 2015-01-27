<div class="row" style="text-align:center;">
     <h2>费用审核</h2>
</div>

<div class="row member_info" id="member_info">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>月份</th>
                    <td><? echo $event_month;?></td>
                    <th>使用人</th>
                    <td><?echo $user_info['name']?></td>
                    <th>合计</th>
                    <td><?echo $total;?></td>
                    <th>
                        <?if($is_cost !=1){?>
                            <a class="btn btn-primary change_event_status" id="change_event_status">进行报销</a>
                        <?}else{?>
                            <a class="btn btn-info" id="change_event_status">已报销</a>
                        <?}?>
                    </th>
                    <th colspan="9"></th>
                </tr>                
                <tr>
                <th>序号</th>
                <th>出发时间</th>
                <th>到达时间</th>
                <th>起始地</th>
                <th>目的地</th>
                <th>交通方式</th>
                <th>交通费</th>
                <th>住宿费</th>
                <th>加班餐费</th>
                <th>其他费用</th>
                <th>备注</th>
                <th>单据编号</th>
                <th>事件关联</th>
                <th>小计</th>
                <th>纠正费用</th>
                <th>审核</th>
                </tr>
            </thead>
            <tbody>
                <? $i=1; foreach ($bill_list as $key => $val) {?>
                <tr align="center" id="1">
                    <td><?echo $i;?></td>
                    <td><?echo $val['go_time'];?></td>
                    <td><?echo $val['arrival_time'];?></td>
                    <td><?echo $val['start_place'];?></td>
                    <td><?echo $val['arrival_place'];?></td>
                    <td><?echo $val['transportation_name'];?></td>
                    <td><?echo $val['transportation_fee'];?></td>
                    <td><?echo $val['hotel_fee'];?></td>
                    <td><?echo $val['food_fee'];?></td>
                    <td><?echo $val['other_fee'];?></td>
                    <td><?echo $val['memo'];?></td>
                    <td><?echo $val['bill_no'];?></td>
                    <td><a class="btn btn-primary do_look"  bill_id="<?echo $val['id'];?>" onclick="do_look(this)">查看</a></td>
                    <td><?echo $val['bill_total'];?></td>
                    <td><input type="text" name="rel_fee"></td>
                    <td><a class="btn btn-primary do_check" bill_id="<?echo $val['id'];?>" onclick="do_check(this)">审核</a></td>
                </tr>
                <? $i++;}?>
                <tr>
                    <td colspan="15"></td>
                    <td><a class="btn btn-info do_check" bill_id="<?echo $val['id'];?>" onclick="do_check(this)">一键审核</a></td>
                </tr>
            </tbody>
        </table>
        <input class="event_month" type="hidden" value="<?php echo $event_month;?>">
        <input class="user_id" type="hidden" value="<?php echo $user_info["id"];?>">
    </div>
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {

        $(".change_event_status").click(function() {
            _self = this;
            event_month = $('.event_month').val();
            user_id = $('.user_id').val();            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'change_event_cost_status'))?>",
                data: "event_month="+event_month+"&user_id="+user_id+"&status=3",
                success: function(result){
                    if(result="succ"){
                        $("#change_event_status").removeClass("change_event_status");
                        $("#change_event_status").removeClass("btn-primary");
                        $("#change_event_status").addClass("btn-info");
                        $("#change_event_status").html("已报销");
                    }
                }
             });
        });

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
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'change_event_cost_status'))?>",
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

})
</script>