const buttons = document.querySelectorAll('.add-to-cart')
const counter = document.querySelector('.cart-counter')

const handler = (button) => {
    button.onclick = () => {
        $.ajax({
            'url': '/cart/add/' + button.dataset.productId
        }).then((response) => {
            counter.innerHTML = response.sum
        })
    }
}

buttons.forEach(handler)

// const increases = document.querySelectorAll('.cart_quantity_up')
//
// const handler = (increase) => {
//     increase.onclick = () => {
//         $.ajax({
//             'url': '/cart/increase/' + increase.dataset.productId
//         }).then((response) => {
//             counter.innerHTML = response.productId
//         })
//     }
// }
//
// increase.forEach(handler)
