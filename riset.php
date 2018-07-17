<?php include_once "head_riset.php"; ?>
<?php print_r($_FILES);?>
<form action="riset.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php include_once "footer.php"; ?>