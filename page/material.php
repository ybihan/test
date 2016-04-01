<?php headerPage('Сторінка матеріалів');?>
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
            <article class='box post post-excerpt'>
                <div class='info'>

                    <span class='date'><span class='month'>Jul<span>y</span></span> <span class='day'>14</span><span class='year'>, 2014</span></span>

                </div>
        </div>
    </div>

<?php leftMenu(); ?>

</body>
</html>