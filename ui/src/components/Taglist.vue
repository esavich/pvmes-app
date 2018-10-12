<template>
    <div class="taglist">
        <span class="tag badge badge-warning" v-for="tag in tags" v-bind:key="tag._id">
            {{tag._id}} ({{tag.count}})
        </span>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "Taglist",
        data() {
            return {
                tags: [],
                loaded: false
            }
        },
        created() {
            this.loadTags();
        },
        methods: {
            loadTags() {
                let vm = this;
                let url = '/api/tags/';

                vm.loaded = false;

                axios.get(url)
                    .then(function (response) {
                        vm.loaded = true;
                        vm.tags = response.data.tags;

                    });
            }
        }
    }
</script>

<style>

</style>