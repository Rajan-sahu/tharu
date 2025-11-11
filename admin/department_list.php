<?php
require_once('./pura-common/head.php');
require_once('./pura-common/sidebar.php');
require_once('./pura-common/header.php');
?>

<div class="container-fluid content-inner mt-n5">
   <div class="card shadow-lg border-0 rounded-3">
      <div class="card-header d-flex justify-content-between align-items-center">
         <div class="header-title">
            <h4 class="card-title mb-0">Department List</h4>
         </div>
         <a href="department_add.php" class="btn btn-sm btn-primary">
            <i class="fa-sharp fa-solid fa-plus"></i> Add New
         </a>
      </div>
      <div class="card-body">
         <?php
         $departments = [];
         $sql = "SELECT * FROM zuraud_department ";
         $result = $conn->query($sql);
         if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $departments[] = $row;
            }
         }
         if (!empty($departments)) { ?>
            <button id="exportDepartment" class="btn btn-success mb-2">Export Departments to Excel</button>
            <div class="table-responsive">
               <table id="departmentTable" class="table table-bordered table-striped table-hover">
                  <thead class="table-light">
                     <tr>
                        <th>#</th>
                        <th>Department Name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($departments as $index => $department) { ?>
                        <tr>
                           <td><?= $index + 1 ?></td>
                           <td><?= $department['title'] ?></td>
                           <td class="text-center">
                              <a title="Edit" href="department_add.php?id=<?= $department['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                 <i class="fas fa-edit"></i>
                              </a>
                              <a title="Delete" href="#" class="btn btn-sm btn-outline-danger delete-department" data-del_id=<?= $department['id'] ?>>
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
    $('#departmentTable').DataTable({
        pageLength: 10,        // default rows per page
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,        // enable column sorting
        searching: true,       // enable search bar
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search departments..."
        }
    });
});
</script>
<script>
   const departmentData = <?= json_encode($departments); ?>;
   document.getElementById("exportDepartment").addEventListener("click", function() {
      
      const refinedData = departmentData.map(item => ({
         ID: item.id,
         Department_Name: item.title
      }));

      // Convert JSON → Worksheet
      const worksheet = XLSX.utils.json_to_sheet(refinedData);

      // Create Workbook
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Departments");

      // Download Excel
      XLSX.writeFile(workbook, "Department_List.xlsx");
   });
</script>