export default function auth({next , store}){
    console.log("auth work")
    if( store.getters["auth/check"])
        return next({name:"login"})
    else{
        return next()
    }

}
