
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_role_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">角色名称</th>
                <td>
                    <input type="text" placeholder="角色名称" name="role_name" id="role_name" value="<?php echo $role['role_name']?>">
                </td>
            </tr>
            <tr>
                <th>角色简介</th>
                <td>
                    <textarea type="text" placeholder="角色简介" name="role_memo" id="role_memo"><?php echo $role['role_memo']?></textarea>
                </td>
            </tr>
            <tr>
                <th width="80px">角色权限</th>
                <td>
                    <div class="box-content">
                        <?php foreach ($role['ctl'] as $key => $value) {?>
                           <div class="checkbox-group">
                                <input class="sel-handle" type="checkbox" value="<?echo $value['id']?>" <?php if ($value['sel']=="1") echo "checked"; ?> name="ctl[]">
                                <?php echo $value['name']?>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php foreach ($value['ctl_child'] as $k => $v) {?>
                                    <input type="checkbox" value="<?echo $v['id']?>" <?php if ($v['sel']=="1") echo "checked"; ?> name="ctl[]"><?echo $v['name']?>
                                <?php }?>
                                <br>
                                <hr>
                            </div>
                        <?php }?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
        <input type="hidden" name="role_id" id="role_id" value="<?php echo $role['role_id']?>">
        <button type="submit" class="btn btn-primary">修改</button>
</form>         
