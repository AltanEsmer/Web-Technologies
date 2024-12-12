document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const addSongForms = document.querySelectorAll('.add-song-form');

    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const button = searchForm.querySelector('button');
            const buttonText = button.querySelector('.button-text');
            const loadingText = button.querySelector('.loading-text');

            // Show loading state
            button.disabled = true;
            buttonText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            // Submit the form normally
            searchForm.submit();
        });
    }

    addSongForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const button = form.querySelector('button');
            const buttonText = button.querySelector('.button-text');
            const loadingText = button.querySelector('.loading-text');

            // Show loading state
            button.disabled = true;
            buttonText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            // Submit using fetch
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.innerHTML = '<i class="fas fa-check"></i> Added';
                    button.classList.add('bg-green-500', 'text-white');
                    button.disabled = true;
                }
            })
            .catch(() => {
                // Reset button state
                button.disabled = false;
                buttonText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            });
        });
    });
}); 