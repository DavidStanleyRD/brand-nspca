// Navigation
function stickyHeader() {
	document.addEventListener('scroll', function() {
		const header = document.querySelector('header');
		const scrollPos = window.pageYOffset;
		
		if(scrollPos > 100) {
			header.classList.add('scrolled');
		} else {
			header.classList.remove('scrolled');
		}
	})
}

export {stickyHeader};