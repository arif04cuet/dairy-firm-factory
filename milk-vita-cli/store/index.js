export const state = () => ({
  menus          : [], // PERMITTED MENU
  action_paths   : [], // PERMITTED ACTION MENUS PATH
  menu_paths     : [], // PERMITTED MENUS PATH
  isValidUri     : true,
  host_server    : process.env.HOST_SERVER,
  api_server     : process.env.API_SERVER,
  gender         : [{key:'male', value:'Male'}, {key:'female', value:'Female'}, {key:'others', value:'Others'}],
  shifts         : [{key:'morning', value:'সকাল'}, {key:'evening', value:'বিকেল'}],
  notification   : {notifications:{}, total_unread:0, total_read:0},
  local          : 'bn',
  auth           : {}
});
//
export const getters = {
  authenticated(state) {
    return state.auth.loggedIn;
  },
  // 
  user(state) {
    return state.auth.user;
  },
}
//
export const mutations = {
  setMenus(state, param=[]) 
  {
    state.menus = param; var urls = [], menu_urls = [];
    (state.menus).filter(menu=>{
      if(menu.url && menu.url!='#') menu_urls.push(menu.url);
      //
      menu.action_menu.filter(action=>{if(action.url!='#') urls.push(action.url)});
      menu.sub_menu.filter(sub_menu=>{
        if(sub_menu.url && sub_menu.url!='#') menu_urls.push(sub_menu.url);
        sub_menu.action_menu.filter(action=>{if(action.url!='#') urls.push(action.url)});
      })
    });

    menu_urls.push('/user/dashboard');
    menu_urls.push('/user/profile');

    state.action_paths = urls;
    state.menu_paths   = menu_urls;
  },
  setValidUri(state, param=[]){
    state.isValidUri = param;
  },
  //
  notification(state, param=[]) {
    state.notification = param;
  },
  //
  local(state, param=''){
    state.local = param;
  },
  //
  auth(state, param=''){
    state.auth = param;
  }
}