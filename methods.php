<?php

require_once 'private/config.inc';

if (isset($_GET["action"]) && isset($_GET["x"]) && isset($_GET["y"])){
    $action = $_GET["action"];
    $x = $_GET["x"];
    $y = $_GET["y"];
    if (is_string($action) && is_numeric($x) && is_numeric($y)){
        $data = array();

        $sql = "SELECT * FROM `dots` WHERE `x` = $x AND `y` = $y";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $dot_exist = TRUE;
        }
        else{
            $dot_exist = FALSE;
        }

        if ($_GET["action"] == "add"){
            if (!$dot_exist){
                $sql = "INSERT INTO `dots`( `x`, `y`) VALUES ($x,$y)";
                $db->query($sql);
                $data = array("message" => "The dot added successfully!");
            }
            else{
                $data = array("error" => "Dot already exist!");
            }
        }
        if ($_GET["action"] == "delete"){
            if ($dot_exist){
                $sql = "DELETE FROM `dots` WHERE `x`=$x AND `y`=$y";
                $db->query($sql);
                $data = array("message" => "The dot deleted successfully!");
            }
            else{
                $data = array("error" => "Dot doesn't exist!");
            }
            
        }
        if ($_GET["action"] == "change" && isset($_GET["x0"]) && isset($_GET["y0"])){
            if ($dot_exist){
                $x0 = $_GET["x0"];
                $y0 = $_GET["y0"];
                $sql = "SELECT * FROM `dots` WHERE `x` = $x0 AND `y` = $y0";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $dot0_exist = TRUE;
                }
                else{
                    $dot0_exist = FALSE;
                }

                if (!$dot0_exist){
                    $sql = "UPDATE `dots` SET `x` = $x0,`y` = $y0 WHERE `x` = $x AND `y` = $y";
                    $db->query($sql);
                    $data = array("message" => "The dot updated successfully!");
                }
                else{
                    $data = array("error" => "Dot already exist on remove position!");
                }
            }
            else{
                $data = array("error" => "Dot doesn't exist!");
            }            
        }
        if ($_GET["action"] == "find" && isset($_GET["k"]) && isset($_GET["m"])){            
            $k = $_GET["k"];
            $rad = $_GET["m"];
            $sql = "SELECT *, SQRT(POW(x - $x, 2) + POW(y - $y, 2)) AS distance FROM `dots` WHERE SQRT(POW(x - $x, 2) + POW(y - $y, 2)) < $rad AND NOT x = $x AND NOT y = $y ORDER BY distance LIMIT $k";
            $result = $db->query($sql);
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data["dots"][] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    else{
        http_response_code(406);
    }
}
else{
    http_response_code(406);
}