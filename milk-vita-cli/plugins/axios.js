export default function ({ $axios, app}) {
    $axios.onError(error => {
        if(error.response.statusText=="Unauthorized" || error.response.status==401){
            app.$logout()
        }
    });
    $axios.interceptors.response.use(
        (response) => {
            //
            if(response.config.url=='user'){
                app.store.commit('setMenus', response.data.privilege);
            }
            if(response.data.redirect_url){
                window.location.href = response.data.redirect_url;
                return 0;
            }
            return response;
        }
    )
}