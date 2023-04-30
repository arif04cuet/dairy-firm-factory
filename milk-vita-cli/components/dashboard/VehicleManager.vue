<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/processing-plant/stock-list" class="info-box">
                    <div class="icon" style="background:rgb(166 222 153 / 53%)">
                        <img src="/icons/seatbelt.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(48 147 25)">মোট যানবাহন চালক</span>
                        <strong>{{$en2bn(data.total_driver ? data.total_driver : 0)}} লিটার</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(162 209 212)">
                        <img src="/icons/car.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(72 137 141)">মোট যানবাহন</span>
                        <strong>{{$en2bn(data.total_vehicle ? data.total_vehicle : 0)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(171 182 230)">
                        <img src="/icons/box.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(102 117 187)">মোট চালান</span>
                        <strong>{{$en2bn(data.total_challan ? data.total_challan : 0)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(200 126 199 / 48%)">
                        <img src="/icons/pending-doc.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(197 116 192)">মোট প্রক্রিয়াধীন চালান</span>
                        <strong>{{$en2bn(data.total_processing_challan ? data.total_processing_challan : 0)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
        </div>
        <div class="row">
            <!-- // -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="m-0 mt-2">সকল চিলিং প্ল্যান্ট তালিকা</h5>
                        </div>
                    </div>
                    <div class="card-body min75vh">
                        <form @submit.prevent="filterPlants()">
                            <div class="row">
                                <Location v-model="location_data" class="col-md-12 row">
                                    <div class="form-group col-md-3">
                                        <label>বিভাগ</label>
                                        <div data-division></div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>জেলা</label>
                                        <div data-district data-required="true"></div>
                                    </div>
                                    
                                    <div class="col-md-2 form-group">
                                        <label for="">&nbsp;</label>
                                        <div class="btn-group form-control p-0 bg-default">
                                            <button class="btn btn-success">সার্চ করুন</button>
                                        </div>
                                    </div>
                                </Location>
                            </div>
                        </form>
                        <div class="table-responsive" v-if="!loader">
                            <table class="table table-bordered table-hover custom mb-2">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">ক্রমিক</th>
                                        <th>চিলিং প্ল্যান্টের নাম</th>
                                        <th>প্রসেসিং প্ল্যান্টের নাম</th>
                                        <th>ঠিকানা</th>
                                        <th>পুরো ঠিকানা</th>
                                        <th>স্টক ক্যাপাসিটি</th>
                                        <th>বর্তমান স্টক</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(row, index) in chilling_plants" :key="index">
                                        <td class="text-center">{{$en2bn(index+1)}}</td>
                                        <td>{{row.chilling_plant_name}}</td>
                                        <td>{{row.processing_plant_name}}</td>
                                        <td>
                                            <span v-if="row.location_details" v-for="(area, key) in row.location_details" :key="key">{{area.name ? area.name.bn : ''}}, </span>
                                        </td>
                                        <td>{{row.full_address}}</td>
                                        <td>{{row.stock_capacity}}</td>
                                        <td>
                                            {{$en2bn(Number.parseFloat(row.fillup.stock).toFixed(2))}} লিটার <br>
                                            <span class="text-danger">({{$en2bn(Number.parseFloat(row.fillup.percentage).toFixed(2))}}%)</span>
                                        </td>
                                    </tr>

                                    <tr v-if="(chilling_plants.length <= 0)">
                                        <th colspan="6">কোনো চিলিং প্লান্ট পাওয়া যায়নি</th>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ------------------ PAGINATION ------------------ -->
                            <div class="d-flex justify-content-end">
                                <pagination v-model="plant_page_no" :records="plant_total_row" :per-page="plant_per_page" @paginate="fetchAllPlant"/>
                            </div>

                        </div>
                        <Loader :loader="plant_loader"/>
                    </div>
                </div>
            </div>

            <!-- // -->
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="m-0 mt-2"><i class="fa fa-th-large" aria-hidden="true"></i>&nbsp;&nbsp; বাল্ক তালিকা</h5>
                        </div>
                    </div>
                    <div class="card-body min75vh">
                        <div>
                            <form @submit.prevent="filterBulk()">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <date-picker 
                                            v-model="bulk_search.date['from']"
                                            placeholder="শুরুর তারিখ নির্বাচন করুন"
                                            :locale="$store.state.local"
                                        />
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <date-picker 
                                            v-model="bulk_search.date['to']"
                                            placeholder="শুরুর তারিখ নির্বাচন করুন"
                                            :locale="$store.state.local"
                                        />
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success">সার্চ করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive" v-if="!bulk_loader">
                            <table class="table table-bordered table-hover custom mb-2">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">ক্রমিক</th>
                                        <th>তারিখ</th>
                                        <th>গাড়ী</th>
                                        <th>চালকের নাম</th>
                                        <th>চালান</th>
                                        <th width="70" class="text-center">অ্যাকশন</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(row, index) in bulks" :key="index">
                                        <td class="text-center">{{$en2bn(++index)}}</td>
                                        <td>{{$en2bn(row.date)}}</td>
                                        <td>{{row.vehicle}}</td>
                                        <td>{{row.driver_name}}</td>
                                        <td>{{row.progress}}</td>
                                        <td class="text-center">
                                            <div class="btn-group custom">
                                                <nuxt-link :to="'/processing-plant/bulk/view?id='+row.id" v-if="$ck_action('/processing-plant/bulk/view')">
                                                    <button class="btn btn-success">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </nuxt-link>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="(bulks.length <= 0)">
                                        <th colspan="6">Data Not Found</th>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ------------------ PAGINATION ------------------ -->
                            <div class="d-flex justify-content-end">
                                <pagination v-model="bulk_page_no" :records="bulk_total_row" :per-page="bulk_per_page" @paginate="fetchBulks"/>
                            </div>

                        </div>
                        <Loader :loader="bulk_loader"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name:'',
    data(){
        return {
            kernel   : {},
            user     : this.$store.state.auth.user,
            data     : {},
            loading  : true,   
            loader   : false,
            bulks    : [],
            //
            bulk_search : {
                id:'',
                date : {
                    from  : '',
                    to    : '',
                }
            },
            bulk_per_page   : 10,
            bulk_page_no    : 1,
            bulk_total_row  : 0,
            bulk_loader     : false,
            //
            plant_search     : {},
            chilling_plants  : [],
            plant_per_page   : 10,
            plant_page_no    : 1,
            plant_total_row  : 0,
            plant_loader     : false,
            location_data    : {},
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.fetchAllPlant();
        this.fetchBulks();
    },
    methods:{
        filterBulk(){
            this.bulk_page_no = 1;
            this.fetchBulks();
        },
        filterPlants(){
            this.plant_page_no = 1;
            this.fetchAllPlant();  
        },
        fetchAllPlant(){
            this.plant_loader = true;
            this.http('chilling-plant/all', 'all-plant', {
                per_page    : this.plant_per_page,
                page_no     : this.plant_page_no,
                where       : this.plant_search
            });
        },
        fetchBulks(){
            this.bulk_loader = true;
            this.http('processing-plant/bulk/list', 'bulks', {
                per_page    : this.bulk_per_page,
                page_no     : this.bulk_page_no,
                where       : this.bulk_search
            });
        },
        http(url, type, data=null){
            this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
        },
    },
    watch : {
        location_data(){
            this.plant_search.id = '';
            this.plant_search.division_id = this.location_data.division_id;
            this.plant_search.district_id = this.location_data.district_id;
        },
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data    = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='bulks'){
                    this.bulks          = this.kernel[key].data;
                    this.bulk_total_row = this.kernel[key].total_row;
                    this.bulk_loader    = false;
                }
                if(key=='all-plant'){
                    this.chilling_plants = this.kernel[key].data;
                    this.plant_total_row = this.kernel[key].total_row;
                    this.plant_loader    = false;
                }
            }
        }
    }
}
</script>
