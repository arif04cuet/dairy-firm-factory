<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">লোকেশন তালিকা</h5>
            </div>
        </div>
        <div class="card-body min75vh">
            <div>
                <form @submit.prevent="filter">
                    <!-- // -->
                    <location v-model="location_data">
                        <div class="row">
                            <div class="col-md-4"  data-location_types ></div>
                            <div class="col-md-2">
                                <button class="btn btn-success">সার্চ করুন</button>
                            </div>
                        </div>
                    </location>
                    <!-- // -->
                </form>
            </div>
            <!-- // -->
            <hr class="mb-0">

            <ul class="location-step">
                <li v-for="(row, index) in steps" :key="index" @click="NextPage(row, (index+1))" :style="(steps.length == (index + 1) ? 'color:#69ce59;':'')">
                    <i v-if="index!=0" class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;{{row.name.bn}}
                </li>
            </ul>
            <div class="table-responsive" v-if="!loader">
                <table class="table table-bordered table-hover custom mb-2">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>জোনের নাম (BN)</th>
                            <th>জোনের নাম (EN)</th>
                            <th width="120" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(row, index) in locations" :key="index">
                            <td class="text-center">{{$en2bn($paginatedIndex(per_page, page_no, (index+1)))}}</td>
                            <td>{{row.name.bn}}</td>
                            <td>{{row.name.en}}</td>
                            <td class="text-center">
                                <div class="btn-group custom" v-if="row.children!=0">
                                    <button class="btn btn-primary" @click="NextPage(row)">
                                        এগিয়ে যান &nbsp;<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div v-else >
                                    ---
                                </div>
                            </td>
                        </tr>

                        <tr v-if="(locations.length <= 0)">
                            <th colspan="5">কোনো লোকেশন পাওয়া যায়নি </th>
                        </tr>
                    </tbody>
                </table>
                <!-- ------------------ PAGINATION ------------------ -->
                <div class="d-flex justify-content-end">
                    <!-- <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="getLocation"/> -->
                </div>

            </div>
            <Loader :loader="loader"/>
        </div>


    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    import Location from '@/components/system/Location';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
            'location':Location,
        },
        data(){
            return {
                kernel          : {},
                plants          : [],
                type_id         : '',
                locations       : [],
                search          : {
                    processing_plant_id : '',
                },
                per_page        : 10,
                page_no         : 1,
                total_row       : 0,
                loader          : false,
                steps           : [],
                location_data   : {},
                is_submited_type_id : 0,
            }
        },
        methods:{
            NextPage(row, index=false){
                console.log(row);
                if(index!=false){
                    var new_step = [];
                    (this.steps).forEach((row2, key) => {
                        if(key < index) new_step.push(row2);
                    });
                    this.steps = new_step;
                }
                else {
                    this.steps.push(row);
                }
                this.loader = true;
                this.http('location', 'type-wise-location', {
                    type_child_id:row.id
                });
            },
            filter(){
                this.page_no = 1;
                this.is_submited_type_id = this.type_id;
                this.getLocation();
            },
            getLocation(){
                this.loader = true;
                this.steps = [];
                this.http('location', 'type-wise-location', {
                    type_id:this.type_id
                });
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='type-wise-location'){
                        if(this.kernel[key].length>0){
                            this.locations  = this.kernel[key];
                            this.total_row  = this.kernel[key].total_row;
                        }
                        this.loader     = false;
                    }
                }
            },
            location_data(){
                this.type_id = this.location_data.type_id;
            }
        }
    }
</script>

<style>
    .location-step {
        margin: 0;
        padding: 0;
        display: flex;
    }
    .location-step li {
        list-style: none!important;
        padding-left: 7px!important;
        user-select: none;
        cursor: pointer;
    }
    .location-step li:hover {
        color:#69ce59;
    }
</style>
