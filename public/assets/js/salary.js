let nameType   = document.querySelector('[name="type"]');
let nameAmount = document.querySelector('[name="amount"]');
if (!!nameType) {
    let oldType = nameType.value;
    nameType.addEventListener('change', function () {
        let type = this.value;
        if (!!nameAmount) {
            let amount       = nameAmount.value;
            nameAmount.title = `Previous type: ${oldType}, previous amount: ${amount || 0}`;
            nameAmount.value = null;
            oldType          = type;
        }
    });
}
