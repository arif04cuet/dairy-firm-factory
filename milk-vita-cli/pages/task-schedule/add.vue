<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-plus"></i>&nbsp;
                    <span>সময়সূচী যোগ করুন</span>
                </h5>
                <div class="btn-group">
                    <nuxt-link to="/task-schedule/list" class="btn btn-primary">
                        <i class="fa fa-list"></i>&nbsp;তালিকায় ফিরে যান
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <form @submit.prevent="submit()">
                <div class="row">
                    <label class="col-md-3 text-right mt-2" for="start-date">শুরুর তারিখ</label>
                    <div class="col-md-6">
                        <div class="form-group">
                            <date-picker 
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
                                v-model="form.end_date"
                                id="end-date"
                                placeholder="শুরুর তারিখ"
                                :locale="$store.state.local"
                            />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right mt-2">বিষয়</label>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" v-model="form.subject" class="form-control" placeholder="বিষয়">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 text-right mt-2">বর্ণনা</label>
                    <div class="col-md-6">
                       <textarea v-model="form.description" class="form-control" cols="15" rows="7" placeholder="বর্ণনা"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 text-right pt-3">
                        <div class="btn-group">
                            <button class="btn btn-success" style="min-width:130px">
                                <span v-if="is_submit==false"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;সাবমিট করুন</span>
                                <span v-else ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;লোডিং...</span>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'Add',
        data(){
            return {
                kernel     : {},
                is_submit  : false,
                form       : {},
            }
        },
        methods:{
            submit(){
                this.is_submit = true;
                this.http('task-schedule/store', 'store', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='store'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.$msgSenitize(this.kernel[key].errors));
                        }
                        else {
                            this.$toastr.s("সময়সূচী সফল ভাবে সংরক্ষন করা হয়েছে");
                            this.$router.push({path:'/task-schedule/list'});
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>
