<?php
include "../con/connection.php";

function createDestination($conn)
{
    if (isset($_POST['submit'])) {
        $name_destination = $_POST['name_destination'];
        $description_destination = $_POST['description_destination'];

        $rand = rand();
        $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
        $filename = $_FILES['image_destination']['name'];
        $ukuran = $_FILES['image_destination']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $ekstensi)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed.'); window.location.href='../screen/destination.php';</script>";
        } else {
            if ($ukuran < 1044070) {
                $xx = $rand . '_' . $filename;
                $target_directory = '../images/';
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0755, true);
                }

                $tmp_name = $_FILES['image_destination']['tmp_name'];
                $destination_path = $target_directory . $xx;
                if (move_uploaded_file($tmp_name, $destination_path)) {
                    $stmt = $conn->prepare("INSERT INTO destination (name, description, image_url) VALUES (?, ?, ?)");
                    $stmt->bind_param('sss', $name_destination, $description_destination, $xx);
                    if ($stmt->execute()) {
                        echo "<script>alert('Data successfully inserted'); window.location.href='../screen/destination.php';</script>";
                    } else {
                        echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../screen/destination.php';</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Failed to upload image. Please try again.'); window.location.href='../screen/destination.php';</script>";
                    error_log("Failed to move uploaded file. Temporary path: $tmp_name, Destination path: $destination_path");
                }
            } else {
                echo "<script>alert('File size is too large. Maximum allowed size is 1MB.'); window.location.href='../screen/destination.php';</script>";
            }
        }
    }
}

function createCategory($conn)
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name_category'];

        $queryUser = "INSERT INTO category (name) VALUES ('$name')";
        $result = mysqli_query($conn, $queryUser);

        if ($result) {
            echo "<script>alert('Data succesfully create.'); window.location.href='../screen/category.php';</script>";
        } else {
            echo "<script>alert('Failed to create category. Please try again.'); window.location.href='../screen/category.php';</script>";
        }
    }
}

function createTravel($conn)
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $destination_id = $_POST['destination_id'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        
        $rand = rand();
        $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
        $filename = $_FILES['image_url']['name'];
        $ukuran = $_FILES['image_url']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $ekstensi)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed.'); window.location.href='../screen/add_travel.php';</script>";
        } else {
            if ($ukuran < 1044070) { 
                $xx = $rand . '_' . $filename;
                $target_directory = '../images/';
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0755, true);
                }

                $tmp_name = $_FILES['image_url']['tmp_name'];
                $destination_path = $target_directory . $xx;
                if (move_uploaded_file($tmp_name, $destination_path)) {
                    $stmt = $conn->prepare("INSERT INTO travel (name, description, destination_id, category_id, price, image_url) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssiiis', $name, $description, $destination_id, $category_id, $price, $xx);
                    if ($stmt->execute()) {
                        echo "<script>alert('Data successfully inserted'); window.location.href='../screen/travels.php';</script>";
                    } else {
                        echo "<script>alert('Something went wrong. Please try again.'); window.location.href='../screen/travels.php';</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Failed to upload image. Please try again.'); window.location.href='../screen/travels.php';</script>";
                }
            } else {
                echo "<script>alert('File size is too large. Maximum allowed size is 1MB.'); window.location.href='../screen/travels.php';</script>";
            }
        }
    }
}


if ($_POST['action'] == 'createDestination') {
    createDestination($conn);
} elseif ($_POST['action'] == 'createCategory') {
    createCategory($conn);
} elseif ($_POST['action'] == 'createTravel') {
    createTravel($conn);
}
