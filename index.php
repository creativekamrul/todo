<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <title>Nexo Tasks - The Best Task Manager</title>
</head>
<body>
<!--Styling-->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,700;1,700&display=swap');
    #logo{
        font-family: Ubuntu;
        font-weight: bold;
    }
    body{
        font-family: Roboto;
    }
    h1, label {
        font-family: Ubuntu;
    }
    .table.dataTable tbody td{
        padding: 15px 10px;
    }
    .main-form {
        box-shadow: 2px 2px 11px #0a58caa8;
        padding: 50px;
        border-radius: 10px;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit This Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mt-1" action="/todo/index.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <label for="todo-title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="todo-title-edit" name="todo-title-edit" >
                    </div>
                    <div class="mb-3">
                        <label for="todo-description" class="form-label">Task Title</label>
                        <textarea class="form-control" rows="5" id="todo-description-edit" name="todo-description-edit" ></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--Nav bar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary text-bold">
    <div class="container-fluid">
        <a class="navbar-brand p-3" href="#" id="logo">Nexo Tasks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-bold">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" aria-current="page" href="/todo">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="https://www.kamrulinfo.com" target="_blank">About The Dev</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="https://kamrulinfo.com/#arrival-contact" target="_blank">Contact</a>

                </li>
            </ul>
        </div>

    </div>
</nav>
<div class="container mt-5 main-form">
<!--    PHP Starts Here     -->
    <?php
    //All Variables
    $insert_status = false;
    $update_status = false;
    $delete_status = false;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "todolist";

//Database Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }
// Creating, Updating, Deleting Tasks
    if (isset($_GET['delete'])){
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `todos` WHERE `snum` = '$sno'";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $delete_status = true;
        }
        echo "
        <script>
         setTimeout(function () {
         window.location.href = '/todo'; //will redirect to your blog page (an ex: blog.html)
        }, 5000); //will call the function after 2 secs.
        </script>
        ";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['snoEdit'])){
            $sno = $_POST["snoEdit"];
            $title = $_POST["todo-title-edit"];
            $description = $_POST["todo-description-edit"];

            $sql = "UPDATE `todos` SET `todotitle` = '$title' , `tododesc` = '$description' WHERE `todos`.`snum` = '$sno'";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $update_status = true;
            }
            echo "
             <script>
              setTimeout(function () {
              window.location.href = '/todo'; //will redirect to your blog page (an ex: blog.html)
              }, 5000); //will call the function after 2 secs.
              </script>
              ";
        }else{

            $title = $_POST['todo-title'];
            $description = $_POST['todo-description'];

            $sql = "INSERT INTO `todos` (`todotitle`, `tododesc`) VALUES ('$title', '$description');";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $insert_status = true;
            }

            echo "
             <script>
              setTimeout(function () {
              window.location.href = '/todo'; //will redirect to your blog page (an ex: blog.html)
              }, 5000); //will call the function after 2 secs.
              </script>
              ";
        }

// Alerts For Create/Update/Delete
    }
    if ($insert_status){
        echo "
            <div class='alert alert-primary' role='alert'>
            Your Task has been added
            </div>
            ";
    }
    if ($update_status){
        echo "
            <div class='alert alert-info' role='alert'>
            Task has been updated
            </div>
            ";
    }
    if ($delete_status){
        echo "
            <div class='alert alert-danger' role='alert'>
            Task has been deleted
            </div>
            ";
    }
    ?>
    <h1>Add Tasks</h1>
    <form class="mt-5" action="/todo/index.php" method="post">
        <div class="mb-3">
            <label for="todo-title" class="form-label">Task Title</label>
            <input type="text" class="form-control" id="todo-title" name="todo-title" >
        </div>
        <div class="mb-3">
            <label for="todo-description" class="form-label">Task Title</label>
            <textarea class="form-control" rows="5" id="todo-description" name="todo-description" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>
<div class="container mt-5">

    <table class="table" id="todo_table">
        <thead>
        <tr>
            <th scope="col">S. No</th>
            <th scope="col">Todo Title</th>
            <th scope="col">Todo Description</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM `todos`";
        $sno = 0;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $sno ++;
            echo "
            <tr>
            <th scope='row'>". $sno ."</th>
            <td>". $row['todotitle'] ."</td>
            <td>". $row['tododesc'] ."</td>
            <td class='ml-3'>
            <button class='edit-btn btn btn-sm btn-primary' id=". $row['snum'] .">Edit</button>
            <button class='delete-btn btn btn-sm btn-danger' id=d". $row['snum'] .">Delete</button>
            </td>
            
            </tr>";
        }
        ?>
        </tbody>
    </table>
</div>


<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#todo_table').DataTable();
    } );
    edits = document.getElementsByClassName('edit-btn');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
         tr = e.target.parentNode.parentNode;

         title = tr.getElementsByTagName('td')[0].innerText;
         desc = tr.getElementsByTagName('td')[1].innerText;
         var todotitleedit = document.getElementById('todo-title-edit');
         var tododescriptionedit = document.getElementById('todo-description-edit');
         var snoEdit = document.getElementById('snoEdit');
         todotitleedit.value = title;
         tododescriptionedit.value = desc;
         $('#editmodal').modal('toggle');
         snoEdit.value = e.target.id;

        })
    })
    delets = document.getElementsByClassName('delete-btn');
    Array.from(delets).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1,)
        if (confirm("Are You Sure You Want To Delete This Task?")){
            window.location = `/todo/index.php?delete=${sno}`
        }

        })
    })
</script>
</body>
</html>