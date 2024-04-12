function deleteBug(reportId) {
    if(confirm('Are you sure you want to delete this bug?')) {
        fetch('delete_bugreport.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'report_id=' + reportId
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            document.getElementById('bug_' + reportId).remove(); // Remove the bug from the list
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the bug.');
        });
    }
}
