const wine = document.querySelectorAll('.wine')

if (wine !== null) {
    wine.forEach((obj, index) => {

       var modalTrigger = obj.querySelector('.modal-trigger'),
           wineModal = document.querySelector('.wine-modal-' + (index += 1))
           closeTrigger = wineModal.querySelector('.modal-close'),
           wineDetailWrapper = document.querySelector('.wine-detail-modals')


        if (modalTrigger !== null) {

            modalTrigger.addEventListener('click', (e) => {
                e.preventDefault()
                e.stopPropagation()
                wineModal.classList.add('modal-open')
                wineDetailWrapper.classList.add('add-overlay')
                wineModal.querySelector('.btn-default').style.display = 'inline-block';
            })

            wineModal.querySelector('.modal-close').addEventListener('click', (e) => {
                e.preventDefault()
                e.stopPropagation()
                wineDetailWrapper.classList.remove('add-overlay')
                wineModal.classList.remove('modal-open')
                wineModal.querySelector('.btn-default').style.display = 'none';
            })
        }
    })
}