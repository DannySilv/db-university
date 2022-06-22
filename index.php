<?php
  require_once __DIR__ . "/database.php";
  require_once __DIR__ . "/department.php";

  $sql = "SELECT `id`, `name` FROM `departments`;";
  $result = $conn->query($sql);

  $departments = [];

  // If/Else cycle to scan errors
  if ($result && $result->num_rows > 0) {
      // se la query va bene, usiamo il ciclo while perchè non sappiamo il numero di iterazioni
    while ($row = $result->fetch_assoc()) {
      $thisDepartment = new Department($row["id"], $row["name"]);
      $departments[] = $thisDepartment;
    }
  } elseif ($result) {
    // Empty Result
  } else {
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
  <title>DBUniversity</title>
</head>
<body>
  <h1>University Departments</h1>
  <div>
    <?php foreach ($departments as $department) { ?>
      <div>
        <h2><?php echo $department->name; ?></h2>
        <a href="department-details.php?id=<?php echo $department->id; ?>">Click for more details</a>
      </div>
    <?php }
    ?>
  </div>
</body>
</html>