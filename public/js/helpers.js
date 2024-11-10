function getPhaseName(phase) {
    const listName = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh'];

    return listName[phase - 1];
}

function formatDateString(data) {
    const date = new Date(data); // replace with your date object
    let options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
    };

    // Convert the date to a formatted string
    let formattedDate = date.toLocaleString('id-ID', options);
    return formattedDate;
}
