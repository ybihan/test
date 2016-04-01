<?php headerPage('Головна сторінка');?>
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
            <p>Останні новини</p>
            <?
            $sql = "SELECT id, dirimg FROM loads ORDER BY id DESC LIMIT 4";
            $res = mysqli_query($cnn, $sql);

            while($row = mysqli_fetch_assoc($res)){
                 echo"   <a href='load/material/id/$row[id]'><img src='/catalog/img/$row[dirimg]/$row[id].jpg' width='200px'></a>";
            }



            ?>
            <article class='box post post-excerpt'>

        </div>
    </div>

<?php leftMenu(); ?>

</body>
</html>