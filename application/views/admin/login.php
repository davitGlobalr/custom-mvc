<link href="<?php echo URL; ?>public/css/admin/login.css" rel="stylesheet">
<div class="clearfix"></div>
<div>
    <a style="margin: 20px" class="btn btn-primary float-right" href="/home">Go Home</a>
</div>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Login Form -->
        <form action="/admin/login" method="post">
            <?php if (isset($status)) { ?>
                <div class="errors-box">
                    <span color="red"><?php  echo $status; ?></span>
                </div>
            <?php } ?>
            <input type="text" id="login" class="fadeIn second" name="name" placeholder="login" required>
            <input type="password" id="password" class="fadeIn third" name="pass" placeholder="password" required>
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

    </div>
</div>
