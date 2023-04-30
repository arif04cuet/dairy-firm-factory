<template>
<div class="card border-0 pos-print">
    <div class="print-layer" v-if="results.length>0">
        <div class="print-header">
            <br><br><br><br><br><br>
            <div class="img"><img src="@/assets/images/milk-vita.png" style="margin:0 auto" height="500" alt=""></div>
            <br><br><br><br>
            <h1 style="text-align:center">বাংলাদেশ দুগ্ধ উৎপাদনকারী সমবায় ইউনিয়ন লিমিটেড</h1>
        </div>
        <br><br>
        <table>
            <tr>
                <th>তারিখ</th>
                <td>: {{ $en2bn(results[0].testable.date) }}</td>
            </tr>
            <tr>
                <th>খামারি</th>
                <td>: {{ (results[0].testable.member).member_name }}</td>
            </tr>
            <tr>
                <th>শিফট</th>
                <td>: {{ $shift(results[0].testable.shift) }}</td>
            </tr>
            <tr>
                <th>পরিমাণ</th>
                <td>: {{ $en2bn(results[0].testable.amount_of_milk) }} লিটার</td>
            </tr>
            <tr>
                <th>তাপমাত্রা</th>
                <td>: {{ $en2bn(results[0].testable.temperature) }} সেলসিয়াস</td>
            </tr>
        </table>

        <br><br><hr>

        <h1 class="m-0">
            <span>খামারির দুধের পরীক্ষার ফলাফল</span>
        </h1>
        <br><br>

        <div class="table-responsive">
            <table class="table table-bordered custom">
                <thead>
                    <tr>
                        <th class="text-left">পরীক্ষার নাম</th>
                        <th class="text-left">আদর্শ মান</th>
                        <th class="text-left">পরীক্ষার ফলাফল</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(row, index) in results" :key="index">
                        <td class="text-left">{{ $en2bn(++index) }}. {{ row.test?row.test.test_name:"" }}</td>
                        <td class="text-left">{{ row.test?row.test.standerd_value:"" }}</td>
                        <td class="text-left">{{ row.result }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="height:500px; width:100%; border-bottom:1px solid #ddd">ddd</div>
    </div>
    <!-- // -->
    <div class="general-layer">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0">
                <i class="fa fa-list-alt"></i>
                <span>খামারির দুধের পরীক্ষার ফলাফল</span>
            </h3>
            <button class="btn btn-success" @click="print()">
                <i class="fa fa-print"></i>
            </button>
        </div>
        <div class="card-body min85vh">
            <!-- // -->
            <div class="table-responsive" v-if="(results.length > 0) && results[0].testable">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-left">খামারি</th>
                            <th class="text-left">শিফট</th>
                            <th class="text-left">দুধের পরিমাণ (লিটার)</th>
                            <th class="text-left">দুধের তাপমাত্রা (সেলসিয়াস)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-left">{{ (results[0].testable.member).member_name }}</td>
                            <td class="text-left">{{ (results[0].testable.shift) }}</td>
                            <td class="text-left">{{ (results[0].testable.amount_of_milk) }}</td>
                            <td class="text-left">{{ (results[0].testable.temperature) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- // -->
            <div class="table-responsive">
                <table class="table table-bordered custom">
                    <thead>
                        <tr>
                            <th class="text-center" width=20>ক্রমিক</th>
                            <th class="text-left">পরীক্ষার নাম</th>
                            <th class="text-left">আদর্শ মান</th>
                            <th class="text-left">পরীক্ষার ফলাফল</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in results" :key="index">
                            <td class="text-center">{{ $en2bn(++index) }}</td>
                            <td class="text-left">{{ row.test?row.test.test_name:"" }}</td>
                            <td class="text-left">{{ row.test?row.test.standerd_value:"" }}</td>
                            <td class="text-left">{{ row.result }}</td>
                        </tr>
                        <tr v-if="results.length<=0">
                            <td colspan="4">কোনো পরীক্ষার ফলাফল পাওয়া যায়নি</td>
                        </tr>
                    </tbody>
                </table>
                <div class="qck-btn-custom">
                    <button class="btn btn-light ml-2" @click="close()">বাতিল করুন</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name:'milk-collection-view',
    props:['collection_id'],
    model:{
        prop : 'collection_id',
        event: 'cancel',
    },
    data(){
        return {
            results: [],
            data : {},

        }
    },
    mounted(){
        this.$axios.post("association/milk-collection/single-test-result/"+ this.collection_id)
        .then(res=>{
            this.results = res.data;
            this.data = res.data.testable;
        })
        .catch();
    },
    methods:{
        close(){
            this.$emit('cancel', '');
        },
        print(){
            window.print();
        }
    }
}
</script>

<style>


    .general-layer {
        display: block;
    }
    .print-layer {
        display: none;
        height: fit-content;
    }
    .print-layer ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .print-layer table tr td, .print-layer table tr th {
        font-size: 7rem;
        margin-top: 7px;
    }
    .print-header h1 {
        text-align: center;
        font-size: 9rem;
        font-weight: bold;
    }
    .print-header .img {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

@page {
  size: 58cm 210cm;
}
@media print {
    .min75vh {
        min-height: 400px!important;
    }
    .popup {
        height: initial!important;
    }
    .app-footer {
        display: none!important;
    }
    .app-nav {
        display: none!important;
    }
    .app-aside {
        display: none!important;
    }
    .pos-print, .popup-box {
        position: fixed!important;
        top: 0!important;
        left: 0!important;
        z-index: 999999;
        width: 100%;
        position: fixed!important;
        top: 0!important;
        left: 0!important;
        transform: initial!important;
        background: #fff;
    }
    .popup .popup-box, .popup .popup-body {
        position: fixed;
        min-height: fit-content;
    }
    .pos-print h1 {
        font-size: 9rem;
    }
    .pos-print .table-bordered thead th, .pos-print .table-bordered thead td, .pos-print .table-bordered tbody td {
        font-size: 5.5rem;
        color: black;
    }
    .print-layer {
        display: block;
    }    .general-layer {
        display: none;
    }
    .print-layer {
        display: block;
    }
}
</style>
