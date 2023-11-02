<template>
    <div v-show="this.msg != null" class="alert alert-primary" role="alert">
        Добавлена новая статья <strong>{{this.msg}}</strong>
    </div>
</template>
<script>
    export default {
    data() { return { msg: null } },
        created() {
            window.Echo.channel('test').listen('EventNewArticle', (name) => {
                console.log(name.article.title);
                this.msg=name.article.title;
                // alert('Добавлена новая статья!');
            })
        }
    }
</script>