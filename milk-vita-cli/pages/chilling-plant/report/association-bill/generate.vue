<template>
    <div class="card min85vh">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0 p-0"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Payment of Milk Bill (Generate New Sheet)</h5>
            <div class="btn-group">
                <nuxt-link to="/chilling-plant/report/association-bill/list" class="btn btn-primary">
                    <i class="fa fa-arrow-circle-o-left"></i>&nbsp;Go back to the list
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered custom challan-table">
                    <thead>
                        <tr>
                            <th width="20">SL</th>
                            <th>Association</th>
                            <th>Code</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Day</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in list" :key="index">
                            <td>{{ (index + 1) }}</td>
                            <td>{{ row.association_name }}</td>
                            <td>{{ row.association_code }}</td>
                            <td class="custom-challan-row">
                                <input type="date" v-model="list[index].from_date">
                            </td>
                            <td class="custom-challan-row">
                                <input type="date" v-model="list[index].to_date">
                            </td>
                            <td>{{ dayCalculate(row.from_date, row.to_date) }}</td>
                            <td><input type="checkbox" v-model="list[index].is_ready"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button class="btn btn-success float-right" v-if="is_submit==false" @click="submit">Generate Bill</button>
            <button class="btn btn-success float-right" v-else ><i class="fa fa-spinner fa-spin fa-fw"></i> Processing..</button>
        </div>
    </div>
</template>
<script>
    import Pagination from 'vue-pagination-2';
    export default {
        layout:'admin',
        name:'all',
        components : {
            Pagination,
        },
        data(){
            return {
                kernel    : {},
                list      : [],
                is_submit : false,
            }
        },
        mounted(){
            this.http('chilling-plant/report/last-milk-collection-list', 'society-list');
        },
        methods:{
            submit(){
                this.is_submit = true;
                var is_ready   = false, ready_pack = [];
                //
                (this.list).forEach((row, key)=>{
                    if(row.is_ready==true && (row.from_date && row.to_date)){
                        is_ready = true;
                        ready_pack.push(row);
                    }
                });
                //
                if(is_ready==false){
                    this.$toastr.w("Something is wrang! Plese Try Again");
                    this.is_submit = false;
                }
                else {
                    this.http('chilling-plant/report/generate-association-bill-record', 'association-bill-record', {associations:ready_pack });
                }
            },
            dayCalculate(from_date, to_date)
            {
                if(from_date && to_date){
                    var date1 = new Date(from_date);
                    var date2 = new Date(to_date);
                    var Difference_In_Time = date2.getTime() - date1.getTime();
                    return (Difference_In_Time / (1000 * 3600 * 24));
                }
                else return '---';
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='society-list'){
                        this.list = this.kernel[key];
                        //
                        (this.list).forEach((row, key)=>{
                            this.list[key].from_date =(this.list[key].last_recorded_date ? this.list[key].last_recorded_date : this.list[key].first_collected_date);
                        });
                    }
                    else if(key=='association-bill-record')
                    {
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$router.push({path:'/chilling-plant/report/association-bill/list'});
                        }
                        this.is_submit = false;
                    }
                }
            }
        }
    }
</script>

<style>
    .header {
        padding: 25px 0px;
    }
    .header h3, .header h4, .header h5 {
        display: block;
        text-align: center;
        font-size: 23px;
    }
    .header h4 {
        font-size: 18px;
    }
    .header h5 {
        font-size: 15px;
    }
    .custom-challan-row input {
        height: 30px;
    }
</style>
