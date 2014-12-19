<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=home&act=index');?>">首页</a>
        </li>
        <li>
            <a href="<?php echo site_url('ctl=user&act=info');?>">个人设置</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>账户管理</h4></th>
                </tr>
                <tr>
                    <th>账户列表</th>
                    <th colspan="6"></th>
                    <th>搜索</th>
                    <th>
                    </th>
                    <th>查询</th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>账户</th>
                    <th>使用人</th>
                    <th>短号</th>
                    <th>部门</th>
                    <th>状态</th>
                    <th>工作地点</th>
                    <th>工作类型</th>
                    <th>访问权限</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($user_list as $key => $value) {?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['username'];?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><?php echo $value['short_num'];?></td>
                    <td><?php echo $value['department'];?></td>
                    <td><?php if('1' == $value['status']){echo "在职";}else{echo "离职";}?></td>
                    <td><?php echo $value['addr'];?></td>
                    <td><?php if('1' == $value['work_type']){echo "驻场";}else{echo "非驻场";}?></td>
                    <td><?php echo $value['roles'];?></td>
                    <td>查看</td>
                </tr>
                <?php $i++;} ?>

            </tbody>
        </table>
    </div>
</div>
