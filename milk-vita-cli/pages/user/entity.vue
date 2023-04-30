<template>
    <div class="card">
        <div class="card-header">
            <h5 class="mt-1 m-0">এনটিটি</h5>
        </div>
        <div class="card-body min75vh">
           <form @submit.prevent="form.entity_id ? update() : save()">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="" class="mt-1">প্যারেন্ট এনটিটি নাম</label>
                        <select class="form-control" v-model="form.parent_id" :disabled="form.is_system==1">
                            <option value="0">প্যারেন্ট এনটিটি নির্বাচন</option>
                            <option v-for="(row, index) in parents" v-if="row.id!=form.entity_id" :key="index" :value="row.id">{{row.entity_name}}</option>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="" class="mt-1">এনটিটি নাম</label>
                        <input class="form-control" placeholder="সংস্থার নাম" v-model="form.entity_name" required>
                    </div>

                    <div class="col-md-2 form-group" style="display:grid">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-success">
                            <span v-if="form.entity_id">আপডেট</span>
                            <span v-else >সেইভ</span>
                        </button>
                    </div>
                </div>
           </form>

            <hr class="mt-0">

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered custom mb-2">

                    <thead>
                        <tr>
                            <th width="50" class="text-center">SL</th>
                            <th class="text-left">এনটিটি নাম</th>
                            <th class="text-left">প্যারেন্ট এনটিটি নাম</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(entity, index) in entities" :key="index" v-if="entity.id!=form.entity_id">
                            <td class="text-center">{{$en2bn(mkindex(++index))}}</td>
                            <td class="text-left">{{entity.entity_name}}</td>
                            <td class="text-left">{{entity.parent_name}}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <button class="btn btn-primary" @click="edit(entity)" :disabled="(entity.is_system==1)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchAllEntity"/>
                </div>
            </div>
            <Loader :loader="loader"/>
        </div>
    </div>
</template>
<script>

    import Pagination from 'vue-pagination-2';
    export default {
        layout  : 'admin',
        name    : 'entity',
        components : {
            Pagination
        },
        data(){
            return {
                kernel      : {},
                entities    : [],
                parents     : [],
                total_row   : 0,
                per_page    : 10,
                page_no     : 1,
                loader      : true,
                form:{
                    parent_id   : '0',
                    is_system   : 0,
                    entity_name : '',
                    entity_id   : '',
                },
            }
        },
        mounted(){
            this.fetchParent();
            this.fetchAllEntity();
        },
        methods:{
            onChangeSystem(){
                this.form.parent_id = '0';
                this.fetchParent();
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            fetchParent(){
                this.http('entity/all', 'all_parent', {
                    where:{parent_id:'0'}
                });
            },
            fetchAllEntity(){
                this.loader = true;
                this.http('entity/all', 'all_entity', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                });
            },
            save:function(){
                this.http('entity/store', 'entity_store', this.form);
            },
            edit:function(entity){
                this.form = {
                    entity_name : entity.entity_name,
                    parent_id   : entity.parent_id,
                    is_system   : entity.is_system,
                    entity_id   : entity.id,
                };
            },
            update(){
                this.http('entity/update/'+this.form.entity_id, 'update_entity', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data)
                .then(res=>{this.kernel = Object.assign({}, {[type]:res.data}); });
            },
        },
        watch:{
            kernel:function(){
                if(this.kernel)
                for(const key in this.kernel){
                    if(key=='all_entity'){
                        this.entities  = this.kernel[key].data;
                        this.total_row = this.kernel[key].total_row;
                        this.loader = false;
                        console.log(this.kernel[key].data);
                    }
                    else if(key=='entity_store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.fetchAllEntity();
                            this.form.entity_name = '';
                            this.form.system_id   = 0;
                            this.$toastr.s('এনটিটি সফলভাবে সংরক্ষিত হয়েছে');
                        }
                        this.fetchParent();
                    }
                    else if(key=='all_parent'){
                        this.parents = this.kernel[key].data;
                    }
                    else if(key=='update_entity'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.fetchAllEntity();
                            this.form = {
                                entity_name : '',
                                parent_id   : 0,
                                system_id   : 0,
                                entity_id   : 0,
                            };
                            this.$toastr.s('এনটিটি সফলভাবে আপডেট হয়েছে');
                        }
                    }
                }
            }
        },
    }
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
</style>
