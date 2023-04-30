<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">আবেদনকৃত সমিতির তালিকাঃ</h5>
                <div class="btn-group">
                    <nuxt-link to="/association/add" class="btn btn-primary" v-if="$ck_action('/association/add')">
                        <i class="fa fa-plus"></i>&nbsp;নতুন সমিতি সংযুক্ত করুন
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <association-list
                type="chilling-manager-application-list"
            ></association-list>
        </div>
    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    import list from '@/components/association/AssociationList.vue';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
            'association-list':list
        },
        data(){
            return {
                kernel                : {},
                paginate_associations : [],
                all_association       : [],
                search                : { id : '', association_code : '',},
                user                  : '',
                total_row             : 0,
                per_page              : 10,
                page                  : 1,
                is_quick_info         : false,
                loader                : true,
            }
        },
        mounted(){
            this.user = this.$store.state.auth.user;
            this.fetchData();
            this.http('association/list', 'all_association', {
                select:['id', 'association_name'],
                type        : 'field-officer-appllication-list',
            });
        },
        methods:{
            fetchData:function(){
                this.loader = true;
                this.http('association/list', 'paginate_associations', {
                    per_page    : this.per_page,
                    page_no     : this.page,
                    where       : this.search,
                    type        : 'field-officer-appllication-list',
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page, index);
            },
            filter:function(){
                this.fetchData();
            },
            view_details:function(association_id){
                this.$router.push({path:'/association/applied/details?id='+association_id});
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_association'){
                        this.all_association = this.kernel[key].data;
                    }
                    else if(key=='paginate_associations'){
                        this.paginate_associations   = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                        this.loader = false;
                    }
                }
            }
        }
    }
</script>

<style>
    .VuePagination__count  {
        display: none!important;;
    }
    /* .popup-box {
        width: 65%!important;
    } */
</style>
