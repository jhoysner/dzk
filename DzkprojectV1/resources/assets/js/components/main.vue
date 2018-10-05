<template>
	<div>
		<div class="content">
			<router-view></router-view>
		</div>
	</div>
</template>

<script>
import header from './layouts/header.vue';

export default {
	mounted() {
	 console.log('Component mounted.')
	 }
}
</script>