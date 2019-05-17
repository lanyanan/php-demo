<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('sys/sys_user/register'); ?>

    <label for="title">昵称</label>
    <input type="input" value="<?php echo set_value('nick_name'); ?>" name="nick_name" /><br />

    <label for="title">登录名</label>
    <input type="input" value="<?php echo set_value('login_name'); ?>" name="login_name" /><br />

    <label for="title">密码</label>
    <input type="input" name="password" /><br />

    <label for="title">确认密码</label>
    <input type="input"  name="passconf" /><br />

    <label for="title">用户性别</label>
	<select name="user_sex" >
       <option value="1" <?php if ( set_value('user_sex') == '1' ) { echo "selected = 'selected'"; } ?>>男</option>
       <option value="2" <?php if ( set_value('user_sex') == '2' ) { echo "selected = 'selected'"; } ?>>女</option>
    </select> 
    <br />
    
    <label for="title">手机号</label>
    <input type="input" value="<?php echo set_value('mobile'); ?>"  name="mobile" /><br />

    <input type="submit"  name="submit" value="注册" />

</form>