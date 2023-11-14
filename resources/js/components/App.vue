<template>
    <div v-show="this.article != null" class="alert alert-primary" role="alert">
        Добавлен новый комментарий к статье <strong><a :href="`/article/${this.article.id}/`">{{this.article.name}}</a></strong>
    </div>
    </template>
    <script>
        export default {
        data() { return { 
            article: null,
         } },
            created() {
                window.Echo.channel('test').listen('EventNewComment', (data) => {
                    // console.log(name);
                    this.article=data.article;
                    // alert('Добавлена новая статья!');
                })
            }
        }
    </script>