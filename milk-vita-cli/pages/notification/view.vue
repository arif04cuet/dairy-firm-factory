<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2"><i class="fa fa-bell-o" aria-hidden="true"></i> নোটিফিকেশন</h4>
                <div class="btn-group">
                    <nuxt-link to="/notificaton/list" v-if="$ck_action('/notification/list')" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>

        <div class="card-body min75vh">
            <div>
                <h4 class="border-bottom">{{notification.title}}</h4>
                <p>
                    {{$en2bn(notification.body)}}
                </p>
            </div>

            <loader :loader="loader" />
        </div>

    </div>
</template>
<script>
import Loader from '~/components/Loader.vue';
    export default {
  components: { Loader },
        layout:'admin',
        name:'NotificationView',
        data(){
            return {
                kernel : {},
                loader : true,
                notification : {}
            }
        },
        mounted(){
            this.http('notification/view/'+this.$route.query.id, 'notification');
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='notification'){
                        this.loader = false;
                        this.notification = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>
