<template>
<div>
    <div>
      <!-- // -->
      <Nav />
      <!-- // -->
      <div class="container main-page-wrapper">
        <Nuxt />
      </div>
      <Footer />
    </div>
</div>
</template>

<script>
  export default {
		mounted() {
			this.$nextTick(() => {
				this.$nuxt.$loading.start();
				setTimeout(() => this.$nuxt.$loading.finish(), 500);
			})
		}
  }
</script>


<style scoped>
.main-page-wrapper {
  padding: 5px 0px;
  width: 100%!important;
}
</style>
