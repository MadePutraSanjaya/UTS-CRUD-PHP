<?php
include "../con/connection.php";

$destinations = mysqli_query($conn, "SELECT id, name FROM destination");
$categories = mysqli_query($conn, "SELECT id, name FROM category");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UTS Pemrogramman Web</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/screen/category.php" class="nav-link ">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/screen/destination.php" class="nav-link">
                                <i class="nav-icon fas fa-map-pin"></i>
                                <p>
                                    Destination
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/screen/travels.php" class="nav-link active">
                                <i class="nav-icon fas fa-plane-departure"></i>
                                <p>
                                    Travel
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Travel</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Travel</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kelola Data Travel</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="button-table">
                                    <a href="#" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal">Tambah Travel</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Destination</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT 
                                        travel.id, 
                                        travel.name, 
                                        travel.description, 
                                        travel.price, 
                                        travel.image_url, 
                                        destination.name AS destination_name, 
                                        category.name AS category_name 
                                    FROM travel
                                    INNER JOIN destination ON travel.destination_id = destination.id
                                    INNER JOIN category ON travel.category_id = category.id");

                                        while ($data = mysqli_fetch_assoc($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $data['name']; ?></td>
                                                <td><?php echo $data['description']; ?></td>
                                                <td><?php echo $data['destination_name']; ?></td>
                                                <td><?php echo $data['category_name']; ?></td>
                                                <td><?php echo $data['price']; ?></td>
                                                <td><img src="<?php echo '../images/' . $data['image_url']; ?>" width="35" height="40"></td>

                                                <td>
                                                    <a href="#" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id']; ?>">Edit</a>
                                                    <a href="#" type="button" class="btn btn-md btn-danger" data-toggle="modal" data-target="#myModal<?php echo $data['id']; ?>Delete">Delete</a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit User-->
                                            <div class="modal fade" id="myModal<?php echo $data['id']; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Data Travel</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="../actions/edit.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="action" value="updateTravel">
                                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>" required>

                                                                    <label>Description</label>
                                                                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($data['description']); ?></textarea>

                                                                    <label>Destination</label>
                                                                    <select name="destination_id" class="form-control" required>
                                                                        <option value="select_destination" disabled>Select Destination</option>
                                                                        <?php
                                                                        $destinations = mysqli_query($conn, "SELECT id, name FROM destination");
                                                                        while ($row = mysqli_fetch_assoc($destinations)) : ?>
                                                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $data['destination_name']) echo 'selected'; ?>><?php echo htmlspecialchars($row['name']); ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>

                                                                    <label>Category</label>
                                                                    <select name="category_id" class="form-control" required>
                                                                        <option value="select_category" disabled>Select Category</option>
                                                                        <?php
                                                                        $categories = mysqli_query($conn, "SELECT id, name FROM category");
                                                                        while ($row = mysqli_fetch_assoc($categories)) : ?>
                                                                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $data['category_name']) echo 'selected'; ?>><?php echo htmlspecialchars($row['name']); ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>

                                                                    <label>Price</label>
                                                                    <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($data['price']); ?>" required>

                                                                    <label>Current Image</label>
                                                                    <?php if (!empty($data['image_url'])) : ?>
                                                                        <div>
                                                                            <img src="../images/<?php echo htmlspecialchars($data['image_url']); ?>" alt="Current Image" style="max-width: 200px;">
                                                                            <p><?php echo htmlspecialchars($data['image_url']); ?></p>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <p>No image uploaded.</p>
                                                                    <?php endif; ?>
                                                                    <input type="file" name="image_url">
                                                                    <br>
                                                                    <span style="color:red; font-size:12px;">Only jpg / jpeg/ png /gif format allowed. Maximum size is 1MB.</span>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" name="submit" class="btn btn-success">Update Travel</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal Delete User-->
                                            <div class="modal fade" id="myModal<?php echo $data['id']; ?>Delete" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Anda Yakin Ingin Menghapus Data Travel?</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="../actions/delete.php" method="post">
                                                                <?php
                                                                $id = $data['id'];
                                                                $query_edit = mysqli_query($conn, "SELECT travel.*, destination.name AS destination_name, category.name AS category_name FROM travel JOIN destination ON travel.destination_id = destination.id JOIN category ON travel.category_id = category.id WHERE travel.id = '$id'");
                                                                while ($row = mysqli_fetch_array($query_edit)) {
                                                                ?>
                                                                    <input type="hidden" name="action" value="deleteTravel">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" disabled>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Description</label>
                                                                        <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($row['description']); ?>" disabled>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Destination</label>
                                                                        <input type="text" name="destination_name" class="form-control" value="<?php echo htmlspecialchars($row['destination_name']); ?>" disabled>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Category</label>
                                                                        <input type="text" name="category_name" class="form-control" value="<?php echo htmlspecialchars($row['category_name']); ?>" disabled>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Price</label>
                                                                        <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($row['price']); ?>" disabled>
                                                                    </div>

                                                                    <label>Image</label>
                                                                    <?php if (!empty($row['image_url'])) : ?>
                                                                        <div>
                                                                            <img src="../images/<?php echo htmlspecialchars($row['image_url']); ?>" alt="Current Image" style="max-width: 200px;">
                                                                            <p><?php echo htmlspecialchars($row['image_url']); ?></p>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <p>No image uploaded.</p>
                                                                    <?php endif; ?>

                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="submit" class="btn btn-danger">Hapus Data Travel</button>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </tbody>


                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Travels</h4>
                    </div>
                    <div class="modal-body">
                        <form action="../actions/add.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="createTravel">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>

                                <label>Description</label>
                                <textarea name="description" class="form-control" required></textarea>

                                <label>Destination</label>
                                <select name="destination_id" class="form-control" required>
                                    <option value="select_destination" disabled selected>Select Destination</option>
                                    <?php
                                    $destination_query = mysqli_query($conn, "SELECT id, name FROM destination");
                                    while ($destination = mysqli_fetch_assoc($destination_query)) {
                                        $selected = $destination['id'] == $row['destination_id'] ? 'selected' : '';
                                        echo "<option value='{$destination['id']}' {$selected}>{$destination['name']}</option>";
                                    }
                                    ?>
                                </select>

                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="select_category" disabled selected>Select Category</option>
                                    <?php
                                    $category_query = mysqli_query($conn, "SELECT id, name FROM category");
                                    while ($category = mysqli_fetch_assoc($category_query)) {
                                        $selected = $category['id'] == $row['category_id'] ? 'selected' : '';
                                        echo "<option value='{$category['id']}' {$selected}>{$category['name']}</option>";
                                    }
                                    ?>
                                </select>

                                <label>Price</label>
                                <input type="number" name="price" class="form-control" required>

                                <label>Image</label>
                                <input type="file" name="image_url" class="form-control" required>
                                <span style="color:red; font-size:12px;">Only jpg / jpeg/ png /gif format allowed. Maximum size is 1MB.</span>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Add Travel</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024-2025 UTS Pemrogramman</strong>

            
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/dist/js/pages/dashboard.js"></script>
</body>

</html>