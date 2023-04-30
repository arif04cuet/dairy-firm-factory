<template>
<div class="min70vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/member/list" class="info-box">
                    <div class="icon" style="background:#caf6ce9e">
                        <img src="@/assets/icons/user.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#16a416">মোট সদস্য সংখ্যা</span>
                        <strong>{{$en2bn(data.total_member)}} জন</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/association/member/list" class="info-box">
                    <div class="icon" style="background:rgb(244 180 212)">
                        <img src="@/assets/icons/ox.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#d24088">মোট গবাদি পশুর সংখ্যা</span>
                        <strong>{{$en2bn(data.total_cattle)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="#" class="info-box">
                    <div class="icon" style="background:rgb(69 177 255 / 35%)">
                        <img src="@/assets/icons/milk-jar.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#4477a0">সাপ্তাহিক দুধ সংগ্রহ</span>
                        <strong>{{$en2bn(data.last_week_collections)}} লিটার</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> দৈনিক দুগ্ধ সরবরাহ এর তালিকা </h5>
                            <div class="btn-group custom">
                                <nuxt-link to="/association/milk-collection/all" class="btn btn-small btn-primary" style="color:#fff!important">সব দেখুন</nuxt-link>
                            </div>
                        </div>  
                        <div class="table-responsive" v-if="data.today_milk_collections">
                            <table class="table table-bordered table-hover custom">
                                <thead>
                                    <tr>
                                        <th>নং </th>
                                        <th>গ্রহণের তারিখ</th>
                                        <th>সদস্য কোড</th>
                                        <th>সদস্যের নাম</th>
                                        <th>শিফট</th>
                                        <th>দুগ্ধ পরিমান (লিটার)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in data.today_milk_collections" :key="index">
                                        <th>{{$en2bn(index+1)}}</th>
                                        <td>{{$en2bn(row.date)}}</td>
                                        <td>{{$en2bn(row.member_code)}}</td>
                                        <td>{{row.member_name}}</td>
                                        <td>{{$shift(row.shift)}}</td>
                                        <td>{{$en2bn(row.amount_of_milk)}}</td>
                                    </tr>
                                    <!-- // -->
                                    <tr v-if="(data.today_milk_collections).length == 0">
                                        <th colspan="6">আজ কোনো দুগ্ধ সংগ্রহ করা হয়নি</th>
                                    </tr>
                                </tbody>
                            </table>
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
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                today_milk_collections : []
            },
            loading:true
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
    },
    methods:{
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
            }
        }
    }
}
</script>
