<template>
    <div class="card min85vh">
        <div class="p-4" v-if="form_data.details">
            <form @submit.prevent="submit">
                <div class="header">
                    <h3>Bangladesh Milk Producer's Co-operative Union Ltd</h3>
                    <h4>{{ form_data.chilling_plant_name }}</h4>
                    <h5 class="border-bottom pb-2">Milk Bill</h5>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div><strong>Memo No : </strong> {{ form_data.memo_no }}</div>
                    <div><strong>Date : </strong>{{ ($date()) }}</div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">To The Manager,</label>
                        <textarea name="" class="form-control" id="" style="font-size:13px" rows="2" v-model="form_data.to"></textarea>
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Subject</label>
                        <textarea name="" class="form-control" id="" style="font-size:13px" v-model="form_data.subject"></textarea>
                    </div>
                </div>
                <!-- // -->
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Body</label>
                        <textarea name="" class="form-control" id="" rows="3" style="font-size:13px" v-model="form_data.body"></textarea>
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
                        <tr v-for="(row, index) in form_data.details" :key="index">
                            <th>{{index+1}}</th>
                            <td>{{ (row).association_name }}</td>
                            <td>{{ (row).account_no }}</td>
                            <td class="custom-challan-row"><input type="number" step="any" v-model="form_data.details[index].amount" required></td>
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
                <!-- // -->
                <button class="btn btn-success float-right">Update</button>
            </form>
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
                kernel     : {},
                data       : [],
                form_data  : {
                    details : [],
                    to      : "Janata Bank Ltd. \nBalijuri Bazar Branch, Jamalpur.",
                    subject : "Transfer of fund from BMPCUL A/C. No CD 1011012443 amounting to TK 34565534 for payment against Milk Bill to the DUSS Ltd's account maintain with you bank.",
                    body    : "Dear Sir,\nPlease find there with a cheque for tk 225546645 cheque No 24435646 Dated 27-02-2022 in favour of your Bank towards payment of Milk Billl for the period from 17-02-2022 to 28-02-2022 you are therefore, advised to creadit the following accounts accordingly.",
                },
                search     : {
                    chilling_plant_id : ''
                },
                chilling_plant_id : '',
                chilling_plants   : [],
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
            submit(){
                var data = Object.assign({}, this.form_data);
                //
                data['associations'] = data.details;
                //
                delete (data['details']);
                //
                this.http('head-office/report/application/update/'+this.$route.query.id, 'application-update', data);
            },
            openSociety(){
                if(this.search.chilling_plant_id){
                    this.chilling_plant_id = this.search.chilling_plant_id;
                }
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            }
        },
        watch:{
            kernel()
            {
                for(const key in this.kernel){
                    if(key=='chilling-plant-list'){
                        this.chilling_plants = this.kernel[key].data;
                    }
                    else if(key=='application') {
                        this.form_data = this.kernel[key];
                    }
                    else if(key=='chilling-plant-record'){
                        this.data = this.kernel[key];
                    }
                    else if(key=='application-update'){
                        if(this.kernel[key].errors){
                            this.$toastr.w(this.kernel[key].errors);
                        }
                        else {
                            this.$toastr.s('Application Successfully Submited');
                            this.$router.push({path:'/head-office/bank-forwarding-litter/view?id='+this.kernel[key]});
                        }
                    }
                }
            },
            chilling_plant_id()
            {
                if(this.chilling_plant_id)
                    this.http('head-office/report/chilling-plant-record/'+this.chilling_plant_id, 'chilling-plant-record');
            }
        },
        computed:{
            sum(){
                var total = 0;
                if(this.form_data.details)
                (this.form_data.details).forEach(row=>{
                    if(row.amount)
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
