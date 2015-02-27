<!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <? foreach ($menu_list as $key => $value) {?>                        
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span><?echo $value['name'];?></span></a>
                            <ul class="nav nav-pills nav-stacked">
                            <?if(isset($value['child'])){foreach ($value['child'] as $k => $val) {?>
                                <li><a href='<?php echo site_url("ctl=".$val['ctl_file']."&act=".$val['ctl_act']);?>'><?echo $val['name'];?></a></li>
                            <?}}?>
                            </ul>                              
                        </li>
                        <?}?>                        
                        <!--
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>客户模块</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo site_url('ctl=member&act=add');?>">客户添加</a></li>
                                <li><a href="<?php echo site_url('ctl=member&act=search');?>">客户查询</a></li>
                                <li><a href="<?php echo site_url('ctl=member&act=manage');?>">客户管理</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus event"></i><span>外勤模块</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo site_url('ctl=event&act=index');?>">事件开设</a></li>
                                <li><a href="<?php echo site_url('ctl=event&act=event_list');?>">工单列表</a></li>
                                <li><a href="<?php echo site_url('ctl=event&act=event_check');?>">事件审核</a></li>
                                <li><a href="<?php echo site_url('ctl=event&act=cost_check');?>">费用审核</a></li>
                                <li><a href="<?php echo site_url('ctl=event&act=event_search');?>">事件查询</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>云模块</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">浪潮云</a></li>
                                <li><a href="<?php echo site_url('ctl=cloud&act=doc_download');?>">数据下载</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>查询模块</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">绩效查询</a></li>
                                <li><a href="<?php echo site_url('ctl=search&act=data_search');?>">业务查询</a></li>
                                <li><a href="<?php echo site_url('ctl=search&act=data_export');?>">数据导出</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>后台模块</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo site_url('ctl=system&act=role_list');?>">角色管理</a></li>
                                <li><a href="<?php echo site_url('ctl=system&act=setting_list');?>">基础信息设置</a></li>
                                <li><a href="<?php echo site_url('ctl=system&act=event_list');?>">事件类型/故障分类</a></li>
                                <li><a href="<?php echo site_url('ctl=system&act=time_list');?>">时间设定</a></li>
                                <li><a href="<?php echo site_url('ctl=system&act=doc_list');?>">文档管理</a></li>
                            </ul>
                        </li> 
                        -->                                                                                                                     
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->