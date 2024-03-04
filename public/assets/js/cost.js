function checkPaid() {
    let checks = document.querySelectorAll(".fad.fa-check-double")
    checks.forEach(element => {
        element.closest("tr")?.classList?.add("paid_success")
    })
}

if (typeof window?.erp_callbacks?.DOMSubtreeModified === 'undefined') {
    window.erp_callbacks = {
        DOMSubtreeModified: [checkPaid],
    }
} else {
    window.erp_callbacks.DOMSubtreeModified.push(checkPaid)
}
