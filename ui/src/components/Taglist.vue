<template>
    <div class="taglist">
        <router-link
                v-bind:to="{name: 'tagged', params: {tag: tag._id}}"
                class="tag badge badge-warning"
                v-for="tag in tags"
                v-bind:key="tag._id"
        >
            {{tag._id}} ({{tag.count}})
        </router-link>
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