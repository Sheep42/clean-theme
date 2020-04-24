<?php
  if( !defined('ABSPATH') || !function_exists( 'cleantheme_authenticate_test_user' ) ) die('Not allowed');
  if( !cleantheme_authenticate_test_user() ) wp_die( 'Not allowed' );
?>

<!DOCTYPE html>
<html>
  
  <head>
    <title>Mocha Tests</title>
    <link rel="stylesheet" href="node_modules/mocha/mocha.css">
  </head>

  <body>

    <div id="mocha"></div>
    <script src="<?php echo get_theme_file_uri('/node_modules/mocha/mocha.js'); ?>"></script>
    <script src="<?php echo get_theme_file_uri('/node_modules/chai/chai.js'); ?>"></script>
    
    <script>
    	mocha.setup('tdd');

    	var assert = chai.assert;
    </script>

    <!-- Sources -->
    <script src="<?php echo site_url('/wp-includes/js/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo get_theme_file_uri('/assets/js/src/admin/admin.js'); ?>"></script>
    <script src="<?php echo get_theme_file_uri('/assets/js/src/theme/main.js'); ?>"></script>

    <!-- Tests -->
    <script src="<?php echo get_theme_file_uri('/assets/js/tests/test-theme.js'); ?>"></script>
    <script src="<?php echo get_theme_file_uri('/assets/js/tests/test-admin.js'); ?>"></script>

    <script>
      mocha.run();
    </script>

  </body>
</html>