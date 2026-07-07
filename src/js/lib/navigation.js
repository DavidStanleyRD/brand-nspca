function hamburger() {
    const hamburger = document.querySelector('.hamburger');
    const mobilenav = document.querySelector('.mobile-navigation');
    if (!hamburger || !mobilenav) {
        return;
    }

    hamburger.addEventListener('click', function() {
        this.classList.toggle('open');
        mobilenav.classList.toggle('open');

        if (!mobilenav.classList.contains('open')) {
            const openItems = mobilenav.querySelectorAll('li.menu-item-has-children.open');
            const openSubmenus = mobilenav.querySelectorAll('ul.sub-menu.open');
            const openArrows = mobilenav.querySelectorAll('.nav-arrow.open');

            openItems.forEach((item) => item.classList.remove('open'));
            openSubmenus.forEach((submenu) => submenu.classList.remove('open'));
            openArrows.forEach((arrow) => arrow.classList.remove('open'));
        }
    })
}

export {hamburger};

function getDirectChildWithClass(parent, className) {
    return Array.from(parent.children).find((child) => child.classList && child.classList.contains(className));
}

function submenus() {
    const submenuItems = document.querySelectorAll('li.menu-item-has-children');

    submenuItems.forEach((tag) => {
        const submenu = getDirectChildWithClass(tag, 'sub-menu');

        if (!submenu) {
            return;
        }

        if (!getDirectChildWithClass(tag, 'nav-arrow')) {
            const arrow = document.createElement('img');
            arrow.className = 'nav-arrow';
            arrow.src = '/wp-content/themes/brand-nspca/src/images/dropdown.svg';
            arrow.alt = 'Toggle submenu';

            tag.insertBefore(arrow, submenu);
        }

        if (tag.dataset.desktopHoverBound === 'true') {
            return;
        }

        tag.addEventListener('mouseover', function() {
            if (window.innerWidth > 990) {
                this.classList.add('open');
            }
        })

        tag.addEventListener('mouseout', function() {
            if (window.innerWidth > 990) {
                this.classList.remove('open');
            }
        })

        tag.dataset.desktopHoverBound = 'true';
    })
}

export {submenus};

// mobile nav dropdowns

function mobilesubnav() {
    const submenuItems = document.querySelectorAll('.mobile-navigation li.menu-item-has-children');

    submenuItems.forEach((item) => {
        const submenu = getDirectChildWithClass(item, 'sub-menu');
        const arrow = getDirectChildWithClass(item, 'nav-arrow');

        if (!submenu || !arrow || arrow.dataset.mobileBound === 'true') {
            return;
        }

        arrow.addEventListener('click', function(event) {
            if (window.innerWidth > 990) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const isOpening = !item.classList.contains('open');
            const siblingItems = Array.from(item.parentElement.children).filter((siblingItem) => {
                return siblingItem !== item && siblingItem.classList && siblingItem.classList.contains('menu-item-has-children');
            });

            siblingItems.forEach((siblingItem) => {
                const siblingSubmenu = getDirectChildWithClass(siblingItem, 'sub-menu');
                const siblingArrow = getDirectChildWithClass(siblingItem, 'nav-arrow');

                siblingItem.classList.remove('open');

                if (siblingSubmenu) {
                    siblingSubmenu.classList.remove('open');
                }

                if (siblingArrow) {
                    siblingArrow.classList.remove('open');
                }
            });

            item.classList.toggle('open', isOpening);
            submenu.classList.toggle('open', isOpening);
            this.classList.toggle('open', isOpening);
        });

        arrow.dataset.mobileBound = 'true';
    })
}

export {mobilesubnav};