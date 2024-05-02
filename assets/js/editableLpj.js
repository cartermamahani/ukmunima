$(document).ready(function() {
    $(document).on("click", ".edit", function() {
      var row = $(this).closest("tr");
      var id = $(this).data("id");
      var rowIndex = row.index();
      var nama_bidang = row.find("[data-field='nama_bidang']").text().trim();
      var judul = row.find("[data-field='judul']").text().trim();
      var keterangan = row.find("[data-field='keterangan']").text().trim();
      var file = row.find("[data-field='file']").text().trim();
      var tanggal = $(this).data("tanggal_periode_lpj");
  
      // Show the edit form and populate with existing data
      $("#editRowId").val(id);
      $("#rowIndex").val(rowIndex);
      $("#nama_bidang").val(nama_bidang);
      $("#judul").val(judul);
      $("#tanggal_periode_lpj").val(tanggal);
      $("#keterangan").val(keterangan);
      $("#file").val(file);
    });
  
    // Function to handle the save action
    $(document).on("click", "#saveEdit", function() {
      var id = $("#editRowId").val();
      var rowIndex = $("#rowIndex").val();
      var tanggal_periode_lpj = $("#tanggal_periode_lpj").val().trim();
      var nama_bidang = $("#nama_bidang").val().trim();
      var judul = $("#judul").val().trim();
      var keterangan = $("#keterangan").val().trim();
      var file = document.getElementById('file');

      var formData = new FormData();
        formData.append('id_lpj', id);
        formData.append('nama_bidang', nama_bidang);
        formData.append('judul', judul);
        formData.append('tanggal_periode_lpj', tanggal_periode_lpj);
        formData.append('keterangan', keterangan);
        formData.append('file', file.files[0]);
  
      // Perform an AJAX call to update the data in the database
      $.ajax({
        url: "update_lpj",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Update the table row with the updated data
          var row = $("#editableTable").find("tr").eq(rowIndex+1);
          row.find("[data-field='tanggal_periode_lpj']").text(tanggal_periode_lpj.toString('dd-mm-yyyy'));
          row.find("[data-field='nama_bidang']").text(nama_bidang);
          row.find("[data-field='judul']").text(judul);
          row.find("[data-field='keterangan']").text(keterangan);
          row.find("[data-field='file']").file(file);
  
          // Hide the edit form and show edit and delete buttons again
          $("#editModal").modal("hide");
          const editSuccessToast = document.getElementById('editSuccessToast')
          const toastBootstrap = bootstrap.Toast.getOrCreateInstance(editSuccessToast)
          toastBootstrap.show()
        },
        error: function(xhr, status, error) {
          const editFailToast = document.getElementById('editFailToast')
          const toastBootstrap = bootstrap.Toast.getOrCreateInstance(editFailToast)
          toastBootstrap.show()
        },
      });
    });
  
    // Function to handle the delete action
    $(document).on("click", ".delete", function() {
      var row = $(this).closest("tr");
      var id = row.find(".delete").data("id");
  
      // Perform an AJAX call to delete the data from the database
      $.ajax({
        url: "delete_lpj",
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
  
    // $(document).on("click", "#addData", function() {
    //     var idUkm = $("#idUkm").val().trim();
    //     var namaBidang = $("#nama_bidang").val().trim();
    //     var judul = $("#judul").val().trim();
    //     var tanggalPeriodeLpj = $("#tanggal_periode_lpj").val().trim();
    //     var keterangan = $("#keterangan").val().trim();
    //     var fileInput = document.getElementById('fileInput');

    //   var selectedDate = new Date($("#tanggal_periode_lpj").val().trim());
    //   var day = selectedDate.getDate();
    //   var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
    //   var year = selectedDate.getFullYear();
    //   var formatTglLPJ = day + '-' + month + '-' + year;

    //   var formData = new FormData();
    //   formData.append('id_ukm', idUkm);
    //   formData.append('nama_bidang', namaBidang);
    //   formData.append('judul', judul);
    //   formData.append('tanggal_periode_lpj', tanggalPeriodeLpj);
    //   formData.append('keterangan', keterangan);
    //   formData.append('file', fileInput.files[0]);
  
    //   // Perform an AJAX call to add the new data to the database
    //   $.ajax({
    //       url: "add_lpj",
    //       method: "POST",
    //       data: formData,
    //       contentType: false,
    //       processData: false,
    //       success: function(response) {
    //         var newRow = `
    //         <tr>
    //             <td>${namaBidang}</td>
    //             <td>${judul}</td>
    //             <td>${formatTglLPJ}</td>
    //             <td>${keterangan}</td>
    //             <td>
    //                 <a href="${response.id_lpj}" target="_blank">
    //                 <?php
    //                 if ($row['content_type'] == "application/pdf") {
    //                     echo '<i class="fas fa-file-pdf"></i>';
    //                 } else if ($row['content_type'] == "application/msword") {
    //                     echo '<i class="fas fa-file-word"></i>';
    //                 } else {
    //                     echo '<i class="fas fa-file"></i>';
    //                 }
    //                 ?>
    //                 </a>
    //             </td>
    //             <td>
    //             <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_lpj'] ?>" data-tanggal="<?= $row['tanggal_periode_lpj'] ?>">
    //                 <i class="fas fa-pen"></i>
    //             </a>
    //             <a class="button button-small delete" title="Delete" data-id="<?= $row['id_lpj'] ?>">
    //                 <i class="fas fa-trash"></i>
    //             </a>
    //             </td>
    //         </tr>
    //       `;
  
    //         // Append the new row to the table body
    //         $("#editableTable tbody").append(newRow);
    
    //         const addSuccessToast = document.getElementById('addSuccessToast')
    //         const toastBootstrap = bootstrap.Toast.getOrCreateInstance(addSuccessToast)
    //         toastBootstrap.show()
    //         // Hide the add form modal
    //         $("#addModal").modal("hide");
    //       },
    //       error: function(xhr, status, error) {
    //         const addFailToast = document.getElementById('addFailToast')
    //         const toastBootstrap = bootstrap.Toast.getOrCreateInstance(addFailToast)
    //         toastBootstrap.show()
    //       },
    //   });
     
    // });
  
  });