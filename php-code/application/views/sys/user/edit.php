<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php 
$url = 'sys/sys_user/edit/' . $sys_user_item['id'];
echo form_open($url); ?>
	<input type='hidden' value="<?php echo $sys_user_item['id']; ?>">
    <label for="title">昵称</label>
    <input type="input" value="<?php echo $sys_user_item['nick_name']; ?>" name="nick_name" /><br />

    <label for="title">用户性别</label>
	<select name="user_sex"   >
       <option value="1" <?php if ( $sys_user_item['user_sex'] == '1' ) { echo "selected = 'selected'"; } ?>>男</option>
       <option value="2" <?php if ( $sys_user_item['user_sex'] == '2' ) { echo "selected = 'selected'"; } ?>>女</option>
    </select> 
    <br />
    
    <label for="title">手机号</label>
    <input type="input" value="<?php echo $sys_user_item['mobile']; ?>"  name="mobile" /><br />

    <input type="submit"  name="submit" value="修改" />

</form>