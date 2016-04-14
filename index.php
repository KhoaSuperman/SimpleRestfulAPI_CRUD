<?php
include_once "style.php";
?>

<body>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h3 id="glyphicons" class="page-header">Product Management
            <small>Simple CRUD by KhoaHA</small>
        </h3>

        <div class="x_content">
            <a class="btn btn-primary" data-target=".bs-example-modal-sm" href="create.php">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create
            </a>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // include database connection
                include 'database.php';

                $action = isset($_GET['action']) ? $_GET['action'] : "";

                // if it was redirected from delete.php
                if ($action == 'deleted') {
                    echo "<div>Record was deleted.</div>";
                }

                // select all data
                $query = "SELECT id, name, description, price FROM products";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                //check if more than 0 record found
                if ($num > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        // creating new table row per record
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$description}</td>";
                        echo "<td>&#36;{$price}</td>";
                        echo "<td>";
                        // we will use this links on next part of this post
                        echo "<a class='collapse-link' href='update.php?id={$id}' ><i class='fa fa-wrench'></i></a>";
                        echo " / ";
                        // we will use this links on next part of this post
                        echo "<a href='#' onclick='delete_user({$id});' class='close-link'><i class='fa fa-close'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // end table
                    echo "</table>";

                } // if no records found
                else {
                    echo "<div>No records found.</div>";
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>
</div>


<script type='text/javascript'>
    function delete_user(id) {

        var answer = confirm('Are you sure?');
        if (answer) {
            // if user clicked ok,
            // pass the id to delete.php and execute the delete query
            window.location = 'delete.php?id=' + id;
        }
    }
</script>
</body>
