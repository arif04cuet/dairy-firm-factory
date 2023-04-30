<template>
    <div>
        <edit-member
            v-if="member_id"
            v-model="member_id"
        >
        </edit-member>
        <!-- // -->
        <div class="card border-0 shadow-0" v-else >
            <div class="card-header bg-white border-0 shadow-0">
                &nbsp;
                <div class="card-header bg-white d-flex justify-content-between card-header-custom">
                    <h6 class="text-strong m-0">প্রস্তাবিত প্রাথমিক দুগ্ধ উৎপাদনকারী সমিতির সদস্যদের যুক্ত করুনঃ </h6>
                    <h6 class="text-strong m-0">মোট সদস্য সংখ্যাঃ <span>{{$en2bn(total_member)}} জন</span> </h6>
                </div>
            </div>
            <div class="card-body pt-0" style="padding-bottom:70px!important">
                <form @submit.prevent="saveMember()">
                    <!-- // -->
                    <fieldset class="fieldset" v-for="(row, index) in form.members" :key="index" >
                        <legend class="m-0"><span class="mr-1 ml-1"> মেম্বার নাম্বার  - {{($en2bn(total_member+(index+1)))}}</span></legend>
                        <div class="row form-group member_rows" style="position:relative">
                            <button type="button" v-if="index!=0" class="btn btn-danger p-0 pl-2 pr-2" style="position:absolute;right:7px;top:0;custor:pointer;z-index:20" @click="close(index)"><i class="fa fa-times"></i></button>
                            <!-- // -->
                            <div class="col-md-6 border-right">
                                <!-- // -->
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label> নাম <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text" v-model="form.members[index].member_name" class="form-control required" style="border-radius: 3px;" placeholder="সদস্যের নাম">
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>পিতার/স্বামীর নাম <span class="text-danger">*</span></label>
                                        <input type="text" v-model="form.members[index].spouse_name_en" class="form-control required" placeholder="সদস্যের পিতার/স্বামীর নাম ">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>লিঙ্গ <span class="text-danger">*</span></label>
                                        <div class="form-control border-0 p-0 m-0" :ref="'required_gender_'+index">
                                            <Gender
                                                v-model="form.members[index].gender"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-3 p-0 form-group">
                                        <label>বয়স <span class="text-danger">*</span></label>
                                        <input type="number" min="0" v-model="form.members[index].age" class="form-control required">
                                    </div>

                                    <div class="col-md-5 form-group">
                                        <label>মোবাইল <span class="text-danger">*</span></label>
                                        <input type="text" v-model="form.members[index].mobile" class="form-control required" placeholder="মোবাইল">
                                    </div>   

                                    <div class="col-md-12">
                                        <Location class="row" v-model="form.members[index].geolocation">
                                            <!-- // -->
                                            <div class="col-md-6 form-group">
                                                <label>বিভাগ <span class="text-danger">*</span></label>
                                                <div data-division :ref="'required_division_'+index"></div>
                                            </div>
                                            <!-- // -->
                                            <div class="col-md-6 form-group">
                                                <label>জেলা <span class="text-danger">*</span></label>
                                                <div data-district :ref="'required_district_'+index"></div>
                                            </div>
                                            <!-- // -->
                                            <div class="col-md-6 form-group">
                                                <label>উপজেলা <span class="text-danger">*</span></label>
                                                <div data-upazila :ref="'required_upazila_'+index"></div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>গ্রাম <span class="text-danger">*</span></label>
                                                <input type="text" v-model="form.members[index].village" class="form-control required" placeholder="গ্রাম">
                                            </div>
                                        </Location>

                                    </div>


                                </div>
                                <!-- // -->
                            </div>
                            <!-- // -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 form-group" title="উৎপাদিত দুধের পরিমান (প্রতিদিন)"> 
                                        <!-- (প্রতিদিন) -->
                                        <label><small>উৎপাদিত দুধের পরিমান</small></label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" v-model="form.members[index].amount_of_milk_produced" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">লিটার</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="">গাভী</label>
                                        <input type="number" min="0" v-model="form.members[index].total_gavi" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>বকনা</label>
                                        <input type="number" min="0" v-model="form.members[index].total_bokna" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>বকন বাছুর</label>
                                        <input type="number" min="0" v-model="form.members[index].total_bokon_bachor" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>এঁড়ে বাছুর</label>
                                        <input type="number" min="0" v-model="form.members[index].total_bokna" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>ষাঁড়</label>
                                        <input type="number" min="0" v-model="form.members[index].total_shar" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>বলদ</label>
                                        <input type="number" min="0" v-model="form.members[index].total_bolod" class="form-control">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>মহিষ</label>
                                        <input type="number" min="0" v-model="form.members[index].total_mohish" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>কোথায় বিক্রয় হয়</label>
                                        <textarea style="min-height:125px" v-model="form.members[index].where_sales_are" class="form-control" placeholder="কোথায় বিক্রয় হয়" cols="30" rows="4"></textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>মন্তব্য</label>
                                        <textarea style="min-height:125px" v-model="form.members[index].remark" class="form-control" placeholder="মন্তব্য" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <div class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success border-success" @click="addExicutiveMemberInfo()"><i class="fa fa-plus" aria-hidden="true"></i> আরও যুক্ত করুন</button>
                            <button type="submit" class="btn btn-success border-success ml-1"><i class="fa fa-floppy-o" aria-hidden="true"></i> সংরক্ষণ করুন</button>
                        </div>
                    </div>
                </form>
                <!-- --------------------------- MEMBER LIST -------------------------- -->
                <hr class="mb-0">

                <div class="table-responsive mb-0">
                    <caption class="text-nowrap m-0 p-0">সকল সদস্যদের তালিকা</caption>
                    <table class="table table-bordered custom mb-2">
                        <thead>
                            <tr>
                                <th width="40px">ক্রমিক</th>
                                <th class="text-center">সদস্যের নাম</th>
                                <th class="text-center">বয়স</th>
                                <th class="text-center">পিতার/স্বামীর</th>
                                <th class="text-center">গ্রাম</th>
                                <th class="text-center">গাভী</th>
                                <th class="text-center">বকনা</th>
                                <th class="text-center">বকন বাছুর</th>
                                <th class="text-center">এঁড়ে বাছুর</th>
                                <th class="text-center">ষাঁড়</th>
                                <th class="text-center">বলদ</th>
                                <th class="text-center">মহিষ</th>
                                <th class="text-center">মোট গবাদি পশুর সংখ্যা</th>
                                <th class="text-center">উৎপাদিত দুধের পরিমান</th>
                                <th class="text-center">কোথায় বিক্রয় হয়</th>
                                <!-- <th class="text-center">মন্তব্যঃ</th> -->
                                <th class="text-center" width="40">অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(row, index) in all_members" :key="index">
                                <td>{{$en2bn(mkindex(++index))}}</td>
                                <td class="text-center">{{row.member_name}}</td>
                                <td class="text-center">{{row.age}}</td>
                                <td class="text-center">{{row.spouse_name_en}}</td>
                                <td class="text-center">{{row.village}}</td>
                                <td class="text-center">{{row.total_gavi}}</td>
                                <td class="text-center">{{row.total_bokna}}</td>
                                <td class="text-center">{{row.total_bokon_bachor}}</td>
                                <td class="text-center">{{row.total_are_bachor}}</td>
                                <td class="text-center">{{row.total_shar}}</td>
                                <td class="text-center">{{row.total_bolod}}</td>
                                <td class="text-center">{{row.total_mohish}}</td>
                                <td class="text-center">{{row.total_cattle}}</td>
                                <td class="text-center">{{row.amount_of_milk_produced}}</td>
                                <td class="text-center">{{row.where_sales_are ? row.where_sales_are : '---'}}</td>
                                <!-- <td class="text-center">{{row.remark}}</td> -->
                                <td class="text-center">
                                    <div class="btn-group custom">
                                        <button @click="edit(row.id)" class="btn btn-success">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <!-- // -->
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- // -->
                            <tr v-if="all_members.length==0">
                                <th colspan="16" class="text-center">কোনো সদস্য যুক্ত করা হয়নি </th>
                            </tr>
                        </tbody>
                    </table>
                    <pagination class="float-right" v-model="page_no" :records="total_row" :per-page="per_page" @paginate="getAllMembers"/>
                </div>
            </div>
            <!-- // -->
            <div class="cancel_btn border-top">
                <button type="button" class="btn btn-danger" @click="cancel"><i class="fa fa-times" aria-hidden="true"></i> বাতিল করুন</button>
            </div>

            <div class="progressbar" v-if="is_processing">
                <div style="display:grid">
                    <span>{{total_success}}/{{form.members.length}}</span>
                    <progress id="file" :value="total_success" :max="form.members.length">{{((form.members.length/100)*total_success)}}% </progress>
                </div>
            </div>

        </div>
        <Loader :loader="is_loading"/>
    </div>
