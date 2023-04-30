<template>
    <div class="card-body">
        <form @submit.prevent="submit()">

            <div class="row">
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSo4EzIadT5BNjNZjfrYzGxUkdMT8EDoE-T3w&usqp=CAU" alt="">
                    </div>
                    <div class="choose">
                        <span>Chose Profile Photo</span>
                        <input type="file">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name_bn" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Mobile</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Mobile No" v-model="form.mobile" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">E-mail</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Enter E-mail Address" v-model="form.email" required>
                        </div>
                    </div>

                    
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Processing Plant</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.processing_plant_id" :disabled="type=='driver'" required>
                                <option value="">Select Processing Plant Plant</option>
                                <option v-for="(row, index) in processing_plants" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Entity</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.entity_id" disabled required>
                                <option value="">Select Entity</option>
                                <option v-for="(row, index) in entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Role</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.role_id" :disabled="type=='driver'" required>
                                <option value="">Select User Role</option>
                                <option v-for="(row, index) in roles" :key="index" :value="row.id">{{row.role_name}}</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <select class="form-control" v-model="form.division_id" @change="checkLocation('division', form.division_id)" required>
                        <option value="">বিভাগ নির্বাচন করুন </option>
                        <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{division.bn_name}}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control" v-model="form.district_id" @change="checkLocation('district', form.district_id)" required>
                        <option value="">জেলা নির্বাচন করুন </option>
                        <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.bn_name}}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control" v-model="form.thana_id" required>
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
        props:['edit_id', 'type'],
        data(){
            return {
                kernel          : {},
                divisions       : [],
                districts       : [],
                thanas          : [],
                user_roles      : [],
                processing_plants : [],
                roles           : [],
                entities        : [],
                form : {
                    name_bn     :'',
                    mobile      :'',
                    email       :'',
                    division_id :'',
                    district_id :'',
                    thana_id    :'',
                    username    :'',
                    password    :'',
                    entity_id   :'',
                    role_id     :'',
                    password_confirmation : '',
                    processing_plant_id     : '',
                },
            }
        },
        mounted(){
            if(this.edit_id){
                this.http('user/all', 'edit_user_data', {
                    where:{
                        id:this.edit_id
                    }
                });
            }
            //
            this.http('entity/all', 'all-entity', {
                parent_id : '0'
            });
            //
            this.http('location/divisions', 'divisions');
            this.http('processing-plant/all', 'processing_plants ', { select:['id', 'processing_plant_name', 'entity_id']});

            //
            if(this.type=='driver'){
                this.form.processing_plant_id = this.$store.state.auth.user.processing_plant_id;
            }
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
            getRole(entity_id){
                this.http('role/all', 'all_role', {
                    where:{
                        entity_id : entity_id
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
                    if(key=='processing_plants '){
                        this.processing_plants = this.kernel[key].data;
                    }
                    else if(key=='update'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('ব্যবহারকারী সফলভাবে আপডেট করা হয়েছে');
                            this.form.password = '';
                            this.form.password_confirmation = '';
                        }
                    }
                    else if(key=='all_role'){
                        this.roles = this.kernel[key].data;

                        if(this.type=='driver'){
                            (this.roles).forEach((row)=>{
                                if(row.slug=='driver-processing-plant') {this.form.role_id = row.id;}
                            });
                        }
                    }
                    else if(key=='divisions'){
                        this.divisions = this.kernel[key];
                    }
                    else if(key=='all-entity'){
                        this.entities = this.kernel[key].data;
                        (this.entities).map(x=>{
                            if(x.slug=='processing-plant') {
                                this.form.entity_id = x.id;
                                this.getRole(x.id);
                            };
                        });
                    }
                    else if(key=='edit_user_data'){
                        this.form = this.kernel[key].data[0];
                        this.form.password = '';
                        // 
                        this.getRole();
                        this.checkLocation('division', this.form.division_id);
                        this.checkLocation('district', this.form.district_id);
                    }
                    else if(key=='store'){
                        if( this.kernel[key].errors){alert(this.kernel[key].errors);}
                        else {
                            this.$toastr.s('সফলভাবে ব্যবহারকারী তৈরি হয়েছে');
                            if(this.type=='driver')
                                this.$router.push({path:'/processing-plant/driver/list'});
                            else 
                                this.$router.push({path:'/user/access/all'});
                        }
                    }
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