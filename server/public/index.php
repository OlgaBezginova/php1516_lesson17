<?php
$name = '';
$review = '';
$name_msg = '';
$review_msg = '';
$success_msg = '';

$required_text = '<div class="alert alert-danger" role="alert">
                        The field <strong>%s</strong> is required!
                     </div>';
$success_text = '<div class="alert alert-success" role="alert" style="display: flex; justify-content: space-between">
                    <div>Thanks for the review!</div>
                    <a href="javascript:void(0)" class="alert-link" onclick="this.closest(\'.alert-success\').style.display = \'none\'">X</a>
                 </div>';

define('DB_HOST', 'a_level_nix_mysql');
define('DB_USER', 'root');
define('DB_PASSWORD', 'cbece_gead-cebfa');
define('DB_NAME', 'a_level_nix_mysql');

/**
 * @return mysqli
 */
function connect()
{
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!$connection) {
        die();
    }

    return $connection;
}


/**
 * @param string $name
 * @param string $review
 * @return void
 */
function addReview($name, $review)
{
    $name  = trim(strip_tags($name));
    $review = trim(strip_tags($review));

    if (empty($name) || empty($review)) {
        return;
    }

    $mysql = connect();
    $query = sprintf('INSERT INTO reviews (`name`, `review`) VALUES (\'%s\', \'%s\')', $name, $review);

    mysqli_query($mysql, $query);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $success = true;

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name_msg = sprintf($required_text, 'Name');
        $success = false;
    }

    if (isset($_POST['review']) && !empty($_POST['review'])) {
        $review = $_POST['review'];
    } else {
        $review_msg = sprintf($required_text, 'Review');
        $success = false;
    }

    if ($success) {
        addReview($_POST['name'], $_POST['review']);
        $success_msg = $success_text;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 d-flex justify-content-around text-center">
                <h1>Leave a review about... whatever</h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="name"><strong>Name*</strong></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="<?php echo $name; ?>">
                    </div>
                    <?php echo $name_msg; ?>
                    <div class="form-group">
                        <label for="review"><strong>Review*</strong></label>
                        <textarea name="review" class="form-control" id="review" placeholder="Say something" rows="5"><?php echo $review; ?></textarea>
                    </div>
                    <?php echo $review_msg; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <?php echo $success_msg; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
