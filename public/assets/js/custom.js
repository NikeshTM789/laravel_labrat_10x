document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('#logout').addEventListener('click', function(e) {
        if (confirm('logout?')) {
            e.target.parentElement.nextElementSibling.submit();
        }
    });
});

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
        this.callback = obj.hasOwnProperty('callback') ? obj.callback : [];
        this.cols = obj.columns;
        return this.init();
    }
    init(funcCalls = null) {
        const _this = this;
        return $(this.id).DataTable({
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
                _this.callback.forEach((CB) => CB(this));
            },
            columns: this.cols,
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search",
            }
        });
    }
}


/*----------  Dropzone  ----------*/
class dz{
    constructor(obj){
        Dropzone.autoDiscover = false;
        let preloadedFiles = (obj.hasOwnProperty('preloaded_files') ? obj.preloaded_files : []);
        this.configs = {
            headers: {
                'X-CSRF-TOKEN': obj.csrf_token
            },
            parallelUploads: 1,
            uploadMultiple: (obj.hasOwnProperty('upload_multiple') ? obj.upload_multiple : false),
            maxFilesize: (obj.hasOwnProperty('max_size') ? obj.max_size : 1572864),
            maxFiles: (obj.hasOwnProperty('max_files') ? obj.max_files : 1),
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictRemoveFileConfirmation: 'delete',
            init:function(){
                  var myDropzone = this
                    preloadedFiles.forEach((media) =>{
                      var mockFile = {
                        id: media.id,
                        name: media.name,
                        size: media.size
                      };
                      console.log(mockFile);
                      myDropzone.files.push(mockFile);
                      myDropzone.displayExistingFile(mockFile, media.url, null, '*');
                    });
                myDropzone.on('removedfile', (file) => {
                    console.log(file)
                    sendAjaxRequest({data:{id: file.id}, token: obj.csrf_token, method: 'DELETE', success: (msg)=> alert('success : '+msg), error: (msg) => alert('error : '+msg)})
                })
            }
        }
        this.form_id = 'form#'+obj.form_id;
        return this.init();
    }
    init(){
        const DZ = new Dropzone(this.form_id, this.configs);
        console.log(DZ);
    }
}

/*----------  Ajax  ----------*/
function ajax(ev, setup = {err:(msg) => alert(msg), ok:(msg) => alert(msg)}){
    ev.preventDefault();
    const btn = ev.target;
    const form = btn.closest('form');
    const csrf_token = form.querySelector('input[name="_token"]').value;
    const url = form.getAttribute('action');
    const method = form.getAttribute('method').toUpperCase();

    let form_data = new FormData(form);
    let entries = Object.fromEntries(form_data.entries());
    const body = JSON.stringify(entries);

    const headers = {
        'Content-Type': 'application/json',// is a header used in HTTP requests that tells the server what kind of data is being sent in the request body.
        'Accept': 'application/json', // header is used in an HTTP request to tell the server what type of data the client (like your browser or application) expects to receive in response.
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrf_token
    };

    btn.setAttribute('disabled',true);
    const btn_label = btn.innerHTML;
    // btn.innerHTML = ' <i class="fas fa-spinner fa-pulse"></i>';
    btn.innerHTML = '<i class="fas fa-sync fa-spin"></i>';
    fetch(url, {
        method,
        headers,
        body
    }).then((response) => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(errData => {
            console.log(errData);
            throw new Error(errData.message || 'An error occurred');
        });
    }).then(function(data) {
        setup.ok(data);
        btn.innerHTML = btn_label;
        btn.removeAttribute('disabled');
        (setup.hasOwnProperty('form_reset') && setup.form_reset) ? form.reset() : 0;
    }).catch(error => {
        setup.err(error);
        btn.innerHTML = btn_label;
        btn.removeAttribute('disabled');
    });
}