<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>&nbsp;
                    <span>সময়সূচী</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/task-schedule/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form>
                <div class="row">
                    <label class="col-md-3 text-right mt-2" for="start-date">শুরুর তারিখ</label>
                    <div class="col-md-6">
                        <div class="form-group">
                            <date-picker 
                                readonly
                                v-model="form.start_date"
                                id="start-date"
                                placeholder="শুরুর তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <label class="col-md-3 text-right mt-2" for="end-date">শেষ তারিখ</label>
                    <div class="col-md-6">
                        <div class="form-group">
                            <date-picker 
                                readonly
                                v-model="form.end_date"
                                id="end-date"
                                placeholder="শুরুর তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right mt-3">বিষয়</label>
                    <div class="col-md-6 pt-3">
                        : {{form.subject}}
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right mt-3">বর্ণনা</label>
                    <div class="col-md-6 pt-3">
                        : {{form.description}}
                    </div>
                </div>
            </form>

            <div v-if="form.is_complete==0" class="alert alert-info mt-3">
                <div class="row">
                    <div class="col-md-9 d-flex justify-content-end">
                        <h4 class="m-0 mt-1 mr-2">টাস্কটি সম্পূর্ণ হয়েছে ?</h4>
                        <div class="btn-group">
                            <button @click="doneSchedule()" class="btn btn-success" style="min-width:120px">
                                <span v-if="is_processing==false"><i class="fa fa-check-square-o" aria-hidden="true"></i> &nbsp;হ্যাঁ</span>
                                <span v-else ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> &nbsp;লোডিং...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="form.is_complete==1" class="alert alert-info mt-3">
                <div class="row">
                    <div class="col-md-9 d-flex justify-content-end">
                        <h4 class="m-0 mt-1 mr-2">টাস্কটি সম্পূর্ণ হয়েছে {{$en2bn(form.complete_date)}} তারিখে</h4>
                    </div>
                </div>
            </div>

        </div>
        <Loader :loader="loader"/>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel     : {},
                form       : {},
                editable_id: '',
                is_processing : false,
                loader : true,
            }
        },
        mounted(){
            this.editable_id = this.$route.query.id;
        },
        methods:{
            doneSchedule(){
                this.is_processing = true;
                this.http('task-schedule/done/'+this.editable_id, 'done');
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            editable_id(){
                if(this.editable_id)
                    this.http('task-schedule/view/'+this.editable_id, 'details');
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='details'){
                        this.form = this.kernel[key];
                        this.loader = false;
                    }
                    else if(key=='done'){
                        this.is_processing = false;
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else {
                            this.$toastr.s("টাস্কটি সফলভাবে সম্পন্ন করা হয়েছে");
                            this.http('task-schedule/view/'+this.editable_id, 'details');
                        }
                        console.log(this.kernel[key]);
                    }
                }
            }
        }
    }
</script>

<style>

</style>
