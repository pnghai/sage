<?php if (!(is_home())):?>
<footer class="content-info">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <?php dynamic_sidebar('sidebar-footer1'); ?>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <?php dynamic_sidebar('sidebar-footer2'); ?>
      </div>
      <div class="clearfix visible-sm-block"></div>
      <div class="col-xs-12 col-sm-6 col-md-2">
        <?php dynamic_sidebar('sidebar-footer3'); ?>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-3">
        <?php dynamic_sidebar('sidebar-footer4'); ?>
      </div>
    </div>
  </div>
</footer>
<?php endif;