<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0 mt-2"><i class="fa fa-bell-o" aria-hidden="true"></i> সকল নোটিফিকেশন</h4>
                <div class="btn-group">
                    <nuxt-link to="/notificaton/list" v-if="$ck_action('/notification/list')" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>

        <div class="card-body min75vh">
            
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>তারিখ</th>
                            <th>শিরোনাম</th>
                            <th>বিস্তারিত</th>
                            <th>বর্তমান অবস্থা</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in notifications" :key="index">
                            <td class="text-center">{{$en2bn(index+1)}}</td>
                            <td>{{$en2bn(row.created_at)}}</td>
                            <td>{{row.title}}</td>
                            <td>{{row.body}}</td>
                            <td :class="row.read_at==null?'text-success':''">{{(row.read_at!=null ? 'দেখা হয়েছে':'দেখা হয়নি')}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/notification/view?id='+row.id" v-if="$ck_action('/notification/view')">
                                        <button class="btn btn-info">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(notifications.length <= 0)">
                            <th colspan="6">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="getAllNotifications"/>
                </div>

            </div>

            <loader :loader="loader" />
        </div>

    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'NotificationView',
        components : {Pagination},
        data(){
            return {
                kernel        : {},
                loader        : true,
                per_page      : 10,
                page_no       : 1,
                total_row     : 0,
                notifications : {},
                search        : {}
            }
        },
        mounted(){
            this.getAllNotifications();
        },
        methods:{
            getAllNotifications(){
                this.page_no = 1;
                this.http('notification/list', 'notifications', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='notifications'){
                        this.loader = false;
                        this.notifications = this.kernel[key];
                        console.log(this.notifications);
                    }
                }
            }
        }
    }
</script>

<style>

</style>