</template>

<script>
    import EditMember from '@/components/association/EditMember.vue';
    import Gender from '@/components/system/Gender.vue';
    import Location from '@/components/system/Location.vue';
    //
    export default {
        props:['association_id', 'is_open'],
        components : {'edit-member':EditMember, Gender, Location },
        model:{
            prop  : 'is_open',
            event : 'change'
        },
        data(){
            return {
                kernel      : {},
                total_row   : 0,
                per_page    : 9,
                page_no     : 1,
                member_id   : '',
                gender      : '86',
                total_success : 0,
                total_member  : 0,
                is_processing : false,
                is_loading    : true,
                form:{
                    association_id : '',
                    members : [
                        {
                            member_name             : "",
                            spouse_name_en          : "",
                            village                 : "",
                            age                     : 0,
                            amount_of_milk_produced : 0,
                            where_sales_are         : '',
                            total_gavi              : 0,
                            total_bokna             : 0,
                            total_bokon_bachor      : 0,
                            total_are_bachor        : 0,
                            total_shar              : 0,
                            total_bolod             : 0,
                            total_mohish            : 0,
                            remark                  : "",
                        }
                    ]
                },
                all_members:[]
            }
        },
        mounted(){
            this.form.association_id = this.association_id;
            this.getAllMembers();
        },
        methods:{
            close(index){
                this.$delete(this.form.members, index);
            },
            edit(member_id){
                this.member_id = member_id;
            },
            saveMember()
            {

                if(this.ck_member_info()) 
                {
                    this.is_processing = true; this.total_success = 0;
                    //
                    var group = [], obj=this;
                    //
                    (this.form.members).forEach(row=>{
                        var index = group.length > 0 ? group.length-1 : group.length;
                        //
                        if(!group[index] || group[index].length==3) group[index+1] = [row];
                        else if(!group[index] || group[index].length<3) (group[index]).push(row);
                    });

                    group = Object.values(group);

                    var counter = 0;
                    //
                    function loop (index)
                    {
                        if(index < (group.length)){
                            var members = group[index];
                            counter+=1;

                            obj.$axios.post('association/add-member', {
                                association_id : obj.form.association_id,
                                members : members,
                            })
                            .then(response=>{
                                obj.total_success = obj.total_success+(members.length);
                                loop(counter);
                            });
                        } 
                        if((index) == group.length){

                            obj.getAllMembers();
                            obj.page_no = 1;
                            setTimeout(()=>{
                                obj.is_processing = false;
                                obj.form.members = [
                                    {
                                        member_name             : "",
                                        spouse_name_en          : "",
                                        village                 : "",
                                        age                     : 0,
                                        amount_of_milk_produced : 0,
                                        where_sales_are         : '',
                                        total_gavi              : 0,
                                        total_bokna             : 0,
                                        total_bokon_bachor      : 0,
                                        total_are_bachor        : 0,
                                        total_shar              : 0,
                                        total_bolod             : 0,
                                        total_mohish            : 0,
                                        remark                  : "",
                                    }
                                ];
                            }, 1000);
                            obj.$toastr.s("সদস্যদের তথ্য সফলভাবে সংগ্রহ করা হয়েছে");
                        }
                    }
                    //
                    loop(counter);
                }
            },
            ck_member_info()
            {
                var ready = true;

                var required_fields = document.querySelectorAll('.required');
                //
                Object.values(required_fields).forEach(field=>{
                    field.classList.remove('border-danger');
                    if(field.type=='number' && field.value < 18){
                        field.classList.add('border-danger');
                        ready = false;
                    }
                    else if(field.type && !field.value){
                        field.classList.add('border-danger');
                        ready = false;
                    }
                });

                Object.values(this.form.members).forEach((member, key)=>{

                    var gender   = this.$refs["required_gender_"+key]?this.$refs["required_gender_"+key][0]:false;
                    var division = this.$refs["required_division_"+key]?this.$refs["required_division_"+key][0]:false;
                    var district = this.$refs["required_district_"+key]?this.$refs["required_district_"+key][0]:false;
                    var upazila  = this.$refs["required_upazila_"+key]?this.$refs["required_upazila_"+key][0]:false;

                    if(gender && (!member.gender || !member.gender)) gender.querySelector('.vs__dropdown-toggle').classList.add('border-danger'); else if(gender) gender.querySelector('.vs__dropdown-toggle').classList.remove('border-danger');
                    if(division && (!member.geolocation || !member.geolocation.division_id)) division.querySelector('.vs__dropdown-toggle').classList.add('border-danger'); else if(division) division.querySelector('.vs__dropdown-toggle').classList.remove('border-danger');
                    if(district && (!member.geolocation || !member.geolocation.district_id)) district.querySelector('.vs__dropdown-toggle').classList.add('border-danger'); else if(district) district.querySelector('.vs__dropdown-toggle').classList.remove('border-danger');
                    if(upazila && (!member.geolocation || !member.geolocation.upazila_id) )  upazila.querySelector('.vs__dropdown-toggle').classList.add('border-danger'); else if(upazila) upazila.querySelector('.vs__dropdown-toggle').classList.remove('border-danger');

                    if(member.member_name=='' || member.age<18 || member.spouse_name_en=='' || member.village=='' || !member.gender || !member.geolocation.division_id || !member.geolocation.district_id || !member.geolocation.upazila_id){
                        ready = false;
                    }
                });
                //
                (ready==false ? this.$toastr.w('অনুগ্রহ করে সদস্যদের তথ্য চেক করুন!!!') : '');
                return ready;
            },
            mkindex:function(index){
                return this.$paginatedIndex(this.per_page, this.page_no, index);
            },
            getAllMembers(){
                this.http('association/all-member', 'all_member', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where : {
                        association_id : this.association_id
                    }
                });
            },
            addExicutiveMemberInfo:function(){
                (this.form.members).push({
                    member_name             : "",
                    mobile                  : "",
                    spouse_name_en          : "",
                    village                 : "",
                    age                     : 0,
                    amount_of_milk_produced : 0,
                    where_sales_are         : '',
                    total_gavi              : 0,
                    total_bokna             : 0,
                    total_bokon_bachor      : 0,
                    total_are_bachor        : 0,
                    total_shar              : 0,
                    total_bolod             : 0,
                    total_mohish            : 0,
                    remark                  : "",
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data)
                .then(res=>{this.kernel = Object.assign({}, {[type]:res.data})});
            },
            cancel(){
                document.querySelector('BODY').style.overflow = '';
                this.$emit('change', '');
                //
                if(this.$route.path!='/association/edit'){
                    this.$router.push({path:`/association/all`});
                }
            }
        },
        watch:{
            member_id:function(){
                if(this.member_id==''){
                    this.getAllMembers();
                }
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='member-add'){
                        if(this.kernel[key].erros){
                            this.$toastr.w(this.kernel[key].erros);
                        }
                        else {
                            this.$toastr.s('সদস্যদের সফলভাবে সংরক্ষণ করা হয়েছে');
                            this.getAllMembers();
                            this.form.members = [
                                {
                                    member_name             : "",
                                    spouse_name_en            : "",
                                    village                 : "",
                                    age                     : 0,
                                    amount_of_milk_produced : 0,
                                    where_sales_are         : '',
                                    total_gavi              : 0,
                                    total_bokna             : 0,
                                    total_bokon_bachor      : 0,
                                    total_are_bachor        : 0,
                                    total_shar              : 0,
                                    total_bolod             : 0,
                                    total_mohish            : 0,
                                    remark                  : "",
                                }
                            ]
                        }
                    }
                    else if(key=='all_member'){
                        this.all_members  = this.kernel[key].data;
                        this.total_row    = this.kernel[key].total_row;
                        this.total_member = this.kernel[key].total_member;
                        this.is_loading   = false;
                    }
                }
            }
        }
    }
</script>

<style scoped >
    .progressbar {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #dddddde6;
        z-index: 9999;
    }
    .member_rows {
        background: #f3f3f3;
        padding-top: 7px;
        margin-top: 4px;
    }
    .card {
        position: initial;
    }
    .cancel_btn {
        width: 100%;
        position: absolute;
        right: 0;
        bottom: 0;
        background: #fff;
        padding: 12px;
        display: flex;
        justify-content: right;
        z-index: 99;
    }
    .qck-btn-custom {
        position: absolute;
        right: 15px;
        bottom: 15px;
    }
    .custom button {
        padding: 1px 8px!important;
        font-size: 11px!important;
        line-height: 21px;
    }
    .card-header-custom {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 99;
        width: 100%;
    }
    .popup-box {
        width: 75%!important;
        border-radius: 4px;
    }
</style>
