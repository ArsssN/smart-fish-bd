function checkCLoseCycle() {
    let closeCycleSelector = document.querySelectorAll('a.closeCycle')
    closeCycleSelector.forEach((aCloseCycle) => {
        aCloseCycle.addEventListener('click', (e) => {
            // e.preventDefault()
            const searchParams = new URLSearchParams(window.location.search)
            let url            = e.target.dataset.href
            let slug           = e.target.dataset.slug
            let title          = e.target.dataset.title
            let actionDone     = e.target.dataset.actionDone
            let alertPop       = {
                actionDone,
                alert: {
                    type: 'info',
                    text: 'This cycle is already closed',
                },
            }
            slug               = searchParams.get('cycle_id_text')?.toLowerCase()?.replaceAll(' ', '') ?? slug
            if (!slug) {
                slug = prompt('Enter the slug of the cycle to close')
            }
            urlConfirm(e, `${url}/${slug}`, `Are you sure you want to close cycle: ${title} ?`, alertPop)
        })
    })
}

if (typeof window?.erp_callbacks?.DOMSubtreeModified === 'undefined') {
    window.erp_callbacks = {
        DOMSubtreeModified: [checkCLoseCycle],
    }
} else {
    window.erp_callbacks.DOMSubtreeModified.push(checkCLoseCycle)
}
