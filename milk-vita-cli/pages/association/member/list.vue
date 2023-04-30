<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সদস্যদের তালিকা</h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select-picker 
                                placeholder="সমিতির সদস্য নির্বাচন করুন"
                                :options="all_members"
                                v-model="search.id"
                                :reduce="row=>row.id"
                                label="member_name"
                            />
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-success" >সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover custom">
                    <thead>
                        <tr>
                            <th width="40">ক্রমিক</th>
                            <th class="text-center">সদস্যের নাম</th>
                            <th class="text-center">বয়স</th>
                            <th class="text-center">পিতার/স্বামীর নাম</th>
                            <th class="text-center">গ্রাম</th>
                            <th class="text-center">গাভী</th>
                            <th class="text-center">বকনা</th>
                            <th class="text-center">বকন বাছুর</th>
                            <th class="text-center">এঁড়ে বাছুর</th>
                            <th class="text-center">ষাঁড়</th>
                            <th class="text-center">বলদ</th>
                            <th class="text-center">মহিষ</th>
                            <th class="text-center">মোট গবাদি পশু</th>
                            <th class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in paginated_members" :key="index">
                            <td>{{$en2bn(mkindex(index+1))}}</td>
                            <td class="text-center">{{row.member_name}}</td>
                            <td class="text-center">{{row.age}}</td>
                            <td class="text-center">{{row.spouse_name_en ? row.spouse_name_en : '--'}}</td>
                            <td class="text-center">{{row.village}}</td>
                            <td class="text-center">{{row.total_gavi}}</td>
                            <td class="text-center">{{row.total_bokna}}</td>
                            <td class="text-center">{{row.total_bokon_bachor}}</td>
                            <td class="text-center">{{row.total_are_bachor}}</td>
                            <td class="text-center">{{row.total_shar}}</td>
                            <td class="text-center">{{row.total_bolod}}</td>
                            <td class="text-center">{{row.total_mohish}}</td>
                            <!-- // -->
                            <td>{{row.total_cattle}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/association/member/profile?id='+row.id">
                                        <button class="btn btn-success"><i class="fa fa-eye"></i></button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="(paginated_members).length <= 0">
                            <th colspan="14" class="text-center">কোনো সদস্য পাওয়া যায়নি</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Loader />
            <div class="d-flex justify-content-end">
                <pagination v-model="page" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
            </div>
        </div>

        <!-- LIST OF ALL paginated_members OF AN ASSOCIATION -->
        <div v-if="association_id" class="popup">
            <div class="popup-box">
                <quick-info
                    v-model="association_id"
                ></quick-info>
            </div>
        </div>


    </div>
</template>
<script>
    import QuickInfo from '@/components/association/QuickInfo.vue';
    export default {
        layout:'admin',
        name:'all',
        components : {
            'quick-info':QuickInfo
        },
        data(){
            return {
                kernel                : {},
                paginated_members     : [],
                all_members           : [],
                search                : { id : '', association_code : '',},
                user                  : '',
                total_row             : 0,
                per_page              : 10,
                page                  : 1,
                is_quick_info         : false,
                association_id        : '',
            }
        },
        mounted(){
            this.user = this.$store.state.auth.user;
            this.fetchData();
            this.http('association/all-member', 'all_members', {
                select:['id', 'member_name']
            });
        },
        methods:{
            edit:function(item){
                this.$router.push({path:`/association/edit?id=${item.id}`});
            },
            fetchData:function(){
                this.$store.commit('pageLoader', true);
                this.http('association/all-member', 'paginated_members', {
                    per_page    : this.per_page,
                    page_no     : this.page,
                    where       : this.search,
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page, index);
            },
            filter:function(){
                this.fetchData();
            },
            quick_info:function(association_id){
                this.association_id = association_id;
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            association_id:function(){
                var niddle = '';
                if(this.association_id){
                    niddle = 'hidden';
                }
                document.querySelector('BODY').style.overflow = niddle;
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_members'){
                        this.all_members = this.kernel[key].data;
                    }
                    else if(key=='paginated_members'){
                        this.paginated_members   = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                        this.$store.commit('pageLoader', false);
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
</style>
