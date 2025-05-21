<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?php $this->load->view('layouts/navbar'); ?>

<div class="container py-5">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-cloud-upload-alt me-2"></i> Google Drive Files</h3>
        <div class="d-flex gap-2">
            <input type="text" id="searchInput" class="form-control" placeholder="Search files..." style="width: 220px;">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-upload me-1"></i> Upload
            </button>
        </div>
    </div>

    <!-- Files Table -->
    <div class="card shadow-sm border-0">
        <div class="table-responsive" style="max-height: 500px;">
            <table class="table table-hover table-striped align-middle mb-0" id="fileTable">
                <thead class="table-primary sticky-top">
                    <tr>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Drive Link</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($files)): ?>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td><?= htmlspecialchars($file->file_name) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= explode('/', $file->mime_type)[1] ?? $file->mime_type ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= $file->drive_link ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt"></i> View
                                    </a>
                                </td>
                                <td><?= date("M d, Y h:i A", strtotime($file->uploaded_at)) ?></td>
                                <td>
                                    <a href="<?= base_url('GoogleDriveUpload_controller/delete/' . $file->file_id) ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure you want to delete this file?');">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>No files uploaded yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="<?= base_url('GoogleDriveUpload_controller/do_upload') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="uploadModalLabel"><i class="fas fa-upload me-2"></i> Upload File</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="fileInput" class="form-label">Select File</label>
                        <input type="file" name="file" id="fileInput" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Search Filter
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const value = this.value.toLowerCase();
        document.querySelectorAll('#fileTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
