<?php
include_once "style.php";
?>

<body>
<?php
if ($_POST) {

    // include database connection
    include 'database.php';

    try {

        // insert query
        $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created";

        // prepare query for execution
        $stmt = $con->prepare($query);

        // posted values
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $description = htmlspecialchars(strip_tags($_POST['description']));
        $price = htmlspecialchars(strip_tags($_POST['price']));

        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);

        // specify when this record was inserted to the database
        $created = date('Y-m-d H:i:s');
        $stmt->bindParam(':created', $created);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div class='alert alert-success alert-dismissible fade in'>
                <p>Record was saved</p>
                <a href='index.php' class=''>
                    <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> Back to list
                </a>
            </div>";
        } else {
            die('Unable to save record.');
        }

    } // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h3 id="glyphicons" class="page-header">Create New Product
            <small>Simple CRUD by KhoaHA</small>
        </h3>

        <div class="x_content">
            <form action='create.php' method='post' class="form-horizontal form-label-left">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" required="required"
                               class="form-control col-md-7 col-xs-12"
                               data-parsley-id="4235">
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="description" name="description" required="required"
                               class="form-control col-md-7 col-xs-12"
                               data-parsley-id="4235">
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="price" name="price" required="required"
                               class="form-control col-md-7 col-xs-12"
                               data-parsley-id="4235">
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></span>
                    </label>

                    <button type="submit" class="btn btn-primary col-md-6 col-sm-6 col-xs-12"
                            data-target=".bs-example-modal-sm">
                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Submit
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>