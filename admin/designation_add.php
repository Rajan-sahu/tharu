<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
   $update_id = db_sanitize($_GET['id']);
   $designation_sql = $conn->query("SELECT * FROM `zuraud_designation` WHERE `id`='{$update_id}'");
   if ($designation_sql && $designation_sql->num_rows > 0) {
      $designation = $designation_sql->fetch_assoc();
   }
}
?>

<div class="container-fluid content-inner mt-n5">
   <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
         <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
               <div class="header-title">
                  <h4 class="card-title mb-0"><?= isset($update_id) ? "Update": 'Add' ?> Designation </h4>
               </div>
               <a href="designation_list.php" class="btn btn-sm btn-primary">
                  <i class="fas fa-list me-2"></i> List
               </a>
            </div>
            <div class="card-body">
               <form id="designation_add">

                  <!-- Departmet Name -->
                  <div class="mb-3">
                     <label for="title" class="form-label">Designation Name <span class="text-danger">*</span></label>
                     <input type="hidden" name="update_id" value="<?= @$designation['id'] ?>">
                     <input type="text" class="form-control" id="title" name="title" placeholder="Enter designation name" value="<?= @$designation['title'] ?>">
                  </div>
                  <!-- Submit Button -->
                  <div class="d-grid">
                     <button type="submit" class="btn btn-primary btn-md" id="sub_btn">
                        <i class="fas fa-save me-2"></i> Save Designation
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>