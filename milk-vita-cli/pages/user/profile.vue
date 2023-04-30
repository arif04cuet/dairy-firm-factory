<template>
    <div class="card">
        <div class="card-body min85vh">
            <div class="profile-env">
                <div class="d-flex align-items-end">
                    <div class="img">
                        <img :src="(user ? ($store.state.host_server+($auth.user.photo_path ? $auth.user.photo_path :'images/user.jpg')):'')" class="img-responsive img-circle">
                        <input type="file" class="profile_pic_file" @change="onChangeProfile">
                        <label for="">
                            <i v-if="is_uploading" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <i v-else style="font-size: 40px;" class="fa fa-upload" aria-hidden="true"></i>
                        </label>
                    </div>
                    
                    <div class="">
                        <h4 style="color: #337ab7;" class="m-0">{{(user ? $auth.user.name_bn : '')}}</h4>
                        <p>{{user.role_name}}</p>
                        
                        <div class="action-btn" ref="btns">
                            <button @click="tabChange('personal_info', 1)" class="active"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;ব্যাক্তিগত তথ্যাদি</button>
                            <button @click="tabChange('forgot_password', 2)"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;পাসওয়ার্ড পরিবর্তন</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pt-0">
                    <hr class="mt-0" style="border-top: 1px solid #ddd;">
                    <personal-info v-if="niddle=='personal_info'"></personal-info>
                    <forgot-password v-if="niddle=='forgot_password'"></forgot-password>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ForgotPassword from '@/components/user/ForgotPassword.vue';
import PersonalInfo from '@/components/user/UpdatePersonalInfo.vue';
export default {
    name:"profile",
    layout: 'admin',
    components:{
        'forgot-password':ForgotPassword,
        'personal-info':PersonalInfo
    },
    data(){
        return {
            niddle:'personal_info',
            user:'',
            is_uploading:false,
        }
    },
    mounted(){
        this.user = this.$store.state.auth.user;
    },
    methods:{
        onChangeProfile(event){
            this.is_uploading = true;
            //
            var file = event.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.addEventListener('load', (event) => {
                    this.$axios.post('user/update/'+this.user.id, {
                        'photo':event.target.result
                    })
                    .then(res=>{
                        if(!res.data.errors){
                            this.is_uploading = false;
                            this.$auth.$storage.setUniversal('user', res.data, true);
                            this.$toastr.s('সফলভাবে আপনার প্রোফাইলের ছবি পরিবর্তন হয়েছে');
                        }
                    });
                });
                reader.readAsDataURL(file);
            }
        },
        tabChange(niddle='personal_info', index=1){
            var btns = this.$refs.btns.children;
            Object.values(btns).forEach(btn=>{
                btn.classList.remove('active');
            });
            if(btns[(index-1)]) btns[(index-1)].classList.add('active');
            this.niddle = niddle;
        }
    }
}
</script>

<style scoped>
    .profile-env h4 {
        font-weight: 600;
    }
    .profile-env .img {
        width: 117px;
        height: 117px;
        overflow: hidden;
        border: 3px solid #ddd;
        border-radius: 50%;
        margin: 15px;
        margin-left: 30px;
        position: relative;
        cursor: pointer;
    }
    .profile-env .img label {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #00000045;
        color: #fff;
        opacity: 0.5;
        transition: all 0.5s linear;
    }
    .profile-env .img:hover label {
        opacity: 1;
    }
    .profile_pic_file {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 12;
        cursor: pointer;
    }
    .profile-env .img img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .card-log {
        margin: 0 auto;
    }
    .action-btn {
        margin-bottom: -1px;
        display: flex;
    }
    .action-btn button {
        margin: 0;
        border: 1px solid #ddd;
        color : #878787;
        background: #fff;
        padding: 3px 12px;
        font-size: 14px;
        z-index: 99;
    }
    .action-btn button + button {
        margin-left: -1px;
    }
    .action-btn button.active {
        border-bottom: #fff;
        color: #545454;
        font-weight: 600;
    }
    .action-btn button:first-child{
        border-radius: 4px 0 0 0;
    }
    .action-btn button:last-child{
        border-radius: 0 4px 0 0;
    }
</style>