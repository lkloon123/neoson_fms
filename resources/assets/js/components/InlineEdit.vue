<template>
    <div class="row">
        <div class="col-md-8 col-xs-8 input-text">
            <input type="text"
                   v-model="editedText"
                   class="form-control input-sm"
                   :disabled="isSending"
                   @keyup.enter="handleSubmit"/>
        </div>
        <div class="col-md-4 col-xs-4 box-tools text-center btn-editable">
            <button class="btn btn-box-tool btn-danger btn-cancel" @click="handleCancel" :disabled="isSending">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
            <button class="btn btn-box-tool" @click="handleSubmit" :disabled="isSending">
                <i class="fa fa-check-circle fa-lg"></i>
            </button>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            textToEdit: {
                type: String,
                default: "",
            },
        },
        data: () => ({
            editedText: this.textToEdit,
            isSending: false
        }),
        methods: {
            handleSubmit(event) {
                this.isSending = true;
                this.$SpinnerPlugin.showSpinner(event.currentTarget);

                if (this.editedText.length === 0 || !this.editedText.trim()) {
                    this.$emit('inlineEditDone', {
                        result: false,
                        resultData: this.textToEdit,
                        errorMsg: 'Field Cannot Be Empty'
                    });
                } else if (this.editedText === this.textToEdit) {
                    this.$emit('inlineEditDone', {result: 'close', resultData: this.textToEdit});
                } else {
                    this.$emit('inlineEditDone', {result: true, resultData: this.editedText});
                }
            },
            handleCancel() {
                this.$emit('inlineEditDone', {result: 'close', resultData: this.textToEdit});
            }
        },
        mounted() {
            this.editedText = this.textToEdit;
        }
    }
</script>

<style scoped>
    .btn-editable {
        padding-left: 0;
    }

    .input-text {
        padding-top: 2px;
    }

    .btn-cancel:hover {
        background: #c9302c !important;
    }
</style>