function accountTransfer() {
    let accountTransferSelector = document.querySelectorAll('a.accountTransfer')
    accountTransferSelector.forEach((aAccountTransfer) => {
        aAccountTransfer.addEventListener('click', (e) => {
            // e.preventDefault()
            const searchParams          = new URLSearchParams(window.location.search)
            let url                     = e.target.dataset.href
            let title                   = e.target.dataset.title
            let accountNumber           = e.target.dataset.accountNumber
            let qs                      = e.target.dataset.qs
            let balance                 = Number(e.target.dataset.balance).toFixed(2)
            let transferToAccountNumber = e.target.dataset.transferToAccountNumber
            let transferToBalance       = e.target.dataset.transferToBalance

            if (!transferToAccountNumber) {
                transferToAccountNumber = prompt('Enter the account number to transfer to:')
                if (!transferToAccountNumber) {
                    new Noty({
                        type: 'warning', text: 'You must enter an account number to transfer to',
                    }).show()
                    return
                }

                if (accountNumber.toString() === transferToAccountNumber.toString()) {
                    new Noty({
                        type: 'error', text: 'You cannot transfer to the same account',
                    }).show()
                    return
                }
            }

            if (!transferToBalance) {
                transferToBalance = prompt(`Enter the amount to transfer to account number ${transferToAccountNumber}:`)
                if (!transferToBalance) {
                    new Noty({
                        type: 'warning', text: 'You must enter an balance to transfer to',
                    }).show()
                    return
                }
                transferToBalance = Number(transferToBalance).toFixed(2)

                if (+transferToBalance > +balance) {
                    new Noty({
                        type: 'error', text: 'Transfer amount can\'t be larger than transfer balance',
                    }).show()
                    new Noty({
                        type: 'info',
                        text: `You have balance: ${balance} in account: ${accountNumber} which is less than ${transferToBalance}`,
                    }).show()
                    return
                }
            }

            qs = qs ?? new URLSearchParams({
                transferFromAccountNumber: accountNumber,
                transferFromBalance      : balance,
                transferToAccountNumber,
                transferToBalance,
            }).toString();
            urlConfirm(e, `${url}?${qs}`, `Are you sure you want to transfer ${transferToBalance} to ${transferToAccountNumber} from ${accountNumber}?`)
        })
    })
}

if (typeof window?.erp_callbacks?.DOMSubtreeModified === 'undefined') {
    window.erp_callbacks = {
        DOMSubtreeModified: [accountTransfer],
    }
} else {
    window.erp_callbacks.DOMSubtreeModified.push(accountTransfer)
}
