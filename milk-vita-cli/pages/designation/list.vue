<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">পদবীর তালিকা</h5>
                <div class="btn-group">
                    <nuxt-link to="/designation/add" class="btn btn-primary" v-if="$ck_action('/designation/add')">
                        <i class="fa fa-plus"></i>&nbsp;পদবীর সংযুক্ত করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <select class="form-control" v-model="search.entity_id" @change="fetchEntities(search.system_id, search.entity_id, 'child-entity')">
                                <option value="">এনটিটি  নির্বাচন করুন</option>
                                <option v-for="(row, index) in entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group" v-if="(child_entities).length > 0">
                            <select class="form-control" v-model="search.child_entity_id">
                                <option value="">সাব এনটিটি নির্বাচন করুন</option>
                                <option v-for="(row, index) in child_entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 form-group">
                            <button class="btn btn-success text-nowrap">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>পদবীর নাম</th>
                            <th>এন্টিটির নাম</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in designation_list" :key="index">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td>{{row.designation_name}}</td>
                            <td>
                                <span v-if="row.parent_entity_name!='N/A'">
                                    {{row.parent_entity_name}} 
                                    <strong><i class="fa fa-angle-right"></i></strong>
                                </span>
                                <span>{{row.entity_name}}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(row)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>

                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(designation_list.length <= 0)">
                            <th colspan="6">Data Not Found</th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllDesignation"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
        },
        data(){
            return {
                kernel              : {},
                entities            : [],
                child_entities      : [],
                designation_list    : [],
                search              : {
                    entity_id       :'',
                    child_entity_id :'',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchAllDesignation();
            // 
            this.fetchEntities();
        },
        methods:{
            fetchEntities(system_id='0', parent_id='0', type='parent-entity'){
                this.http('entity/all', type, {
                    where:{parent_id:parent_id}
                })
            },
            filter(){
                this.fetchAllDesignation();
            },
            edit(row){
                this.$router.push({path:'/designation/edit?id='+row.id});
            },
            fetchAllDesignation(){
                this.loader = true;

                var where = Object.assign({}, this.search);

                where.entity_id = (where.child_entity_id ? where.child_entity_id : where.entity_id);

                delete where.child_entity_id;
                //
                this.http('designation/list', 'designation-list', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : where
                });
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='designation-list'){
                        this.designation_list = this.kernel[key].data;
                        this.total_row       = this.kernel[key].total_row;
                        this.loader          = false;
                    }
                    else if(key=='parent-entity'){
                        this.entities = this.kernel[key].data;
                    }
                    else if(key=='child-entity'){
                        this.child_entities = this.kernel[key].data;
                    }
                }
            }
        }
    }
</script>

<style>

</style>
