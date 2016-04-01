<?php
//header("Location: /test");
headerPage('Сторінка новин');?>

<!--
    Note: Set the body element's class to "left-sidebar" to position the sidebar on the left.
    Set it to "right-sidebar" to, you guessed it, position it on the right.
-->

<body class="left-sidebar">
<!-- Wrapper -->
<div id='wrapper'>

    <!-- Content -->
    <div id='content'>

          <div class='inner'>

            <!-- Post -->
            <?showMessage();?>
              <? echo "Hello from news"; ?>

</div></div>
<?php leftMenu(); ?>

</body>
</html>