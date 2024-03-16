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
                searchPlaceholder: "search users",
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

function sendAjaxRequest(setup) {
    const url = (setup.hasOwnProperty('url') ? setup.url : window.location.href);
    const body = setup.hasOwnProperty('formEl') ? (new FormData(setup.formEl)) : JSON.stringify(setup.data);
    const csrfToken = setup.token;
    // const body = setup.hasOwnProperty('body') ? setup.body : null;
    const method = (setup.hasOwnProperty('method') ? setup.method : 'POST').toUpperCase();
    const headers = {
        //'Content-Type': 'application/json',// or else $request->all() is empty array
        // 'Accept': 'application/json', // ($request->expectsJson())
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken
    };
    let hasError = false;
    fetch(url, {
        method,
        headers,
        body
    }).then((response) => {
        if (!response.ok) {
            hasError = true;
        }
        return response.json();
    }).then(function(data) {
        if (hasError) {
            setup.hasOwnProperty('error') ? setup.error(data) : console.log(data);
        }else{
            setup.hasOwnProperty('success') ? setup.success(data) : console.log(data);
        }
    });
}