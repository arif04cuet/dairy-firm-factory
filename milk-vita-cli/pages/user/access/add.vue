<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="m-0">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                <span>ব্যবহারকারী তৈরি করুন</span>
            </h3>

            <div class="btn-group">
                <button class="btn btn-light" @click="clear" v-if="niddle!=''">
                    পূর্বাবস্থায় ফিরে যান
                </button>
                <nuxt-link to="/user/access/all" class="btn btn-primary">
                    <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                </nuxt-link>
            </div>
        </div>

        <div class="card-body min75vh position-relative" v-if="niddle==''">
            <div class="custom-btn-group">
                <button class="btn btn-primary mt-2" @click="goToAccess('system')"><i class="fa fa-user" aria-hidden="true"></i> সিস্টেমের জন্য ইউজার তৈরি করুন</button>
                <button class="btn btn-warning mt-2" @click="goToAccess('chilling')"><i class="fa fa-hdd-o" aria-hidden="true"></i> চিলিং প্ল্যান্ট জন্য ইউজার তৈরি করুন</button>
                <button class="btn btn-info mt-2" @click="goToAccess('proccessing')"><i class="fa fa-cogs" aria-hidden="true"></i> প্রসেসিং প্ল্যান্ট জন্য ইউজার তৈরি করুন</button>
                <!-- <button class="btn btn-success mt-2" @click="goToAccess('association')"><i class="fa fa-users"></i> এসোসিয়েশন জন্য ইউজার তৈরি করুন</button> -->
            </div>
        </div>
        
        <!-- ALL MODULES -->
        <system v-if="niddle=='system'"></system>
        <chilling v-if="niddle=='chilling'"></chilling>
        <proccessing v-if="niddle=='proccessing'"></proccessing>
        <association v-if="niddle=='association'"></association>

        <div class="card-footer">&nbsp;</div>

    </div>
</template>

<script>
import system from '@/components/user/mk_access/ForAdmin.vue';
import association from '@/components/user/mk_access/ForAssociation.vue';
import proccessing from '@/components/user/mk_access/ForProcessingPlant.vue';
import chilling from '@/components/user/mk_access/ForChillingPlant.vue';
export default {
    layout:'admin',
    name:'Add',
    components:{
        'system'        : system,
        'association'   : association,
        'proccessing'   : proccessing,
        'chilling'      : chilling,
    },
    data(){
        return {
            niddle : '',
        }
    },
    mounted(){
        
    },
    methods:{
        clear(){
            this.niddle = '';
        },
        goToAccess(niddle){
            this.niddle = niddle;
            // system
            // chilling
            // proccessing
            // association

        }
    }
}
</script>

<style scoped>
 .custom-btn-group {
    display: grid;
    position: absolute;
    top:50%;
    left: 50%;
    transform: translate(-50%, -59%);
 }
</style>