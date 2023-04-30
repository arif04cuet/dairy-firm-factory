<template>
    <li>
        <div class="dropdown" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-expanded="false" >
            <img src="~/assets/icons/notification.webp" />
            <div class="counter">{{totalUnreadNotification}}</div>
        </div>
        <!-- // -->
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">

            <!-- 
                <ul class="notifications-dropdown">
                    <li v-for="(row, index) in notifications" :key="index">
                        <NuxtLink :to="'/notification/view?id='+row.id" class="dropdown-item">{{$en2bn(++index)+'. '+row.title}}</NuxtLink>
                    </li>
                    <li v-if="(Object.values(notifications)).length<=0" >
                        <NuxtLink to="#" class="dropdown-item">কোনো নোটিফিকেশন পাওয়া যায়নি</NuxtLink>
                    </li>
                </ul> 
            -->

            <table>
                <tr v-for="(row, index) in notifications" :key="index" class="dropdown-item link p-1 pl-3 pr-3" @click="$router.push({path:'/notification/view?id='+row.id})">
                    <td width="25" class="text-right border-right">{{$en2bn(++index)}}.</td>
                    <td class="pr-1 pl-2">{{row.title}}</td>
                </tr>

                <tr v-if="(notifications).length <= 0" class="dropdown-item link p-1 pl-3 pr-3">
                    <td colspan="2" class="text-center">কোনো নোটিফিকেশন পাওয়া যায়নি</td>
                </tr>
            </table>
        </div>
        <!-- // -->
    </li>
</template>

<script>
    import Echo from 'laravel-echo';
    var Pusher = require('pusher-js');
    //
    export default {
        name:'Notification',
        data(){
            return {

            }
        },
        mounted(){
            this.$axios.post('notification/list', {
                type:'flash'
            })
            .then(res=>{
                this.$store.commit('notification', res.data);
            });

            var echo = new Echo({
                broadcaster: 'pusher',
                key: '049462b2780d9dc81aa6',
                cluster: 'ap2',
                encrypted: true
            });

            echo.channel('user.notification.'+this.$store.state.auth.user.id)
            .listen('UserNotification', (e) => {
                if(e){
                    Object.values(e.notifications).forEach((row)=>{
                        if(row.push_notification){
                            this.$alert({
                                title: row.title,
                                confirmButtonText:'বাতিল করুন',
                                html: `<a href="/notification/view?id=${row.id}"><i class="fa fa-bell-o"></i>&nbsp; নোটিফিকেশনটি দেখুন</a>`,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                        }
                    });
                    this.$store.commit('notification', e);
                }
            });
        },
        computed:{
            totalUnreadNotification(){
                return this.$store.state.notification.total_unread;
            },
            //
            notifications(){
                return this.$store.state.notification.notifications;
            }
        }
    }
</script>

<style scoped>
    .link {
        font-size: 13px;
    }
    .notifications-dropdown {
        display: grid!important;;
    }
    .notifications-dropdown li {
        margin: 0!important;
        padding: 0px 5px 0px 5px;
    }
    .notifications-dropdown li a{
        margin: 0!important;
        padding: 5px!important;
    }
</style>

