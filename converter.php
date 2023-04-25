<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test_database';

$utf8_conn = new mysqli($servername, $username, $password, $dbname);

$latin1_conn =  new mysqli($servername, $username, $password, $dbname);

$utf8_conn->set_charset("utf8");

$tables = [];

$get_all_tables_query = "SELECT * FROM information_schema.tables WHERE table_schema = '$dbname'";

$result = $utf8_conn->query($get_all_tables_query);

while ($row = $result->fetch_assoc()) {
    $tables[] = $row["TABLE_NAME"];
}

$no_primary_table = [];
foreach ($tables as $table) {
    $get_all_data_query = "SELECT * FROM $table";
    $result = $latin1_conn->query($get_all_data_query);
    while ($row = $result->fetch_assoc()) {
        if (!isset($row['id'])) {
            $no_primary_table[] = $table;
        } else {
            $sql = 'UPDATE ' . $table . ' SET ';

            $update_sql = '';

            foreach ($row as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $update_sql .= $key . '="' . $value . '",';
            }

            $update_sql = rtrim($update_sql, ',');
            $update_sql .= ' WHERE id = ' . $row['id'];
            $sql .= $update_sql;
            mysqli_query($utf8_conn, $sql);
        }
    }
}

if (count($no_primary_table) == 0) {
    echo "\e[92mNo tables without id key.";
    echo PHP_EOL;
} else {
    echo "\e[91mTables without id key:";
    echo PHP_EOL;
    $no_primary_table = array_unique($no_primary_table);
    foreach ($no_primary_table as $table) {
        echo "\e[93m" . '    ' . $table;
        echo PHP_EOL;
    }
}

echo PHP_EOL;
echo "\e[92mCongratulations! All tables with id column have been converted to utf8.";
echo "\e[39m";
