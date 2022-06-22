<?php
  require_once __DIR__."/department.php";
  require_once __DIR__."/database.php";

  //var_dump($conn);
  $id = $_GET["id"];

  // To avoid SQL commands to be written after the query
  $statement = $conn->prepare("SELECT * FROM `departments` WHERE `id` = ?;");
  // Declare that the 'id' value in $statement has to be an integer by using bind_param
  $statement->bind_param("i",$id);

  // Now we can proceed with executing the query
  $statement->execute();
  $result = $statement->get_result();

  // Using an array because it's easier to work with it
  $departments = [];

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $thisRow = new Department($row["id"], $row["name"]);
        $thisRow->genInfo($row["address"],$row["phone"],$row["email"],$row["website"],$row["head_of_department"]);
        $departments[] = $thisRow;
    }
  }
  elseif ($result) {
      // Empty result
  }
  else {
      // No result found, there's an error
      echo "Error";
      die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Department</title>
</head>
<body>

  <div>
    <?php foreach ($departments as $department) { ?>
      <h1><?php echo $department->name; ?></h1>
      <div>
        <h3><?php echo $department->head_of_department; ?></h3>
        <ul>
          <?php foreach ($department->printInfo() as $key => $value) { ?>
            <li><?php echo "$key: $value" ?></li>          
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
    <a href="index.php">Click to go back</a>
  </div>
  
</body>
</html>