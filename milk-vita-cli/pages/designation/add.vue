<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">পদবী যুক্ত করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/designation/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                    <!-- <nuxt-link to="/admin/association/data-add" class="btn btn-info ml-1">নিবন্ধিত সমিতি তথ্য সংযুক্তি</nuxt-link> -->
                </div>
            </div>
        </div>

        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="submit(form)">
                    <div class="form-group row">
                        <div class="col-md-3 text-right pt-1 pr-0">পদবীর নাম</div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" v-model="form.designation_name" placeholder="পদবীর নাম লিখন" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3 text-right pt-1 pr-0">এনটিটি</div>
                        <div class="col-md-5">
                             <select id="" class="form-control" v-model="form.entity_id" @change="onChangeParentEntity" required>
                                <option value="0">এনটিটি নির্বাচন করুন </option>
                                <option v-for="(row, index) in parent_entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" v-if="(child_entities).length">
                        <div class="col-md-3 text-right pt-1 pr-0">চাইল্ড এনটিটি</div>
                        <div class="col-md-5">
                            <select id="" class="form-control" v-model="form.child_entity_id">
                                <option value="0">চাইল্ড এনটিটি নির্বাচন করুন </option>
                                <option v-for="(row, index) in child_entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 text-right">
                            <div class="btn-group">
                                <button class="btn btn-success">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    সেইভ
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'Add',
        components : {Pagination},
        data(){
            return {
                kernel              : {},
                chilling_plants     : [],
                parent_entities     : [],
                child_entities      : [],

                form : {
                    designation_name    : '',
                    entity_id           : '0',
                    child_entity_id     : '0',
                },
            }
        },
        mounted(){
            this.parentEntity();
        },
        methods:{
            submit(form){
                var data = Object.assign({}, this.form);
                    data.entity_id = (this.form.child_entity_id!=0 ? this.form.child_entity_id : this.form.entity_id);
                    //
                this.http('designation/store', 'store', data);
            },
            onChangeSystem(){
                this.parent_entities = [];
                this.child_entities  = [];
                this.form.child_entity_id = '0';
                this.form.entity_id = '0';
                // 
                this.parentEntity();
            },
            onChangeParentEntity(){
                this.child_entities       = [];
                this.form.child_entity_id = '0';
                this.childrenEntity();
            },
            parentEntity(){
                this.http('entity/all', 'all_parent_entities', {
                    where:{parent_id : '0'}
                });
            },
            childrenEntity(){
                this.http('entity/all', 'all_child_entities', {
                    where:{parent_id : (this.form.entity_id != 0 ? this.form.entity_id : '-1')}
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            entity_id:function(){
                this.child_entities  = [],
                this.child_entity_id = '0';
            // --------------------------- //
                this.childrenEntity();
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all_parent_entities'){
                        this.parent_entities = this.kernel[key].data;
                    }
                    else if(key=='all_child_entities'){
                        this.child_entities = this.kernel[key].data;
                    }
                    else if(key=='store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('পদবী সফলভাবে সংরক্ষণ করা হয়েছে');
                            this.$router.push({path:'/designation/list'});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>
