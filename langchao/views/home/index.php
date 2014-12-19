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
        <div class="box-inner">
            <div class="box-header well">
                <h2><i></i></h2>
            </div>
            <div class="box-content row">
                <div class="col-xs-6 col-md-2" style="text-align:center;">
                    <img height="150px" src="<?php echo base_url('upload/img/userlogo').'/'.$user_data['img'];?>" />
                </div>
                <div class="col-lg-7 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="80px">帐号</td>
                                <td><?php echo $user_data['username'];?></td>
                                <td width="80px">登录时间</td>
                                <td><?php echo $user_data['login_time'];?></td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td><?php echo $user_data['name'];?></td>
                                <td>集团短号</td>
                                <td><?php echo $user_data['short_num'];?></td>
                            </tr>
                            <tr>
                                <td>部门</td>
                                <td><?php echo $user_data['department'];?></td>
                                <td>职位</td>
                                <td><?php echo $user_data['position'];?></td>
                            </tr>
                            <tr>
                                <td>移动电话</td>
                                <td><?php echo $user_data['mobile'];?></td>
                                <td>企业邮箱</td>
                                <td><?php echo $user_data['email'];?></td>
                            </tr>                              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>系统提示</th>
                    <th colspan="6" style="text-align:center;">当前已有**件工单超时，请注意！</th>
                </tr>
                <tr>
                    <th>待填工单</th>
                    <th colspan="6"></th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>时间</th>
                    <th>客户简称</th>
                    <th>事件类型</th>
                    <th>使用人</th>
                    <th>事件描述</th>
                    <th>有效期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td><?php echo $user_data['username'];?></td>
                    <td>查看</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
