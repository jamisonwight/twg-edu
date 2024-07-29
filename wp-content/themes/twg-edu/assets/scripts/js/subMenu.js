import globals from './globals'
import anim from './animations'

var mobile = window.matchMedia( "(max-width: 1023px)" )

document.addEventListener("DOMContentLoaded", function () {
    var subMenuItems = document.querySelectorAll('.sub-menu .menu-item'),
        menuHasChildren = document.querySelectorAll('.menu-item-has-children')

    subMenuItems.forEach((obj, index) => {
        obj.querySelector('a').classList.add('sub-anchor')
    })

    menuHasChildren.forEach((obj, index) => {
        obj.querySelector('a').addEventListener('click', (e) => {
            if (mobile.matches) {
                e.preventDefault()
            }
            obj.classList.toggle('toggle-open')
        }, true)

        // obj.addEventListener('mouseover', (e) => {
        //     e.preventDefault()
        //     obj.querySelector('.sub-menu').style.display = 'flex'
        //     obj.classList.add('focus-state')
        // })
        //
        // obj.addEventListener('mouseleave', (e) => {
        //     e.preventDefault()
        //     obj.querySelector('.sub-menu').style.display = 'none'
        //     obj.classList.remove('focus-state')
        // })

    })


})