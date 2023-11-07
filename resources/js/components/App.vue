<template>
    <div v-show="this.msg != null" class="alert alert-primary" role="alert">
        Добавлена новая статья <strong>{{this.msg}}</strong>
    </div>
    </template>
    <script>
        export default {
        data() { return { msg: null } },
            created() {
                window.Echo.channel('test').listen('EventNewComment', (name) => {
                    console.log(name);
                    this.msg=name.name;
                    // alert('Добавлена новая статья!');
                })
            }
        }
    </script>