function search() {
    const trigger    = document.querySelector('.search-icon');
    const modal      = document.querySelector('.search-modal');
    const input      = document.querySelector('#live-search-input');
    const results    = document.querySelector('#live-search-results');
    const background = document.querySelector('.search-modal__background');

    if (!trigger || !modal) return;

    trigger.addEventListener('click', () => {
        modal.classList.add('open');
        setTimeout(() => {
            if (input) {
                input.focus();
                if (!input.value.trim()) showRecommended();
            }
        }, 300);
    });

    background.addEventListener('click', () => modal.classList.remove('open'));

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') modal.classList.remove('open');
    });

    if (!input || !results) return;

    let debounceTimer;

    input.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        const query = input.value.trim();

        if (query.length < 2) {
            showRecommended();
            return;
        }

        debounceTimer = setTimeout(() => fetchResults(query), 350);
    });

    function renderResults(items, heading) {
        const headingHtml = heading
            ? `<p class="search-results-heading">${heading}</p>`
            : '';
        results.innerHTML = headingHtml + items.map(r => `
            <a href="${r.url}" class="result">
                <span class="result-type">${r.type}</span>
                <h3>${r.title}</h3>
                ${r.excerpt ? `<p>${r.excerpt}</p>` : ''}
            </a>
        `).join('');
    }

    function showRecommended() {
        const pages = (typeof themeSearch !== 'undefined' && themeSearch.recommended) || [];
        if (!pages.length) {
            results.innerHTML = '';
            return;
        }
        renderResults(pages, 'Suggested pages');
    }

    function fetchResults(query) {
        results.innerHTML = '<p class="search-status">Searching&hellip;</p>';

        const data = new FormData();
        data.append('action', 'live_search');
        data.append('nonce', themeSearch.nonce);
        data.append('query', query);

        fetch(themeSearch.ajaxUrl, { method: 'POST', body: data })
            .then(res => res.json())
            .then(json => {
                if (!json.success || !json.data.results.length) {
                    results.innerHTML = `<p class="search-status">No results found for <strong>${query}</strong></p>`;
                    return;
                }
                renderResults(json.data.results, null);
            })
            .catch(() => {
                results.innerHTML = '<p class="search-status">Something went wrong. Please try again.</p>';
            });
    }
}

export { search };
