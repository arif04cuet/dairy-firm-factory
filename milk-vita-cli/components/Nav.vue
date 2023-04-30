<template>
   <div class="app-nav">
      <div class="app-company">
         <NuxtLink to="/user/dashboard" class="brand">
            <img src="~/assets/banners/polli-unnoyon.png" alt="" />
         </NuxtLink>
      </div>
      <div class="app-quick-actions">
         <ul>
            <li v-if="loggedIn">
               <div class="dropdown" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" >
                  <img :src="(user ? ($store.state.host_server+($auth.user.photo_path ? $auth.user.photo_path :'images/user.jpg')):'~assets/icons/user.png')"  alt="">
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                     <NuxtLink to="/user/dashboard" type="button" class="dropdown-item" >
                        <span class="d-flex align-items-center">
                           <img  src="@/assets/icons/archive.webp" class="rounded-circle icon mr-1" alt="">
                           <span class="ellipsis">{{$auth.user.username}}</span>
                        </span>
                     </NuxtLink>
                     <!-- // -->
                     <NuxtLink to="/user/dashboard" class="dropdown-item"> 
                        <img  src="@/assets/images/home.png" class="rounded-circle icon" alt=""> ড্যাশবোর্ড
                     </NuxtLink>
                     <!-- // -->
                     <NuxtLink to="/user/profile" class="dropdown-item"> 
                        <img src="@/assets/images/user.png" class="rounded-circle icon" alt=""> প্রোফাইল 
                     </NuxtLink>
                     <div class="dropdown-divider m-0"></div>
                     <a href="#" type="button" class="dropdown-item" @click="logout" >
                        <img src="@/assets/icons/sign-out-red.webp" class="rounded-circle icon" alt=""> <span class="text-danger">লগ-আউট</span>
                     </a>
                  </div>
               </div>
            </li>
            <!-- // -->
            <Notificaton v-if="loggedIn" />
            <!-- // -->
            <li v-else >
               <nuxt-link to="/auth/login" class="login-btn">লগইন</nuxt-link>
            </li>
            <!-- // -->
            <li class="pt-2" ref="switcher"></li>
         </ul>
      </div>
   </div>
</template>

<script>
export default {
   name:'Nav',
   data(){
      return {
         user           : {},
         is_quickaside  : false,
         logout_process : false, 
         loggedIn       : false,
      }
   },
   mounted(){
      this.user     = this.$store.state.auth.user;
      this.loggedIn = this.$store.state.auth.loggedIn;
      if(this.loggedIn)
         this.initAppSwitcher();
   },
   methods: {
      initAppSwitcher()
      {
         let app = this;
         (this.$refs.switcher).innerHTML = "<app-switcher></app-switcher>";
         (new AppSwitcher()).serve({
            dashboard_url : process.env.DASHBOARD_URL,
            token         : (this.user ? this.user.token : ''),
            onLogout:(response)=>{
               app.$logout();
               window.location.href = response.redirect_url="?redirect_path=/";
            },
            onSwitch:(model)=>{
               app.$logout();
               if(model.slug=='dashboard')
                  window.location.href=model.url;
               else 
                  window.location.href=model.login_handler+'?token='+(this.user ? this.user.token : '');
            },
         });
      },
      logout: function (){
         this.$nuxt.$loading.start();
         this.$logout();
      },
   },
};
</script>


<style scoped>
   .quick-aside {
      position: fixed;
      top: 0;
      right: -300px;
      height: 100vh;
      background: #fff;
      width: 300px;
      z-index: 9999;
      box-shadow: 0px -4px 4px #ddd;
      transition: all .3s linear;
      padding: 5px;
   }
   .nav-item {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 8px;
   }
   .quick-aside.open {
      right: 0px;
   }
   .fixed-top {
      height: 77px;
      position: fixed!important;
   }
   .nav-wrapper {
      width: 100%; 
      height:77px;
   }
   .menu-item-user img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
   }
   .nav-item img {
      width: 45px!important;
      height: 45px!important;
      border-radius: 50%!important;
      object-fit: cover!important;
   }
   img#apps {
      width: 200px;
   }
   .ellipsis {
      width: 118px;
      text-overflow: ellipsis;
      overflow: hidden;
      display: block;
   }
</style>

