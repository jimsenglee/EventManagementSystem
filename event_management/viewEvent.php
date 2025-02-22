<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="viewEvent.css" rel="stylesheet" type="text/css"/>
    <title>Event Details</title>

</head>
<body>
    
    <div class="container">
        <header>
            <h1>Events Details</h1>
            <div class="back-btn">
                <a href="events.php">Back</a>                        
            </div>
        </header>
        
        <?php
        require_once("connect.php");

        $id = $_GET['id'];
        if ($id) {
            $sql = "SELECT * FROM events WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
             ?>
            <table>
                <tr>
                    <th>Event:</th>
                    <td><?php echo $row["event_name"]; ?></td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td><?php echo $row["event_year"],'-',$row["event_month"],'-',$row["event_day"]; ?></td>
                </tr>
                <tr>
                    <th>Time:</th>
                    <td><?php echo date('g:i A', strtotime($row["event_start_time"])); ?></td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td><?php echo $row["event_desc"]; ?></td>
                </tr>
                <tr>
                    <th>Category:</th>
                    <td><?php echo $row["event_category"]; ?></td>
                </tr>
                <tr>
                    <th>Venue:</th>
                    <td><?php echo $row["event_venue"]; ?></td>
                </tr>
            </table>
            <?php
            }
        }
        else {
            echo '<div class="warning-back-btn">';
            echo "<h3 class='warning'>Events Does Not Exist</h3>";
            echo '<div class="back-btn-2">
                <a href="events.php">Back</a>';                    
            echo '</div></div>';
        }   
        ?>
        
    </div>
</body>
</html>
