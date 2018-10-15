<template>
    <div class="comments">
        <div class="comments__item comment media" v-for="comment in comments" v-bind:key="comment._id">
            <img class="mr-3" v-bind:src="comment.gravatarUri" alt="Generic placeholder image">
            <div class="media-body">
                <header class="comment__header">
                    by: {{comment.name}} @ {{ new Date(comment.date).toLocaleString("ru")}}
                </header>
                <div class="comment__body" v-html="comment.comment">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CommentsList",
        props: ['comments']
    }
</script>

<style>

</style>