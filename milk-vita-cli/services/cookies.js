import Cookie from 'js-cookie'
// import jwtDecoded from 'jwt-decode'

// Get server cookie
export const getcookiesInServer = (req) => {
  const serviceCookie = {}
  if (req && req.headers.cookie) {
    req.headers.cookie.split(';').forEach((val) => {
      const parts = val.split('=')
      serviceCookie[parts[0].trim()] = (parts[1] || '').trim()
    })
  }
  return serviceCookie
}

// Get the client cookie
export const getcookiesInClient = (key) => {
  return Cookie.get(key) || false
}
//
export const setcookiesToken = (token) => {
  Cookie.set('token', token)
}
//
export const remove = (x) => {
  Cookie.remove(x)
}
//
export const authorizeProps = (time) => {
  const timeAuthorized = (time > Date.now()) || false
  return {
    timeAuthorized
  }
}