<script>
    // Set the workerSrc for PDF.js to avoid the deprecated warning
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

    // Get the Base64 PDF string from PHP (passed via a variable)
    const base64PDF = "<?php echo $pdfBase64Encoded; ?>";
    const isBase64PDF = true; // We are using Base64 here
    let url;

    if (isBase64PDF) {
        url = base64PDF;
    } else {
        url = '';  // Fallback to file path if needed
    }

    let pdfDoc = null;
    const scale = 1.5; // Scaling factor for PDF pages
    const canvasContainer = document.querySelector('#pdf-container'); // Container where PDF pages will be rendered
    const searchInput = document.querySelector('#search-input');

    let pageText = []; // Array to store text content for each page
    let searchResults = [];
    let currentSearchIndex = 0;

    // Function to render a single page
    const renderPage = (num) => {
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });

            // Create a wrapper div for the canvas (no scroll on individual pages)
            const pageWrapper = document.createElement('div');
            pageWrapper.classList.add('pdf-page-wrapper');
            pageWrapper.setAttribute('id', `page-${num}`);
            canvasContainer.appendChild(pageWrapper);

            // Create a new canvas for each page
            const canvas = document.createElement('canvas');
            pageWrapper.appendChild(canvas);
            const ctx = canvas.getContext('2d');

            // Set canvas size based on page viewport
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderCtx = {
                canvasContext: ctx,
                viewport
            };

            // Render the page and handle the callback when rendering is complete
            page.render(renderCtx).promise.then(() => {
                // Automatically render the next page if available
                if (num < pdfDoc.numPages) {
                    renderPage(num + 1);
                }
            });

            // Render the text layer (for searching)
            page.getTextContent().then(textContent => {
                pageText[num - 1] = textContent; // Store the text content for later search
            });
        }).catch(err => {
            console.error("Error rendering page", err);
        });
    };

    // Function to perform the search
    const searchPDF = () => {
        const searchTerm = searchInput.value.trim().toLowerCase();
        if (!searchTerm) {
            clearSearchHighlights(); // Clear highlights if search is empty
            return;
        }

        // Reset search results
        searchResults = [];
        currentSearchIndex = 0;

        // Loop through all pages and search for the term
        pageText.forEach((textContent, pageNum) => {
            const pageTextStr = textContent.items.map(item => item.str).join(' ').toLowerCase();
            const matches = pageTextStr.match(new RegExp(searchTerm, 'g'));

            if (matches) {
                searchResults.push({ pageNum: pageNum + 1, matches });
            }
        });

        // Handle no search results
        if (searchResults.length === 0) {
            alert('No results found.');
            return;
        }

        // Highlight first match
        highlightSearchResults();
    };

    // Function to highlight search results
    const highlightSearchResults = () => {
        if (searchResults.length === 0) return;

        const currentResult = searchResults[currentSearchIndex];
        const pageWrapper = document.querySelector(`#page-${currentResult.pageNum}`);
        const textLayer = pageWrapper.querySelector('.text-layer');

        // Loop through the text items and highlight the search term
        currentResult.matches.forEach(match => {
            const regex = new RegExp(match, 'gi');
            textLayer.querySelectorAll('span').forEach(span => {
                if (span.textContent.match(regex)) {
                    span.style.backgroundColor = 'yellow'; // Highlight color
                }
            });
        });
    };

    // Function to clear previous search highlights
    const clearSearchHighlights = () => {
        const highlightedSpans = document.querySelectorAll('.text-layer span');
        highlightedSpans.forEach(span => {
            span.style.backgroundColor = ''; // Reset highlight
        });
    };

    // Event listener for search input (automatically triggers search as the user types)
    searchInput.addEventListener('input', () => {
        searchPDF(); // Trigger search as the user types
    });

    // Function to load and render the PDF
    window.onload = function() {
        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            renderPage(1); // Start rendering from page 1
        }).catch(err => {
            console.error('Error loading PDF:', err);
            const div = document.createElement('div');
            div.className = 'error';
            div.appendChild(document.createTextNode(err.message));
            document.querySelector('body').appendChild(div);
        });
    };
</script>
