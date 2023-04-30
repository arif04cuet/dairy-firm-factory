<template>
    <div>
        <form @submit.prevent="filter">
            <div class="row">
                <div class="col-md-3 form-group">
                    <select class="form-control" v-model="search.id">
                        <option value="">সমিতির নির্বাচন করুন</option>
                        <option v-for="(row, index) in all_association" :key="index" :value="row.id">{{row.association_name}}</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" v-model="search.association_code" placeholder="সমিতির কোড">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success" >সার্চ করুন</button>
                </div>
            </div>
        </form>
            
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom">
                <thead>
                    <tr>
                        <th width="50" class="text-center">ক্রমিক</th>
                        <th>প্রস্তাবিত সমিতির নাম</th>
                        <th>কোড</th>
                        <th>সমিতির কার্যকরী এলাকা</th>
                        <th>দুগ্ধ এলাকার নাম</th>
                        <th>সদস্যগনের সংখ্যা</th>
                        <th v-if="checkOpen()" class="text-center"> বর্তমান অবস্থা</th>
                        <th width="70" class="text-center">অ্যাকশন</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(row, index) in paginate_associations" :key="index">
                        <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                        <td>{{row.association_name}}</td>
                        <td>{{row.association_code ? row.association_code : '#'}}</td>
                        <td>{{row.working_area_of_association}}</td>
                        <td>{{row.name_of_dairy_area}}</td>
                        <td>{{row.total_members}}</td>
                        <td v-if="checkOpen()">{{row.last_status}}</td>
                        <td class="text-center">
                            <div class="btn-group custom">
                                <button v-if="checkOpen()" @click="track_stasus(row)" class="btn btn-info mr-1">
                                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                </button>
                                <!-- // -->
                                <button 
                                    v-if="type!='verified-resolution-list' && checkUser" 
                                    @click="viewDetails(row.id)" 
                                    class="btn btn-success"
                                >
                                    <i class="fa fa-eye"></i>
                                </button>
                                <!-- // -->
                                <nuxt-link :to="`/association/application/meeting-resolution?id=${row.id}`">
                                    <button v-if="type=='verified-resolution-list'" class="btn btn-success">
                                        <i class="fa fa-users"></i>
                                    </button>
                                </nuxt-link>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="(paginate_associations.length<=0 && !loader)">
                        <th colspan="8">Data Not Found</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <Loader :loader="loader"/>
        <div class="d-flex justify-content-end">
            <pagination v-model="page" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
        </div>

        <!-- LIST OF ALL MEMBERS OF AN ASSOCIATION -->
        <div v-if="association_id" class="popup">
            <div class="popup-box">
                <status-track v-model="association_id" ></status-track>
            </div>
        </div>
    </div>
</template>
<script>
    import Track from '@/components/association/Track.vue';
    export default {
        name:'all',
        props:['type'],
        components : {'status-track':Track},
        data(){
            return {
                kernel                : {},
                paginate_associations : [],
                all_association       : [],
                search                : {id : '', association_code : ''},
                user                  : '',
                total_row             : 0,
                per_page              : 10,
                page                  : 1,
                is_quick_info         : false,
                loader                : true,
                association_id        : '',
            }
        },
        computed:{
            checkUser:function() 
            {
                return this.$ck_action(['/association/application/details', '/plant-manager/application/details', '/plant-officer/application/details'], 'or');
            }
        },
        mounted(){
            this.user = this.$store.state.auth.user;
            //
            this.fetchData();
            this.http('association/list', 'all_association', {
                select: ['id', 'association_name'],
                type  : this.type
            });
        },
        methods:{
            track_stasus(association){
                this.association_id = association.id;
            },
            edit:function(item){
                this.$router.push({path:`/association/edit?id=${item.id}`});
            },
            fetchData:function(){
                this.loader = true;
                //
                this.http('association/list', 'paginate_associations', {
                    per_page    : this.per_page,
                    page_no     : this.page,
                    where       : this.search,
                    type 		: this.type
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page, index);
            },
            filter:function(){
                this.fetchData();
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
            checkOpen(){
                return (this.type!='application-review-list' && this.type!='verified-resolution-list');
            },
            viewDetails(id){
                var path = `/association/application/details?id=${id}`;
                //
                if(this.type=='application-review-list'){
                    path = `/association/applied/details?id=${id}`;
                }
                //
                if(this.type=='chilling-manager-application-list'){
                    path = `/plant-manager/application/details?id=${id}`;
                }
                //
                if(this.type=='chilling-officer-application-list'){
                    path = `/plant-officer/application/details?id=${id}`;
                }
                this.$router.push({path: path});
            }
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
</style>
