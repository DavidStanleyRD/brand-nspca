function copyToClipboard(event) {
    const el = event.currentTarget;
    let value = el.dataset.copy || '';

    // Strip leading # so hex values paste cleanly into Word etc.
    value = value.replace(/^#/, '');

    const tooltip = el.querySelector('.tooltip');

    const showCopied = () => {
        if (!tooltip) return;
        tooltip.textContent = 'Copied!';
        el.classList.add('is-copied');
        setTimeout(() => {
            tooltip.textContent = 'Click to copy';
            el.classList.remove('is-copied');
        }, 2000);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(value).then(showCopied);
    } else {
        // Fallback for non-HTTPS environments
        const tmp = document.createElement('textarea');
        tmp.value = value;
        tmp.style.cssText = 'position:fixed;top:-9999px;left:-9999px';
        document.body.appendChild(tmp);
        tmp.select();
        document.execCommand('copy');
        document.body.removeChild(tmp);
        showCopied();
    }
}

export { copyToClipboard };
