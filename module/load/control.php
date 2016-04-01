<?php
userAccess(2);

if ($param['id'] && $param['command']){
    if ($param['command'] == 'active'){
        mysqli_query($cnn, "UPDATE loads SET active = 1 WHERE id = $param[id]");
        sendMessage(26,'/load');
    }
    if ($param['command'] == 'delete'){
        $sql = "SELECT dirimg FROM loads WHERE id = $param[id]";
        $res = mysqli_query($cnn, $sql);
        $row = mysqli_fetch_assoc($res);
        mysqli_query($cnn, "DELETE FROM loads WHERE id = $param[id]");
        unlink("catalog/img/".$row['dirimg'].'/'.$param['id'].'.jpg');
        sendMessage(27,'/load');
    }
}