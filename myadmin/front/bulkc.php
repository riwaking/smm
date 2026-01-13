<?php include 'header.php'; ?>
<style>
.input-check {
  width: 3%;
}
.input {
  width: 5%;
}
.input2 {
  width: 92%;
}
#bulkActions {
  display: none;
  margin-bottom: 15px;
}
</style>

<center><h2>Bulk Categories Editor</h2></center>
<br>
<div class="container-fluid">
   
   <div id="bulkActions" class="alert alert-info">
     <strong><span id="selectedCount">0</span> categories selected</strong>
     <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="margin-left: 15px;">
       <i class="fa fa-trash"></i> Delete Selected
     </button>
   </div>
   
   <table class="table" style="border:1px solid #ddd">
      <thead>
            <th class="input-check"><input type="checkbox" id="selectAll" title="Select All"></th>
            <th class="input">ID</th>
            <th class="input2">Name</th>
      </thead>
   <tbody>

<form action="" method="post" enctype="multipart/form-data" id="bulkForm">
         
           <?php foreach($services as $service ):  ?>
       <tr data-id="<?php echo $service["category_id"]; ?>">
            <td class="input-check">
              <input type="checkbox" class="selectCategory" name="delete_category[<?php echo $service["category_id"]; ?>]" value="<?php echo $service["category_id"]; ?>">
            </td>
            <td class="input">
              <div><input type="text" class="form-control" name="service[<?php echo $service["category_id"]; ?>]"  value="<?php echo $service["category_id"]; ?>" readonly></div>
            </td>
            <td class="input2">
              <div><input type="text" class="form-control" name="name-<?php echo $service["category_id"]; ?>"  value="<?php echo $service["category_name"]; ?>"></div>
            </td>
       </tr>
<?php endforeach; ?>
   </tbody>
</table>
              
<br>
<center><button type="submit" class="btn btn-primary" >Save Changes</button></center>
</form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <strong><span id="deleteCount">0</span></strong> categories?</p>
        <p class="text-danger">This will also delete all services in these categories. This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function() {
    $('#selectAll').on('change', function() {
        $('.selectCategory').prop('checked', $(this).prop('checked'));
        updateSelectedCount();
    });

    $('.selectCategory').on('change', function() {
        updateSelectedCount();
    });

    function updateSelectedCount() {
        var count = $('.selectCategory:checked').length;
        $('#selectedCount').text(count);
        $('#deleteCount').text(count);
        if (count > 0) {
            $('#bulkActions').show();
        } else {
            $('#bulkActions').hide();
        }
    }

    $('#bulkDeleteBtn').on('click', function() {
        var count = $('.selectCategory:checked').length;
        if (count > 0) {
            $('#deleteCount').text(count);
            $('#confirmDelete').modal('show');
        }
    });

    $('#confirmDeleteBtn').on('click', function() {
        var categoryIds = [];
        $('.selectCategory:checked').each(function() {
            categoryIds.push($(this).val());
        });

        $.ajax({
            url: '<?php echo site_url("admin/ajax_data"); ?>',
            type: 'POST',
            data: {
                action: 'bulk_delete_categories',
                category_ids: categoryIds
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message || 'Error deleting categories');
                }
            },
            error: function() {
                alert('Error deleting categories');
            }
        });
    });
});
</script>
