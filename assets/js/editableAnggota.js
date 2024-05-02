$(document).ready(function() {
    $(document).on("click", ".edit", function() {
      var row = $(this).closest("tr");
      var id = $(this).data("id");
      var rowIndex = row.index();
      var nama = row.find("[data-field='nama_mahasiswa']").text().trim();
      var nim = row.find("[data-field='nim']").text().trim();
      var fakultas = row.find("[data-field='fakultas']").text().trim();
      var jurusan = row.find("[data-field='jurusan']").text().trim();
      var alamat = row.find("[data-field='alamat']").text().trim();
      var tempat_lahir = row.find("[data-field='tempat_lahir']").text().trim();
      var tanggal = $(this).data("tanggal");
  
      // Show the edit form and populate with existing data
      $("#editRowId").val(id);
      $("#rowIndex").val(rowIndex);
      $("#editNim").val(nim);
      $("#editNamaMahasiswa").val(nama);
      $("#editFakultas").val(fakultas);
      $("#editJurusan").val(jurusan);
      $("#editAlamat").val(alamat);
      $("#editTempatLahir").val(tempat_lahir);
      $("#editTanggalLahir").val(tanggal);
    });
  
    // Function to handle the delete action
    $(document).on("click", ".delete", function() {
      var row = $(this).closest("tr");
      var id = row.find(".delete").data("id");
  
      // Perform an AJAX call to delete the data from the database
      $.ajax({
        url: "delete_anggota",
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