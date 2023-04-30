<template>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="m-0"><i class="fa fa-user-plus" aria-hidden="true"></i> ব্যবহারকারী সম্পাদন করুন </h3>
        <div class="btn-group">
            <nuxt-link to="/user/access/all" class="btn btn-primary">
                <i class="fa fa-list"></i>
                তালিকায় ফিরে যান
            </nuxt-link>
        </div>
    </div>
    <!-- // -->

    <!-- 
        <system :edit_id="edit_id" v-if="niddle=='system'"></system>
        <chilling :edit_id="edit_id" v-if="niddle=='chilling'"></chilling>
        <proccessing :edit_id="edit_id" v-if="niddle=='processing'"></proccessing>
        <association :edit_id="edit_id" v-if="niddle=='association'"></association> 
    -->

    <general-user :edit_id="edit_id"></general-user>
    <!-- // -->
    <div class="card-footer">&nbsp;</div>
</div>
</template>

<script>
import system from '@/components/user/mk_access/ForAdmin.vue';
import association from '@/components/user/mk_access/ForAssociation.vue';
import proccessing from '@/components/user/mk_access/ForProcessingPlant.vue';
import chilling from '@/components/user/mk_access/ForChillingPlant.vue';
import GeneralUser from '@/components/user/mk_access/GeneralUser.vue';

    export default {
        layout:'admin',
        name:'AddAccess',
        components:{
            'system'        : system,
            'association'   : association,
            'proccessing'   : proccessing,
            'chilling'      : chilling,
            'general-user'  : GeneralUser,
        },
        data(){
            return {
                edit_id : '',
                niddle  : '',
            }
        },
        mounted(){
            this.edit_id = this.$route.query.id;
        },
        methods:{
           
        },
        watch:{
            edit_id(){
                this.$axios.post('user/all', {
                    where:{id:this.edit_id}
                }).then(res=>{
                    var user = res.data.data[0];
                    if(user){
                        if(user.chilling_plant_id==0 && user.association_id==0 && user.processing_plant_id==0){
                            this.niddle = 'system';
                        }
                        else if(user.chilling_plant_id!=0){
                            this.niddle = 'chilling';
                        }
                        else if(user.processing_plant_id!=0){
                            this.niddle = 'processing';
                        }
                    }
                });
            },
        }
    }
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
    .img-wrapper {
        width: 100%;
        overflow: hidden;
        box-sizing: border-box;
        padding: 7px;
        border:1px solid #ddd;
    }
    .img-wrapper img{
        width: 100%;
    }
    .choose {
        width: 100%;
        height: 30px;
        background: #ddd;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .choose input[type='file'], .choose span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        opacity: 0;
        cursor: pointer;
    }
    .choose span {
        z-index: 998;
        opacity: 1;
        border: 1px solid #ddd;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
</style>
