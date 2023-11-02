<template>
    <div v-show="this.msg != null" class="alert alert-primary" role="alert">
        Добавлена новая статья <strong><a href="article/this.id">{{this.msg}}</a></strong>
    </div>
</template>
<script>
    export default {
    data() { return { msg: null, id: null} },
        created() {
            window.Echo.channel('test').listen('EventNewArticle', (name) => {
                console.log(name.article.title);
                this.msg=name.article.title;
                this.id=name.article.id;
                // alert('Добавлена новая статья!');
            })
        }
    }
</script>