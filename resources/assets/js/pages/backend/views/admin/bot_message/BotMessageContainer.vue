<template>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Send Message From Bot</h3>
                </div>
                <div class="box-body">
                    <div class="form-group has-feedback" :class="{ 'has-error': errors.has('Message') }">
                        <label for="message_box">Message</label><br/>
                        <textarea rows="10"
                                  name="Message"
                                  id="message_box"
                                  v-model="message"
                                  v-validate="'required'"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" value="all" v-model="type">
                            All
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="fb" v-model="type">
                            Facebook
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="tele" v-model="type">
                            Telegram
                        </label>
                    </div>

                    <div class="form-group" v-if="type !== 'all'">
                        <label for="select_user">User List (leave empty for all)</label>
                        <multi-select id="select_user"
                                      v-model="selectedUserList"
                                      :multiple="true"
                                      :options="userListOptions"
                                      track-by="id"
                                      label="name"
                                      :searchable="true"
                                      group-values="data"
                                      group-label="selectAll"
                                      :group-select="true"></multi-select>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary" @click="handleSubmit" :disabled="isSending">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    export default {
        data: () => ({
            message: '',
            type: 'all',
            isSending: false,
            userList: [],
            selectedUserList: []
        }),
        computed: {
            userListOptions() {
                return [{
                    selectAll: 'Select All',
                    data: this.userList
                }]
            },
        },
        methods: {
            fetchUserList() {
                axios.get(baseUrl + 'user')
                    .then(response => {
                        this.userList = response.data;
                    })
                    .catch(error => {
                        this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                    });
            },
            handleSubmit(event) {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        this.$SpinnerPlugin.showSpinner(event.target);
                        this.isSending = true;

                        let postData = {
                            type: this.type,
                            message: this.message
                        };

                        if (!_.isEmpty(this.selectedUserList)) {
                            postData.target = this.selectedUserList.map(user => user.id);
                        }

                        axios.post(baseUrl + 'modules/bot/message', postData)
                            .then(response => {
                                this.$SweetAlertPlugin.basicDialog(response.data.msg);
                            })
                            .catch(error => {
                                this.$SweetAlertPlugin.basicDialog(error.message, 'error');
                            })
                            .finally(() => {
                                this.$SpinnerPlugin.hideSpinner();
                                this.isSending = false;
                            });
                    } else {
                        this.$SweetAlertPlugin.basicDialog(this.errors.all()[0], 'error');
                    }
                });
            }
        },
        components: {
            MultiSelect
        },
        created() {
            this.fetchUserList();
        }
    }
</script>

<style scoped>
    textarea {
        width: 100%;
        resize: none;
    }
</style>