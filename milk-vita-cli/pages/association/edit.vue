<template>
<div>
    <div class="card p-4 pt-3">
        <div class="card-body min65vh">
            <form @submit.prevent="saveAssociation()">
                <div class="form-header">
                    <h1>বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড(মিল্কভিটা)</h1>
                    <h2>প্রধান কার্যালয়</h2>
                    <h2>দুগ্ধ ভবন, ১৩৯-১৪০ তেজগাঁও শিল্প এলাকা, ঢাকা-১২০৮</h2>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="text-strong">১. দুগ্ধ এলাকার নাম</label>
                        <input type="text" class="form-control" v-model="form.name_of_dairy_area" placeholder="দুগ্ধ এলাকার নাম" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="text-strong"> ২. প্রস্তাবিত সমিতির নাম</label>
                        <input type="text" class="form-control" v-model="form.association_name" placeholder="প্রস্তাবিত সমিতির নাম" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="text-strong"> ৩. সমিতির কার্যকরী এলাকা</label>
                        <input type="text" class="form-control" v-model="form.working_area_of_association" placeholder="সমিতির কার্যকরী এলাকা" required>
                    </div>

                    <div class="col-md-12">
                        <div class="btn-group float-right" v-if="is_open==false">
                            <button type="button" class="btn btn-info" @click="toList()">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                সমিতির তালিকায় ফিরে যান
                            </button>

                            <button type="button" class="btn btn-primary ml-2" @click="member_panel()">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                সদস্য আপডেট করুন
                            </button>

                            <button class="btn btn-success ml-2">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                সমিতি আপডেট করুন
                            </button>
                        </div>
                    </div>
                    
                </div>
            </form>
            
            <div v-if="is_open" class="popup">
                <div class="popup-box" style="width: 90% !important;">
                    <add-member
                        class="popup-inner-div"
                        :association_id = "regi_id"
                        v-model="is_open"
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
        name:'add',
        layout:'admin',
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
                edit_id     : '',
                kernel      : {},
                is_open : false,
                regi_id     : '',
                loader      : false,
                form : {
                    working_area_of_association : '',
                    name_of_dairy_area          : '',
                    association_name            : '',
                }
            }
        },
        mounted(){
            this.edit_id = this.$route.query.id;
            this.regi_id = this.$route.query.id;
        },
        methods:{
            toList(){
                this.$router.push({path:'/association/all'});
            },
            member_panel(){
                this.is_open = true;
                document.querySelector('BODY').style.overflow = 'hidden';
            },
            saveAssociation(){
                this.loader  = true;
                this.http('association/update/'+this.edit_id, 'update', this.form);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='update'){
                        this.$toastr.s('সমিতি সফলভাবে আপডেট হয়েছে');
                        this.loader   = false;
                    }
                    else if(key=='get_association'){
                        this.form = this.kernel[key].data[0];
                    }
                }
            },
            edit_id:function(){
                this.http('association/list', 'get_association', {
                    where:{
                        id:this.edit_id
                    },
                    select:['id', 'working_area_of_association', 'name_of_dairy_area', 'association_name'],
                    type:'survey-list'
                });
            }
        }
    }
</script>

<style scoped>
    .popup-box {
        width: 90%;
        border-radius: 4px;
    }
    .popup-inner-div {
        width: 100%;
        max-height: 90vh;
        display: block;
        overflow: auto;
    }
</style>
