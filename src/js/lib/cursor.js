import {throttle} from './throttle';

function cursor(elements) {
  elements.forEach(function (element) {

    element.addEventListener(
      'mousemove',
      throttle(function (event) {
        const rect = element.getBoundingClientRect();
        const cursorX = event.clientX - rect.left;
        const cursorY = event.clientY - rect.top;

        let tooltip = document.querySelectorAll('.tooltip');

        tooltip.forEach( tag => {
          tag.style.left = cursorX + 'px';
          tag.style.top = cursorY + 'px';
        })
      }, 25) // Adjust the delay (in milliseconds) to control the frequency of updates
    );
  });
}

export {cursor};