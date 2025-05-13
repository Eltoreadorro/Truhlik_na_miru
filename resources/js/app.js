import './bootstrap';
import './cart'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function loadMore(button) {
    const url = button.dataset.url;
    fetch(`${url}&ajax=1`)
        .then(response => response.text())
        .then(html => {
            button.parentElement.remove();
            document.getElementById('products-container').insertAdjacentHTML('beforeend', html);
        });
}
