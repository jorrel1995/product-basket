import axios from 'axios';

const buttons = document.querySelectorAll('.btn-primary');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.dataset.productId;
        const quantity = document.getElementById(`quantity-${productId}`).value;
        const price = document.getElementById(`price-${productId}`).innerText;
        const total = quantity * price;

        axios.post('/basket/add', {
            product_id: productId,
            quantity: quantity,
        })
            .then(response => {
                console.log(response.data);
                window.location.reload();
                alert(response.data.message);
            })
            .catch(error => {
                console.log(error);
                alert('Error processing request');
            });
    });
});

window.deleteProduct = function (productId) {
    axios.post('/basket/delete', {
        product_id: productId,
        quantity: 1 // Dummy quantity for validation
    })
        .then(response => {
            console.log(response.data);
            window.location.reload();
            alert(response.data.message);
        })
        .catch(error => {
            console.log(error);
            alert('Error removing product');
        });
}

window.clearBasket = function () {
    axios.post('/basket/clear')
        .then(response => {
            console.log(response.data);
            window.location.reload();
            alert(response.data.message);
        })
        .catch(error => {
            console.log(error);
            alert('Error clearing basket');
        });
}

window.updateQuantity = function (productId, quantity) {
    axios.post('/basket/update', {
        product_id: productId,
        quantity: quantity,
    })
        .then(response => {
            console.log(response.data);
            window.location.reload();
            alert(response.data.message);
        })
        .catch(error => {
            console.log(error);
            alert('Error updating quantity');
        });
}