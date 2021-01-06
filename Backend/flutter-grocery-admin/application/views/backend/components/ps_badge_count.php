<!-- info box -->
<div class="info-box">
  <span class="info-box-icon <?php echo $color; ?>">
    <?php if ($status_id != 0){?>
     <a href="<?php  echo site_url('/admin/transactions/filter_from_dashboard/'.$status_id); ?>">
  <?php } else { ?>
     <a href="<?php  echo site_url('/admin/transactions/index'); ?>">
  <?php } ?>
      <i class="<?php echo $icon; ?>"></i>
    </a>
  </span>

  <div class="info-box-content">
  <?php if ($status_id != 0){?>
     <a href="<?php  echo site_url('/admin/transactions/filter_from_dashboard/'.$status_id); ?>">
  <?php } else { ?>
     <a href="<?php  echo site_url('/admin/transactions/index'); ?>">
  <?php } ?>
      <span class="info-box-text" style="font-weight: bold;"><?php echo $label; ?></span>
    </a>
     <span class="info-box-number">
         <?php echo $total_count ; ?>
        </span>
  </div>
  <!-- /.info-box-content -->
</div>