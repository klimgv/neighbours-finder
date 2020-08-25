<?php       
    require_once 'private/config.inc';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighbours</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">
        
            <?php               

                $x0 = 0;
                $y0 = 0;
                $m = 50;
                $k = 5;


                if (isset($_GET['x']) && isset($_GET['y']) && isset($_GET['k']) && isset($_GET['m'])){
                    $x0 = $_GET['x'];
                    $y0 = $_GET['y'];
                    $m = $_GET['m'];
                    $k = $_GET['k'];
                    if ($m <= 0) $m=50;
                    if ($k <= 0) $k=5;
                }
                echo "<form class='row m-3'>
                        <div class='col-sm-2'>
                            <label>x</label>
                            <input type='number' class='form-control' placeholder='x' name='x' value='$x0'>
                        </div>
                        <div class='col-sm-2'>
                            <label>y</label>
                            <input type='number' class='form-control' placeholder='y' name='y' value='$y0'>
                        </div>
                        <div class='col-sm-2'>
                            <label>m</label>
                            <input type='number' class='form-control' placeholder='m' name='m' value='$m' min='1'>
                        </div>
                        <div class='col-sm-2'>
                            <label>k</label>
                            <input type='number' class='form-control' placeholder='k' name='k' value='$k' min='1'>
                        </div>
                        <div class='col-sm-4'>
                            <button type='submit' class='btn btn-primary position-absolute' style='bottom: 0'>Найти</button>
                        </div>
                    </form>";

                $json = file_get_contents("http://localhost/neighbours/methods.php?action=find&x=$x0&y=$y0&m=$m&k=$k");
                $obj = json_decode($json);
                if (isset($obj->dots)) $dots = $obj->dots;
                echo "<div class='row'>
                        <div class='col-sm-8'>
                            <table class='m-auto map'>";

                for ($y=$y0-50; $y <= $y0 + 50; $y++) { 
                    echo "<tr>";
                    for ($x=$x0-50; $x <= $x0 + 50; $x++) {                         
                        $sql = "SELECT * FROM `dots` WHERE `x` = $x AND `y` = $y";
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {     
                            if (isset($obj->dots)){            
                                $found_x = array_search($x, array_column($dots, 'x'));
                                $found_y = array_search($y, array_column($dots, 'y'));
                                if (is_numeric($found_x) && is_numeric($found_y) && $found_x === $found_y){
                                    $dot_type = 'bg-primary';
                                }
                                else{
                                    $dot_type = 'bg-warning';
                                }
                            } 
                            else{
                                $dot_type = 'bg-warning';
                            }
                            $dot_exist = 1;
                        }
                        else{
                            $dot_type = 'bg-secondary';
                            $dot_exist = 0;
                        }
                        if ($y == $y0 && $x == $x0) $dot_type = 'bg-danger';
                        echo "<td tabindex='0' class='$dot_type' data-container='body' data-toggle='popover' data-trigger='focus' data-placement='top' data-content='($x, $y)' data-x='$x' data-y='$y' data-exist='$dot_exist'></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>
                    <div class='row m-3 justify-content-md-center'>
                    <table>
                        <tr>
                            <td class='bg-secondary' style='width: 12px; height: 12px;'></td><td style='font-size: 8px; height: 12px; padding-right: 15px;'>Dot doesn't exist</td>
                            <td class='bg-warning' style='width: 12px; height: 12px;'></td><td style='font-size: 8px; height: 12px; padding-right: 15px;'>Dot exist</td>
                            <td class='bg-primary' style='width: 12px; height: 12px;'></td><td style='font-size: 8px;height: 12px; padding-right: 15px;'>Neighbour dot by parameters</td>
                            <td class='bg-danger' style='width: 12px; height: 12px;'></td><td style='font-size: 8px;height: 12px; padding-right: 15px;'>Home dot</td>
                        </tr>
                    </table>
                    </div>
                </div>";

            ?>
                <div class="col-sm-4">
                    <div class="button-block mb-3" style="min-height: 125px;">

                    </div>
                    <div class="neighbours-list">
                            <?php
                            if (isset($obj->dots)){   
                                foreach ($dots as $dot) {
                                    echo "<table class='mb-2'><tr><td class='bg-primary' style='width: 20px; height: 20px;'></td><td style='font-size: 12px;height: 20px; padding-left: 5px;'>(".$dot->x.", ".$dot->y.")</td></tr></table>";
                                }
                            }
                            ?>
                    <div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });

    $(document).mouseup(function (e){
		if (!$(".map td").is(e.target) && !$(".button-block .btn").is(e.target) && !$(".button-block input").is(e.target)) {
            $(".button-block").html('');
		}
	});

    $(".map td").click(function(){
        let x = $(this).data('x');
        let y = $(this).data('y');
        console.log(x, y);
        let dot_exist = $(this).data('exist');
        if (dot_exist == 1){
            $(".button-block").html(`<form action="methods.php" method="GET"><input type='hidden' name='action' value='change'><input type='hidden' name='x' value='${x}'><input type='hidden' name='y' value='${y}'><div class="row"><div class="col-sm-6"><input type='number' class='form-control' placeholder='x' name='x0' value='${x}'></div><div class="col-sm-6"><input type='number' class='form-control' placeholder='y' name='y0' value='${y}'></div></div><button type="submit" id="change-button" class="btn btn-secondary mt-3">Изменить</button></form><a id="delete-button" class="btn btn-danger mt-3" href="methods.php?action=delete&x=${x}&y=${y}">Удалить</a>`);
        }
        else{
            $(".button-block").html(`<a id="add-button" class="btn btn-info mt-3" href="methods.php?action=add&x=${x}&y=${y}">Добавить</a>`);
        }
    });
    </script>
</body>
</html>