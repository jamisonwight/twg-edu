import g from './globals'

if (g.elementInDom('.accordion')) {
    const accordionItems = document.querySelectorAll('.accordion-item')
    var isActive = false;

    accordionItems.forEach((obj, index) => {
        obj.querySelector('.accordion-title').addEventListener('click', (e) => {
            e.preventDefault()
            var accordionContentToggle = obj.querySelector('.accordion-content-toggle'),
                isCollapsed = accordionContentToggle.getAttribute('data-collapsed') === 'true',
                toggleIdentifier = e.currentTarget.querySelector('.toggle-identifier')
            if(isCollapsed) {
                expandSection(accordionContentToggle)
                accordionContentToggle.setAttribute('data-collapsed', 'false')
                toggleIdentifier.classList.add('toggle-open')
            } else {
                collapseSection(accordionContentToggle)
                toggleIdentifier.classList.remove('toggle-open')
            }
        })
    })

    function closeAllItems() {
        accordionItems.forEach((obj, index) => {
            obj.classList.remove('toggle-open')
        })
    }

    function collapseSection(element) {
        // get the height of the element's inner content, regardless of its actual size
        var sectionHeight = element.scrollHeight;
        // temporarily disable all css transitions
        var elementTransition = element.style.transition;
        element.style.transition = '';
        // on the next frame (as soon as the previous style change has taken effect),
        // explicitly set the element's height to its current pixel height, so we
        // aren't transitioning out of 'auto'
        requestAnimationFrame(function() {
            element.style.height = sectionHeight + 'px';
            element.style.transition = elementTransition;
            // on the next frame (as soon as the previous style change has taken effect),
            // have the element transition to height: 0
            requestAnimationFrame(function() {
                element.style.height = 0 + 'px';
            });
        });
        // mark the section as "currently collapsed"
        element.setAttribute('data-collapsed', 'true');
    }

    function expandSection(element) {
        // get the height of the element's inner content, regardless of its actual size
        var sectionHeight = element.scrollHeight;
        // have the element transition to the height of its inner content
        element.style.height = sectionHeight + 'px';
        // when the next css transition finishes (which should be the one we just triggered)
        element.addEventListener('transitionend', function(e) {
            // remove this event listener so it only gets triggered once
            element.removeEventListener('transitionend', arguments.callee);
            // remove "height" from the element's inline styles, so it can return to its initial value
            element.style.height = null;
        });
        // mark the section as "currently not collapsed"
        element.setAttribute('data-collapsed', 'false');
    }
}