<!DOCTYPE html>
<html>
<head>
    <title>Upload File to Google Drive</title>
</head>
<body>

<h2>Upload File</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<?php echo form_open_multipart('GoogleDriveUpload_controller/do_upload'); ?>

<input type="file" name="file" required />
<br><br>
<input type="submit" value="Upload to Google Drive" />

</form>

</body>
</html>
