<template>
    <div class="min60vh">
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom mb-2">
                <thead>
                    <tr>
                        <th width="70" class="text-center" rowspan="2">ক্রমিক নং</th>
                        <th rowspan="2">তারিখ</th>
                        <th colspan="2">দুধের পরিমান</th>
                        <th rowspan="2">শিফট</th>
                        <th colspan="2">মূল্য</th>
                        <th rowspan="2" width="70" class="text-center">অ্যাকশন</th>
                    </tr>
                    <tr>
                        <th>লিটার</th>
                        <th>মিঃলিঃ</th>
                        <!-- // -->
                        <th>টাকা</th>
                        <th>পঃ</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(row, index) in collections" :key="index">
                        <td class="text-center">{{$en2bn(++index)}}</td>
                        <td>{{$en2bn(row.date)}}</td>
                        <td>{{$en2bn(Math.floor(row.amount_of_milk))}}</td>
                        <td>{{$en2bn(onlyMl(row.amount_of_milk))}}</td>
                        <td>{{$shift(row.shift)}}</td>
                        <td>--</td>
                        <td>--</td>
                        <td class="text-center">
                            <div class="btn-group custom">
                                <button class="btn btn-info">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="collections.length == 0">
                        <th colspan="8">কোন তথ্য পাওয়া যায়নি</th>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <pagination v-model="page_no" :records="total_row" :per-page="per_page" @paginate="fetchCollection" />
            </div>
        </div>
      <Loader :loader="loader" />
    </div>
</template>

<script>
import Pagination from "vue-pagination-2";
export default {
    name:'',
    components: { Pagination },
    props:['member_id'],
    data(){
        return {
            kernel      : {},
            search      : {
                member_id:this.member_id
            },
            collections : [],
            per_page    : 10,
            page_no     : 1,
            total_row   : 0,
            loader      : true, 
        }
    },
    mounted(){
        this.fetchCollection();
    },
    methods:{
        onlyMl(amount){
            amount = Number(amount).toFixed(3);
            return (amount.slice((amount).indexOf('.')+1));
        },
        fetchCollection() {
            this.loader = true;
            this.http("association/milk-collection/all", 'collections', {
                per_page : this.per_page,
                page_no  : this.page_no,
                where    : this.search,
            });
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
                if (key == "collections") {
                    this.collections = this.kernel[key].data;
                    this.total_row   = this.kernel[key].total_row;
                    this.loader      = false;
                }
            }
        },
    },
}
</script>
