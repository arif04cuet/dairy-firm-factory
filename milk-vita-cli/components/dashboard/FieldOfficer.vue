<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
        <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/all" class="info-box">
                    <div class="icon" style="background:#524e83">
                        <img src="@/assets/icons/committee.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#514e82">প্রাথমিক জরিপ</span>
                        <strong>{{$en2bn(data.total_survey)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(26 91 208 / 84%)">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#3561b7">মোট অপেক্ষমান আবেদন</span>
                        <strong>{{$en2bn(data.total_pending_app)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:#D01A67">
                        <img src="@/assets/icons/application.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#ab1b57">মোট প্রাথমিক সমবায় সমিতি</span>
                        <strong>{{$en2bn(data.total_primary_asso)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-3">
                <nuxt-link to="/association/application/list" class="info-box">
                    <div class="icon" style="background:rgb(36 170 164 / 65%)">
                        <img src="@/assets/icons/ox.svg" alt="">
                    </div>
                    <div class="info">
                        <span style="color:#1d8780">মোট গবাদি পশুর সংখ্যা</span>
                        <strong>{{$en2bn(data.total_cattle ? data.total_cattle : 0)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <h5><i class="fa fa-list-alt" aria-hidden="true"></i> আবেদনকৃত সমিতির তালিকা </h5>
                            <!-- // -->
                            <form @submit.prevent="fetchData">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" v-model="search.association_code" placeholder="সমিতির কোড">
                                    </div>
                                    <!-- // -->
                                    <div class="col-md-4">
                                        <button class="btn btn-success text-nowrap" >সার্চ করুন</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                        <!-- // -->
                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover custom">
                                    <thead>
                                        <tr>
                                            <th width="50" class="text-center">ক্রমিক</th>
                                            <th>প্রস্তাবিত সমিতির নাম</th>
                                            <th>কোড</th>
                                            <th>সমিতির কার্যকরী এলাকা</th>
                                            <th>দুগ্ধ এলাকার নাম</th>
                                            <th>সদস্যগনের সংখ্যা</th>
                                            <th class="text-center"> বর্তমান অবস্থা</th>
                                            <th width="70" class="text-center">অ্যাকশন</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(row, index) in asso_list" :key="index">
                                            <td class="text-center">{{$en2bn(++index)}}</td>
                                            <td>{{row.association_name}}</td>
                                            <td>{{row.association_code ? row.association_code : '#'}}</td>
                                            <td>{{row.working_area_of_association}}</td>
                                            <td>{{row.name_of_dairy_area}}</td>
                                            <td>{{row.total_members}}</td>
                                            <td>{{row.last_status}}</td>
                                            <td class="text-center">
                                                <div class="btn-group custom">
                                                    <button @click="track_stasus(row)" class="btn btn-info mr-1">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </button>

                                                    <nuxt-link :to="'/association/application/details?id='+row.id" v-if="$ck_action('/association/application/details')">
                                                        <button  class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </nuxt-link>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="(asso_list.length<=0 && !loading)">
                                            <th colspan="8">Data Not Found</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <pagination v-model="page" :records="total_row" :per-page="per_page" @paginate="fetchData"/>
                            </div>
                        </div>
                        <!-- // -->
                    </div>
                </div>
            </div>
        </div>
        <!-- // Schedule // -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-0 bg-white">
                    <h2 class="text-center pt-5">কার্য্য তালিকা</h2>
                    <FullCalendar
                        :events="events"
                    />
                </div>
            </div>
        </div>

        <!-- LIST OF ALL MEMBERS OF AN ASSOCIATION -->
        <div v-if="association_id" class="popup">
            <div class="popup-box">
                <status-track v-model="association_id" ></status-track>
            </div>
        </div>
        <!-- // -->
    </div>
</div>
</template>

<script>
import Track from '@/components/association/Track.vue';
import FullCalendar from '~/components/FullCalendar.vue';
import Pagination from 'vue-pagination-2';

export default {
  components: { Pagination, 'status-track': Track, FullCalendar},
    name:'',
    data(){
        return {
            search : {},
            kernel : {},
            user   : this.$store.state.auth.user,
            data   : {
                today_milk_collections : []
            },
            loading   :true,
            total_row : 0,
            per_page  : 10,
            page      : 1,
            asso_list : [],
            association_id:'',
            events : []
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
        this.fetchData();
    },
    methods:{
        track_stasus(association){
            this.association_id = association.id;
        },
        fetchData(){
            this.loader = true;
            //
            this.http('association/list', 'paginate_associations', {
                per_page    : this.per_page,
                page_no     : this.page,
                where       : this.search,
                type        : 'application-list'
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
                    this.data    = this.kernel[key];
                    // MEETING EVENTS //
                    this.events  = (this.kernel[key].meetings ? this.kernel[key].meetings : []);
                    this.events.map((row)=>{ 
                        if(row.type=='schedule')
                            row.path = "/task-schedule/view?id="+row.id
                        else
                            row.path = "/field-officer/meeting-resolution/meeting?id="+row.id
                    });
                    this.loading = false;
                }
                else if(key=='paginate_associations'){
                    this.asso_list = this.kernel[key].data;
                    this.total_row = this.kernel[key].total_row ? this.kernel[key].total_row : 0;
                    this.loading   = false;
                }
            }
        }
    }
}
</script>


<style>
    .full-calendar-body .dates .dates-events .events-week .events-day {
        transition: all 0.3s linear;
        cursor: default!important;;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day:hover {
        background: rgb(235 240 237 / 80%);
    }
    .full-calendar-body .dates .dates-events .events-week .events-day.today {
        background: #e9f2fb!important;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day .day-number {
        opacity: 1!important;
    }
    .comp-full-calendar {
        max-width: initial!important;;
    }
    .full-calendar-body .dates .week-row .day-cell {
        flex: 1;
        min-height: 72px!important;
        padding: 4px;
        border-right: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day {
        cursor: pointer;
        flex: 1;
        min-height: 72px!important;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day .event-box .event-item:hover {
        background: #ddd;
    }
</style>