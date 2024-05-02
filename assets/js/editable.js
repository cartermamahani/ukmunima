$(document).ready(function() {
  $(document).on("click", ".edit", function() {
    var row = $(this).closest("tr");
    var id = $(this).data("id");
    var rowIndex = row.index();
    var namaPrestasi = row.find("[data-field='prestasi']").text().trim();
    var tanggalPrestasi = $(this).data("tanggal");

    // Show the edit form and populate with existing data
    $("#editRowId").val(id);
    $("#rowIndex").val(rowIndex);
    $("#editNamaPrestasi").val(namaPrestasi);
    $("#editTanggalPrestasi").val(tanggalPrestasi);
  });

  // Function to handle the delete action
  $(document).on("click", ".delete", function() {
    var row = $(this).closest("tr");
    var id = row.find(".delete").data("id");

    // Perform an AJAX call to delete the data from the database
    $.ajax({
      url: "delete_prestasi",
      method: "POST",
      data: { id: id },
      success: function(response) {
        const deleteSuccessToast = document.getElementById('deleteSuccessToast')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(deleteSuccessToast)
        toastBootstrap.show()
        row.remove();
      },
      error: function(xhr, status, error) {
        const deleteFailToast = document.getElementById('deleteFailToast')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(deleteFailToast)
        toastBootstrap.show()
      },
    });
  });

});