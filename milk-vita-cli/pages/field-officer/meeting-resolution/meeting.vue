<template>
    <div class="card">
        <div class="card-body min85vh">
            <div class="profile-env">
                <div class="d-flex align-items-end">
                    <div class="">
                        <h4 style="color: #337ab7;" class="m-0 mb-4 mt-3">
                            <i class="fa fa-object-group" aria-hidden="true"></i>
                            মিটিং রেজোলিউশন - {{resolution.association_name}}
                        </h4>
                        
                        <div class="action-btn" ref="btns">
                            <button @click="tabChange('general_meeting', 1)" class="active"><i class="fa fa-gg" aria-hidden="true"></i>&nbsp;সাধারণ মিটিং</button>
                            <button @click="tabChange('for_manager_change', 2)"><i class="fa fa-gg" aria-hidden="true"></i></i>&nbsp;ম্যানেজার পরিবর্তন</button>
                            <button @click="tabChange('for_committee_change', 3)"><i class="fa fa-gg" aria-hidden="true"></i></i>&nbsp;কমিটি পরিবর্তন</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 pt-0">
                    <!-- // -->
                    <hr class="mt-0" style="border-top: 1px solid #ddd;">
                    <!-- // -->
                    <general-meeting  v-if="niddle=='general_meeting'"></general-meeting>
                    <manager-change   v-if="niddle=='for_manager_change'"></manager-change>
                    <committee-change v-if="niddle=='for_committee_change'"></committee-change>
                </div>

            </div>
        </div>

    </div>
</template>
<script>

import GeneralMeeting from '@/components/meetingResolution/GeneralMeeting.vue';
import ManagerChange from '@/components/meetingResolution/ManagerChange.vue';
import CommitteeChange from '@/components/meetingResolution/CommitteeChange.vue';

    export default {
        layout:'admin',
        name:'New',
        components:{
            'general-meeting'  : GeneralMeeting,
            'manager-change'   : ManagerChange,
            'committee-change' : CommitteeChange
        },
        data(){
            return {
                niddle:'general_meeting',
                resolution:{}
            }
        },
        mounted(){
            this.$axios.post('meeting-resolution/list',{where:{id:this.$route.query.id}})
            .then(res=>{
                if((res.data.data).length > 0){
                    this.resolution = res.data.data[0];
                }
            });
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            tabChange(niddle='general_meeting', index=1){
                var btns = this.$refs.btns.children;
                Object.values(btns).forEach(btn=>{
                    btn.classList.remove('active');
                });
                if(btns[(index-1)]) btns[(index-1)].classList.add('active');
                this.niddle = niddle;
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='designation-list'){
                        //
                    }
                }
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
