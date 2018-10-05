<template>
    <div v-if="errors.length">
        <ul>
            <li role="alert" v-for="error in errores">
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  {{error}}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props : ['errors'],
        mounted() {
            console.log('Component mounted.')
            this.errores = this.errors
        }
    }
</script>