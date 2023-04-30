<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="m-0"><i class="fa fa-calculator" aria-hidden="true"></i> চালান রিসিভ (ড্রাইভার)</h4>
                
            </div>
        </div>
        <div class="card-body min75vh">
            <!-- // -->
            <form @submit.prevent="filter">
                <div class="row">
                    <div class="col-md-5 form-group">
                        <input type="text" class="form-control" v-model="search.voucher_no" placeholder="চালান আই .ডি">
                    </div>
                    <div class="col-md-5 form-group">
                        <select class="form-control">
                            <option value="">চিলিং প্লান্টের</option>
                            <option v-for="(row, index) in chilling_plants" :key="index" :value="row.id">{{row.chilling_plant_name}}</option>
                        </select>
                    </div>
                    <!-- // -->
                    <div class="col-md-2">
                        <div class="btn-group">
                            <button class="btn btn-success">সার্চ করুন</button>
                        </div>
                    </div>
                </div>
            </form>

            <div v-if="loader!=true">
            <!-- // -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover custom"> 
                        <thead>
                            <tr>
                                <th width="50" class="text-center">ক্রমিক</th>
                                <th>চালান আই .ডি</th>
                                <th>তারিখ</th>
                                <th>চিলিং প্লান্টের নাম</th>
                                <th>চিলিং প্লান্টের ঠিকানা</th>
                                <th>দুধের পরিমান</th>
                                <th>বর্তমান অবস্থা</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in challans" :key="index">
                                <td class="text-center">{{$en2bn(1)}}</td>
                                <td>{{$en2bn(row.voucher_no)}}</td>
                                <td class="text-center">{{$en2bn(row.date)}}</td>
                                <td>{{row.chilling_plant_name}}</td>
                                <td>{{row.chilling_plant_address}}</td>
                                <td>{{$en2bn(+row.clpt_liter)}} লিটার</td>
                                <td>{{row.is_driver_receive==0?'অপেক্ষমান':'গৃহীত হয়েছে'}}</td>
                                <td>
                                    <nuxt-link :to="'/processing-plant/driver/challan-view?id='+row.id" v-if="$ck_action('/processing-plant/driver/challan-view')">
                                        <button class="btn btn-success"><i class="fa fa-eye"></i></button>
                                    </nuxt-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- // -->
            </div>
            <Loader :loader="loader" />
            <div class="d-flex justify-content-end">
                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetch"/>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    layout: "admin",
    data() {
        return {
            kernel: {},
            per_page: 20,
            page_no: 1,
            total_row: 0,
            loader: true,
            search:{},
            challans:[],
            chilling_plants:[],
        }
    },
    mounted() {
        this.loader = false;
        this.fetch();
        this.http('chilling-plant/all', 'chilling-plant', {});
    },
    methods: {
        filter(){
            this.page_no = 1;
            this.fetch();
        },
        fetch(){
            this.http('processing-plant/challan/list', 'challans', {
                type:'driver',
                where:this.search
            });
        },
        http(url, type, data = null) {
            this.$axios.post(url, data).then((res) => {
                this.kernel = Object.assign({}, { [type]: res.data });
            });
        },
    },
    watch: {
        kernel: function () {
            for (const key in this.kernel) {
                if(key=='challans') {
                    this.challans = this.kernel[key].data;
                }
                else if(key=='chilling-plant'){
                    this.chilling_plants = this.kernel[key].data;
                }
            }
        },
    },
};
</script>
