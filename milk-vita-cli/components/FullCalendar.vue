<template>
    <div class="custom-calendar">
        <Calendar 
            class="w100"
            :events="data" 
            @eventClick="handleEventClick" 
        >
        </Calendar>

        <div class="calendar-info-wrapper" v-if="is_open" @click="close"></div>
        <div class="calendar-info" v-if="is_open">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-0">{{details.title}}</h5>
                    <p class="card-text mb-1 text-info">{{$en2bn(details.start)}} <span v-if="details.end"> থেকে </span> <span v-if="details.end">{{$en2bn(details.end)}}</span></p>
                    <p class="card-text" v-if="details.details">{{details.details}}</p>
                    <div class="w100 text-right">
                        <div class="btn-group">
                            <nuxt-link :to="details.path" class="btn btn-primary" v-if="details.path">
                                <span>এগিয়ে যান</span>
                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                            </nuxt-link>
                            <button class="btn btn-info ml-1" @click="close">
                                <span>বাতিল করুন</span>
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['events'],
        data(){
            return {
                data    : [],
                details : {},
                is_open : false,
            }
        },
        mounted(){
            this.data = (this.events ? this.events : []);
        },
        methods:{
            close(){
                this.is_open = false;
            },
            handleEventClick(details){
                this.details = details;
                this.is_open = true;
            },
        }
    }
</script>


<style scoped>
    .custom-calendar {
        position: relative;
    }
    .calendar-info-wrapper, .calendar-info {
        min-width: 400px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 999;
        background: #fff;
    }
    .calendar-info-wrapper {
        z-index: 998;
        width: 100%;
        height: 100%;
        background: #0000004a;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day {
        transition: all 0.3s linear;
        cursor: default!important;;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day:hover {
        background: rgb(235 240 237 / 80%);
    }
    .full-calendar-body .dates .dates-events .events-week .events-day.today {
        background: #e9f2fb!important;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day .day-number {
        opacity: 1!important;
    }
    .comp-full-calendar {
        max-width: initial!important;;
    }
    .full-calendar-body .dates .week-row .day-cell {
        flex: 1;
        min-height: 72px!important;
        padding: 4px;
        border-right: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day {
        cursor: pointer;
        flex: 1;
        min-height: 72px!important;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .full-calendar-body .dates .dates-events .events-week .events-day .event-box .event-item:hover {
        background: #ddd;
    }
</style>