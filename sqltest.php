<?php // sqltest.php

  require_once 'login.php';

  $conn = new mysqli($hn, $un, $pw, $db);

  if ($conn->connect_error) die($conn->connect_error);

  if (isset($_POST['delete']) && isset($_POST['ISBN']))
  {
    $isbn   = get_post($conn, 'ISBN');
    $query  = "DELETE FROM Classics WHERE ISBN='$ISBN'";
    $result = $conn->query($query);
    if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
  }

  else if (isset($_POST['AUTHOR'])   &&
           isset($_POST['TITLE'])    &&
           isset($_POST['CATEGORY']) &&
           isset($_POST['YEAR'])     &&
           isset($_POST['ISBN']))
  {
    $author   = get_post($conn, 'AUTHOR');
    $title    = get_post($conn, 'TITLE');
    $category = get_post($conn, 'CATEGORY');
    $year     = get_post($conn, 'YEAR');
    $isbn     = get_post($conn, 'ISBN');
    $query    = "INSERT INTO Classics VALUES" .
      "('$AUTHOR', '$TITLE', '$CATEGORY', '$YEAR', '$ISBN')";
    $result   = $conn->query($query);

    if (!$result)  echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
  }

  echo <<<_END

<script src="../js/checkboxes.js"></script>
<link rel="stylesheet" type="text/css" href="../css/table.css">

  <form action="sqltest.php" method="post"><pre>
    Author <input type="text" name="AUTHOR">
     Title <input type="text" name="TITLE">
  Category <input type="text" name="CATEGORY">
      Year <input type="text" name="YEAR">
      ISBN <input type="text" name="ISBN">
           <input type="submit" value="ADD RECORD">

  <form action="sqltest.php" method="post">
           <input type="hidden" name="delete" value="yes">
           <input type="hidden" name="ISBN" value="$ISBN">
           <input type="submit" value="DELETE RECORD">
  </form>
<table>
<td id = "Classics" colspan="3">
<thead>
  <tr>
    <th>Author</th>
    <th>Title</th>
    <th>Category</th>
    <th>Year</th>
    <th>ISBN</th>
    <th><input type="checkbox" name="checkbox" onclick="check_all();"></th>
  </tr>
</thead>
_END;

  $query  = "SELECT * FROM Classics";
  $result = $conn->query($query);
  if (!$result) die($conn->error);
  $rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j) {
    echo '<tr>';
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
       echo '<td>' . $row[AUTHOR] . '</td>';
       echo '<td>' . $row[TITLE]    . '</td>';
       echo '<td>' . $row[CATEGORY] . '</td>';
       echo '<td>' . $row[YEAR]     . '</td>';
       echo '<td>' . $row[ISBN]     . '</td>';
       echo '<td> <input type="checkbox" name="ids[]" value=" '     . $row[ISBN]     . '"></td>';
       echo '</tr>';}

  $result->close();
  $conn->close();

  function get_post($conn, $var) {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
