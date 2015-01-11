<div class="box col-lg-7 col-md-7">
    <?php
    if(isset($member)&&!empty($member)){
    ?>
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
                    <select name="department" id="department">                                        
                        <?php foreach ($department_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>事件类型</th>
                <td>
                    <select name="event" id="department">                                        
                        <?php foreach ($event_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
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
                    <select name="worktime" id="worktime">                                        
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
                    </div>                    
                </td>
            </tr>                                                                                                                                                                                                                         
        </tbody>
    </table>
<?php }else{?>
<p>查询不到客户信息!</p>
<?php }?>
</div>