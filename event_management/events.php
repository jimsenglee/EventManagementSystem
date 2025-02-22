<?php
session_start();
require_once ('connect.php');
if(!isset($_SESSION['admin_name'])){
   header('location:../login/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="eventlist.css" rel="stylesheet" type="text/css"/>
    <title>Event Lists</title>

</head>
<body>
        <?php
        if(isset($_SESSION["admin_name"])) {
            include '../header&footer/adminHeader.php';
        } else {
            include '../header&footer/userHeader.php';
        }
        
        
        ?> 
    
    
        
    
    

    <div class="event-wrapper">
        <header>
            <h1>Event List</h1>

            <div>
            

                <a href="addEvent.php?page=addEvents" class="btn2 btn-add">Add New Event</a>
            </div>
        </header>
        
        <?php
            //check if user clicked the delete button
            if(isset($_POST["multiple-delete"])){
                //retrieve from checkbox
                //the list of id to delete
                $checked = isset($_POST["checked"]) ? $_POST["checked"] : "";
                if(!empty($checked)){
                    //user did checked the checkbox
                    
                    foreach($checked as $value){
                    $escaped[] = $conn -> real_escape_string($value);
                    
                }
                
                //DELETE FROM user 
                $sql1 = "DELETE FROM events WHERE id IN ('".implode("','",$escaped)."')";
                
                if($conn->query($sql1)){
                    //deleted
                    printf("<div class='alert alert-success'>
                            <b>%d</b> event's record has been deleted!
                            </div>",$conn->affected_rows);
                }
                }
            }
        ?>        
        
        
        
        
        
        
        
        
        
        
        
        <?php
        if (isset($_SESSION["addevent"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["addevent"];
            ?>
        </div>
        <?php
        unset($_SESSION["addevent"]);
        }
        ?>
        
         <?php
        if (isset($_SESSION["edit"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["edit"];
            ?>
        </div>
        <?php
        unset($_SESSION["edit"]);
        }
        ?>
        <?php
        if (isset($_SESSION["delete"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["delete"];
            ?>
        </div>
        <?php
        unset($_SESSION["delete"]);
        }
        ?>
        
                
            <?php
                 $header = array(
                       'id' => 'No.',
                       'event_name' => 'Events',
                        'event_date' => 'Date',
                        'event_start_time' => 'Time',   
                        'event_venue' => 'Venue',   
                        'event_desc' => 'Description'
                    );

                    //check $sort $order variable -> prevent sql error
                    //which column to sort?
                    global $sort,$order;
                    if(isset($_GET['sort'])&&isset($_GET['order'])){
                    $sort = (array_key_exists($_GET['sort'], $header)?$_GET['sort']:'id');

                    //how to arrange order sequence ASC/DESC
                    $order = ($_GET['order']=='DESC')?'DESC':'ASC';
                    }
                    else{
                        $sort="id";
                        $order="ASC";
                    }

                    if(isset($_GET['venue'])){            
                    $venue = (array_key_exists($_GET['venue'], getAllVenue())?$_GET['venue']:"%");

                    }else{
                        $venue="%";

                    }
            ?>
        
        
        
        
  <div class="filter-container">Filter:
  <a class="filter-link" href="?sort=<?php echo $sort ?>&order=<?php echo $order ?>">ALL VENUES</a>
  <?php
    $allVenue = getAllVenue();//array
    foreach($allVenue as $key => $value){
      printf("<a class='filter-link' href='?sort=%s&order=%s&venue=%s'>%s</a>",$sort,$order,$key,$value);
    }
  ?>
</div>

        
        <form method="post">
        <table>
            <tr>
                <th>
                    <button type="submit" name="multiple-delete" class="delete" onclick="return confirm('This will delete all checked records!\n Are you sure?')">🗑</button>
                </th>                
            <?php
                    foreach($header as $key => $value){
                        if($key==$sort){
                            //YES, user click to perform sorting
                        printf('<th>
                            <a href="?sort=%s&order=%s&venue=%s">%s</a>%s    
                                </th>',$key
                                ,$order=='ASC'?'DESC':'ASC'
                                    ,$venue //to retain filter effect even after sorting the record
                                ,$value
                                ,$order=='ASC'?'⬆':'⬇');
                    }else{
                            //NO, user never click to perform anything
                        printf('<th><a href="?sort=%s&order=ASC&venue=%s">%s
                                </a></th>',$key
                                ,$venue  //to retain filter effect even after sorting the record
                                ,$value);
                    }
                    }
                ?>
                <th style="color:black">Action</th>
            </tr>
            <?php
            
            
            //Step 3: sql statement
            $sql = "SELECT id, event_name, CONCAT(event_year,'-',event_month,'-',event_day) AS event_date, event_start_time, event_venue, event_desc FROM events WHERE event_venue LIKE '$venue'ORDER BY $sort $order";

            //Step 4: run sql
            //$result - consist of 5 records
            if($result = $conn->query($sql)){
                
            while($record = $result->fetch_object()){
                $event_desc = $record->event_desc;
                $limit = 50;

                if(strlen($event_desc) > $limit) {
                    $event_desc = substr($event_desc, 0, $limit) . "... <a href='viewEvent.php?id={$record->id}'>
                                                                    <span class='more'>View More</span></a>";
                }
                    printf("
                        <tr>
                        <td><input type='checkbox' name='checked[]' value='%s' /></td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>
                            <a href='viewEvent.php?id=%s' class='btn2 btn-info'>View</a>
                            <a href='editEvent.php?id=%s' class='btn2 btn-warning'>Edit</a>
                            <a href='deleteEvent.php?id=%s' class='btn2 btn-danger'>Delete</a>

                        </td>
                        </tr>
                           ",$record->id
                            , $record->id
                            , $record->event_name
                            , $record->event_date
                            , date('g:i A', strtotime($record->event_start_time))
                            , getAllVenue()[$record->event_venue]
                            , $event_desc
                            ,$record->id
                            ,$record->id 
                            ,$record->id 
                            );
                }
                
                printf("<tr><td colspan='8'>%d event(s) Existed.
                         </tr></td>",
                        $result->num_rows);
                
                //Step 5: close connection
                $result->free();
                $conn->close();
            }
            
            ?>
            

        
        <tbody>
        
        </tbody>
        </table>
        </form>
    </div>
    
            <?php include '../header&footer/footer.php' ?>

</body>
</html>