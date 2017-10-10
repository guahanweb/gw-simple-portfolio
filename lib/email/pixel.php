<?php
// let's trap any possible output from our handler
ob_start();

ob_end_clean();

// now, output our 1x1 pixel tracker
header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
?>
