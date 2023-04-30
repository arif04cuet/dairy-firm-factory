import * as cookiesUtils from '~/services/cookies'

export default function ({ store, route, req, redirect }) {
  const isClient = process.client;
  const isServer = process.server;

  const getItem = (item) => {
    // On server
    if (isServer) {
      const cookies = cookiesUtils.getcookiesInServer(req);
      return cookies[item] || false;
    }

    // On client
    if (isClient) {
      return cookiesUtils.getcookiesInClient(item);
    }
  }


  const time = getItem('auth._token_expiration.local');
  const user = getItem('auth._token.local');
  const { timeAuthorized } = cookiesUtils.authorizeProps(time);

  if(user && timeAuthorized && route.path=='/auth/login'){
    redirect('/user/dashboard');
  }
  else if((!user || !timeAuthorized) && route.path!='/auth/login' && route.path!='/sso/login'){
    redirect('/auth/login');
  }
}