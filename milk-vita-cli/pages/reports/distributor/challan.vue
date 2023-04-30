<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    <span>ডিস্ট্রিবিউটর চালান রিপোর্ট</span>
                </h5>
                    <select-picker 
                        style="width:200px"
                        v-model="type"
                        :options='types'
                        :reduce="row=>row.value"
                        label="title"
                    />
            </div>
        </div>
        <div class="card-body min75vh">
            <div class="row">
                <div class="col-md-4 form-group" v-if="type=='daily'">
                    <date-picker 
                        v-if="search.date['from']"
                        v-model="search.date['from']"
                        :locale="$store.state.local"
                        placeholder="শুরুর তারিখ"
                    />
                </div>

                <div class="col-md-4 form-group" v-if="type=='daily'">
                    <date-picker 
                        v-if="search.date['from']"
                        v-model="search.date['to']"
                        :locale="$store.state.local"
                        placeholder="শেষের তারিখ"
                    />
                </div>

                <div class="col-md-3 text-right mt-2" v-if="type=='yearly' || type=='monthly'">
                    <span v-if="type=='monthly'">বছর এবং মাস নির্বাচন করুন</span>
                    <span v-else >বছর নির্বাচন করুন</span>
                </div>

                <div class="col-md-3 form-group" v-if="type=='monthly'">
                    <input v-model="search.date" type="month" class="form-control" required >
                </div>

                <div class="col-md-3 form-group" v-if="type=='yearly'">
                    <select-picker
                        v-model="search.date"
                        placeholder="বছর নির্বাচন করুন"
                        :options="years"
                        :reduce="row=>row.value"
                        label="label"
                    />
                </div>

                <div class="col-md-2 form-group">
                    <button class="btn btn-success" @click="filter" ><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <th width="50" class="text-center">ক্রমিক</th>
                        <th width="130px">{{type == 'daily' ? 'তারিখ' : (type == 'monthly' ? 'মাস' : 'বছর')}}</th>
                        <th>মোট চালান</th>
                        <th>মোট ডিমান্ড পণ্য</th>
                        <th>মোট ডেলিভারি পণ্য</th>
                    </thead>
                    <tbody v-if="records">
                        <tr v-for="(row, key) in records" :key="key">
                            <td>{{$en2bn(key+1)}}</td>
                            <td>
                                {{$en2bn(type == 'daily' ? row.date : (type == 'monthly' ? row.year+'-'+row.month : row.year))}}
                            </td>
                            <td>{{row.total_challan}}</td>
                            <td>{{row.total_demand_item}}</td>
                            <td>{{row.total_challan_item}}</td>
                        </tr>
                        <tr v-if="records.length == 0">
                            <td colspan="5" class="text-center">কোনো চালান পাওয়া যায়নি</td>
                        </tr>
                    </tbody>
                </table>
                <!-- // -->
                <div class="d-flex justify-content-end">
                    <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchRecords"/>
                </div>
            </div>
            <loader :loader="loader" />
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel      : {},
                loader      : false,
                type        : 'daily',
                types       : [
                    {title:'দৈনিক', value:'daily'},
                    {title:'মাসিক', value:'monthly'},
                    {title:'বার্ষিক', value:'yearly'},
                ],
                search      : {date : {
                    'from'  : this.$date(),
                    'to'    : this.$date(),
                }},
                records     : {},
                years       : [],

                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
            }
        },
        mounted(){
            this.fetchRecords();
            var years = [];
            for(var i = 1998; i<= +((new Date()).getFullYear()); i++) years.unshift({label:i, value:i});
            this.years = years;
        },
        methods:{
            filter(){
                this.page_no = 1;
                this.fetchRecords();
            },
            fetchRecords(){
                if(this.search.date!=''){
                    this.loader = true;
                    this.http('report/distributor/challan', 'records', {
                        where:this.search,
                        type:this.type
                    });
                }
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            type(){
                if(this.type=='daily') this.search.date = {'from' : this.$date(), 'to' : this.$date()};
                else if(this.type=='yearly') this.search.date = (new Date()).getFullYear();
                else this.search.date = '';
                //
                this.page_no = 1;
                this.records = [];
                this.fetchRecords();
            },
            kernel(){
                for(const key in this.kernel){
                    if(key=='records'){
                        this.records    = this.kernel[key].data;
                        this.total_row  = this.kernel[key].total_row;
                        this.loader     = false;
                    }
                }
            }
        }
    }
</script>
