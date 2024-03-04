let setT = null
document.querySelector('#crudTable tbody').addEventListener('DOMSubtreeModified', function () {
    clearTimeout(setT)
    setT = setTimeout(function () {
        if (typeof erp_callbacks.DOMSubtreeModified !== 'undefined') {
            erp_callbacks.DOMSubtreeModified.forEach((callback) => {
                callback()
            })
        }
    }, 100)
})
