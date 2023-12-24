toastr.options.timeOut = 0;
toastr.options.extendedTimeOut = 0;

function success(msg = 'Success'){
      toastr.success(msg);
}

function error(msg = 'Error'){
      toastr.error(msg);
}

function info(msg = 'Info'){
      toastr.info(msg);
}