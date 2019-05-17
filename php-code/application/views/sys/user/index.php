<h2><?php echo $title; ?></h2>
<?php foreach ($sys_user as $sys_user_item): ?>
    <h3><?php echo $sys_user_item['login_name']; ?></h3>
    <div class="main">
        <?php echo $sys_user_item['nick_name']; ?>
        <?php echo $sys_user_item['full_name']; ?>
        <h4>密码：<?php echo $sys_user_item['password']; ?></h4>
    </div>
    <p><a href="<?php echo site_url('sys/sys_user/detail/'.$sys_user_item['id']); ?>">aView article</a></p>
<?php endforeach; ?>