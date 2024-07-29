// import main SASS file
import '../../styles/scss/style.scss'

// Import Foundation
import './init-foundation'

import './lazyload'
import './ie'
// import './subMenu'
import './fancybox'
import './animations'
import './quiz'
// import './modal'


// Mac font spacing hack
if (navigator.userAgent.match(/Macintosh/) || navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
    document.querySelectorAll('.heading-1, .heading-2, .heading-3, .heading-4, .heading-5, .btn-default, .btn, .section-title').forEach((obj, index) => {
        obj.classList.add('is-mac')
    })
}

var currentPath = location.pathname;

var viewport = window.outerWidth || document.documentElement.clientWidth || document.body.clientWidth;

var menuHasChildren =  document.querySelectorAll('.menu-item-has-children')
menuHasChildren.forEach((obj, index) => {
    obj.querySelector('a').innerHTML += '<span class="arrow"></span>'
    obj.querySelector('a').addEventListener('click', (e) => {
        if (viewport < 1024) {
            e.preventDefault()
            e.stopPropagation()
        }
        obj.classList.toggle('menu-is-open')
        document.querySelector('.contact-mobile').classList.toggle('menu-open')
    }, true)
})