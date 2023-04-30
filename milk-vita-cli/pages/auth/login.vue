<template>
<div class="login-wrapper">
    <form @submit.prevent="login" class="login-form">
        <div class="card p-5" style="background:#fff;width: 395px;">
            <div class="card-header" style="background:#fff!important">
                <div class="d-flex justify-content-between align-items-center">
                    <img src="~/assets/images/milkvita-logo.png" class="p-2" srcset="" />
                    <div class="p-2 c-name"> বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় <br /> ইউনিয়ন লিমিটেড(মিল্কভিটা) </div>
                </div>
            </div>

            <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                <label class="btn btn-outline-primary active">
                    <input type="radio" name="options" id="option1" checked /> এডমিন
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="options" id="option2" /> দপ্তর
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="options" id="option3" /> সমবায়
                </label>
            </div>

            <div class="form-group">
                <label for="username" class="m-0">ইউজার আইডি</label>
                <input type="text" class="form-control" placeholder="Enter Your Username" v-model="credentials.username" />
            </div>

            <div class="form-group">
                <label for="password" class="m-0">পাসওয়ার্ড</label>
                <span class="password-field">
                    <input :type="password_type=='private' ? 'password' : 'text'" class="form-control" placeholder="Enter Your Password" v-model="credentials.password" />
                    <i :class="(password_type=='private' ? 'fa fa-eye' : 'fa fa-eye-slash')" @click="(password_type = (password_type=='private' ? 'public' : 'private'))"></i>
                </span>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <span v-if="!is_submit">লগইন করুন </span>
                    <i v-if="is_submit" class="fa fa-spinner fa-spin fa-fw"></i>
                    <span v-if="is_submit">লগইন হচ্ছে... </span>
                </button>
            </div>
        </div>
    </form>
</div>
</template>

<script>
export default {
    middleware: "admin-auth",
    layout: "loginLayout",
    data() {
        return {
            is_submit: false,
            credentials: {
                username: "01983667657",
                password: "12345678",
            },
            password_type:'private',
            err_msg: "",
        };
    },
    methods: {
        login: function () {
            this.err_msg   = "";
            this.is_submit = true;
            //
            this.$auth.loginWith('local', {
                data: this.credentials
            })
            .then(res=>{
                this.$nextTick(() => {
                    this.$nuxt.$loading.finish();
                });

                if(res.data.errors && res.status==200) {
                    this.is_submit = false;
                    this.$alert({
                        icon:'error',
                        text:'অনুগ্রহ করে আপনার ইউজারনেইম এবং পাসওয়ার্ড চেক করুন'
                    });
                } 
                else if(res.status==200){
                    this.$store.state.loggedIn = true;
                    this.$router.push({ path: "/user/dashboard" });
                }
            });
        },
    },
};
</script>

<style scoped>
    @import url("~/assets/css/login.css");
</style>