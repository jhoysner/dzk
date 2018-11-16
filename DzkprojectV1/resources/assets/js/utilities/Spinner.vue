<template>
	<div id="loading">
    Cargando...</div>
</template>
<script>
   export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style>
  body {
    margin: 0;
  }
  #loading {
    background-color: #63ab97;
    color: white;
    font-size: 32px;
    padding-top: 10vh;
    height: 100vh;
    text-align: center;
  }
</style>