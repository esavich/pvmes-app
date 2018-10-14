<template>
    <form method="post" @submit.prevent="validate">
        <h3>Add your comment to post «{{post.title}}»</h3>
        <div class="alert alert-success" v-if="successSended">
            Comment added
        </div>
        <div class="form-group">
            <label for="name">Enter your name</label>
            <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Your name"
                    v-model="name"
                    name="name"
                    v-validate="'required'"
                    v-bind:class="{'is-invalid': errors.has('name')}"
            >
            <div class="invalid-feedback">
                Please enter your name.
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Email"
                    v-model="email"
                    name="email"
                    v-validate="'required|email'"
                    v-bind:class="{'is-invalid': errors.has('email')}"
            >
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="invalid-feedback">
                Please provide a valid email.
            </div>
        </div>
        <div class="form-group">
            <label for="comment">Enter comment</label>
            <textarea
                    class="form-control"
                    id="comment"
                    rows="3"
                    placeholder="Comment"
                    v-model="comment"
                    name="comment"
                    v-validate="'required|min:10'"
                    v-bind:class="{'is-invalid': errors.has('comment')}"
            >
            </textarea>
            <div class="invalid-feedback">
                {{ errors.first('comment') }}
            </div>
        </div>
        <button type="submit" class="btn btn-primary" v-bind:disabled="isSending">Submit</button>
    </form>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "CommentForm",
        props: [
            'post'
        ],
        data() {
            return {
                name: '',
                email: '',
                comment: '',
                isSending: false,
                successSended: false
            }
        },
        methods: {
            validate() {
                var vm = this;
                this.$validator.validateAll().then(function (result) {
                    if (result) {
                        vm.isSending = true;
                        axios.post('/api/comments/', {
                            name: vm.name,
                            email: vm.email,
                            comment: vm.comment,
                            postId: vm.post._id

                        }).then(function (response) {
                            if (response.data.status == 'success') {
                                vm.isSending = false;
                                vm.$emit('added');
                                vm.reset();
                                vm.blinkSuccess();
                            }
                        }).catch(function (/*error*/) {
                            vm.isSending = false;
                        });
                    }
                });
            },
            reset() {
                this.name = null;
                this.email = null;
                this.comment = null;
                this.$validator.reset();
            },
            blinkSuccess() {
                this.successSended = true;
                setTimeout(() => {
                    this.successSended = false;
                }, 2000);
            }
        }
    }
</script>

<style lang="scss">

</style>