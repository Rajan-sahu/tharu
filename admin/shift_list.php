<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title">
            <h4 class="card-title mb-0">Shift List</h4>
         </div>
         <a href="shift_add.php" class="btn btn-sm btn-primary">
            <i class="fa-sharp fa-solid fa-plus"></i> Add New
         </a>
      </div>
      <div class="card-body">
         <?php
         $shifts = [];
         $sql = "SELECT * FROM zuraud_shift ";
         $result = $conn->query($sql);
         if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $shifts[] = $row;
            }
         }
         if (!empty($shifts)) { ?>
            <div class="table-responsive">
               <table id="shiftTable" class="table table-bordered table-striped table-hover">
                  <thead class="table-light">
                     <tr>
                        <th>#</th>
                        <th>Shift Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($shifts as $index => $shift) { ?>
                        <tr>
                           <td><?= $index + 1 ?></td>
                           <td><?= $shift['name'] ?></td>
                           <td><?= (!empty($shift['start_time'])) ? date('h:i A', strtotime($shift['start_time'])) : '' ?></td>
                           <td><?= (!empty($shift['end_time'])) ? date('h:i A', strtotime($shift['end_time'])) : '' ?></td>
                           <td class="text-center">
                              <a title="Edit" href="shift_add.php?id=<?= $shift['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                 <i class="fas fa-edit"></i>
                              </a>
                              <a title="Delete" href="#" class="btn btn-sm btn-outline-danger delete-shift" data-del_id=<?= $shift['id'] ?>>
                                 <i class="fas fa-trash"></i>
                              </a>
                           </td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         <?php } else { ?>
            <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
               <div class="card shadow-sm w-100">
                  <div class="card-body text-center py-5">
                     <i class="fas fa-database fa-3x text-muted mb-3"></i>
                     <h5 class="text-muted">No Data Available</h5>
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
   </div>
</div>

<?php
include_once('./pura-common/footer.php');
?>

<!-- DataTable Init -->
<script>
$(document).ready(function () {
    $('#shiftTable').DataTable({
        pageLength: 10,        // default rows per page
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,        // enable column sorting
        searching: true,       // enable search bar
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search shifts..."
        }
    });
});
</script>