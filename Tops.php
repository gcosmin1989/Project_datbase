<?php
require_once 'Dbh.php';

class Tops
{
    public function ReturnArray()
    {
        $new = new Dbh(1, 'month');
        $results = $new->selectTops();
        $records = array();
        $period = $new->period;
        while ($row = mysqli_fetch_array($results)) {
            $records[] = $row;
        }
        echo "<table style='border: 1px solid black'>
  <tr>
    <th>Prod</th>
    <th>$period</th>
    <th>value</th>
    <th>Stadiu</th>
  </tr>";
        foreach ($records as $row) {
            echo "<tr>
    <td>$row[prod]</td>
    <td>$row[$period]</td>
    <td>$row[value]</td>
    <td>id</td>
  </tr>
    ";
        }
        echo "</tr>";
        echo "</table>";
    }
}

$new = new Tops();
$new->ReturnArray();