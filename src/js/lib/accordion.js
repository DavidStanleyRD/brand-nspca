function accordion() {
	const headers = document.getElementsByClassName("accordion-toggle"),
      contents = document.getElementsByClassName("accordion-content"),
      icons = document.getElementsByClassName('plus');

	 for (let i = 0; i < headers.length; i++) {
	    headers[i].addEventListener("click", () => {

	        for (let j = 0; j < contents.length; j++) {
	            if (i == j) {
	                icons[j].classList.toggle("rotate");
	                contents[j].classList.toggle("content-transition");
	            } 
	        }

	    });
	}
}

export {accordion};