function urlConfirm(event, url = null, title = null, alertPop = null) {
    event.preventDefault()
    url          = url ?? event.target.href
    title        = title ?? event.target.title
    let isPrompt = event.target.dataset.prompt ?? false

    console.log(`url: ${url}`, `title: ${title}`, `isPrompt: ${isPrompt}`);

    if (isPrompt) {
        let command     = prompt("Please insert the command: ");
        let commandBtoA = btoa(command)
        let newUrl      = new URL(url)
        url             = newUrl.origin + newUrl.pathname + `/${commandBtoA}` + newUrl.search

        if (!command) {
            return false
        }
    }

    console.log(alertPop, 'alertPop');

    if (alertPop && !!alertPop.actionDone) {
        new Noty(alertPop.alert).show()
        return false
    }

    let confirm = window.confirm(title)
    if (confirm) {
        window.location.href = url
    } else {
        return false
    }
}
