<?php
include_once 'database.php';

function connectDB() {
    global $servername, $username, $password, $database;
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function fetchAll($table) {
    $conn = connectDB();
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $rows = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    $conn->close();
    return $rows;
}

function fetchById($table, $id) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $row;
}

function insert($table, $data) {
    $conn = connectDB();
    $keys = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql = "INSERT INTO $table ($keys) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $conn->close();
        return $last_id;
    } else {
        $conn->close();
        return false;
    }
}

function update($table, $id, $data) {
    $conn = connectDB();
    $updateValues = [];
    foreach ($data as $key => $value) {
        $updateValues[] = "$key = '$value'";
    }
    $updateString = implode(", ", $updateValues);
    $sql = "UPDATE $table SET $updateString WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

function delete($table, $id) {
    $conn = connectDB();
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}
?>
