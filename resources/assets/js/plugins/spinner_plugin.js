export default function (Vue) {
    Vue.Spinner = {
        showSpinner(target) {
            if ($(target)[0].tagName === 'BUTTON') {
                window.tempButtonText = $(target).text();
                window.tempButton = $(target);
                $(target).html('<i class="fa fa-spinner fa-lg fa-spin"></i>');
            }
        },

        hideSpinner(buttonText = null, buttonRawHtml = null) {
            if (window.tempButton !== undefined) {
                if (buttonText != null) {
                    window.tempButton.text(buttonText);
                } else if (buttonRawHtml != null) {
                    window.tempButton.html(buttonRawHtml);
                } else {
                    window.tempButton.text(window.tempButtonText);
                }
                this.clearSpinner();
            }
        },

        clearSpinner() {
            window.tempButton = undefined;
            window.tempButtonText = undefined;
        }
    };

    Object.defineProperties(Vue.prototype, {
        $SpinnerPlugin: {
            get() {
                return Vue.Spinner;
            }
        }
    })
}