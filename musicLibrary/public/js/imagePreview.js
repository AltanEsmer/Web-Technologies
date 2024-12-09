document.getElementById('cover_image').addEventListener('change', function(event) {
  const preview = document.getElementById('preview');
  const file = event.target.files[0];

  if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
      };

      reader.readAsDataURL(file);
  } else {
      preview.src = '';
      preview.classList.add('hidden');
  }
});