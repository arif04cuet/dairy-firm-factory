<template>
    <div class="card min85vh p-4">
        <div class="header">
            <h3>Bangladesh Milk Producer's Co-operative Union Ltd</h3>
            <h4> {{data.chilling_plant_name}} </h4>
            <h5 class="border-bottom pb-2">Milk Bill</h5>
        </div>

        <div class="card-body">
            
            <div class="d-flex justify-content-between mb-4">
                <div><strong>Memo No : </strong>{{ data.memo_no }}</div>
                <div><strong>Date : </strong>{{ data.date }}</div>
            </div>
            <!-- // -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="" class="m-0">To The Manager,</label>
                    <textarea name="" class="form-control" id="" style="font-size:13px; border:none; background: #fff" rows="2" v-model="data.to" disabled></textarea>
                </div>
            </div>
            <!-- // -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="" class="m-0">Subject</label>
                    <textarea name="" class="form-control" id="" style="font-size:13px; border:none; background: #fff" v-model="data.subject" disabled></textarea>
                </div>
            </div>
            <!-- // -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <textarea name="" class="form-control" id="" rows="5" style="font-size:13px; border:none; background: #fff" v-model="data.body" disabled></textarea>
                </div>
            </div>
            <!-- // -->
            <div class="table-responsive">
                <table class="table table-bordered custom challan-table">
                    <tr>
                        <th colspan="4" class="text-center">To be fill up by the Milk Union</th>
                        <th colspan="2" class="text-center">To be filled by Bank</th>
                    </tr>
                    <tr>
                        <th width="30">SL</th>
                        <th>Name of Soccieties</th>
                        <th>Bank A/C No</th>
                        <th>Amount</th>
                        <th>Signature of ledger Keeper</th>
                        <th>Signature of officer</th>
                    </tr>
                    <tr v-for="(row, index) in data.details" :key="index">
                        <th>{{ (index + 1) }}</th>
                        <td>{{ row.association_name }}</td>
                        <td>{{ row.account_no }}</td>
                        <td class="text-right">{{ row.amount }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th class="text-right p-1">{{ Number.parseFloat(sum).toFixed(2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </table>
            </div>
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
                kernel : {},
                data   : [],
            }
        },
        mounted(){
            if(this.$route.query.id){
                this.http('head-office/report/application/view/'+this.$route.query.id, 'application', {
                    select:['id', 'chilling_plant_name']
                });
            }
        },
        methods:{
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel()
            {
                for(const key in this.kernel){
                    if(key=='application'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.data = this.kernel[key];
                        }
                    }
                }
            },
        },
        computed:{
            sum(){
                var total = 0;
                if(this.data.details)
                (this.data.details).forEach(row=>{
                    total += +row.amount;
                });
                return total;
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
