<template>
    <div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="m-0"><i class="fa fa-user-plus" aria-hidden="true"></i> দুধ সংগ্রহের বিজ্ঞপ্তি</h4>
        </div>
    </div>
    <div class="card-body min75vh">
        <div v-if="loader!=true">
            <div class="row">
                <div class="col-md-9">
                    <div class="alert alert-info">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>&nbsp; মোট কলেকশনের অনুরোধ সংখ্যাঃ {{$en2bn(((notifications).length > 9 ? (notifications).length : '0'+(notifications).length))}}
                    </div>
                </div>

                <div class="col-md-3 text-right">
                    <div class="btn-group">
                        <button class="btn btn-primary" @click="optinDialog(true)">
                            <i class="fa fa-plus"></i>
                            <span>বাল্ক তৈরী করুন</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover custom"> 
                    <thead>
                        <tr>
                            <th width="50" class="text-center"><input type="checkbox" @click="selectAll"></th>
                            <th width="50" class="text-center">ক্রমিক</th>
                            <th>চিলিং প্লান্টের নাম</th>
                            <th>ঠিকানা</th>
                            <th>বর্তমান দুধের পরিমান</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in notifications" :key="index">
                            <td class="text-center">
                                <input type="checkbox" @click="checked(row.id)" :checked="bulk_ids.indexOf(row.id) > -1">
                            </td>
                            <td class="text-center">{{$en2bn(1)}}</td>
                            <td>{{row.chilling_plant_name}}</td>
                            <td>{{row.full_address}}</td>
                            <td>{{$en2bn(+row.stock_amount)}} লিটার ({{$en2bn((+row.fillup_persentage).toFixed(2))}}%)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- // -->
        </div>
        <Loader :loader="loader" />

        <div class="popup" v-if="popup">
            <div class="popup-body">
                <form @submit.prevent="submit()">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="m-0 mt-2"><i class="fa fa-plus"></i> নতুন বাল্ক তৈরী করুন</h4>
                            <button type="button" class="btn btn-danger" @click="optinDialog(false)"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col-md-4 text-right">চিলিং প্লান্টের সংখ্যা</div>
                                <div class="col-md-4">: {{$en2bn(bulk_ids.length)}}</div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4 text-right">দুধের আনুমানিক পরিমাণ</div>
                                <div class="col-md-4">: {{$en2bn(form.expected)}}</div>
                            </div>

                            <hr>

                            <div class="row form-group">
                                <div class="col-md-4 text-right">ড্রাইভার</div>
                                <div class="col-md-6">
                                    <select class="form-control" v-model="form.driver_id" required>
                                        <option value="">ড্রাইভার নির্বাচন করুন</option>
                                        <option v-for="(row, index) in drivers" :key="index" :value="row.id">{{row.name_bn}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4 text-right">যানবাহন</div>
                                <div class="col-md-6">
                                    <select class="form-control" v-model="form.vehicle_id" required>
                                        <option value="">যানবাহন নির্বাচন করুন</option>
                                        <option v-for="(row, index) in vehicles" :key="index" :value="row.id">{{row.model_no}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-10 text-right">
                                    <div class="btn-group">
                                        <button v-if="is_submit==false" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;বাল্ক তৈরী করুন</button>
                                        <button v-else type="button" class="btn btn-success"><i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>&nbsp;অপেক্ষা করুন</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetch"/>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    layout: "admin",
    name: "processingPlant",
    data() {
        return {
            kernel      : {},
            per_page    : 20,
            page_no     : 1,
            total_row   : 0,
            loader      : true,
            popup       : false,
            notifications : [],
            bulk_ids      : [],
            drivers       : [],
            vehicles      : [],
            form          : {
                vehicle_id : '',
                driver_id  : '',
                expected   : 0,
            },
            is_submit : false,
        }
    },
    mounted() {
        this.loader = false;
        this.fetch();
        this.http('driver/list', 'driver', {
            type:'bulk-check'
        });
        this.http('vehicle/list', 'vehicle', {
            type:'bulk-check'
        });
    },
    methods: {
        optinDialog(x){
            if(x==true && (this.bulk_ids.length > 0))
            {
                this.form.expected = 0;
                // CALCULATE EXPECTED MILK AMOUNT
                (this.notifications).forEach((row)=>{
                    if((this.bulk_ids).indexOf(row.id)>-1) this.form.expected += +row.stock_amount;
                });
                this.popup = x;
            }
            else if(x==false) this.popup = x;
            else this.$toastr.w('অনুগ্রহ পূর্বক চিলিং প্লান্ট নির্বাচন করে চেষ্টা করুন');
        },
        submit(){
            this.is_submit = true;
            this.form.chilling_plant_ids = this.bulk_ids;
            //
            if(this.bulk_ids.length > 0)
                this.http('processing-plant/bulk/add', 'mkBulk', this.form);
            else 
                this.$toastr.w('অনুগ্রহ করে প্রথমে চিলিং প্লান্ট নির্বাচন করুন!!');
        },
        selectAll(event){
            this.bulk_ids = [];
            if(event.target.checked){
                (this.notifications).forEach(x=>{this.bulk_ids.push(x.id)});
            }
        },
        checked(id){
            if(this.bulk_ids.indexOf(1) > -1){
                this.$delete(this.bulk_ids, this.bulk_ids.indexOf(1));
            }
            else { this.bulk_ids.push(id);}
        },
        fetch(){
            this.http('processing-plant/notification/milk', 'notifications');
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
                if (key == "divisions") {
                    this.divisions = this.kernel[key];
                }
                else if(key=='notifications') {
                    this.notifications = this.kernel[key].data;
                }
                else if(key=='mkBulk'){
                    if(this.kernel[key]){
                        this.$toastr.s('বাল্ক সফল ভাবে তৈরী করা হয়েছে');
                        this.$router.push({path:'/processing-plant/bulk/list'});
                    }
                }
                else if(key=='driver'){
                    this.drivers = this.kernel[key];
                }
                else if(key=='vehicle'){
                    this.vehicles = this.kernel[key].data;
                }
            }
        },
    },
};
</script>

<style>
.popup .popup-box, 
.popup .popup-body {
    min-height: 48%!important;
}
</style>
