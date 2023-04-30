<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background: rgb(217 226 243 / 84%)">
                        <img src="/icons/pi.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#3561b7">মোট চালান </span>
                        <strong>{{$en2bn(data.total_challan)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(247 211 227)">
                        <img src="/icons/box.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#ab1b57">মোট সম্পূর্ণ চালান</span>
                        <strong>{{$en2bn(data.total_complete)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(161 205 203 / 65%)">
                        <img src="/icons/pending-doc.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#1d8780">মোট প্রক্রিয়াধীন চালান </span>
                        <strong>{{$en2bn(data.total_in_process)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="m-0"><i class="fa fa-calculator" aria-hidden="true"></i> চালান রিসিভ (ড্রাইভার)</h4>
                            
                        </div>
                    </div>
                    <div class="card-body min75vh">
                        <!-- // -->
                        <form @submit.prevent="filter()">
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <input type="text" class="form-control" v-model="search.voucher_no" placeholder="চালান আই .ডি">
                                </div>
                                <div class="col-md-5 form-group">
                                    <select class="form-control" v-model="search.chilling_plant_id">
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

                        <div v-if="loading!=true">
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
                        <Loader :loader="is_loading" />
                        <div class="d-flex justify-content-end">
                            <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetch"/>
                        </div>
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
            search : {
                chilling_plant_id : ''
            },
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {},

            challans  : [],
            loading   : true,
            total_row : 0,
            per_page  : 10,
            page_no   : 1,
            is_loading : false,
            chilling_plants : [],
            
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.fetch();
        this.http('chilling-plant/all', 'chilling-plant', {});
    },
    methods:{
        filter(){
            this.page_no = 1;
            this.fetch();
        },
        fetch(){
            this.is_loading = true;
            this.http('processing-plant/challan/list', 'challans', {
                type:'driver',
                where:this.search
            });
        },
        http(url, type, data=null){
            this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
        },
    },
    watch:{
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data = this.kernel[key];
                    this.loading = false;
                }
                else if(key=='challans') {
                    this.challans = this.kernel[key].data;
                    this.is_loading = false;
                }
                else if(key=='chilling-plant'){
                    this.chilling_plants = this.kernel[key].data;
                }
            }
        }
    }
}
</script>
