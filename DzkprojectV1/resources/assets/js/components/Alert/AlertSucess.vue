<template>
    <div v-if="success.length">
        <ul>
            <li role="alert" v-for="tmp in success">
                <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  {{tmp}}
                </div>
            </li>
        </ul>
    </div>

</template>

<script>
    export default {
        props : ['success'],
        mounted() {
            console.log('Component mounted.')
            this.errores = this.errors
        }
    }
</script>