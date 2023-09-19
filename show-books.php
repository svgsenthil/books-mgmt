<?php

$page_title = "Books List";
$upload_dir = "uploads/";

include "inc/header.php";

include "utility/autoload.php";

$crud = new Crud;

$show_data = $crud->read();

// Show the Record Create, Update and Delete Status
if (isset($_REQUEST['record_add_status'])):
    echo "<div class='text-center error'><p>Record has added successfully..!</p></div>";
elseif (isset($_REQUEST['record_update_status'])):
    echo "<div class='text-center error'><p>Record has updated successfully..!</p></div>";
elseif (isset($_REQUEST['record_delete_status'])):
    echo "<div class='text-center error'><p>Record has deleted successfully..!</p></div>";
endif;

if (!empty($show_data)):

    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="text-center bottom-margin">
                    <a href="index.php">
                        <button class="btn btn-success">Home</button>
                    </a>
                    <a href="create-book-record.php">
                        <button class="btn btn-danger">Create Book</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Books List</div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($show_data as $data): ?>
                                    <tr>
                                        <td>
                                            <?php echo ucwords($data['title']); ?>
                                        </td>
                                        <td>
                                            <?php echo $data['price']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['description']; ?>
                                        </td>
                                        <td><img src="<?php echo $upload_dir . $data['image'] ?>" height="40"></td>
                                        <td>
                                            <?php echo $data['category']; ?>
                                        </td>
                                        <td>
                                            <a href="delete.php?id=<?php echo htmlentities($data['id']); ?>"
                                                onClick="return confirm('Are you sure you want to delete?')">
                                                <button class="btn btn-danger">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

else:
    echo "<h2>There is no record!</h2>";
endif;

include "inc/footer.php";
?>