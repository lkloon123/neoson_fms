import swal from 'sweetalert2';

export default function (Vue) {
    Vue.SweetAlert = {
        //default for customization
        swal: swal,

        cfmDialog(message, okCallback, cancelCallback) {
            swal({
                title: 'Confirmation',
                text: message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    if (okCallback) {
                        okCallback();
                    }
                } else {
                    if (cancelCallback) {
                        cancelCallback();
                    }
                }
            });
        },

        basicDialog(message, type = 'success', callback) {
            swal({
                text: message,
                type: type,
                focusConfirm: true
            }).then((result) => {
                if (callback) {
                    callback(result);
                }
            });
        }
    };

    Object.defineProperties(Vue.prototype, {
        $SweetAlertPlugin: {
            get() {
                return Vue.SweetAlert;
            }
        }
    })
}