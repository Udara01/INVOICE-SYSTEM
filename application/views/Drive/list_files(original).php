<h2>Uploaded Files</h2>
<table border="1">
    <tr>
        <th>File Name</th>
        <th>MIME Type</th>
        <th>Drive Link</th>
        <th>Uploaded At</th>
    </tr>
    <?php foreach($files as $file): ?>
    <tr>
        <td><?= $file->file_name ?></td>
        <td><?= $file->mime_type ?></td>
        <td><a href="<?= $file->drive_link ?>" target="_blank">View</a></td>
        <td><?= $file->uploaded_at ?></td>
    </tr>
    <?php endforeach; ?>
</table>
