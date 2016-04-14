<?php
include_once "style.php";
?>

<?php
//include database connection
include 'database.php';

// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// read current record's data
try {
    // prepare select query
    $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
    $stmt = $con->prepare($query);

    // this is the first question mark
    $stmt->bindParam(1, $id);

    // execute our query
    $stmt->execute();

    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // values to fill up our form
    $name = $row['name'];
    $description = $row['description'];
    $price = $row['price'];
} // show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// check if form was submitted
if ($_POST) {

    try {
        $query = "UPDATE products
                    SET name=:name, description=:description, price=:price
                    WHERE id = :id";

        // prepare query for excecution
        $stmt = $con->prepare($query);

        // posted values
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $description = htmlspecialchars(strip_tags($_POST['description']));
        $price = htmlspecialchars(strip_tags($_POST['price']));

        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div class='alert alert-success alert-dismissible fade in'>
                <p>Record was updated</p>
                <a href='index.php' class=''>
                    <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> Back to list
                </a>
            </div>";
        } else {
            echo 'Unable to update record. Please try again.';
        }

    } // show errors
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h3 id="glyphicons" class="page-header">Update Product
            <small>Simple CRUD by KhoaHA</small>
        </h3>

        <div class="x_content">
            <form action='update.php?id=<?php echo htmlspecialchars($id); ?>' method='post'
                  class="form-horizontal form-label-left">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Name <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" required="required"
                               class="form-control col-md-7 col-xs-12"
                               data-parsley-id="4235"
                               value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control" id="description" name="description" rows="3">
                            <?php echo htmlspecialchars($description, ENT_NOQUOTES); ?>
                        </textarea>
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span
                            class="required">*</span>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="price" name="price" required="required"
                               class="form-control col-md-7 col-xs-12"
                               data-parsley-id="4235"
                               value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"/>
                        <ul class="parsley-errors-list" id="parsley-id-4235"></ul>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></span>
                    </label>

                    <button type="submit" class="btn btn-primary col-md-6 col-sm-6 col-xs-12"
                            data-target=".bs-example-modal-sm">
                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Update
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>

<!--<!--we have our html form here where new user information will be entered-->
<!--<form action='update.php?id=--><?php //echo htmlspecialchars($id); ?><!--' method='post' border='0'>-->
<!--    <table>-->
<!--        <tr>-->
<!--            <td>Name</td>-->
<!--            <td><input type='text' name='name' value="--><?php //echo htmlspecialchars($name, ENT_QUOTES); ?><!--"/></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Description</td>-->
<!--            <td><textarea name='description'>--><?php //echo htmlspecialchars($description, ENT_QUOTES); ?><!--</textarea></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Price</td>-->
<!--            <td><input type='text' name='price' value="--><?php //echo htmlspecialchars($price, ENT_QUOTES); ?><!--"/></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td></td>-->
<!--            <td>-->
<!--                <input type='submit' value='Save Changes'/>-->
<!--                <a href='index.php'>Back to read records</a>-->
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
<!--</form>-->
