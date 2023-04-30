<template>
    <perfect-scrollbar class="app-aside" >
        <ul class="app-aside-menus">
            <li 
                class="app-aside-menu-item"
                :class="uri=='/user/dashboard'?'active':''"
                @click="clickEvent($route.path=='/user/dashboard')"
            >
                <nuxt-link to="/user/dashboard">
                    <img  src="@/assets/icons/home.webp" class="icon" alt=""> ড্যাশবোর্ড
                </nuxt-link>
            </li>

            <li 
                class="app-aside-menu-item"
                :class="uri=='/user/profile'?'active':''"
                @click="clickEvent($route.path=='/user/profile')"
            >
                <nuxt-link to="/user/profile">
                    <img src="@/assets/images/user.png" class="rounded-circle icon" alt=""> প্রোফাইল
                </nuxt-link>
            </li>

            <li 
                v-for="(menu, index) in menus" 
                :key="index" 
                :ref="'pm-'+index"
                v-if="menu.slug!='dashboard-module' && menu.slug!='dashboard-card'"

                @click="clickEvent((true), $refs['pm-'+index][0])"

                class="app-aside-menu-item" 
                :class="
                    (checkIsParent(menu, ('pm-'+index), menu.url)?'active ':'')+
                    ((menu.sub_menu && menu.sub_menu.length>0)?'dropdown':'')
                "
            >
                <a v-if="menu.sub_menu && menu.sub_menu.length>0">
                    <img :src="$store.state.host_server+menu.icon" class="rounded-circle icon" alt=""> {{ menu.name_bn }}
                </a>
                <NuxtLink :to="menu.url" v-else >
                    <img :src="$store.state.host_server+menu.icon" class="rounded-circle icon" alt=""> {{ menu.name_bn }}
                </NuxtLink>

                <ul v-if="menu.sub_menu && menu.sub_menu.length>0">
                    <li v-for="(smenu, key2) in menu.sub_menu" :key="key2" :class="(($freshUri($route.path)==smenu.url || checkIsParent(smenu, null, smenu.url))?'active':'')"><NuxtLink :to="smenu.url">{{smenu.name_bn}}</NuxtLink></li>
                </ul>
            </li>
        </ul>
    </perfect-scrollbar>
</template>

<script>
//
export default {
    data() {
        return {
            menus     : [],
            user      : '',
            fired_tag : false,
        };
    },
    mounted(){
        setTimeout(()=>{
            this.user  = this.$store.state.auth.user;
            this.menus = this.$store.state.auth.user.privilege;
            this.$store.commit('setValidUri', this.$ckMenu(this.$freshUri(this.$route.path)));
        }, 100);
        
    },
    methods: {
        clickEvent:function(active=false, tag=false) {
            this.toggle(tag);
            this.$store.commit('setValidUri', this.$ckMenu(this.$freshUri(this.$route.path)));
        },
        checkIsParent(menu=[], ref=null, url=null)
        {
            var isActive = (url==this.$route.path);
            var c = this.$freshUri(this.$route.path);

            if(!isActive && menu.sub_menu){
                menu.sub_menu.forEach(sub=>{
                    if(sub.url==c) isActive = true;
                    //
                    if(!isActive && sub.action_menu.length>0){
                        (sub.action_menu).forEach(action=>{
                            if(!isActive) (isActive = action.url==c);
                        });
                    }
                });
            }

            if(!isActive && menu.action_menu && menu.action_menu.length>0){
                (menu.action_menu).forEach(action=>{
                    if(!isActive) isActive = (action.url==c);
                })
            }

            if(isActive && ref) {
                this.$store.commit('setValidUri', true);
                setTimeout(()=>{this.toggle(this.$refs[ref][0]);}, 100);
            };
            return isActive;
        },
        toggle(tag){
            if(this.fired_tag){
                this.fired_tag.removeAttribute('style');
                this.fired_tag.classList.remove('active');
            };
            if(tag){
                if(tag.querySelector('ul')) tag.style.height = (tag!=this.fired_tag ? tag.scrollHeight+7 : tag.scrollHeight)+'px';
                tag.classList.add('active');
            };
            this.fired_tag = tag;
        }
    },
    computed:{
        uri(){ return this.$route.path;}
    }
};
</script>

<style scoped>
  .avatar {
    width: 110px;
    height: 110px;
    object-fit: cover;
  }
</style>
