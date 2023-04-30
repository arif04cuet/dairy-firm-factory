<template>
    <div class="row p-md-4" style="background:#d8ebe5">
        <div class="col-md-12" v-if="$dashboardElement('', 'info-box')<=0">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <h2 class="m-0">মিল্কভিটা ড্যাশবোর্ডে স্বাগতম</h2>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="wrapper">
                        <div class="display">
                            <div id="time"></div>
                        </div>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- // -->
        <div class="col-md-3" v-if="$dashboardElement('total_association_member', 'info-box')">
            <nuxt-link to="/association/member/list" class="info-box">
                <div class="icon" style="background:#caf6ce9e">
                    <img src="@/assets/icons/user.svg" alt="">
                </div>
                <div class="info">
                    <span style="color:#16a416">মোট সদস্য সংখ্যা</span>
                    <strong>{{$en2bn(data.total_asso_member ? data.total_asso_member:0)}} জন</strong>
                </div>
            </nuxt-link>
        </div>

        <!-- // -->
        <div class="col-md-3" v-if="$dashboardElement('total_cattle', 'info-box')">
            <nuxt-link to="/association/member/list" class="info-box">
                <div class="icon" style="background:rgb(244 180 212)">
                    <img src="@/assets/icons/ox.svg" alt="">
                </div>
                <div class="info">
                    <span style="color:#d24088">মোট গবাদি পশুর সংখ্যা</span>
                    <strong>{{$en2bn(data.total_cattle ? data.total_cattle:0)}} টি</strong>
                </div>
            </nuxt-link>
        </div>

        <!-- // -->
        <div class="col-md-3" v-if="$dashboardElement('total_association-member', 'info-box')">
            <nuxt-link to="#" class="info-box">
                <div class="icon" style="background:rgb(69 177 255 / 35%)">
                    <img src="@/assets/icons/milk-jar.svg" alt="">
                </div>
                <div class="info">
                    <span style="color:#4477a0">সাপ্তাহিক দুধ সংগ্রহ</span>
                    <strong>{{$en2bn(data.last_week_collections ? data.last_week_collections:0)}} লিটার</strong>
                </div>
            </nuxt-link>
        </div>
        <!-- // -->

        <div class="col-md-3" v-if="$dashboardElement('total_primary_servey', 'info-box')">
            <nuxt-link to="/association/all" class="info-box">
                <div class="icon" style="background:#524e83">
                    <img src="@/assets/icons/committee.webp" alt="">
                </div>
                <div class="info">
                    <span style="color:#514e82">প্রাথমিক জরিপ</span>
                    <strong>{{$en2bn(data.total_primary_survey?data.total_primary_survey:0)}} টি</strong>
                </div>
            </nuxt-link>
        </div>
        <!-- // -->

        <div class="col-md-3" v-if="$dashboardElement('total_pending_application', 'info-box')">
            <nuxt-link to="/association/application/list" class="info-box">
                <div class="icon" style="background:rgb(26 91 208 / 84%)">
                    <img src="@/assets/icons/application.webp" alt="">
                </div>
                <div class="info">
                    <span style="color:#3561b7">মোট অপেক্ষমান আবেদন</span>
                    <strong>{{$en2bn(data.total_pending_application?data.total_pending_application:0)}} টি</strong>
                </div>
            </nuxt-link>
        </div>
        <!-- // -->

        <div class="col-md-3" v-if="$dashboardElement('total_primary_association', 'info-box')">
            <nuxt-link to="/association/application/list" class="info-box">
                <div class="icon" style="background:#D01A67">
                    <img src="@/assets/icons/application.webp" alt="">
                </div>
                <div class="info">
                    <span style="color:#ab1b57">মোট প্রাথমিক সমবায় সমিতি</span>
                    <strong>{{$en2bn(data.total_primary_association?data.total_primary_association:0)}} টি</strong>
                </div>
            </nuxt-link>
        </div>
        <!-- // -->
    </div>
</template>

<script>
export default {
    data:()=>({
        data:{}
    }),
    mounted(){
        this.$setTimeToTag('#time');
        var actions = this.$dashboardElement('actions', 'info-box'), slugs = [];
        //
        if(typeof actions == 'object') {
            Object.values(actions).filter(item=>{
                slugs.push(item.slug);
            });
        }
        //
        this.$axios.post("dashboard", {
            slugs:slugs
        })
        .then(res=>{
            this.data = res.data.info_boxes
        });
    },
}
</script>



<style scoped>
    .wrapper {
        position: relative;
        width: 257px;
        height: 54px;
        border-radius: 10px;
        cursor: default;
        animation: animate 2s linear infinite;
    }

    .wrapper .display {
        position: absolute;
        top: 50%;
        left: 50%;
        background: rgb(188 224 234 / 40%);
        transform: translate(-50%, -50%);
        width: 255px;
        height: 52px;
        text-align: center;
        border-radius: 8px;
        z-index: 100;
    }

    .wrapper .display #time {
        background: #000000a3;
        line-height: 53px;
        font-size: 2.1rem;
        font-weight: 600;
        letter-spacing: 1px;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: animate 2s linear infinite;
    }

    .wrapper span {
        width: 100%;
        height: 100%;
        background: inherit;
        border-radius: 10px;
    }

    .wrapper span:first-child {
        filter: blur(10px);
    }

    .wrapper span:last-child {
        filter: blur(20px);
    }

    @keyframes animate {
        100% {
            filter: hue-rotate(360deg);
        }
    }

</style>