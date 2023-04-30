<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">সকল পণ্যের ইউনিট</h5>
                <div class="btn-group">
                    <nuxt-link to="/product/unit/add" class="btn btn-primary" v-if="$ck_action('/product/unit/add')">
                        <i class="fa fa-plus"></i>&nbsp;পণ্যের ইউনিট তৈরি করুন
                    </nuxt-link>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <select-picker
                                placeholder="ইউনিট নির্বাচন করুন"
                                :options="all_unit"
                                v-model="search.id"
                                :reduce="row=>row.id"
                                label="unit_name"

                            />
                        </div>
                        
                        <div class="col-md-2">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th class="text-left">ইউনিট নাম</th>
                            <th width="70" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in units" :key="index">
                            <td class="text-center">{{$en2bn(++index)}}</td>
                            <td class="text-left">{{ row.unit_name }}</td>
                            <td class="text-center">
                                <div class="btn-group custom">
                                    <nuxt-link :to="'/product/unit/edit?id='+row.id" v-if="$ck_action('/product/unit/edit')">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                    </nuxt-link>
                                    
                                    <!-- // -->
                                    <nuxt-link to="#" v-if="$ck_action('/product/unit/destroy')">
                                        <button class="btn btn-danger" @click="destroy(row.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </nuxt-link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="(units).length==0">
                            <td colspan="3">কোনো ইউনিট পাওয়া যায়নি </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchunit"/>
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


    </div>
</template>
<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel          : {},
                all_unit        : [],
                units           : [],
                search          : {id:''},
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : true,
            }
        },
        mounted(){
            this.fetchunit();
            //
            this.http('product/unit/list', 'all_unit');
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchunit();
            },
            destroy(id){
                this.$alert({
                    icon:'question',
                    text: 'আপনি কি নিশ্চিত, ইউনিট মুছে ফেলতে চান?',
                    showCancelButton: true,
                    confirmButtonText: 'হ্যাঁ',
                    cancelButtonText: `না`,
                })
                .then((result) => {
                    if(result.isConfirmed) {
                        this.http('product/unit/destroy/'+id, 'destroy');
                    }
                })
            },
            fetchunit(){
                this.loader = true;
                this.http('product/unit/list', 'units', {
                    per_page    : this.per_page,
                    page_no     : this.page_no,
                    where       : this.search
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='units'){
                        this.units = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                    else if(key=='all_unit'){
                        this.all_unit = this.kernel[key].data;
                    }
                    else if(key=='destroy'){
                        if(this.kernel[key].errors){
                            this.$toastr.s(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('সফলভাবে মুছে ফেলা হয়েছে');
                            this.filter();
                        }
                    }
                }
            }
        }
    }
</script>

<style>

</style>
