<template>
    <div class="app">
        <Nav v-if="client" />
        <div class="app-body">
            <AdminAside />
            <div class="app-contents">
                <Nuxt v-if="isValidUri" />
                <div v-else class="access-denied">
                    <span>Access Denied</span>
                </div>
                <!-- // -->
                <Footer />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'admin',
    middleware:['admin-auth'],
    data(){
        return {
            user:{},
            client:false,
            loader:true,
        }
    },
    mounted(){
        this.client = process.client;
        this.$toastr.defaultStyle   = { "margin-top": "70px" };
        this.$toastr.defaultTimeout = "2000";
        this.user = this.$store.state.auth.user;
        //
        this.$nextTick(() => {
            this.$nuxt.$loading.start();
            setTimeout(() => this.$nuxt.$loading.finish(), 500);
        })
    },
    computed:{
        isValidUri:function(){
            return this.$store.state.isValidUri;
        }
    },
}
</script>

<style scoped>
    @import url("~/assets/css/master.css");
    .access-denied {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 43px;
        color: #626262;
    }
</style>