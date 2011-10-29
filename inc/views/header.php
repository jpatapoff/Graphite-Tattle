<?php fHTML::sendHeader() ?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->prepare('title') ?><?php echo (strpos($this->get('title'), 'Graphite-Tattle') === FALSE ? ' - Graphite-Tattle' : '') ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
<?php if (!$this->get('full_screen')) { ?>
    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
<?php } ?>
   <base href="<?php echo fURL::getDomain() . '/graphite-tattle/'; ?>" />
    
   	
    <link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css">	
    <script src="assets/js/jquery.min.js"></script> 
    <script src="assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.collapsible.js"></script>
<?php if ($this->get('graphlot')) { ?>
    <script type="text/javascript" src="<?php echo GRAPHITE_URL; ?>/content/js/jquery.flot.js"></script>
    <script type="text/javascript" src="<?php echo GRAPHITE_URL; ?>/content/js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="<?php echo GRAPHITE_URL; ?>/content/js/jquery.flot.selection.js"></script>
    <script type="text/javascript" src="<?php echo GRAPHITE_URL; ?>/content/js/jquery.flot.crosshair.js"></script>
    <script type="text/javascript" src="assets/js/jquery.graphite.js"></script>
    <script type="text/javascript">

    $(document).ready(function () {
        $('.graphite').graphiteGraph();
    });

    </script>

<?php } ?>  

    <script type="text/javascript"> 
      $(function() {
                 $("#check-target").autocomplete({
		  source: "ajax/autocomplete.php",
		  minLength: 2,
		  select: function(event, ui) {
  		    $('#check-target').val(ui.item.id);
		  }
        });
      });
     
   	</script>
    <script type="text/javascript"> 
      $(function() {
                 $("#line-target").autocomplete({
		  source: "ajax/autocomplete.php",
		  minLength: 2,
		  select: function(event, ui) {
  		    $('#line-target').val(ui.item.id);
		  }
        });
      });
     
   	</script> 

    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-twipsy.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
  </head>
  <body>

<?php 
if (!$this->get('full_screen')) { ?>
   <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Graphite-Tattle </a>
          <ul class="nav">
            <?
              
              $current_url = str_replace('/graphite-tattle/','',fURL::getWithQueryString());
              echo '<li' . ($current_url == '' ? ' class="active"' : '') . '><a href="#">Alerts</a></li>'. "\n";                
              $check_list = Check::makeURL('list');
              echo '<li' . ($current_url == $check_list ? ' class="active"' : '') . '><a href="' . $check_list . '" >Checks</a></li>' . "\n";
              $subscription_list = Subscription::makeURL('list');
              echo '<li' . ($current_url == $subscription_list ? ' class="active"' : '') .'><a href="' . $subscription_list . '" >Subscriptions</a></li>' . "\n";
              $dashboard_list = Dashboard::makeURL('list');
              echo '<li' . ($current_url == $dashboard_list ? ' class="active"' : '') . '><a href="' . $dashboard_list . '">Dashboards</a></li>';
if (fSession::get('user_id') == 1) {
              $user_list = User::makeURL('list'); 
              echo '<li><a href="' . User::makeURL('list') . '" >Users</a></li>';
}              
?>
          </ul>
 <?php   if (is_numeric(fSession::get('user_id'))) { ?>
 <p class="pull-right">
     Logged in as <a href="<?= User::makeUrl('edit',fSession::get('user_id'));?>"><?php echo fSession::get('user_name'); ?></a>
</p>
    <?php } ?> 
</div> 
        </div>
      </div>
<?php } ?>
<div class="container-fluid">
<?php  
    $breadcrumbs = $this->get('breadcrumbs');
    if (is_array($breadcrumbs)) {
    echo '<ul class="breadcrumb">';
      $crumb_count = count($breadcrumbs);
      $crumb_counter = 1;
      foreach($breadcrumbs as $crumb) {
        echo '<li' . (isset($crumb['class']) ? ' class="' . $crumb['class'] .'"' : ' class="active"' ) .'><a href="'. $crumb['url'] . '">' . $crumb['name'] . '</a>';
        if ($crumb_counter < $crumb_count) {
          echo '<span class="divider">/</span></li>';
        }
        $crumb_counter++;
      }
     echo '</ul>';
    } ?>
<?php
if (fMessaging::check('error', fURL::get())) {
  echo '<div class="alert-message error">';
    fMessaging::show('error', fURL::get());
  echo '</div>';
}

if (fMessaging::check('success', fURL::get())) {
  echo '<div class="alert-message success">';
    fMessaging::show('success', fURL::get());
  echo '</div>';
}
