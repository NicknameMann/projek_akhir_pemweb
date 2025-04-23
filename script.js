// Inisialisasi setiap slider secara mandiri
document.querySelectorAll('.slider').forEach((slider) => {
    // Pastikan hanya slider yang valid (misalnya, slider promo dan slider comments)
    const images = slider.querySelectorAll('img');
    const leftBtn = slider.querySelector('.nav-btn.left');
    const rightBtn = slider.querySelector('.nav-btn.right');
    let currentIndex = 0;
    let interval;
  
    // Fungsi untuk menampilkan gambar dengan efek slide
    function showImage(index) {
      if (!images.length) return; // Pastikan ada gambar
      images.forEach((img, i) => {
        if (i === index) {
          img.classList.add('active');
          // Pastikan gambar aktif berada di posisi yang benar
          img.style.transform = "translateX(0)";
          img.style.left = "0";
        } else {
          img.classList.remove('active');
          // Gambar non-aktif diletakkan ke kiri atau kanan tergantung posisi relatif
          img.style.transform = i < index ? "translateX(-100%)" : "translateX(100%)";
        }
      });
    }
  
    // Fungsi untuk maju ke gambar berikutnya
    function nextImage() {
      currentIndex = (currentIndex + 1) % images.length;
      showImage(currentIndex);
    }
  
    // Fungsi untuk mundur ke gambar sebelumnya
    function prevImage() {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      showImage(currentIndex);
    }
  
    // Mulai sliding otomatis
    function startAutoSlide() {
      if (images.length > 1) {
        interval = setInterval(nextImage, 3000);
      }
    }
  
    // Hentikan sliding otomatis
    function stopAutoSlide() {
      clearInterval(interval);
    }
  
    // Event listener untuk tombol navigasi
    if (leftBtn && rightBtn) {
      leftBtn.addEventListener('click', () => {
        stopAutoSlide();
        prevImage();
        startAutoSlide();
      });
  
      rightBtn.addEventListener('click', () => {
        stopAutoSlide();
        nextImage();
        startAutoSlide();
      });
    }
  
    // Tampilkan gambar pertama dan mulai slider otomatis
    showImage(currentIndex);
    startAutoSlide();
  });
  