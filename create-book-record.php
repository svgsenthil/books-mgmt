<?php

$page_title = "Create Book";

include "inc/header.php";

include "utility/autoload.php";

$crud = new Crud;
$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST"):

    $err_message = $validation->check_empty_field($_POST, ['title', 'price']);

    $crud->title = $_POST['title'];
    $crud->price = $_POST['price'];
    $crud->description = $_POST['description'];
    $crud->category = $_POST['category'];
    $crud->image = $_FILES['image'];

    //Validation Starts
    $check_title = $validation->is_valid_title($crud->title);
    $check_price = $validation->is_valid_price($crud->price);
    $check_image = $validation->is_upload($crud->image);
    $check_category = $validation->check_atleast_one_category($crud->category);

    if ($err_message != null):
        echo $err_message;
    elseif ($check_title):
        echo "<div class='text-center'><p class='error'>Please provide title in letters and numbers with maximum 100 characters</p></div>";
    elseif ($check_price):
        echo "<div class='text-center'><p class='error'>Book price should be number and minimum 5 and maximum 1000</p></div>";
    elseif ($check_image):
        echo "<div class='text-center'><p class='error'>Please provide proper image</p></div>";
    else:
        $store_data = $crud->create();

        if ($store_data):
            header("location:show-books.php?record_add_status=success");
        endif;
    endif;

endif;

$category_list = $crud->getCategory();

?>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="text-center bottom-margin">
                <a href="index.php">
                    <button class="btn btn-success">Home</button>
                </a>
                <a href="show-books.php">
                    <button class="btn btn-info">Show Books</button>
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Create Record</div>
                <div class="card-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required="true"
                                placeholder="Enter Book Title"
                                value="<?php echo isset($_POST["title"]) ? $_POST["title"] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" required="true" min="5"
                                max="1000" placeholder="Enter Book Price"
                                value="<?php echo isset($_POST["price"]) ? $_POST["price"] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"
                                placeholder="Enter Book Description"><?php echo isset($_POST["description"]) ? $_POST["description"] : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label><br />

                            <?php
                            $checked_arr = array();

                            foreach ($category_list as $category) {
                                $checked = "";
                                if (in_array($category, $checked_arr)) {
                                    $checked = "checked";
                                }
                                echo '<input type="checkbox" name="category[]" id="category" value="' . $category['name'] . '" ' . $checked . ' > ' . $category['name'] . ' <br/>';
                            }
                            ?>

                        </div>
                        <div class="form-group">
                            <label for="image">Choose Book Image</label>
                            <div class="col-md-12">
                                <input type="file" class="form-control" name="image" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="Submit" class="btn btn-primary waves">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>