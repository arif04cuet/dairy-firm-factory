<template>
    <div class="card">
        <div class="card-body p-5">
            <div class="form-header">
                <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                <h2>প্রধান কার্যালয়</h2>
                <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
            </div>

            <hr>

            <div class="alert alert-warning" v-if="form.control_flow && (form.control_flow.is_reject_chilling_plant_manager==1 || form.control_flow.is_reject_milkvita_officer==1 || form.control_flow.is_reject_cooperative_officer)">{{form.control_flow.remark}}</div>

            <h6 class="pb-2 mb-3 text-strong"> প্রস্তাবিত প্রাথমিক সমবায় সমিতি সংগঠন সংক্রান্ত তথ্য স্বারক </h6>

            <div class="row form-group">
                <div class="col-md-4 form-group">
                    <label class="text-strong">১. প্রস্তাবিত সমিতির নাম</label>
                    <input type="text" class="form-control" v-model="form.association_name" :readonly="checkStatus('text')">
                </div>

                <div class="col-md-4 form-group">
                    <label class="text-strong">২. দুগ্ধ এলাকার নাম</label>
                    <input type="text" class="form-control" v-model="form.name_of_dairy_area" readonly>
                </div>

                <div class="col-md-4 form-group">
                    <label class="text-strong"> ৩. সমিতির কার্যকরী এলাকা</label>
                    <input type="text" class="form-control" v-model="form.working_area_of_association" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-4 text-strong pr-0 mt-2"> ৪. প্রস্তাবিত সমিতির কোডঃ:</div>
                        <div class="col-md-2 pl-0">
                            <input type="text" class="form-control" :value="$en2bn(form.association_code)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-4 text-strong pr-0 mt-2"> ৫. সাংগঠনিক সভায় উপস্থিত সদস্য সংখ্যাঃ</div>
                        <div class="col-md-2 pl-0">
                            <input type="text" class="form-control" :value="$en2bn(form.total_present_member)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="col-md-4 text-strong pr-0 mt-2"> ৬. কার্যকরী কমিটির সদস্যগণের সংখ্যাঃ</div>
                        <div class="col-md-2 pl-0">
                            <input type="text" class="form-control" :value="$en2bn(form.total_committe_member)" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="border-bottom mb-3"><strong> ৭. দুগ্ধ এলাকার ঠিকানাঃ</strong></label>&ensp;
                    {{$locationSanitize(form.milk_area_location_details)}}|
                    <label class="text-strong">গ্রাম : {{form.milk_area_village}}</label>   
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label class="border-bottom mb-2"><strong> ৮. সমিতির ঠিকানাঃ </strong></label>&ensp;
                    {{$locationSanitize(form.association_location_details)}}|
                    <label class="text-strong">গ্রাম : {{form.association_village}}</label> 
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-6 text-strong pr-0 mt-1"><label for=""> ৯. প্রস্তাবিত সমিতির কার্যকরী এলাকা হইতে পার্শ্ববর্তি সমিতির কার্যকরী এলাকার দূরত্বঃ</label></div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" :value="$en2bn(form.distance_of_working_area_to_adjoining_area)" readonly aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">কিঃ মিঃ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-6 text-strong"><label for=""> ১০. প্রস্তাবিত সমিতির দুগ্ধ সংগ্রহ কেন্দ্র হইতে কারখানার দূরত্বঃ</label></div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" :value="$en2bn(form.distance_of_factory_to_association_center)" readonly aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">কিঃ মিঃ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="border-bottom text-strong"> ১১. রাস্তার ধরন  <span><i class="fa fa-spinner fa-spin" v-if="is_loading_types"></i></span>  </label>
                    <ol>
                        <li v-for="(item, index) in form.road_types" :key="index">
                            <div class="row form-group">
                                <div class="col-md-5 custom-label">
                                    <label for="name">
                                        <span>&nbsp;</span>
                                        <input type="text" class="form-control" :value="$en2bn(item.distance)" readonly>
                                    </label>
                                </div>

                                <div class="col-md-4">
                                    <input type="text" class="form-control" :value="item.road_type_name" readonly>
                                </div>

                                <div class="col-md-3 custom-label">
                                    {{item.unit}}
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <p>প্রত্যয়ন করা যাইতেছে যে, প্রস্তাবিত <strong class="text-info border-bottom">{{form.association_name}}</strong> সমিতির নিয়ম মোতাবেক সংগ্রহ করা হইতেছে। অত্র সমিতির কার্যকরী এলাকা নিবিড় ও সলংগ্ন। সাংগঠনিক সভায় উপস্তি সমিতির সদস্য পদ গ্রহনে আগ্রহী ব্যক্তিগনের বয়স ১৮ বৎসরের নিচে নহে  প্রত্যেকে গাভী পালন করেন </p>

            <!-- // Resolution info // -->
            <hr>

            <div class="row mb-4">
                <div class="col-md-12 text-strong pr-0 mt-2 mb-4"> ১২. দুগ্ধ সংরক্ষণের স্থানঃ &nbsp;{{form.dairy_storage_area}}</div>

                <div class="col-md-12">

                    <label class="text-strong"> ১৩. সদস্যদের তালিকা </label>
                    <hr class="mt-0">

                    <div class="table-responsive">
                        <table class="table table-bordered custom">
                            <thead>
                                <tr>
                                    <th width="40">ক্রমিক</th>
                                    <th class="text-center">সদস্যের নাম</th>
                                    <th class="text-center">উপাধি</th>
                                    <th class="text-center">বয়স</th>
                                    <th class="text-center">কোড</th>
                                    <th class="text-center">গাভী</th>
                                    <th class="text-center">বকনা</th>
                                    <th class="text-center">বকন বাছুর</th>
                                    <th class="text-center">এঁড়ে বাছুর</th>
                                    <th class="text-center">ষাঁড়</th>
                                    <th class="text-center">বলদ</th>
                                    <th class="text-center">মহিষ</th>
                                    <th class="text-center">গাভীর সংখ্যা</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in form.members" :key="index">
                                    <td>{{$en2bn(index+1)}}</td>
                                    <td class="text-center">{{row.member_name}}</td>
                                    <td class="text-center">{{row.designation}}</td>
                                    <td class="text-center">{{row.age}}</td>
                                    <td class="text-center">{{row.member_code ? row.member_code : '#'}}</td>
                                    <td class="text-center">{{row.total_gavi}}</td>
                                    <td class="text-center">{{row.total_bokna}}</td>
                                    <td class="text-center">{{row.total_bokon_bachor}}</td>
                                    <td class="text-center">{{row.total_are_bachor}}</td>
                                    <td class="text-center">{{row.total_shar}}</td>
                                    <td class="text-center">{{row.total_bolod}}</td>
                                    <td class="text-center">{{row.total_mohish}}</td>
                                    <td>{{row.total_cattle}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mb-4" v-if="form.manager">
                <div class="col-md-12">
                    <label class="text-strong"> ১৪. সমিতির ম্যানেজারের তথ্য </label>
                    <hr class="mt-0">
                    <div class="row pl-4">
                        
                        <label class="col-md-3 text-strong text-nowrap">১. ম্যানেজারের নাম</label><span class="col-md-9 text-strong">: {{form.manager.name_bn}}</span>
                        
                        <label class="col-md-3 text-strong text-nowrap">২. ম্যানেজারের মোবাইল নাম্বার</label><span class="col-md-9 text-strong">: {{form.manager.mobile}}</span>

                        <label class="col-md-3 text-strong text-nowrap">৩. ইমেইল এড্রেস</label><span class="col-md-9 text-strong">: {{form.manager.email}}</span>

                        <label class="col-md-3 text-strong text-nowrap">৪. জাতীয় পরিচয়পত্র নম্বর</label><span class="col-md-9 text-strong">: {{form.manager.nid_no}}</span>
                        
                        <label class="col-md-3 text-strong text-nowrap">৫. ম্যানেজারের ঠিকানা</label> <span class="col-md-9 text-strong">: {{form.manager.address}}</span>
                        
                    </div>
                </div>
            </div>

            <div class="row" v-if="form.bank_infos">
                <div class="col-md-12" v-for="(row, index) in form.bank_infos" :key="index">
                    <label class="text-strong"> {{$en2bn((index+15))}}. {{row.type=='commission_account' ? 'দুগ্ধ কমিশন একাউন্ট' : 'দুগ্ধ বিল একাউন্ট'}}</label>
                    <hr class="mt-0">
                    <div class="row pl-4">

                        <label class="col-md-3 text-strong text-nowrap">১. ব্যাংকের নাম</label><span class="col-md-9 text-strong">: {{row.bank_name}}</span>
                        
                        <label class="col-md-3 text-strong text-nowrap">২. শাখার নাম</label><span class="col-md-9 text-strong">: {{row.branch_name}}</span>
                        
                    </div>
                </div>
            </div>


            <div class="row pt-5">
                <div class="col-md-3" style="display:grid">
                    <img height="35" style="margin:auto" :src="(Object.values(form).length > 0) ? (form.signatures ? host_server+form.signatures.field_officer_signature_path :'') : ''" alt="">
                     <small class="text-center text-nowrap border-top">ফিল্ড অফিসার </small>
                </div>

                <div class="col-md-3" style="display:grid">
                    <img height="35" style="margin:auto" :src="(Object.values(form).length > 0) ? (form.signatures ? host_server+form.signatures.chilling_plant_manager_signature_path :'') : ''" alt="">
                    <small class="text-center text-nowrap border-top">চিলিং প্ল্যান্ট ম্যানেজার</small>
                </div>

                <div class="col-md-3" style="display:grid">
                    <img height="35" style="margin:auto" :src="(Object.values(form).length > 0) ? (form.signatures ? host_server+form.signatures.milkvita_officer_signature_path :'') : ''" alt="">
                     <small class="text-center text-nowrap border-top">চেয়ারম্যান</small>
                </div>

                <div class="col-md-3" style="display:grid">
                    <img height="35" style="margin:auto" :src="(Object.values(form).length > 0) ? (form.signatures ? host_server+form.signatures.upazila_cooperative_officer_signature_path :'') : ''" alt="">
                     <small class="text-center text-nowrap border-top">উপজেলা সমবায় কর্মকর্তা</small>
                </div>
            </div>
            
            <div v-if="form.control_flow  && relation=='chilling-plant-manager'" class="mt-4 pt-4 text-right">
                <div class="btn-group" v-if="form.control_flow.is_resolution==0 && form.control_flow.is_approved_chilling_plant_manager==0">
                    <div v-if="form.control_flow.is_resolution==0 && form.control_flow.is_approved_chilling_plant_manager==0 && form.control_flow.is_reject_chilling_plant_manager==0 && form.control_flow.is_forward_for_correction==0">
                        <button class="btn btn-info" @click="updateStatus('approve', form.id)">
                            <i class="fa fa-check" aria-hidden="true"></i> &nbsp;
                            Approve
                        </button>

                        <button class="btn btn-danger ml-1" @click="updateStatus('reject', form.id)">
                            <i class="fa fa-times" aria-hidden="true"></i> &nbsp;
                            Reject
                        </button>

                        <button class="btn btn-danger ml-1" @click="updateStatus('correction', form.id)">
                            <i class="fa fa-share" aria-hidden="true"></i> &nbsp;
                            For Correction
                        </button>
                    </div>
                </div>
                    
                <div v-if="form.control_flow && form.control_flow.is_resolution==0">
                    <button class="btn btn-light border" v-if="form.control_flow.is_approved_chilling_plant_manager==1 || form.control_flow.is_reject_chilling_plant_manager==1 || form.control_flow.is_forward_for_correction==1">
                        {{
                            (form.control_flow.is_approved_chilling_plant_manager==1 ? 'Approved':
                                (form.control_flow.is_reject_chilling_plant_manager==1 ? 'Rejected':
                                (form.control_flow.is_forward_for_correction==1? 'Forward For Correction' : '')
                            ))
                        }}
                    </button>
                </div>
                    
                <div v-if="form.control_flow && form.control_flow.is_resolution==1">
                    <button class="btn btn-info" :class="(form.control_flow.is_forward_chilling_plant_manager==1 ? 'btn-light' : '')" @click="(form.control_flow.is_forward_chilling_plant_manager==0 ? updateStatus('forward', form.id) : '')">
                        <i :class="(form.control_flow.is_forward_chilling_plant_manager==0 ? 'fa fa-paper-plane-o' : 'fa fa-check')" aria-hidden="true"></i> &nbsp;
                        {{(form.control_flow.is_forward_chilling_plant_manager==0 ? 'Forward' : 'Forwarded')}}
                    </button>
                </div>

            </div>
            
            <div v-if="form.control_flow && relation=='chilling-plant-officer'" class="mt-4 pt-4 text-right">
                <div class="btn-group">
                    <div v-if="form.control_flow.is_approved_milkvita_officer==0 && form.control_flow.is_reject_milkvita_officer==0">
                        <button class="btn btn-info" @click="updateStatus('approve', form.id)">
                            <i class="fa fa-check" aria-hidden="true"></i> &nbsp;
                            Approve
                        </button>

                        <button class="btn btn-danger ml-1" @click="updateStatus('reject', form.id)">
                            <i class="fa fa-times" aria-hidden="true"></i> &nbsp;
                            Reject
                        </button>
                    </div>

                    <button v-else class="btn btn-light border">
                        <i class="fa fa-check" aria-hidden="true"></i> &nbsp;
                        {{
                            (form.control_flow.is_approved_milkvita_officer==1?'Approved':
                            (form.control_flow.is_reject_milkvita_officer==1?'Rejected':''))
                        }}
                    </button>
                </div>
            </div>

            <Loader :loader="is_loader" />
        </div>
    </div>
</template>

<script>
    export default {
        name:'ApplicationDetals',
        layout:'admin',
        props:['relation'],
        data(){
            return {
                kernel              : {},
                is_loader           : true,
                divisions           : [],
                districts           : [],
                thanas              : [],
                somity_districts    : [],
                somity_thanas       : [],
                road_types          : [],
                is_loading_types    : false,
                is_submit           : false,
                form                : {},
                host_server         : process.env.HOST_SERVER,
            }
        },
        mounted(){
            this.fetchAssociation();
            //
            this.http('road-type/all', 'road_types');
        },
        methods:{
            checkStatus(niddle){
                if(this.relation=='chilling-plant-manager' && this.form.control_flow)
                {
                    if(this.form.control_flow.is_approved_chilling_plant_manager==1){
                        return (niddle=='text'?'Approved':false);
                    }
                    else if(this.form.control_flow.is_reject_chilling_plant_manager==1){
                        return (niddle=='text'?'Rejected':false);
                    }
                    else if(this.form.control_flow.is_forward_for_correction==1){
                        return (niddle=='text'?'Forward For Correction':false);
                    }
                    else if(this.form.control_flow.is_forward_chilling_plant_manager==1){
                        return (niddle=='text'?'Forward To Chairman':false);
                    }
                }
                return (niddle=='text' ? true:true);
            },
            updateStatus(status, id){
                var option = {
                    text: "আপনি কি নিশ্চিত, এই আবেদন সংশোধন জন্য ফিরিয়ে দিতে চান ?",
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonText: "বাতিল করুন",
                    confirmButtonText: "সাবমিট করুন",
                };

                if(status=='reject' || status=='correction'){
                    option = Object.assign(option, {
                        input: 'textarea',
                        inputAttributes:{
                            placeholder:'আপনার মন্তব্য লিখুন'
                        }
                    });
                }

                option.text = (status=="reject" ? "আপনি কি নিশ্চিত, এই আবেদনটি বাতিল করতে চান ?" : 
                              (status=="correction" ? "আপনি কি নিশ্চিত, এই আবেদন সংশোধন জন্য ফিরিয়ে দিতে চান ?" : 
                              (status=="approve" ? "আপনি কি নিশ্চিত, এই আবেদনটি অনুমতি দিতে চান ?" : 
                              (status=="forward" ? "আপনি কি নিশ্চিত, এই আবেদনটি ফরওয়ার্ড করতে চান ?" : ""))))

                this.$alert(option)
                .then((result)=>{
                    if(result.isConfirmed){
                        this.http('association/status-update/'+this.$route.query.id, 'status-update', {
                            'status' : status,
                            'remark' : result.value,
                            'type'   : (this.relation=='chilling-plant-manager' ? 'plant-manager':'plant-officer')
                        });
                    }
                });
            },
            fetchAssociation(){
                this.http('association/list', 'association', {
                    where:{ id:this.$route.query.id }
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel:function(){
                for(const key in this.kernel){
                    if(key=='status-update'){
                       this.$toastr.s('আবেদনটি সফলভাবে প্রক্রিয়াকরণ করা হয়েছে');
                       this.fetchAssociation();
                    }
                    else if(key=='road_types'){
                        this.road_types       = this.kernel[key];
                        this.road_type_limit  = (this.kernel[key]).length-1;
                        this.is_loading_types = false;
                    }
                    else if(key=='send_application'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                            this.is_submit = false;
                        }
                        else {
                            this.is_submit = false;
                            this.$toastr.s('আপনার আবেদনটি সংরক্ষন করা হয়েছে');
                            this.$router.push({path:'/association/application/list'});
                        }
                    }
                    else if(key=='association'){
                        if(this.kernel[key].data[0]){
                            this.form = this.kernel[key].data[0];
                            this.is_loader = false;
                            // 
                        }
                    }
                }
            }
        }
    }
</script>

<style>
    .custom-btn-group {
        display: grid;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -59%);
    }
</style>
