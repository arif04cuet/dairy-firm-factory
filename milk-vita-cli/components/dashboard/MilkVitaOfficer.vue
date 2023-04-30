<template>
<div class="min60vh" style="position:relative">
    <Loader :loader="loading"/>
    <div v-if="loading==false">
        <div class="row p-md-4" style="background:#d8ebe5">
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/plant-officer/application/list" class="info-box">
                    <div class="icon" style="background:rgb(255 225 225)">
                        <img src="@/assets/icons/complete.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(202 138 136)">মোট সম্পূর্ণ আবেদন</span>
                        <strong>{{$en2bn(data.total_approve)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/plant-officer/application/list" class="info-box">
                    <div class="icon" style="background:rgb(227 241 224)">
                        <img src="@/assets/icons/pending.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(129 159 120)">মোট অপেক্ষমান আবেদন</span>
                        <strong>{{$en2bn(data.total_pending)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
            <!-- // -->
            <div class="col-md-4">
                <nuxt-link to="/plant-officer/application/list" class="info-box">
                    <div class="icon" style="background:rgb(237 237 237)">
                        <img src="@/assets/icons/close.webp" alt="">
                    </div>
                    <div class="info">
                        <span style="color:rgb(89 97 113)">মোট প্রত্যাখ্যান আবেদন</span>
                        <strong>{{$en2bn(data.total_reject)}} টি</strong>
                    </div>
                </nuxt-link>
            </div>
        </div>
        <!-- // -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <association-list
                            type="chilling-officer-application-list"
                        ></association-list>
                        <!-- // -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import AssociationList from '@/components/association/AssociationList.vue';
export default {
  components: {'association-list':AssociationList},
    name:'',
    data(){
        return {
            search  : {},
            kernel  : {},
            user    : this.$store.state.auth.user,
            data    : {},
            loading : true,
            
        }
    },
    mounted(){
        this.http('dashboard', 'dashboard');
    },
    methods:{
        http(url, type, data=null){
            this.$axios.post(url, data).then(res=>{this.kernel=Object.assign({}, {[type]:res.data})});
        },
    },
    watch:{
        kernel:function(){
            for(const key in this.kernel){
                if(key=='dashboard'){
                    this.data    = this.kernel[key];
                    this.loading = false;
                }
            }
        }
    }
}
</script>
