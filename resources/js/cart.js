document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', async (e) => {
        e.preventDefault();

        const response = await fetch(button.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        // Обновляем Livewire-компонент
        Livewire.emit('cartUpdated');

        // Показываем анимацию
        button.classList.add('animate-bounce');
        setTimeout(() => button.classList.remove('animate-bounce'), 1000);
    });
});
