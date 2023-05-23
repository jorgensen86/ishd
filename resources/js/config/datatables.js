export default {
    processing: true,
    serverSide: true,
    pageLength: 10,
    lengthMenu: [10, 25, 50],
    dom: 'lfrtip',
    language: {
        lengthMenu: "Εμφάνιση _MENU_ εγγραφές ανά σελίδα",
        zeroRecords : "Δεν βρέθηκαν αποτελέσματα",
        info: "Εμφάνιση σελίδας _PAGE_ από _PAGES_ (Συνολικά από _TOTAL_ εγγραφές)",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        paginate: {
            next: '<i class="fas fa-angle-right"></i>',
            previous: '<i class="fas fa-angle-left"></i>'
        },
        search: "Ανζήτηση",
        processing:"<i class='fa fa-refresh fa-spin'></i>"
    }
}