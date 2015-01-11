<?if(isset($is_event) && $is_event==1){?>

<div class="box col-md-12">
    <table class="table table-bordered">
        <thead>               
            <tr>
                <th>序号</th>
                <th>客户编号</th>
                <th>客户简称</th>
                <th>客户联系人</th>
                <th>联系电话</th>
                <th>客户属性</th>
                <th>客户所属地</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo "1";?></td>
                <td><?php echo $member['code'];?></td>
                <td><?php echo $member['short_name'];?></td>
                <td><?php echo $member['contacts'];?></td>
                <td><?php echo $member['mobile'];?></td>
                <td><?php echo $member['member_type_name'];?></td>
                <td><?php echo $member['city_name'];?></td>
                <td><a class="btn btn-primary do_add" member_id='<?php echo $member['id'];?>'>确认</a>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php }else{?>
<div class="box col-lg-7 col-md-7">
    <?php
    if(isset($member)&&!empty($member)){
    ?>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="110px">客户编号</th>
                <td colspan="5">
                    <?echo $member['code']; ?>
                </td>
            </tr>
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
                <th>客户属性</th>
                <td>
                    <?echo $member['member_type_name']; ?>
                </td>                
                <th>客户所属地</th>
                <td>
                    
                    <?echo $member['city_name']; ?>
                </td>  
            </tr>
            <tr>
                <th>地址</th>
                <td colspan="5">
                    <?echo $member['addr']; ?>
                </td>
            </tr>
            <tr>
                <th>公交/地铁</th>
                <td colspan="5">
                    <?echo $member['bus']; ?>
                </td>
            </tr>
            <tr>
                <th>客户联系人</th>
                <td>
                    <?echo $member['contacts']; ?>
                </td>
                <th>工程项目负责人</th>
                <td>
                    <?echo $member['project_man']; ?>
                </td>
                <th>日常业务负责人</th>
                <td>
                    <?echo $member['business_man']; ?>
                </td>                
            </tr>
            <tr>
                <th>联系电话</th>
                <td>
                    <?echo $member['mobile']; ?>
                </td>
                <th>联系电话</th>
                <td>
                    <?echo $member['project_mobile']; ?>
                </td>
                <th>联系电话</th>
                <td>
                    <?echo $member['business_mobile']; ?>
                </td>                              
            </tr>
            <tr>
                <th>传真</th>
                <td>
                    <?echo $member['fax']; ?>
                </td>
            </tr>                                                                                                                                                                                                                           
        </tbody>
    </table>
<?php }else{?>
<p>查询不到客户信息!</p>
<?php }?>
</div>
<?php }?>