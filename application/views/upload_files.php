<!DOCTYPE html>
<html lang="en-US">
<head>
    
<title> Upload Multiple Images </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <div class="upload-div">
        <h3>Upload Multiple Images</h3>

        <?php echo !empty($statusMsg)?'<p class="status-msg">' . $statusMsg . '</p>':''; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Choose Images</label>
                <input type="file" class="form-control" name="files[]" multiple/>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control" name="fileSubmit" value="UPLOAD"/>
            </div>
        </form>
    </div>
    <div class="row">
        <h3>Uploaded Images</h3>
        <ul class="gallery">
            <?php if (!empty($files)) { foreach($files as $file) { ?>
            <li class="item col-md-4">
                <img src="<?php echo base_url('uploads/'.$file['file_name']); ?>" width="100%">
                <p>Uploaded On <?php echo date('j M Y', strtotime($file['uploaded_on'])); ?></p>
            </li>
            <?php } } else { ?>
            <p>Files not found... </p>
            <?php } ?>
        </ul>
    </div>
</div>
</body>
</html>