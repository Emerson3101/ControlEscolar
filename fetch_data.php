<?php
// Database connection parameters
$connection = pg_connect("host=localhost port=5432 dbname=ControlEscolar user=postgres password=Abysswalker");

// Check connection
if (!$connection) {
    die("Connection failed: " . pg_last_error());
}

// Query to select data from the table
$query = 'SELECT no_control as "No. de Control", nombre as "Nombre", apellidos as "Apellidos", prom_acum as "Promedio Acumulado", semestre as "Semestre" FROM public.alumnos';
$result = pg_query($connection, $query);

// Check if the query was successful
if (!$result) {
    echo "<div class='no-data'>An error occurred while querying the database.</div>";
    exit;
}

// Check if there are rows to display
if (pg_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";

    // Fetch and display column headers
    $columns = pg_num_fields($result);
    for ($i = 0; $i < $columns; $i++) {
        $fieldName = pg_field_name($result, $i);
        echo "<th>" . htmlspecialchars($fieldName) . "</th>";
    }
    echo "</tr>";

    // Fetch and display each row of data
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $column) {
            echo "<td>" . htmlspecialchars($column) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<div class='no-data'>No data available in the table.</div>";
}

// Free the result and close the connection
pg_free_result($result);
pg_close($connection);
?>
