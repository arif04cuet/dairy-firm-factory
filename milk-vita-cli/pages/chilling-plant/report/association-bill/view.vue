<template>
    <div class="card min85vh p-4" v-if="data.record">

        <div class="header">
            <h3>Bangladesh Milk Producer's Co-operative Union Ltd</h3>
            <h4>Payment of Milk bill</h4>
            <h5>Code No - {{ data.record.association_code }}</h5>
        </div>

        <div class="d-flex justify-content-between">
            <div><strong>Name Of Society : </strong>{{ data.record.association_name }}</div>
            <div><strong>Bill Pay : </strong>{{ (data.record.from_date)+' To '+(data.record.to_date) }}</div>
        </div>

        <div class="table-responsive">
            <caption class="text-nowrap">Supply of Good Milk</caption>
            <table class="table table-bordered  custom challan-table">
                <tr>
                    <th>-</th>
                    <th>-</th>
                    <th colspan="3" class="text-center">Quantity Of Milk</th>
                    <th colspan="2" class="text-center">FAT</th>
                    <th>SNF</th>
                    <th>-</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>LITRE</th>
                    <th>spcific</th>
                    <th>KG</th>
                    <th>%</th>
                    <th>KG</th>
                    <th>%</th>
                    <th>KG</th>
                    <th>PRICE</th>
                    <th>-</th>
                </tr>
                <tr v-for="(row, index) in data.collections" :key="index">
                    <td>{{ row.milk_collection_date }}</td>
                    <td class="text-capitalize">{{ row.shift }}</td>
                    <td class="text-right">{{ row.litre }}</td>
                    <td class="text-right">{{ row.specific_gravity }}</td>
                    <td class="text-right">{{ (row.litre * row.specific_gravity) }}</td>
                    <td class="text-right">{{ row.fat }}</td>
                    <td class="text-right">{{ Number.parseFloat(((row.litre / 100) * row.fat)).toFixed(4) }}</td>
                    <td class="text-right">{{ row.snf }}</td>
                    <td class="text-right">{{ Number.parseFloat(((row.litre / 100) * row.snf)).toFixed(4) }}</td>
                    <!-- <td class="text-right">{{ row.unit_price }}</td> -->
                    <td class="text-center custom-challan-row" width="70"><input type="number" step="any" v-model="data.collections[index].unit_price" @change="calculateGrand" @input="calculateGrand"></td>
                    <td class="text-right">{{ Number.parseFloat((row.litre * row.unit_price)).toFixed(2) }}</td>
                </tr>

                <tr>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right p-1">{{ grand.total_litre }}</th>
                    <th class="text-right p-1">{{ grand.total_specific }}</th>
                    <th class="text-right p-1">{{ grand.total_specific_kg }}</th>
                    <th class="text-right p-1">{{ grand.total_fat }}</th>
                    <th class="text-right p-1">{{ grand.total_fat_kg }}</th>
                    <th class="text-right p-1">{{ grand.total_snf }}</th>
                    <th class="text-right p-1">{{ grand.total_snf_kg }}</th>
                    <th class="text-right p-1"></th>
                    <th class="text-right p-1">{{ Number.parseFloat(grand.total_price).toFixed(2) }}</th>
                </tr>
                <!-- // -->
                <tr><th colspan="11">&nbsp;</th></tr>
                <!-- 
                    <----- START MAKER SECTION -----<
                -->
                <tr>
                    <th colspan="5" class="text-center">QUANTITY OF TOTAL MILK SUPPLY LITRE</th>
                    <th>{{ grand.total_litre }}</th>
                    <th colspan="4" class="text-center">TOTAL MILK PRICE(A+B)</th>
                    <th></th>
                </tr>
                <!-- // -->
                <tr>
                    <th rowspan="7" colspan="6">
                        <br>
                        <p class="m-0 p-0">PREPARED BY</p>
                    </th>
                    <td class="text-left" colspan="3">(+)TRANSPORT</td>
                    <td>4.38</td>
                    <td>2566.68</td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="4">(+)ADVANCE</td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="4">(+)</td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-center" colspan="4">
                        <div class="d-flex justify-content-between">
                            <span>TOTAL AMOUNT</span> <span>E</span>
                        </div>
                    </td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="4">(MINUS)</td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">SHARE PURCHASE X.40</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">CATTLE DEVELOPMENT FOUND</td>
                    <td></td>
                    <td></td>
                </tr>
                

                <!-- 
                    <----- START MAKER SECTION -----<
                -->
                <tr>
                    <th rowspan="5" colspan="6">
                        <br>
                        <p class="m-0 p-0">Depury Manager</p>
                    </th>
                    <td class="text-left" colspan="3">COW LOAN (GVT)</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">COW LOAN (CDF)</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">STATIONARY</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">CATTLE FEED</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">COMISSION OF MILK X 1.00</td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- 
                    <----- END MAKER SECTION -----<
                -->
                <tr><th colspan="11">&nbsp;</th></tr>
                <!-- // -->
                <tr>
                    <th rowspan="5" colspan="6"></th>
                    <td class="text-left" colspan="2">TOTAL MINUS</td>
                    <td></td>
                    <td>D</td>
                    <td></td>
                </tr>
                <!-- // -->
                <tr>
                    <td class="text-left" colspan="3">NET AMOUNT (D-E)</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
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
                data:[],
                grand:{
                    total_litre : 0,
                    total_specific : 0,
                    total_specific_kg : 0,
                    total_fat : 0,
                    total_fat_kg : 0,
                    total_snf : 0,
                    total_snf_kg : 0,
                    total_price : 0,
                }
            }
        },
        mounted(){
            this.$axios.post('chilling-plant/report/view/'+this.$route.query.id)
            .then(res=>{
                var response = res.data;
                
                if(response.errors){
                    this.$toastr.w(response.errors);
                }
                else {
                    this.data = response;
                    this.calculateGrand();
                } 
            });
        },
        methods:{
            calculateGrand(){
                this.grand = {
                    total_litre : 0,
                    total_specific : 0,
                    total_specific_kg : 0,
                    total_fat : 0,
                    total_fat_kg : 0,
                    total_snf : 0,
                    total_snf_kg : 0,
                    total_price : 0,
                };

                if(this.data.collections){
                    (this.data.collections).forEach(row => {
                        this.grand.total_litre += +row.litre;
                        this.grand.total_specific += +row.specific_gravity;
                        this.grand.total_specific_kg += +(row.litre * row.specific_gravity);
                        this.grand.total_fat += +(row.fat);
                        this.grand.total_fat_kg += +(Number.parseFloat(((row.litre / 100) * row.fat)).toFixed(4));
                        this.grand.total_snf += +row.snf;
                        this.grand.total_snf_kg += +(Number.parseFloat(((row.litre / 100) * row.snf)).toFixed(4));
                        this.grand.total_price += +(row.litre * row.unit_price);
                    });
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
