<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">ইউজার রোল এডিট করুন</h5>
                <div class="btn-group">
                    <nuxt-link to="/role/all" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;রোলের তালিকা
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit(form)">

                <div class="row form-group">
                    <div class="col-md-3 text-right pt-2">এনটিটি</div>
                    <div class="col-md-7">
                        <select @change="onChangeEntity()" class="form-control" v-model="form.entity_id" :disabled="form.is_system==1">
                            <option value="0">এনটিটি নির্বাচন করুন</option>
                            <option v-for="(row, index) in entities" :value="row.id" :key="index" >{{ row.entity_name }}</option>
                        </select>
                    </div>
                </div>

                <div class="row form-group" v-if="(sub_entities.length) > 0">
                    <div class="col-md-3 text-right pt-2">সাব-এনটিটি</div>
                    <div class="col-md-7">
                        <select class="form-control" v-model="form.sub_entity_id" :disabled="form.is_system==1">
                            <option value="0">এনটিটি নির্বাচন করুন</option>
                            <option v-for="(row, index) in sub_entities" :value="row.id" :key="index" >{{ row.entity_name }}</option>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3 text-right pt-2">রোলের নাম</div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="রোলের নাম লিখুন" v-model="form.role_name" required />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 text-right">
                        <div class="btn-group">
                            <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;আপডেট</button>
                        </div>
                    </div>
                </div>
            </form>
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
                edit_id:'',
                kernel : {},
                form   : {
                    entity_id:'0',
                    sub_entity_id:'0',
                    role_name    :''
                },
                //
                entities : [],
                sub_entities : [],
            }
        },
        mounted(){
            this.fetchEntity();
            // 
            this.edit_id = this.$route.query.id;
        },
        methods:{
            submit(form){
                var data = Object.assign({}, this.form); data.entity_id = (this.form.sub_entity_id!=0 ? this.form.sub_entity_id : this.form.entity_id);
                this.http('role/update/'+this.edit_id, 'update', form);
            },
            onChangeSystem(){
                this.entities = [];
                this.form.entity_id = '0';
                this.form.sub_entity_id = '0';
                this.sub_entities = [];
                //
                this.fetchEntity();
            },
            onChangeEntity(){
                this.form.sub_entity_id = '0';
                this.sub_entities = [];
                //
                this.fetchSubEntity();
            },
            fetchEntity(){
                this.http('entity/all', 'all-antity', {
                    where:{
                        parent_id:'0',
                        system_id:this.form.system_id
                    }
                });
            },
            fetchSubEntity(){
                this.http('entity/all', 'sub-entity', {
                    where:{
                        system_id:this.form.system_id,
                        parent_id:(+this.form.entity_id ? this.form.entity_id : '-1'),
                    }
                });
            },
            fetchRole(){
                this.http('role/all', 'fetch-role', {
                    where:{
                        id:this.edit_id,
                    }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            edit_id:function(){
                this.fetchRole();
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='all-antity'){
                        this.entities = this.kernel[key].data;
                    }
                    else if(key=='sub-entity'){
                        this.sub_entities = this.kernel[key].data;
                    }
                    else if(key=='update'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('রোল সফলভাবে আপডেট করা হয়েছে');
                            this.$router.push({path:'/role/all'})
                        }
                    }
                    else if(key=='fetch-role'){
                        var data = this.kernel[key].data[0];
                        this.form = data;
                        this.form.sub_entity_id = (data.parent_entity_id ? data.entity_id : data.parent_entity_id);
                        this.form.entity_id     = (data.parent_entity_id ? data.parent_entity_id : data.entity_id);
                        // ----------------------------------
                        this.fetchEntity();
                        this.fetchSubEntity();
                    }
                }
            }
        }
    }
</script>

<style>

</style>
