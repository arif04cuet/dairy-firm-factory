<template>
    <div class="card-body">
        <form @submit.prevent="submit()">

            <div class="row">
                <div class="col-md-12">
                    <employee-selector callback="function(data){window.vue.third_party_res_data = data;}"></employee-selector>
                    <hr>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSo4EzIadT5BNjNZjfrYzGxUkdMT8EDoE-T3w&usqp=CAU" alt="">
                    </div>
                    <!-- // -->
                    <div class="choose">
                        <span>Chose Profile Photo</span>
                        <input type="file">
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Name (BN)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name_bn">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Name (EN)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name_en">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Mobile</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Mobile No" v-model="form.mobile">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">E-mail</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Enter E-mail Address" v-model="form.email">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Role</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.role_id" required>
                                <option value="">Select User Role</option>
                                <option v-for="(row, index) in roles" :key="index" :value="row.id">{{row.role_name}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">NID</label>
                        <div class="col-md-8">
                            <input type="text" v-model="form.nid" class="form-control">
                        </div>
                    </div>

                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <select class="form-control" v-model="form.division_id" @change="checkLocation('division', form.division_id)">
                        <option value="">বিভাগ নির্বাচন করুন </option>
                        <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control" v-model="form.district_id" @change="checkLocation('district', form.district_id)">
                        <option value="">জেলা নির্বাচন করুন </option>
                        <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control" v-model="form.thana_id">
                        <option value="">থানা নির্বাচন করুন </option>
                        <option v-for="(thana, index) in thanas" :key="index" :value="thana.id">{{thana.bn_name}}</option>
                    </select>
                </div>
            </div>
            
            <hr>

            <div class="row form-group">
                <label class="col-md-4 text-md-right mt-1" for="name">Username</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" placeholder="Username" v-model="form.username" :readonly="edit_id"> 
                </div>
            </div>
            
            <div class="row form-group">
                <label class="col-md-4 text-md-right mt-1" for="name">Password</label>
                <div class="col-md-7">
                    <input type="password" class="form-control" placeholder="Password" v-model="form.password" :required="!edit_id">
                </div>
            </div>
            
            <div class="row form-group">
                <label class="col-md-4 text-md-right mt-1" for="name">Confirm Password</label>
                <div class="col-md-7">
                    <input type="password" class="form-control" placeholder="Confirm Password" v-model="form.password_confirmation" :required="!edit_id">
                </div>
            </div>

            <div class="row">
                <div class="col-md-11">
                    <input type="submit" class="btn btn-success float-right" value="Save">
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        name:'AddAccess',
        props:['edit_id'],
        head() {
            return {
                title : 'Milk Vita - New User',
                meta  : [],
                link  : [],
                script:[{hid: 'stripe', src: 'http://dashboard.rdcd.orangebd.com/components/doptor-employee-selector/component.js', defer: true}]
            }
        },
        data(){
            return {
                kernel      : {},
                divisions   : [],
                districts   : [],
                thanas      : [],
                entities    : [],
                c_entities  : [],
                c_entity_id : '0',
                user_roles  : [],
                roles       : [],
                form : {
                    name_bn   :'',
                    mobile      :'',
                    email       :'',
                    division_id :'',
                    district_id :'',
                    thana_id    :'',
                    username    :'',
                    password    :'',
                    entity_id   :'0',
                    role_id     :'',
                    password_confirmation:'',
                    designation_id     : '',
                },
                third_party_res_data:[]
            }
        },
        mounted(){
            window.vue = this;
            if(this.edit_id){
                this.http('user/all', 'edit_user_data', {
                    where:{
                        id:this.edit_id
                    }
                });
            }
            //
            this.http('location/divisions', 'divisions');
            //
            this.getEntities();
            this.getRole();
        },
        methods:{
            submit:function(){
                if(this.edit_id){
                    this.http('user/update/'+this.edit_id, 'update', this.form);
                }
                else if(this.form.password==this.form.password_confirmation){
                    this.http('user/register', 'store', this.form);
                }
                else{ alert('Your Password And Confirm Password Is Not Same'); }
            },
            onChangeEntity(){
                this.c_entities     = [];
                this.c_entity_id    = 0;
                this.roles   = [];
                this.role_id = '';
                // ---------------------
                this.getCEntities();
                this.getRole();
            },
            onChangeCEntity(){
                this.roles   = [];
                this.role_id = '';
                // ---------------------
                this.getRole();
            },
            getEntities(){
                this.http('entity/all', 'entities', {
                    where:{
                        system_id:this.form.system_id,
                        parent_id:'0'
                    }
                });
            },
            getCEntities(){
                this.http('entity/all', 'CNentities', {
                    where:{
                        system_id:this.form.system_id,
                        parent_id:this.form.entity_id,
                    }
                });
            },
            getRole(){
                this.http('role/all', 'all_role', {
                    where:{
                        system_id  : this.form.system_id,
                        entity_id  : (this.c_entity_id != 0 ? this.c_entity_id : this.form.entity_id)
                    }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data)
                .then(res=>{
                    this.kernel = Object.assign({}, {[type]:res.data});
                });
            },
            checkLocation:function(type, id){
                var url = 'location/'+(type=='division' ? 'districts' : (type=='district' ? 'thanas' : ''));
                this.$axios.post(url, {where:{[type+'_id']:id}})
                .then(res=>{
                    if(type=='division'){
                        this.districts = res.data;
                    }
                    else if(type=='district'){
                        this.thanas = res.data;
                    }
                });
            }
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='entities'){
                        this.entities = this.kernel[key].data;
                    }
                    else if(key=='edit_user_data'){
                        this.form = this.kernel[key].data[0];
                        this.form.password = '';
                        // 
                        this.getRole();
                        this.checkLocation('division', this.form.division_id);
                        this.checkLocation('district', this.form.district_id);
                    }
                    else if(key=='update'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('ব্যবহারকারী সফলভাবে আপডেট করা হয়েছে');
                        }
                    }
                    else if(key=='CNentities'){
                        this.c_entities = this.kernel[key].data;
                    }
                    else if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='all_role'){
                        this.roles = this.kernel[key].data;
                    }
                    else if(key=='store'){
                        if( 
                            this.kernel[key].errors){alert(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('সফলভাবে ব্যবহারকারী তৈরি হয়েছে');
                            this.$router.push({path:'/user/access/all'});
                        }
                    }
                }
            },
            third_party_res_data(){
                if(this.third_party_res_data && !this.third_party_res_data.message){
                    var res_data       = this.third_party_res_data
                    this.form.name_bn  = res_data.name.bn;
                    this.form.name_en  = res_data.name.en;
                    this.form.mobile   = res_data.mobile;
                    this.form.email    = res_data.email;
                    this.form.username = res_data.username;
                    this.form.nid      = res_data.nid;
                }
                else {
                    this.form.name_bn   = '';
                    this.form.name_en   = '';
                    this.form.mobile    = '';
                    this.form.username  = '';
                    this.form.email     = '';
                    this.form.nid       = '';
                }
            }
        }
    }
</script>

<style scoped>
    th, td {
        vertical-align: middle;
    }
    .img-wrapper {
        width: 100%;
        overflow: hidden;
        box-sizing: border-box;
        padding: 7px;
        border:1px solid #ddd;
    }
    .img-wrapper img{
        width: 100%;
    }
    .choose {
        width: 100%;
        height: 30px;
        background: #ddd;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .choose input[type='file'], .choose span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        opacity: 0;
        cursor: pointer;
    }
    .choose span {
        z-index: 998;
        opacity: 1;
        border: 1px solid #ddd;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
</style>