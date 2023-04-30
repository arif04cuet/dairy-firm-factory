<template>
<div>
    <div class="card">
        <div class="card-body pt-5 min70vh">
            <form @submit.prevent="saveAssociation()">
                <div class="form-header">
                    <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                    <h2>প্রধান কার্যালয়</h2>
                    <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <label class="text-strong"> ১. দুগ্ধ এলাকার নাম</label>
                        <input type="text" class="form-control" v-model="form.name_of_dairy_area" placeholder="দুগ্ধ এলাকার নাম" required :readonly="is_submited">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <label class="text-strong"> ২. প্রস্তাবিত সমিতির নাম</label>
                        <input type="text" class="form-control" v-model="form.association_name" placeholder="প্রস্তাবিত সমিতির নাম" required :readonly="is_submited">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <label class="text-strong"> ৩. সমিতির কার্যকরী এলাকা</label>
                        <input type="text" class="form-control" v-model="form.working_area_of_association" placeholder="সমিতির কার্যকরী এলাকা" required :readonly="is_submited">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-10">
                        <div class="btn-group float-right" v-if="is_submited==false">
                            <button class="btn btn-success">
                                সংরক্ষণ করুন এবং এগিয়ে যান
                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <div v-if="is_submited" class="popup">
                <div class="popup-box">
                    <add-member
                        class="popup-inner-div"
                        :association_id = "regi_id"
                    ></add-member>
                </div>
            </div>

            <Loader :loader="loader" />
        </div>
    </div>
</div>
</template>

<script>
    import AddMember from '@/components/association/AddMember.vue';
    export default {
        layout:'admin',
        name:'add',
        components:{
            'add-member':AddMember
        },
        head(){
            return {
                title:'সমিতি নিবন্ধন'
            }
        },
        data(){
            return {
                kernel      : {},
                is_submited : false,
                regi_id     : '',
                loader      : false,
                form : {
                    working_area_of_association : '',
                    name_of_dairy_area          : '',
                    association_name            : '',
                }
            }
        },
        methods:{
            saveAssociation(){
                this.loader  = true;
                document.querySelector('BODY').style.overflow = 'hidden';
                this.http('association/store', 'store', this.form);
            },
            geolocation() {
                var option = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition((pos)=>{
                    var crd = pos.coords;
                    this.form.latitude  = crd.latitude;
                    this.form.longitude = crd.longitude;
                },
                (err)=>console.warn(`ERROR(${err.code}): ${err.message}`), option);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='store'){
                        this.$toastr.s('সমিতি সফলভাবে তৈরি হয়েছে');
                        this.is_submited = true;
                        this.loader      = false;
                        this.regi_id     = this.kernel[key].id;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .popup-box {
        width: 75%;
        border-radius: 4px;
    }
    .popup-inner-div {
        width: 100%;
        max-height: 90vh;
        display: block;
        overflow: auto;
    }
</style>
