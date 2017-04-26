<?php foreach ($data["requirements"] as $requirement):?>

<?php
    $class = "check-success";
    $icon = "fa-check-circle";
    
    if ($requirement["error"]) {
        $icon = "fa-times-circle";
        $class = "check-error";
    } else 
        if ($requirement["warning"]) {
            $icon = " fa-exclamation-circle";
            $class = "check-warning";
        }
    
    ?>

<dl class="<?php echo $class?>">
	<dt>
		<i class="fa <?php echo $icon;?>"></i> &nbsp; &nbsp; <?php echo $requirement["name"]?></dt>
	<!--  <dd><?php echo $requirement["memo"]?></dd>-->
</dl>
<?php endforeach;?>


<?php if($data["summary"]["errors"] > 0):?>

<?php $this->beginBlock('ibtnArea'); ?>
<div class="ibtnArea clearfix">
	<span class="pull-left"> <a href="javascript:void(0)"
		class="btn btn-small  btn-primary" id="prevButton"><i
			class="fa fa-arrow-circle-left"></i> 返回 </a>
	</span>
</div>
<?php $this->endBlock(); ?>

<?php endif; ?>