document.addEventListener('DOMContentLoaded', function() {
    fetchAndDisplayBugs();

    const searchForm = document.getElementById('searchForm');
    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const searchParams = new URLSearchParams(formData).toString();
        fetchAndDisplayBugs('?' + searchParams);
    });
});

function fetchAndDisplayBugs(query = '') {
        fetch('fetch_bugs.php' + query)
        .then(response => response.json())
        .then(bugs => {
            const bugList = document.getElementById('bugList');
            bugList.innerHTML = '';

            if (!Array.isArray(bugs) || bugs.length === 0) {
                bugList.innerHTML = '<li>No bugs found according to given criteria.</li>';
            } 
            else 
            {
                bugs.forEach(bug => {
                    const bugItem = document.createElement('li');
                    bugItem.innerHTML = `
                        <div><strong>Report ID:</strong> ${bug.report_id}</div>
                        <div><strong>Program:</strong> ${bug.program}</div>
                        <div><strong>Severity:</strong> ${bug.severity}</div>
                        <div><strong>Problem Summary:</strong> ${bug.problem_summary}</div>
                    `;
                    bugItem.classList.add('bug-item');
                    bugItem.addEventListener('click', function() {
                        window.location.href = 'view_bug.php?report_id=' + bug.report_id;
                    });
                    bugList.appendChild(bugItem);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching bugs:', error);
            bugList.innerHTML = '<li>Error loading bugs.</li>';
        });
}
