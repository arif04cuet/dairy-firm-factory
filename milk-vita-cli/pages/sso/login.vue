<template></template>
<script>
    export default {
        layout:'empty',
        mounted(){
			this.$nextTick(() => {
				this.$nuxt.$loading.start();
			})
            if(this.$route.query.token)
               this.userLogin();
        },
        methods:{
            async userLogin()
            {
                try {
                    this.$axios.post('login', {token:this.$route.query.token})
                    .then(response=>{
                        if(!response.data.errors){
                            let token = 'Bearer ' + response.data;
                            this.$auth.strategy.token.set(token);
                            this.$auth.strategy.token.sync();
                            //
                            this.$auth.fetchUser().then((response)=>{
                                if(response.status==200)
                                    this.$router.push({ path: "/user/dashboard" });
                            });
                        }
                        else 
                            window.location.href = process.env.DASHBOARD_URL+'admin/login?error=User not valid for milkvita !';
                    });
                } 
                catch (err){
                    window.location.href = process.env.DASHBOARD_URL+'admin/login?error=Something is wrong !';
                }
            }
        }
    }
</script>

