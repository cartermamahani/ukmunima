</div>
<div class="footer">
  <br>
  Contact Us
  <div class="text-center">
    <span class="col text-center mx-2"><a href="https://si.unima.ac.id"><i class="fas fa-globe"></i></a></span>
    <span class="col text-center mx-2"><a href="https://instagram.com/unima_1955"><i class="fab fa-instagram"></i></a></span>
    <span class="col text-center mx-2"><a href="https://www.facebook.com/1995Unima"><i class="fab fa-facebook"></i></a></span>
    <p>Jl. Kampus UNIMA, Tonsaru, Kec. Tondano Selatan., Kabupaten Minahasa, Sulawesi Utara., 95618</p>
  </div>
  <span class=""> Copyright &copy; Prodi Teknik Informatika &mdash; UNIMA 2024</span>
</div>
<!-- </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script>
  function updateTime() {
    const currentTime = new Date();
    const day = String(currentTime.getDate()).padStart(2, '0');
    const month = currentTime.toLocaleString("en", {
      month: "long"
    });
    const year = String(currentTime.getFullYear());
    const hours = String(currentTime.getHours()).padStart(2, '0');
    const minutes = String(currentTime.getMinutes()).padStart(2, '0');
    const seconds = String(currentTime.getSeconds()).padStart(2, '0');
    const formattedTime = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds}`;
    document.getElementById('current-time').textContent = formattedTime;
  }

  setInterval(updateTime, 1000);
  updateTime();
</script>