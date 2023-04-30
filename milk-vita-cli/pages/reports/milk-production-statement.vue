<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="m-0 mt-2">
                    <i class="fa fa-list"></i>
                    <span>দুধের স্ট্যান্ডার্ডাইজেশন সিট</span>
                </h5>
                <div>

                    <form @submit.prevent="fetchRecord">
                        <div class="row">
                            <!-- // -->
                            <div class="col-md-8">
                                <date-picker 
                                    v-model="search.date"
                                    v-bind="$local('bind')"
                                    :locale="$store.state.local"
                                />
                            </div>
                            <!-- // -->
                            <div class="col-md-2 text-left">
                                <button class="btn btn-success text-nowrap">
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                    সার্চ করুন&nbsp;
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body min75vh">
            <!-- // -->
            <div class="card-body bg-white">
                <h4 class="text-center p-2">Daily Milk Production Statement</h4>
                <div class="table-responsive">
                    <table class="table table-bordered statement-table">
                        <tr>
                            <th colspan="7" class="text-center text-nowrap" width="50">INTAKE</th>
                            <th class="text-nowrap">Product Ltr</th>
                            <th class="text-nowrap">Sp Gr</th>
                            <th class="text-nowrap">Pro. Kg</th>
                            <th class="text-nowrap">FAT %</th>
                            <th class="text-nowrap">SNF %</th>
                            <th class="text-nowrap">FAT(Kg)</th>
                            <th class="text-nowrap">SNF(KG)</th>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td>-</td>
                            <td colspan="6">Opening Stock (STD Milk)</td>
                            <td class="text-center"><span v-if="record.opening && record.opening.pro_liter">{{record.opening.pro_liter}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.density">{{record.opening.density}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.pro_kg">{{record.opening.pro_kg}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.fat_persentase">{{record.opening.fat_persentase}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.snf_persentase">{{record.opening.snf_persentase}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.fat_kg">{{record.opening.fat_kg}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.snf_kg">{{record.opening.snf_kg}}</span></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td>-</td>
                            <td colspan="6">Opening Stock (Toned Milk)</td>
                            <td class="text-center"><span v-if="record.opening && record.opening.pro_liter">{{record.opening.toned_pro_liter}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.density">{{record.opening.toned_density}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.pro_kg">{{record.opening.toned_pro_kg}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.fat_persentase">{{record.opening.toned_fat_persentase}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.snf_persentase">{{record.opening.toned_snf_persentase}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.fat_kg">{{record.opening.toned_fat_kg}}</span></td>
                            <td class="text-center"><span v-if="record.opening && record.opening.snf_kg">{{record.opening.toned_snf_kg}}</span></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td>-</td>
                            <td colspan="5">Whole Milk Received from plant</td>
                            <td class="text-center">STD.Sl.No</td>
                            <td colspan="7"></td>
                        </tr>
                        <!-- // -->
                        <tr v-if="record.challans" v-for="(row, challan_key) in record.challans" :key="(challan_key+1000)">
                            <td>{{challan_key+1}}</td>
                            <td colspan="5">{{row.chilling_plant_name}}</td>
                            <td class="text-center">{{challan_key+1}} + 0</td>
                            <td class="text-center">{{row.prpt_liter}}</td>
                            <td class="text-center">{{row.prpt_density}}</td>
                            <td class="text-center">{{row.prpt_kg}}</td>
                            <td class="text-center">{{row.prpt_fat_persentase}}</td>
                            <td class="text-center">{{row.prpt_snf_persentase}}</td>
                            <td class="text-center">{{row.prpt_fat_kg}}</td>
                            <td class="text-center">{{row.prpt_snf_kg}}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-right">Total</td>
                            <td class="text-center">{{$toFixed(total.challan_liter)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.challan_kg)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.challan_fat_kg)}}</td>
                            <td class="text-center">{{$toFixed(total.challan_snf_kg)}}</td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <th colspan="14" class="text-left">Market Return</th>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td rowspan="2" class="align-middle">-</td>
                            <td colspan="6">Good</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td colspan="6" class="text-left">Leak</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td rowspan="2" class="align-middle">-</td>
                            <td colspan="2">Additional</td>
                            <td class="text-nowrap"><small>SMP (Kg)</small></td>
                            <td class="text-nowrap"><small>FCMP (Kg)</small></td>
                            <td><small>Cream</small></td>
                            <td><small>Butter</small></td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">---</td>
                            <td class="text-nowrap"><small>---</small></td>
                            <td class="text-nowrap"><small>---</small></td>
                            <td>---</td>
                            <td>---</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <th colspan="14" class="text-left">Recombing Milk</th>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td colspan="7" class="text-left">TOTAL MILK INTAKE (A)</td>
                            <td class="text-center">{{$toFixed(total.intake_liter)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.intake_kg)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.intake_fat_kg)}}</td>
                            <td class="text-center">{{$toFixed(total.intake_snf_kg)}}</td>
                        </tr>
                        <!-- // -->
                        <tr v-if="record.products" v-for="(product, pro_key) in record.products" :key="pro_key">
                            <td>{{pro_key+1}}</td>
                            <td colspan="6">{{product.product_name}}</td>
                            <td class="text-center">{{product.pro_liter}}</td>
                            <td class="text-center">{{product.density}}</td>
                            <td class="text-center">{{product.pro_kg}}</td>
                            <td class="text-center">{{product.fat_persentase}}</td>
                            <td class="text-center">{{product.snf_persentase}}</td>
                            <td class="text-center">{{product.fat_kg}}</td>
                            <td class="text-center">{{product.snf_kg}}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-right">Total</td>
                            <td class="text-center">{{$toFixed(total.product_liter)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.product_kg)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.product_fat_kg)}}</td>
                            <td class="text-center">{{$toFixed(total.product_snf_kg)}}</td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <th colspan="7" class="text-center">Dispatch to</th>
                            <td colspan="7"></td>
                        </tr>
                        <!-- // -->
                        <tr>
                            <td rowspan="3" class="align-middle">8</td>
                            <td colspan="6">Clossing Stock (Whole Milk)</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>

                        <!-- 
                            STD MILK 
                        -->
                        <tr v-if="record.closing && Object.values(record.closing).length > 0">
                            <td colspan="6" class="text-left">Clossing Stock (STD Milk)</td>
                            <td class="text-center"><span>{{closing_stock_data.pro_liter}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.density}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.pro_kg}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.fat_persentase}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.snf_persentase}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.fat_kg}}</span></td>
                            <td class="text-center"><span>{{closing_stock_data.snf_kg}}</span></td>
                        </tr>
                        <tr v-else style="background:#ddd">
                            <td colspan="6" class="text-left">Clossing Stock (STD Milk)</td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.pro_liter" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.density" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.pro_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.fat_persentase" class="form-control m-0" ></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.snf_persentase" class="form-control m-0" ></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.fat_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.snf_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                        </tr>
                        

                        <!-- 
                            TONED MILK
                        -->
                        <tr v-if="record.closing && Object.values(record.closing).length > 0">
                            <td colspan="6" class="text-left">Clossing Stock (Toned Milk)</td>
                            <td class="text-center"><span>{{record.closing.toned_pro_liter}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_density}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_pro_kg}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_fat_persentase}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_snf_persentase}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_fat_kg}}</span></td>
                            <td class="text-center"><span>{{record.closing.toned_snf_kg}}</span></td>
                        </tr>
                        <tr v-else style="background:#ddd">
                            <td colspan="6" class="text-left">Clossing Stock (Toned Milk)</td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.toned_pro_liter" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.toned_density" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.toned_pro_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.toned_fat_persentase" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" @change="ClosingToneedMilkCal()" @input="ClosingToneedMilkCal()" v-model="closing_stock_data.toned_snf_persentase" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.toned_fat_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                            <td class="text-center p-1"><input type="text" v-model="closing_stock_data.toned_snf_kg" @change="outputAndGainLoss()" @input="outputAndGainLoss()" class="form-control m-0"></td>
                        </tr>


                        <!-- // -->
                        <tr>
                            <td rowspan="3" class="align-middle">9</td>
                            <td colspan="6" class="text-right">TOTAL OUTPUT (B)</td>
                            <td class="text-center">{{$toFixed(total.output_liter)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.output_kg)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.output_fat_kg)}}</td>
                            <td class="text-center">{{$toFixed(total.output_snf_kg)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">Gain or Loss (B-A)</td>
                            <td class="text-center">{{$toFixed(total.gain_or_loss_liter ? total.gain_or_loss_liter : '0')}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.gain_or_loss_kg)}}</td>
                            <td class="text-center">---</td>
                            <td class="text-center">---</td>
                            <td class="text-center">{{$toFixed(total.gain_or_loss_fat_kg)}}</td>
                            <td class="text-center">{{$toFixed(total.gain_or_loss_snf_kg)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">% Gain or Loss (B-A)</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    </table>

                    <button v-if="record.closing && !record.closing.pro_liter" class="btn btn-success float-right mt-3" @click="onClose()">
                        <span v-if="is_closing==true">
                            <i class="fa fa-spinner fa-spin fa-fw"></i>
                            <span>Loading...</span>
                        </span>
                        <span v-else >
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            <span>Close Today's</span>
                        </span>
                    </button>
                    <!-- // -->
                </div>
            </div>
            <!-- // -->
            <Loader :loader="loader"/>
            <div class="not-found" v-if="is_ready==false">
                <div>
                    <h4 class="text-center mt-3">{{$en2bn(record.opening_date) + " তারিখে ক্লোজিং করা হয়নি"}}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout:'admin',
        name:'all',
        data(){
            return {
                kernel      : {},
                search      : {date : this.$date(),},
                loader      : false,
                is_closing  : false,
                is_ready    : true,
                record      : {},
                //
                re_closing_stock_data : {},
                closing_stock_data  : {
                    pro_liter       : 0,
                    density         : 0,
                    pro_kg          : 0,
                    fat_persentase  : 0,
                    snf_persentase  : 0,
                    fat_kg          : 0,
                    snf_kg          : 0,
                    //
                    toned_pro_liter : 0,
                    toned_density   : 0,
                    toned_pro_kg    : 0,
                    toned_fat_kg    : 0,
                    toned_snf_kg    : 0,
                    toned_fat_persentase : 0,
                    toned_snf_persentase : 0,
                },
                total : {},
            }
        },
        mounted(){
            this.fetchRecord();
            this.clearTotal();
        },
        methods:{
            clearTotal(){
                this.re_closing_stock_data = Object.assign({}, this.closing_stock_data);
                //
                this.total = {
                    product_liter     : 0,
                    product_kg        : 0,
                    product_fat_kg    : 0,
                    product_snf_kg    : 0,

                    challan_liter     : 0,
                    challan_kg        : 0,
                    challan_fat_kg    : 0,
                    challan_snf_kg    : 0,

                    intake_liter     : 0,
                    intake_kg        : 0,
                    intake_fat_kg    : 0,
                    intake_snf_kg    : 0,

                    output_liter      : 0,
                    output_kg         : 0,
                    output_fat_kg     : 0,
                    output_snf_kg     : 0,

                    gain_or_loss_liter  : 0,
                    gain_or_loss_kg     : 0,
                    gain_or_loss_fat_kg : 0,
                    gain_or_loss_snf_kg : 0,
                };
            },
            ClosingToneedMilkCal(){
                this.closing_stock_data.pro_liter    = Number.parseFloat(+this.re_closing_stock_data.pro_liter - +this.closing_stock_data.toned_pro_liter).toFixed(2);

                this.closing_stock_data.pro_kg       = Number.parseFloat(this.closing_stock_data.pro_liter * this.closing_stock_data.density).toFixed(2);
                this.closing_stock_data.toned_pro_kg = Number.parseFloat(this.closing_stock_data.toned_pro_liter * this.closing_stock_data.toned_density).toFixed(2);

                this.closing_stock_data.fat_kg = Number.parseFloat((this.closing_stock_data.pro_kg / 100) * this.closing_stock_data.fat_persentase).toFixed(2);
                this.closing_stock_data.snf_kg = Number.parseFloat((this.closing_stock_data.pro_kg / 100) * this.closing_stock_data.snf_persentase).toFixed(2);

                this.closing_stock_data.toned_fat_kg = Number.parseFloat((this.closing_stock_data.toned_pro_kg / 100) * this.closing_stock_data.toned_fat_persentase).toFixed(2);
                this.closing_stock_data.toned_snf_kg = Number.parseFloat((this.closing_stock_data.toned_pro_kg / 100) * this.closing_stock_data.toned_snf_persentase).toFixed(2);

                this.outputAndGainLoss();
            },
            calculation(){
                this.clearTotal();
                //
                if(this.record.products){
                    (this.record.products).forEach(item=>{
                        this.total.product_liter   += +item.pro_liter;
                        this.total.product_kg      += +item.pro_kg;
                        this.total.product_fat_kg  += +item.fat_kg;
                        this.total.product_snf_kg  += +item.snf_kg;
                    });
                }
                //
                if(this.record.challans){
                    (this.record.challans).forEach(item=>{
                        this.total.challan_liter   += +item.prpt_liter;
                        this.total.challan_kg      += +item.prpt_kg;
                        this.total.challan_fat_kg  += +item.prpt_fat_kg;
                        this.total.challan_snf_kg  += +item.prpt_snf_kg;
                    });
                }
                //

                this.total.intake_liter   = ((+this.total.challan_liter)  + (+this.record.opening.pro_liter) + (+this.record.opening.toned_pro_liter));
                this.total.intake_kg      = ((+this.total.challan_kg)     + (+this.record.opening.pro_kg)    + (+this.record.opening.toned_pro_kg));
                this.total.intake_fat_kg  = ((+this.total.challan_fat_kg) + (+this.record.opening.fat_kg)    + (+this.record.opening.toned_fat_kg));
                this.total.intake_snf_kg  = ((+this.total.challan_snf_kg) + (+this.record.opening.snf_kg)    + (+this.record.opening.toned_snf_kg));

                if(this.record.closing && Object.values(this.record.closing).length == 0)
                {
                    this.closing_stock_data = {
                        pro_liter       : (this.total.intake_liter - this.total.product_liter),
                        density         : 1.02912,
                        pro_kg          : 0,
                        fat_persentase  : 3.4,
                        snf_persentase  : 8.1,
                        fat_kg          : 0,
                        snf_kg          : 0,
                        //
                        toned_pro_liter : 0,
                        toned_density   : 1.0335,
                        toned_pro_kg    : 0,
                        toned_fat_kg    : 0,
                        toned_snf_kg    : 0,
                        toned_fat_persentase : 2.0,
                        toned_snf_persentase : 8.915,
                    }
                    this.re_closing_stock_data = Object.assign({}, this.closing_stock_data);
                }

                //
                this.ClosingToneedMilkCal();
            },

            outputAndGainLoss(){
                this.total.output_liter  = ((+this.total.product_liter)  + (+this.closing_stock_data.pro_liter) + (+this.closing_stock_data.toned_pro_liter));
                this.total.output_kg     = ((+this.total.product_kg)     + (+this.closing_stock_data.pro_kg)    + (+this.closing_stock_data.toned_pro_kg));
                this.total.output_fat_kg = ((+this.total.product_fat_kg) + (+this.closing_stock_data.fat_kg)    + (+this.closing_stock_data.toned_fat_kg));
                this.total.output_snf_kg = ((+this.total.product_snf_kg) + (+this.closing_stock_data.snf_kg)    + (+this.closing_stock_data.toned_snf_kg));

                this.total.gain_or_loss_liter  = (this.total.output_liter  - this.total.intake_liter);
                this.total.gain_or_loss_kg     = (this.total.output_kg     - this.total.intake_kg);
                this.total.gain_or_loss_fat_kg = (this.total.output_fat_kg - this.total.intake_fat_kg);
                this.total.gain_or_loss_snf_kg = (this.total.output_snf_kg - this.total.intake_snf_kg);
            },
            onClose(){
                this.is_closing = true;
                this.http('report/milk-production-closing', 'closing-balance', this.closing_stock_data);
            },
            fetchRecord(){
                this.loader   = true;
                this.is_ready = true;
                this.http('report/milk-production-statement', 'record', this.search);
            },
            http(url, type, data=null){
                this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
            },
        },
        watch:{
            kernel(){
                for(const key in this.kernel){
                    if(key=='record'){
                        this.record      = this.kernel[key];
                        this.search.date = this.record.search_date;
                        this.calculation();
                        this.loader         = false;

                        if(!this.record.opening || Object.values(this.record.opening).length == 0){
                            this.is_ready = false;
                        }
                        else this.is_ready = true;
                    }
                    else if(key=='closing-balance')
                    {
                        this.is_closing = false;
                        if(this.kernel[key].errors)
                        {
                            this.$toastr.w(this.$msgSanitize(this.kernel[key].errors));
                        }
                        else {
                            this.record.closing = this.closing_stock_data;
                            this.$toastr.s('সফলভাবে ক্লোস করা হয়েছে ');
                        }
                        this.calculation();
                    }
                }
            }
        }
    }
</script>


<style>
    .statement-table {
        font-size: 14px;
    }
    .statement-table tr td:first-child, .statement-table tr th:first-child {
        text-align: center;
    }
    tr td input {
        outline: none!important;
        box-shadow: none!important;
        font-size: 14px!important;
        padding: 0!important;
        text-align: center;
    }
    .not-found {
        position: absolute;
        left: 0;
        top: 0;
        background:#fff;
        width: 100%;
        height: 100%;
    }
</style>