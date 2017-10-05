<?php
$links = array();
foreach(array('twitter', 'facebook', 'instagram') as $network) {
  $option = get_option($network . '_url');
  if (!empty($option)) {
    $links[] = sprintf('<li><a href="%s" class="social-link %s" target="_blank">%s</a></li>', $option, $network, $network);
  }
}

if (count($links) > 0) {
  echo '<ul class="social-nav">';
  foreach ($links as $link) {
    echo $link;
  }
  echo '</ul>';
}
?>
