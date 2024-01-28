document.addEventListener("DOMContentLoaded", function() {});
toastr.options.timeOut = 0;
toastr.options.extendedTimeOut = 0;

function success(msg = 'Success') {
    toastr.success(msg);
}

function error(msg = 'Error') {
    toastr.error(msg);
}

function info(msg = 'Info') {
    toastr.info(msg);
}
/*----------  Datatable  ----------*/
function loadAfterDtTblLoaded() {
    const DT_DELETE = document.querySelectorAll('.dt-delete')
    if (DT_DELETE.length > 0) {
        const DT_DELETE_CLASSES = DT_DELETE.forEach(function(el, index) {
            el.addEventListener('click', (e) => {
                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.parentNode.submit();
                    }
                });
            });
        });
    }
    const DT_RESTORE = document.querySelectorAll('.dt-restore');
    if (DT_RESTORE.length > 0) {
        DT_RESTORE.forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.parentNode.submit();
                    }
                });
            });
        });
    }
}

class dt {
    constructor(obj) {
        this.id = '.' + (obj.hasOwnProperty('table_class') ? obj.table_class : 'datatable');
        this.url = obj.hasOwnProperty('url') ? obj.url : window.location.href;
        this.cols = obj.columns;
        this.init();
    }
    init(funcCalls = null) {
        console.log([this.id, this.url, this.cols]);
        $(this.id).DataTable({
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, "All"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: this.url,
                type: "GET"
            },
            drawCallback: function() {
                loadAfterDtTblLoaded();
            },
            columns: this.cols,
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "search users",
            }
        });
    }
}

function sendAjaxRequest(setup) {
    const url = setup.url;
    const csrfToken = setup.token;
    const body = setup.hasOwnProperty('body') ? setup.body : null;
    const method = setup.hasOwnProperty('method') ? setup.method : 'POST';
    const headers = {
        //'Content-Type': 'application/json',
        // 'Accept': 'application/json', // ($request->expectsJson())
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken
    };
    fetch(url, {
        method,
        headers,
        body
    }).then(response => response.json()).then(function(data) {
        setup.hasOwnProperty('success') ? setup.success() : console.log(data);
    }).catch(function(error) {
        setup.hasOwnProperty('error') ? setup.error() : console.log(error);
    });
}