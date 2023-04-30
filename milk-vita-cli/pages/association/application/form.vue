<template>
    <div>
        <div class="card" v-if="!is_application">
            <div class="card-header d-flex justify-content-between">
                <h3 class="m-0">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>সমিতির নিবন্ধন</span>
                </h3>
            </div>
            <div class="card-body min65vh position-relative">
                <div class="custom-form">
                    <div class="alert alert-success" style="width:500px">
                        <div class="form-group">
                            <h5 for="association_name"> সমিতি নির্বাচন করুন </h5>
                            <div class="input-group mb-3">
                                <select-picker 
                                    class="form-control p-0 m-0 border-0"
                                    aria-label="সমিতি নির্বাচন করুন" 
                                    aria-describedby="basic-addon2"
                                    placeholder="সমিতি নির্বাচন করুন"
                                    v-model="association_id"
                                    :options="associations"
                                    :reduce="row=>row.id"
                                    label="association_name"
                                />

                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-success" @click="CTApplication"> এগিয়ে যান &nbsp;<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card-footer">&nbsp;</div> -->
        </div>


        <!-- // APPLICATION FORM // -->
        <application
            v-if="is_application"
            :association_id="association_id"
        ></application>

    </div>
</template>

<script>
    import application from '@/components/association/ApplicationForm.vue';
    export default {
        layout:'admin',
        name:'app',
        components:{
            application:application
        },
        data(){
            return {
                associations    : [],
                is_application  : false,
                association_id  : '',
            }
        },
        mounted(){
            this.$axios.post('association/list', {
                type:'for-application',
                select:['id', 'association_name'],
            }).then(res=>{
                this.associations = res.data.data;
            });
        },
        methods:{
            CTApplication(){
                if(this.association_id){
                    this.is_application = true;
                }
                else{
                    this.$alert({
                        icon:'warning',
                        text:'সমিতি নির্বাচন করে চেষ্টা করুন'
                    });
                }
            }
        },
    }
</script>

<style scoped>
    .custom-form {
        display: grid;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -59%);
    }
    #association_name {
        min-width: 276px;
    }
</style>
