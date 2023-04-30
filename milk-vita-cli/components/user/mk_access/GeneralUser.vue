<template>
    <div class="card-body min60vh">
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
                        <label for="" class="col-md-3 text-right pt-1">Username</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.username" disabled required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name_bn" disabled required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Mobile</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Enter Mobile No" v-model="form.mobile" disabled required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">E-mail</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Enter E-mail Address" v-model="form.email" disabled required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Entity</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.entity_id" required disabled>
                                <option value="0">System User</option>
                                <option v-for="(row, index) in entities" :key="index" :value="row.id">{{row.entity_name}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <label for="" class="col-md-3 text-right pt-1">Role</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.role_id" disabled required>
                                <option value="">Select User Role</option>
                                <option v-for="(row, index) in roles" :key="index" :value="row.id">{{row.role_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group" v-if="entitie_slug=='chilling-plant'">
                        <label for="" class="col-md-3 text-right pt-1">Chilling Plant</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.chilling_plant_id" required>
                                <option value="">Select Chilling Plant</option>
                                <option v-for="(row, index) in chilling_plants" :key="index" :value="row.id">{{row.chilling_plant_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group" v-if="entitie_slug=='processing-plant'">
                        <label for="" class="col-md-3 text-right pt-1">Processing Plant</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="form.processing_plant_id" @change="getZone(form.processing_plant_id)" required>
                                <option value="">Select Processing Plant</option>
                                <option v-for="(row, index) in processing_plants" :key="index" :value="row.id">{{row.processing_plant_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <!-- // -->
                    <hr>
                    <!-- // -->
                    <div class="card" v-if="this.role_slug=='zone-supervisor' || this.role_slug=='distributor'">
                        <div class="card-header">
                            <h4 class="m-0"><i class="fa fa-map-marker p-1" aria-hidden="true"></i> <span>Zones</span></h4>
                        </div>
                        <!-- // -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4" v-for="(zone, index) in zones" :key="index" >
                                    <label :for="'zone'+index" class=" user-select-none">
                                        <input v-if="role_slug=='distributor'" name="zone_id" type="radio" :id="'zone'+index" v-model="zone_ids[0]"  :value="zone.id">
                                        <input v-if="role_slug!='distributor'" type="checkbox" name="zone_id" :id="'zone'+index" v-model="zone_ids[index]" :true-value="zone.id" > 
                                        <span>{{zone.zone_name_bn}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12 mt-3 text-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fa" :class="is_submit==true ? 'fa-spinner fa-pulse fa-fw' : 'fa-floppy-o' " aria-hidden="true"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- 
            <date-picker 
                v-model="datepicker" 
                placeholder="Placeholder"
                class="mb-2"
                v-bind="$locals('bn.bind')"
                :locale="'bn'"
            /> 
        -->
        
    </div>
</template>

<script>
    export default {
        name:'AddAccess',
        props:['edit_id'],
        data(){
            return {
                kernel            : {},
                processing_plants : [],
                chilling_plants   : [],
                entitie_slug      : '',
                role_slug         : '',
                is_submit         : false,
                entities          : [],
                roles             : [],
                zones             : [],
                zone_ids          : [],

                form : {
                    name_bn     :'',
                    mobile      :'',
                    email       :'',
                    entity_id   :'',
                    role_id     :'',
                    username    :'',
                    password    :'',
                    password_confirmation : '',
                    chilling_plant_id     : '',
                    processing_plant_id   : '',
                },
            }
        },
        mounted(){
            //
        },
        methods:{
            getZone(zone_id){
                if(this.role_slug=='zone-supervisor' || this.role_slug=='distributor'){
                    this.http('zone/list', 'zones', {
                        where:{
                            processing_plant_id : zone_id
                        },
                        select:['id', 'zone_name_bn', 'zone_name_en']
                    });
                }
            },
            submit:function(){
                this.is_submit = true;
                if(this.role_slug!='distributor'){
                    var zones = [];
                    (this.zone_ids).filter((x)=>{if(x)zones.push(x)});
                    this.form.zone_ids = zones;
                }
                else {
                    this.form.zone_ids = [this.zone_ids[0]];
                }
                //
                if(this.edit_id){
                    this.http('user/update/'+this.edit_id, 'update', this.form);
                }
                else if(this.form.password==this.form.password_confirmation){
                    this.http('user/register', 'store', this.form);
                }
                else{ alert('Your Password And Confirm Password Is Not Same'); }
            },
            getInitialData:function(){
                // ALL ENTITIES
                this.http('entity/all', 'all-entity', {parent_id : '0'});

                // USER ROLES
                this.http('role/all', 'all_role', {
                    where:{ entity_id :this.form.entity_id }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data)
                .then(res=>{
                    this.kernel = Object.assign({}, {[type]:res.data});
                });
            },
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='chilling_plants '){
                        this.chilling_plants = this.kernel[key].data;
                    }
                    else if(key=='zone_map'){
                        let zone_ids = [];
                        //
                        (this.kernel[key].data).forEach(x=>{
                            zone_ids.push(x.zone_id);
                        });
                        //
                        if(this.role_slug!='distributor'){
                            let new_ids = [];
                            (this.zones).forEach((row, key) => {
                                if(zone_ids.indexOf(row.id) > -1)new_ids[key] = zone_ids[zone_ids.indexOf(row.id)];
                            });
                            //
                            this.zone_ids = new_ids;
                        }
                        else {
                            this.zone_ids = zone_ids;
                        }
                    }
                    else if(key=='zones'){
                        this.zones = this.kernel[key].data;
                        //
                        this.http('zone/map', 'zone_map', {
                            where:{user_id:this.edit_id}
                        });
                    }
                    else if(key=='processing_plants '){
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
                        this.is_submit = false;
                    }
                    else if(key=='all_role'){
                        this.roles = this.kernel[key].data;

                        (this.roles).map(x=>{
                            if(x.id==this.form.role_id) {
                                this.form.entity_id = x.entity_id;
                                this.role_slug      = x.slug;
                            };
                        });

                        this.getZone(this.form.processing_plant_id);
                    }
                    else if(key=='all-entity'){
                        this.entities = this.kernel[key].data;

                        (this.entities).map(x=>{
                            if(x.id==this.form.entity_id) {
                                this.entitie_slug = x.slug;
                            };
                        });
                    }
                    else if(key=='user'){
                        this.form = this.kernel[key].data[0];
                        this.form.password = '';
                        // 
                        this.getInitialData();
                    }
                    else if(key=='store'){
                        if( this.kernel[key].errors){alert(this.kernel[key].errors);}
                        else {
                            this.$toastr.s('সফলভাবে ব্যবহারকারী তৈরি হয়েছে');
                            this.$router.push({path:'/user/access/all'});
                        }
                        this.is_submit = false;
                    }
                }
            },
            entitie_slug(){
                if(this.entitie_slug=='chilling-plant'){
                    this.http('chilling-plant/all', 'chilling_plants ', { select:['id', 'chilling_plant_name']});
                }
                else if(this.entitie_slug=='processing-plant'){
                    this.http('processing-plant/all', 'processing_plants ', { select:['id', 'processing_plant_name', 'entity_id']});
                }
            },
            edit_id(){
                this.http('user/all', 'user', {
                    where:{ id:this.edit_id }
                });
            },
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